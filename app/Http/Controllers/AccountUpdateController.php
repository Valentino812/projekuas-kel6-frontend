<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;

class AccountUpdateController extends Controller

{
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
}
