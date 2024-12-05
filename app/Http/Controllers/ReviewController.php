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

    public function getAllReviews(Request $request)
    {
        $query = Review::query();

        $reviews = $query->get();

        // Modify the response 
        $reviewsArray = $reviews->map(function ($review) {
            return [
                'productId' => $review->productId,
                'userId' => $review->userId,
                'comment' => $review->comment,
            ];
        });

        return response()->json(['reviews' => $reviewsArray], 200);
    }

    public function getAllWrittenReviews()
    {
        $query = Review::query();

        $reviews = $query->get();

        $reviewsArray = $reviews->map(function ($review) {
            return [
                'id' => $review->id,
                'productId' => $review->productId,
                'userId' => $review->userId,
                'comment' => $review->comment,
            ];
        });

        return response()->json(['reviews' => $reviewsArray], 200);
    }
}