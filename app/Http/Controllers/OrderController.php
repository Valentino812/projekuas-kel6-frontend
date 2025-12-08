<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction;

class OrderController extends Controller
{
    public function addToCart(Request $request)
    {
        // User authentication
        $user = Auth::user(); 

        // Input Validation
        $request->validate([
            'product_id' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);
    
        $productId = $request->product_id;
        $quantity = $request->quantity;
        
        // Finding product info
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Checking if enough stock is available
        if ($product->stock < $quantity) {
             return response()->json([
                 'error' => 'Not enough stock available.',
                 'available_stock' => $product->stock
             ], 400);
        }

        $price = $product->price; 
        $totalPrice = $price * $quantity;
    
        // Search Active or Create New Cart
        $cart = Cart::where('userId', $user->id)->where('status', 'undone')->first();
    
        if (!$cart) {
            $cart = Cart::create([
                'userId' => $user->id,
                'items' => json_encode([]), 
                'total' => 0,
                'status' => 'undone',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        // Updating Cart Items by decoding items into JSON array
        $items = json_decode($cart->items, true) ?? [];
    
        $existingItemIndex = null;
        foreach ($items as $index => $item) {
            if ($item['product_id'] === $productId) {
                $existingItemIndex = $index;
                break;
            }
        }
    
        if ($existingItemIndex !== null) {
            // Update existing item
            $items[$existingItemIndex]['quantity'] += $quantity;
            $items[$existingItemIndex]['total_price'] += $totalPrice;
        } else {
            // Add new item
            $items[] = [
                'product_id' => $productId,
                'price' => $price,
                'quantity' => $quantity,
                'total_price' => $totalPrice,
            ];
        }
    
        // Saving Cart
        $cart->items = json_encode($items);
        $cart->total += $totalPrice;
        $cart->updated_at = now();
        $cart->save();

        // Reducing Product Stock
        $product->stock -= $quantity;
        $product->save();

        return response()->json([
            'message' => 'Product added to cart successfully!',
            'cart' => $cart,
        ]);
    }

    // Remove product from cart
    public function deleteFromCart(Request $request)
    {
        // User Authentication
        $user = Auth::user(); // Securely get current user

        // Validate input (No userId needed here anymore)
        $request->validate([
            'product_id' => 'required|string',
        ]);

        $productId = $request->product_id;

        // Search for the cart belonging to THIS user
        $cart = Cart::where('userId', $user->id)->where('status', 'undone')->first();

        if (!$cart) {
            return response()->json(['error' => 'No active cart found.'], 404);
        }

        $items = json_decode($cart->items, true);

        // Find the item index
        $itemIndex = null;
        foreach ($items as $index => $item) {
            if ($item['product_id'] === $productId) {
                $itemIndex = $index;
                break;
            }
        }

        if ($itemIndex === null) {
            return response()->json(['error' => 'Product not found in the cart.'], 404);
        }

        // Get information to restore stock
        $quantityToRestore = $items[$itemIndex]['quantity'];
        $priceToRemove = $items[$itemIndex]['total_price'];

        // Removing the product
        unset($items[$itemIndex]);
        $items = array_values($items); // Re-index array

        // Updating the cart
        $cart->items = json_encode($items);
        $cart->total -= $priceToRemove;
        
        // Safety check for negative total
        if($cart->total < 0) $cart->total = 0;
        
        $cart->save();

        // Restoring the stock
        $product = Product::find($productId);
        if ($product) {
            $product->stock += $quantityToRestore;
            $product->save();
        }

        return response()->json([
            'message' => 'Product removed from cart successfully!',
            'cart' => $cart,
        ]);
    }


    // Get card items with product info
    public function getCartItems(Request $request)
    {
        // User Authentication
        $user = Auth::user(); 
    
        // Search for cart with the Authenticated User ID and undone status
        $cart = Cart::where('userId', $user->id)->where('status', 'undone')->first();
    
        if (!$cart) {
            // Return an empty items array with a 200 status
            return response()->json([
                'message' => 'No active cart found for the user.',
                'items' => [],
                'cart_total' => 0
            ], 200);
        }
    
        // Decode items JSON to array (Handle potential nulls safely)
        $items = json_decode($cart->items, true) ?? [];
    
        // Fetch product details and combine with cart items
        $enhancedItems = [];
        
        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            
            if ($product) {
                $enhancedItems[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    // Ensure image path is full URL
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
            'cart_total' => $cart->total // Useful to send the total sum back to frontend
        ]);
    }

    public function increaseQuantity(Request $request)
    {
        // User Authentication
        $user = Auth::user(); 

        $request->validate([
            'productId' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->productId;
        $quantityToAdd = $request->quantity;

        // Finding product
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Checking product's stock
        if ($product->stock < $quantityToAdd) {
            return response()->json([
                'error' => 'Not enough stock available.',
                'available_stock' => $product->stock
            ], 400);
        }

        // Find user's cart
        $cart = Cart::where('userId', $user->id)->where('status', 'undone')->first();

        if (!$cart) {
            return response()->json(['error' => 'Cart not found'], 404);
        }

        $items = json_decode($cart->items, true);
        $itemIndex = null;

        foreach ($items as $index => $item) {
            if ($item['product_id'] == $productId) {
                $itemIndex = $index;
                break;
            }
        }

        if ($itemIndex !== null) {
            // Update Cart
            $items[$itemIndex]['quantity'] += $quantityToAdd;
            $items[$itemIndex]['total_price'] += $product->price * $quantityToAdd;
            $cart->total += $product->price * $quantityToAdd;

            // Reduce Stock
            $product->stock -= $quantityToAdd;
            $product->save();
            
            // Save Cart
            $cart->items = json_encode($items);
            $cart->save();

            return response()->json([
                'message' => 'Product quantity increased successfully!',
                'cart' => $cart,
            ]);
        }
        
        return response()->json(['error' => 'Item not found in cart'], 404);
    }

    /**
     * Decrease Quantity
     */
    public function decreaseQuantity(Request $request)
    {
        // User authentication
        $user = Auth::user(); 

        $request->validate([
            'productId' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->productId;
        $quantityToRemove = $request->quantity;

        // Finding product
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Finding User's active cart
        $cart = Cart::where('userId', $user->id)->where('status', 'undone')->first();

        if (!$cart) {
            return response()->json(['error' => 'Cart not found'], 404);
        }

        $items = json_decode($cart->items, true);
        $itemIndex = null;

        foreach ($items as $index => $item) {
            if ($item['product_id'] == $productId) {
                $itemIndex = $index;
                break;
            }
        }

        if ($itemIndex !== null) {
            if ($items[$itemIndex]['quantity'] > $quantityToRemove) {

                // Update Cart
                $items[$itemIndex]['quantity'] -= $quantityToRemove;
                $items[$itemIndex]['total_price'] -= $product->price * $quantityToRemove;
                $cart->total -= $product->price * $quantityToRemove;

                // Restore Stock
                $product->stock += $quantityToRemove;
                $product->save();
                
                // Save Cart
                $cart->items = json_encode($items);
                $cart->save();

                return response()->json([
                    'message' => 'Product quantity decreased successfully!',
                    'cart' => $cart,
                ]);
            } else {
                return response()->json(['error' => 'Cannot decrease quantity below 1. Use remove instead.'], 400);
            }
        }

        return response()->json(['error' => 'Item not found in cart'], 404);
    }

    public function checkout(Request $request)
    {
        // User authentication
        $user = Auth::user(); 
    
        // Find the active cart for this user
        $cart = Cart::where('userId', $user->id)->where('status', 'undone')->first();

        if ($cart) {
            $cart->status = 'done';
            $cart->save();
            
            return response()->json([
                'message' => 'Cart status updated to done.',
            ]);
        } 
        
        return response()->json(['error' => 'No active cart found for the user'], 404);
    }

    public function moveToTransaction(Request $request)
    {
        // Validasi input
        $request->validate([
            'userId' => 'required|string',
        ]);

        $userId = $request->userId;

        // Cari cart dengan status 'done'
        $cart = Cart::where('userId', $userId)->where('status', 'done')->first();

        if (!$cart) {
            return response()->json(['error' => 'No completed cart found for the user'], 404);
        }

        // Pindahkan data ke Transaction
        $transaction = Transaction::create([
            'userId' => $userId,
            'items' => $cart->items,
            'total' => $cart->total,
            'status' => 'completed',
            'datetime' => now(),
        ]);

        // Hapus cart setelah dipindahkan
        $cart->delete();

        return response()->json([
            'message' => 'Cart moved to transaction successfully!',
            'transaction' => $transaction,
        ]);
    }

    public function getAllDoneCarts()
    {
        $carts = Cart::where('status', 'done')->get();

        return response()->json([
            'carts' => $carts,
        ]);
    }

    public function deleteOrder(Request $request)
    {
        // User authentication
        $user = Auth::user();
        
        // Validate order ID
        $request->validate([
            'id' => 'required|string'
        ]);

        $orderId = $request->input('id');

        //  Find the cart and ensure it belongs to the current user
        $cart = Cart::where('_id', $orderId)
                    ->where('userId', $user->id)
                    ->first();

        if (!$cart) {
            return response()->json(['error' => 'Order not found or access denied'], 404);
        }

        $cart->delete();

        return response()->json(['message' => 'Order deleted successfully!']);
    }
}

