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
        $accounts->password = Hash::make($request->input('password'));
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
            'password' => 'required|string',
            'redirect_route' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Find the user by email
        $user = Account::where('email', $request->email)->first();

        // Check if the account is blocked
        if ($user && $user->failed_attempts >= 3) {
            return response()->json([
                'message' => 'Your account is blocked due to too many failed login attempts. Please contact our customer service.'
            ], 403);
        }

        // Login Attempt
        if (Auth::attempt($request->only('email', 'password'))) {
            
            // Generating session ID
            $request->session()->regenerate();

            // Resetting failed attempts
            if ($user && $user->failed_attempts > 0) {
                $user->update(['failed_attempts' => 0]);
            }

            return response()->json([
                'message' => 'Login successful!',
                'redirect_url' => route($request->input('redirect_route')) 
            ], 200);
        }

        // Failed Login
        if ($user) {
            $user->increment('failed_attempts');
            $remaining = 3 - $user->failed_attempts;

            if ($remaining <= 0) {
                return response()->json([
                    'message' => 'Your account is blocked due to too many failed login attempts.'
                ], 403);
            }

            return response()->json([
                'message' => "Invalid password. You have $remaining login attempts left."
            ], 401);
        }

        // If the email doesn't existe
        return response()->json(['message' => 'Email not found'], 401);
    }

    /**
     * Get account information.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAccountInfo(Request $request)
    {
        // Authenticate user
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json(['account' => $user], 200);
    }

    // Update Account Info (First Name and Last Name)
    public function updateAccountInfo(Request $request)
    {
        // Authenticate user
        $user = Auth::user(); 

        // Validate the inputs
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update first and last name
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name
        ]);

        return response()->json(['message' => 'Account info updated successfully'], 200);
    }
 
    // Update Account Login Info (Email and Password)
    public function updateAccountLogin(Request $request)
    {
        // Autenthicate User
        $user = Auth::user(); 

        // Validate the inputs
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:accounts,email,' . $user->id,
            'password' => 'required|string|min:8',
            'new_password' => 'nullable|string|min:8' 
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if the provided password matches the current password
        if (!Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'errors' => ['password' => ['The provided password is incorrect.']]
            ], 400);
        }

        // Check if the email is being updated and is already in use
        if ($request->input('email') !== $user->email) {
            $user->email = $request->input('email');
        }

        // Updating Password If Provided 
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->input('new_password'));
        }

        $user->save();

        return response()->json(['message' => 'Login info updated successfully'], 200);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    public function deleteAccount(Request $request)
    {
        // Autenthicate User
        $user = Auth::user();

        // Validate that they sent a password
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Verifiying password before deleting
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid password'], 403);
        }

        // Deleting the account from the database
        $user->delete();

        // Log out and kill the session
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Account deleted successfully',
            'redirect_url' => '/' 
        ], 200);
    }
}