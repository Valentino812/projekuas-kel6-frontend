<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
    
        // Update cart with the new item
        $cart->items = json_encode($items);
        $cart->total += $totalPrice;
        $cart->updated_at = now();
        $cart->save();

        // Reduce the number of product stock
        $product = Product::find($productId);

        // Check if the product exists
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Reduce the stock
        $product->stock -= $quantity;

        // Save the updated stock to the database
        $product->save();

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

    public function increaseQuantity(Request $request)
    {
        // Validate input
        $request->validate([
            'productId' => 'required|string',
            'quantity' => 'required|integer',
        ]);

        $productId = $request->productId;
        $quantityToAdd = $request->quantity;

        // Find the product in the database
        $product = Product::find($productId);

        // Check if the product exists
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Check if enough stock is available
        if ($product->stock < $quantityToAdd) {
            return response()->json([
                'error' => 'Not enough stock available.',
                'available_stock' => $product->stock
            ], 400);
        }

        // Update the product quantity in the cart
        $cart = Cart::where('userId', $request->userId)->where('status', 'undone')->first();

        if ($cart) {
            $items = json_decode($cart->items, true);
            $itemIndex = null;

            // Find the item in the cart
            foreach ($items as $index => $item) {
                if ($item['product_id'] == $productId) {
                    $itemIndex = $index;
                    break;
                }
            }

            if ($itemIndex !== null) {
                // Increase quantity in cart
                $items[$itemIndex]['quantity'] += $quantityToAdd;
                $cart->total += $product->price * $quantityToAdd;

                // Reduce stock in the product model
                $product->stock -= $quantityToAdd;
                $product->save();
            }

            // Save the cart and update the total
            $cart->items = json_encode($items);
            $cart->save();

            return response()->json([
                'message' => 'Product quantity increased successfully!',
                'cart' => $cart,
            ]);
        }

        return response()->json(['error' => 'Cart not found'], 404);
    }

    public function decreaseQuantity(Request $request)
    {
        // Validate input
        $request->validate([
            'productId' => 'required|string',
            'quantity' => 'required|integer',
        ]);

        $productId = $request->productId;
        $quantityToRemove = $request->quantity;

        // Find the product in the database
        $product = Product::find($productId);

        // Check if the product exists
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Update the product quantity in the cart
        $cart = Cart::where('userId', $request->userId)->where('status', 'undone')->first();

        if ($cart) {
            $items = json_decode($cart->items, true);
            $itemIndex = null;

            // Find the item in the cart
            foreach ($items as $index => $item) {
                if ($item['product_id'] == $productId) {
                    $itemIndex = $index;
                    break;
                }
            }

            if ($itemIndex !== null) {
                if ($items[$itemIndex]['quantity'] > $quantityToRemove) {
                    // Decrease the quantity and total price
                    $items[$itemIndex]['quantity'] -= $quantityToRemove;
                    $cart->total -= $product->price * $quantityToRemove;

                    // Increase stock in the product model
                    $product->stock += $quantityToRemove;
                    $product->save();
                } else {
                    return response()->json(['error' => 'Cannot decrease quantity below 1'], 400);
                }
            }

            // Save the updated cart
            $cart->items = json_encode($items);
            $cart->save();

            return response()->json([
                'message' => 'Product quantity decreased successfully!',
                'cart' => $cart,
            ]);
        }

        return response()->json(['error' => 'Cart not found'], 404);
    }

    
    public function checkout(Request $request)
    {
        // Validasi input
        $request->validate([
            'userId' => 'required|string',
        ]);
    
        $userId = $request->userId;
    
        // Search cart with same userId and undone status
        $cart = Cart::where('userId', $userId)->where('status', 'undone')->first();

        if ($cart) {
            // Update the status to 'done'
            $cart->status = 'done';
            
            // Save the updated cart
            $cart->save();
            
            return response()->json([
                'message' => 'Cart status updated to done".',
            ]);
        } else {
            return response()->json([
                'error' => 'No cart found for the user',
            ], 404);
        }

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

    public function moveCartToTransaction(Request $request)
    {
        // Validate input
        $request->validate([
            'cartId' => 'required|string',
        ]);

        $cartId = $request->cartId;

        // Find the cart with the given ID
        $cart = Cart::find($cartId);

        if (!$cart || $cart->status !== 'done') {
            return response()->json(['error' => 'Cart not found or not completed'], 404);
        }

        // Move data to Transaction
        $transaction = Transaction::create([
            'userId' => $cart->userId,
            'items' => $cart->items,
            'total' => $cart->total,
            'status' => 'completed',
            'datetime' => now(),
        ]);

        // Delete the cart after moving
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

    public function deleteOrder($id)
    {
        $cart = Cart::find($id);

        if (!$cart) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $cart->delete();

        return response()->json(['message' => 'Order deleted successfully!']);
    }
}

