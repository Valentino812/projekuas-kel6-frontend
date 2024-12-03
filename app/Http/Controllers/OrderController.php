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

