<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function addToCart(Request $request)
    {
        // Validasi input
        $request->validate([
            'userId' => 'required|string',
            'product_id' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
        ]);
    
        $userId = $request->userId;
        $productId = $request->product_id;
        $price = $request->price;
        $quantity = $request->quantity;
        $totalPrice = $price * $quantity;
    
        // Search cart with same userId and undone status
        $cart = Cart::where('userId', $userId)->where('status', 'undone')->first();
    
        if (!$cart) {
            $cart = Cart::create([
                'userId' => $userId,
                'items' => json_encode([]), 
                'total' => 0,
                'status' => 'undone',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        // Decode items JSON ke dalam array
        $items = json_decode($cart->items, true);
    
        // Cari apakah produk sudah ada di items
        $existingItemIndex = null;
        foreach ($items as $index => $item) {
            if ($item['product_id'] === $productId) {
                $existingItemIndex = $index;
                break;
            }
        }
    
        if ($existingItemIndex !== null) {
            // Update quantity and total price
            $items[$existingItemIndex]['quantity'] += $quantity;
            $items[$existingItemIndex]['total_price'] += $totalPrice;
        } else {
            // add product if new
            $items[] = [
                'product_id' => $productId,
                'price' => $price,
                'quantity' => $quantity,
                'total_price' => $totalPrice,
            ];
        }
    
        // Update cart dengan items yang baru
        $cart->items = json_encode($items);
        $cart->total += $totalPrice;
        $cart->updated_at = now();
        $cart->save();
    
        return response()->json([
            'message' => 'Product added to cart successfully!',
            'cart' => $cart,
        ]);
    }

    // Get card items with product info
    public function getCartItems(Request $request)
    {
        // Validate input
        $request->validate([
            'userId' => 'required|string',
        ]);
    
        $userId = $request->userId;
    
        // Search for cart with the same user ID and undone status
        $cart = Cart::where('userId', $userId)->where('status', 'undone')->first();
    
        if (!$cart) {
            // Return an empty items array with a 200 status
            return response()->json([
                'message' => 'No active cart found for the user.',
                'items' => [],
            ], 200);
        }
    
        // Decode items JSON to array
        $items = json_decode($cart->items, true);
    
    // Fetch product details and combine with cart items
    $enhancedItems = [];
    foreach ($items as $item) {
        $product = Product::find($item['product_id']);
        if ($product) {
            $enhancedItems[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'img1' => $product->img1 ? asset('storage/' . $product->img1) : null,
                'quantity' => $item['quantity'],
                'total_price' => $item['total_price'],
            ];
        } else {
            // Handle missing product gracefully if needed
            Log::warning("Product with ID {$item['product_id']} not found.");
        }
    }

    return response()->json([
        'message' => 'Cart items retrieved successfully!',
        'items' => $enhancedItems,
    ]);
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

