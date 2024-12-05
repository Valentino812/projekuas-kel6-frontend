<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function getTransactions($id)
    {
        $transactions = Transaction::where('userId', $id)->get(); // Fetch transactions for the specific user

        return response()->json($transactions); // Return the transactions as a JSON response
    }

    public function getAllTransactions()
    {
        $transactions = Transaction::all(); // Fetch all transactions

        return response()->json([
            'transactions' => $transactions,
        ]);
    }
}
