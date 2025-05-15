<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $id)
    {
        // Validate the review input
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Here you would save the review to the database
        // Example (if you have a Review model):
        // Review::create([
        //     'product_id' => $id,
        //     'user_id' => auth()->id(),
        //     'rating' => $request->rating,
        //     'comment' => $request->comment,
        // ]);

        return redirect()->back()->with('success', 'Review submitted!');
    }
} 