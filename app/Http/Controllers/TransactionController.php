<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function getAllTransactions()
    {
        $transactions = Transaction::all();

        return response()->json([
            'transactions' => $transactions,
        ]);
    }
}
