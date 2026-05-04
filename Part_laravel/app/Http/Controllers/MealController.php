<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMealRequest;
use App\Models\Meal;
use App\Models\Recipe;
use Illuminate\Http\Request;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMealRequest $request)
    {
        $validated = $request->validated();

        $recipe = Recipe::find($validated['recipe_id']);
        if (!$recipe) {
            return response()->json([
                'status' => 'fail',
                'message' => 'the recipe doesnt exist'
            ], 404);
        }

        $meal = Meal::create([
            'user_id' => $request->user()->id,
            'recipe_id' => $recipe->id,
            'calories' => $recipe->calories,
            'protein' => $recipe->protein,
            'carbs' => $recipe->carbs,
            'fat' => $recipe->total_fat,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Meal logged successfully',
            'data' => $meal
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Meal $meal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meal $meal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meal $meal)
    {
        //
    }
}
