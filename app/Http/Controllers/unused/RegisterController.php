<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
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
                'message' => 'Validation failed',
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
}