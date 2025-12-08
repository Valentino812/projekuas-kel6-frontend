<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function getTransactions()
    {
        // User Authentication
        $user = Auth::user(); 

        // Fetch transactions for the specific user
        $transactions = Transaction::where('userId', $user->id)->get();

        // Return the transactions as a JSON response
        return response()->json($transactions);
    }

    public function getAllTransactions()
    {
        $transactions = Transaction::all(); // Fetch all transactions

        return response()->json([
            'transactions' => $transactions,
        ]);
    }
}
