<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class ProductController extends Controller
{
    public function addProduct(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'price' => 'required|integer',
            'description' => 'required|string',
            'stock' => 'required|integer',
            'img1' => 'required|image',
            'img2' => 'required|image',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Handle images 
        $img1 = null;
        $img2 = null;

        if ($request->hasFile('img1')) {
            $img1 = $request->file('img1')->store('product_images', 'public');
        }

        if ($request->hasFile('img2')) {
            $img2 = $request->file('img2')->store('product_images', 'public');
        }

        // Create new product entry
        $product = new Product();
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->stock = $request->input('stock');
        $product->img1 = $img1; // Store image path or Base64 string
        $product->img2 = $img2; // Store image path or Base64 string
        $product->save();

        return response()->json(['success' => 'Product added successfully'], 200);
    }
}