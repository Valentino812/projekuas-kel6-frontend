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
    public function accountUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $account = DB::table('accounts')->where('id', $id)->first();

    if (!$account) {
        return response()->json(['message' => 'Account not found'], 404);
    }

    if ($account->email !== $request->input('email')) {
        $existingAccount = Account::where('email', $request->input('email'))->first();
        if ($existingAccount) {
            return response()->json(['message' => 'Email already in use'], 400);
        }
    }   

    $account->first_name = $request->input('first_name');
    $account->last_name = $request->input('last_name');
    $account->email = $request->input('email');
    
    if ($request->filled('password')) {
        $account->password = Hash::make($request->input('password'));
    }

    $account->save();

    return response()->json(['message' => 'Account updated successfully'], 200);
    }
}
