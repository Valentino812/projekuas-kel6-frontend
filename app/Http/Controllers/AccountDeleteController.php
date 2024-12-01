<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;

class AccountDeleteController extends Controller
{
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
