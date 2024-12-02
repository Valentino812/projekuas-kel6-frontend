<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function addProduct(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'price' => 'required|integer',
            'description' => 'required|string',
            'type' => 'required|string',
            'gender' => 'required|string',
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
        $product->type = $request->input('type');
        $product->gender = $request->input('gender');
        $product->stock = $request->input('stock');
        $product->img1 = $img1; // Store image path or Base64 string
        $product->img2 = $img2; // Store image path or Base64 string
        $product->save();

        return response()->json(['success' => 'Product added successfully'], 200);
    }

    public function getAllProducts(Request $request)
    {
        $query = Product::query();

        // Filtering by gender
        if ($request->has('gender') && $request->gender != '') {
            $query->where('gender', $request->gender);
        }

        // Filtering by type
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        // Searching by name
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->get();

        // Modify the response 
        $productsArray = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'description' => $product->description,
                'type' => $product->type,
                'gender' => $product->gender,
                'stock' => $product->stock,
                'img1' => $product->img1 ? asset('storage/' . $product->img1) : null,
                'img2' => $product->img2 ? asset('storage/' . $product->img2) : null,
            ];
        });

        return response()->json(['products' => $productsArray], 200);
    }

    public function getProduct($id)
    {
        // Find product by ID
        $product = Product::find($id);

        // Check if product exists
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Format the product response
        $productData = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'description' => $product->description,
            'type' => $product->type,
            'gender' => $product->gender,
            'stock' => $product->stock,
            'img1' => $product->img1 ? asset('storage/' . $product->img1) : null,
            'img2' => $product->img2 ? asset('storage/' . $product->img2) : null,
        ];

        return response()->json(['product' => $productData], 200);
    }

    public function addToCart(Request $request)
    {
        $productId = $request->input('productId');
        // Logic to add product to the cart in the database
        // For example, create a new order or update an existing one

        return response()->json(['success' => 'Product added to cart'], 200);
    }

    public function checkout(Request $request)
    {
        $items = $request->input('items');
        $total = $request->input('total');

        DB::table('carts')->insert([
            'items' => json_encode($items), // Store items as JSON
            'total' => $total,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => 'Order placed successfully'], 200);
    }

    

}