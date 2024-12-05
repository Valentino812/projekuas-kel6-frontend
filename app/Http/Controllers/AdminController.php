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

    public function getOrders()
    {
        $orders = DB::table('carts')->get();
        return response()->json(['orders' => $orders], 200);
    }

    public function updateProduct(Request $request, $id)
    {
        // Fetch the existing product details
        $product = DB::table('products')->where('id', $id)->first();
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'price' => 'integer',
            'description' => 'string',
            'type' => 'string',
            'gender' => 'string',
            'stock' => 'integer',
            'img1' => 'image|nullable',
            'img2' => 'image|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $updateData = [];
        
        // Update text fields if provided
        foreach(['name', 'price', 'description', 'type', 'gender', 'stock'] as $field) {
            if ($request->has($field)) {
                $updateData[$field] = $request->input($field);
            }
        }

        // Handle image updates
        if ($request->hasFile('img1')) {
            $img1 = $request->file('img1')->store('product_images', 'public');
            $updateData['img1'] = $img1;
        }

        if ($request->hasFile('img2')) {
            $img2 = $request->file('img2')->store('product_images', 'public');
            $updateData['img2'] = $img2;
        }

        DB::table('products')->where('id', $id)->update($updateData);

        return response()->json(['message' => 'Product updated successfully'], 200);
    }

    public function deleteProduct($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Delete the product
        DB::table('products')->where('id', $id)->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }

    public function getProduct($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Ensure all necessary fields, including price, are returned
        return response()->json(['product' => $product], 200);
    }

    public function getReview($id)
    {
        $review = DB::table('reviews')->where('id', $id)->first();
        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        // Ensure all necessary fields, including price, are returned
        return response()->json(['review' => $review], 200);
    }
}
