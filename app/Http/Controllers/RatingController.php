<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Review;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RatingController extends Controller
{
    public function addReview(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'img1' => 'required|image',
            'img2' => 'required|image',
            'comment' => 'required|string',
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
        $review = new Review();
        $review->img1 = $img1; // Store image path or Base64 string
        $review->img2 = $img2; // Store image path or Base64 string
        $review->comment = $request->input('comment');
        $review->save();

        return response()->json(['success' => 'Review added successfully'], 200);
    }
}