<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Review;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function addReview(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'productId' => 'required|string',
            'userId' => 'required|string',
            'comment' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Create new review entry
        $review = new Review();
        $review->productId = $request->input('productId');
        $review->userId = $request->input('userId');
        $review->comment = $request->input('comment');
        $review->save();

        return response()->json(['success' => 'Review added successfully'], 200);
    }
}