<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Handle the register request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The password field must be at least 8 characters. ',
                'errors' => $validator->errors(),
            ], 422); // Unprocessable Entity
        }

        // Checking if email is already registered
        $emailExists = Account::where('email', $request->input('email'))->exists();

        if ($emailExists) {
            return response()->json([
                'message' => 'Email already used',
            ], 409); 
        }

        // Creating new account
        $accounts = new Account();
        $accounts->first_name = $request->input('first_name');
        $accounts->last_name = $request->input('last_name');
        $accounts->email = $request->input('email');
        $accounts->password = bcrypt($request->input('password'));
        $accounts->failed_attempts = 0;
        $accounts->save();

        return response()->json([
            'message' => 'Account created successfully!',
        ], 201); 
    }

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

     // Update Account Info (First Name and Last Name)
     public function updateAccountInfo(Request $request, $id)
     {
         // Validate the inputs
         $validator = Validator::make($request->all(), [
             'first_name' => 'required|string|max:255',
             'last_name' => 'required|string|max:255',
         ]);
 
         if ($validator->fails()) {
             return response()->json(['errors' => $validator->errors()], 422);
         }
 
         // Find the account
         $account = Account::find($id);
 
         if (!$account) {
             return response()->json(['message' => 'Account not found'], 404);
         }
 
         // Update first and last name
         $account->first_name = $request->input('first_name', $account->first_name); // Keep existing value if not provided
         $account->last_name = $request->input('last_name', $account->last_name);   // Keep existing value if not provided
         $account->save();
 
         return response()->json(['message' => 'Account info updated successfully'], 200);
     }
 
     // Update Account Login Info (Email and Password)
     public function updateAccountLogin(Request $request, $id)
     {
         // Validate the inputs
         $validator = Validator::make($request->all(), [
             'email' => 'required|email|max:255|unique:users,email,' . $id,
             'password' => 'required|string|min:8',
             'new_password' => 'nullable|string|min:8'
         ]);
 
         if ($validator->fails()) {
             return response()->json(['errors' => $validator->errors()], 422);
         }
 
         // Find the account
         $account = Account::find($id);
 
         if (!$account) {
             return response()->json(['message' => 'Account not found'], 404);
         }
 
         // Check if the provided password matches the current password
         if (!Hash::check($request->input('password'), $account->password)) {
             return response()->json(['errors' => 'The provided password is incorrect'], 400);
         }
 
         // Check if the email is being updated and is already in use
         if ($request->input('email') && $account->email !== $request->input('email')) {
             $existingAccount = Account::where('email', $request->input('email'))->first();
             if ($existingAccount) {
                 return response()->json(['message' => 'Email already in use'], 400);
             }
             $account->email = $request->input('email');
         }
 
         // Update password if provided
         if ($request->filled('new_password')) {
             $account->password = Hash::make($request->input('new_password'));
         }
 
         $account->save();
 
         return response()->json(['message' => 'Login info updated successfully'], 200);
     }

    public function deleteAccount(Request $request, $id)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Find the account by ID
        $account = Account::find($id);

        if (!$account) {
            return response()->json(['message' => 'Account not found'], 404);
        }

        // Check if the password matches
        if (!Hash::check($request->password, $account->password)) {
            return response()->json(['message' => 'Invalid password'], 403);
        }

        // Delete the account
        $account->delete();

        return response()->json([
            'message' => 'Account deleted successfully',
            'redirect_url' => '/' // URL destination
    ], 200);
    }
}
