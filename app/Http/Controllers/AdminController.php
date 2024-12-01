<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminController extends Controller
{
    public function adminLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $admin = DB::table('admins')->where('username', $request->input('username'))->first();

        if (!$admin || $request->input('password') !== $admin->password) {
            return response()->json(['message' => 'Invalid password'], 401);
        }
        
        // return response()->json(['message' => 'Login successful'], 200);
        return response()->json([
            'message' => 'Login successful!',
            'redirect_url' => route('admin', ['id' => $admin->id]) 
        ], 200);
    }

}
