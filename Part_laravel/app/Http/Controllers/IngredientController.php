<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIngredientRequest;
use App\Http\Requests\UpdateIngredientRequest;
use App\Models\Ingredient;
use App\Models\IngredientCategory;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class IngredientController extends Controller
{
    use SoftDeletes;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ings = Ingredient::with('ingredientCategory')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Ingredients fetched successfully',
            'data' => $ings
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIngredientRequest $request)
    {
        $validated = $request->validated();
        $ing = Ingredient::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => "Ingredient {$ing->name} created successfully",
            'data' => $ing
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ingredient $ingredient)
    {
        $ingredient->load('ingredientCategory');

        return response()->json([
            'status' => 'success',
            'message' => 'Ingredient shown successfully',
            'data' => $ingredient
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIngredientRequest $request, Ingredient $ingredient)
    {
        $ingredient->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Ingredient updated successfully',
            'data' => $ingredient
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Ingredient deleted successfully'
        ]);
    }
}
