<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Recipe;
use App\Models\Review;
use Illuminate\Http\Request;

use function Pest\Laravel\json;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Recipe $recipe)
    {
        $reviews = $recipe->reviews()->with('user:id,username,pic')->latest()->paginate(10);

        return response()->json([
            'status' => 'success',
            'message' => 'Reviews retrieved successfully',
            'data' => $reviews
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request, Recipe $recipe)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;

        $review = $recipe->reviews()->create($validated);
        $review->load('user:id,username,pic');

        return response()->json([
            'status' => 'success',
            'message' => 'Review added successfully',
            'data' => $review
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        $review->load('user:id,username,pic');

        return response()->json([
            'status' => 'success',
            'message' => 'Review retrieved successfully',
            'data' => $review
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        $review->update($request->validated());
        $review->load('user:id,username,pic');

        return response()->json([
            'status' => 'success',
            'message' => 'Review updated successfully',
            'data' => $review
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'review deleted successfully'
        ]);
    }
    
}
