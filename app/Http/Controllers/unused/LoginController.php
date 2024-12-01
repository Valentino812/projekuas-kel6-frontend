<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Account;

class LoginController extends Controller
{
    /**
     * Handle the login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'redirect_route' => 'required|string', // Determent the route after login
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Find the user by email
        $user = DB::table('accounts')->where('email', $request->input('email'))->first();

        if ($user) {
            // Check if the account is blocked
            if ($user->failed_attempts >= 3) {
                return response()->json([
                    'message' => 'Your account is blocked due to too many failed login attempts. Please contact our customer service.'
                ], 403); 
            }

            if (Hash::check($request->input('password'), $user->password)) {
                // Resetting failed attempts when login is successfull
                if ($user->failed_attempts > 0) {
                    DB::table('accounts')
                        ->where('email', $user->email)
                        ->update(['failed_attempts' => 0]);
                }

                // Determine redirect URL
                $redirectRoute = $request->input('redirect_route'); 

                // Authenticate the user using Laravel's session-based authentication
                // Auth::login($user);

                // Set message login sucessfull and redirect to new page
                return response()->json([
                    'message' => 'Login successful!',
                    'redirect_url' => route($redirectRoute, ['id' => $user->id]) // URL destination
                ], 200);
            } else {
                // Increment the account failed login attempts 
                $remainingAttempts = 3 - ($user->failed_attempts + 1);
                DB::table('accounts')
                    ->where('email', $user->email)
                    ->increment('failed_attempts');

                    // Account blocking for 3 failed login attempts
                    if($remainingAttempts <= 0){
                        return response()->json([
                            'message' => 'Your account is blocked due to too many failed login attempts. Please contact our customer service.'
                        ], 403); 
                    } else {
 
                    // Failed login message
                    return response()->json([
                        'message' => 'Invalid password. You have ' . $remainingAttempts . ' login attempts left before your account is blocked.'
                    ], 401);
                }
            }
        }

        // If the email doesn't exist, return the same failure message
        return response()->json([
            'message' => 'Email not found'
        ], 401);

    }

/**
     * Get account information.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAccountInfo($id)
    {
        $user = Account::find($id); 

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(['account' => $user], 200);
    }
} 