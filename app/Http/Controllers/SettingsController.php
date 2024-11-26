<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Assuming you have a User model
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    /**
     * Update user settings.
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user(); // Get currently authenticated user

        $validatedData = $request->validate([
            'firstName' => 'nullable|string|max:255',
            'lastName' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        // Update user fields
        if (!empty($validatedData['firstName'])) {
            $user->first_name = $validatedData['firstName'];
        }
        if (!empty($validatedData['lastName'])) {
            $user->last_name = $validatedData['lastName'];
        }
        if (!empty($validatedData['email'])) {
            $user->email = $validatedData['email'];
        }
        if (!empty($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }

        $user->save();

        return response()->json(['message' => 'Settings updated successfully.']);
    }

    /**
     * Delete user account.
     */
    public function deleteAccount()
    {
        $user = Auth::user(); // Get currently authenticated user
        $user->delete(); // Delete the user's account

        return response()->json(['message' => 'Account deleted successfully.']);
    }
}
