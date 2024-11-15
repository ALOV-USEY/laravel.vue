<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::all();
        return response()->json(['reviews' => $reviews], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'hotel_id' => 'required|exists:hotels,id',
            'content' => 'required|string',
            'rating' => 'required|integer|between:1,5',
        ]);

        $review = Review::create($request->all());

        return response()->json(['review' => $review], 201);
    }

    public function show($id)
    {
        $review = Review::findOrFail($id);
        return response()->json(['review' => $review], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'user_id' => 'exists:users,id',
            'hotel_id' => 'exists:hotels,id',
            'content' => 'string',
            'rating' => 'integer|between:1,5',
        ]);

        $review = Review::findOrFail($id);
        $review->update($request->all());

        return response()->json(['review' => $review], 200);
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return response()->json(['message' => 'Review deleted successfully'], 200);
    }
}
