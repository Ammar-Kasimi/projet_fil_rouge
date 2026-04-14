<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Models\IngredientCategory;
use App\Models\Recipe;
use App\Models\RecipeCategory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    use SoftDeletes;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recipes = Recipe::with(['recipeCategory', 'user', 'ingredients'])->withAvg('reviews', 'rating')->latest()->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Recipes fetched successfully',
            'data' => $recipes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecipeRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;

        $recipe = Recipe::create($validated);

        $pivotData = [];
        foreach ($request->ingredients as $ingredient) {
            $pivotData[$ingredient['id']] = ['amount' => $ingredient['amount']];
        }

        $recipe->ingredients()->sync($pivotData);
        $recipe->load('ingredients');

        return response()->json([
            'status' => 'success',
            'message' => 'Recipe created successfully',
            'data' => $recipe
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe)
    {
        $recipe->load(['recipeCategory', 'user', 'ingredients']);
        $recipe->loadAvg('reviews', 'rating');

        return response()->json([
            'status' => 'success',
            'message' => 'Recipe shown successfully',
            'data' => $recipe
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $validated = $request->validated();

        $recipe->update($validated);

        if (isset($validated['ingredients'])) {
            $pivotData = [];
            foreach ($validated['ingredients'] as $ingredient) {
                $pivotData[$ingredient['id']] = ['amount' => $ingredient['amount']];
            }
            $recipe->ingredients()->sync($pivotData);
        }

        $recipe->load(['ingredients', 'recipeCategory']);

        return response()->json([
            'status' => 'success',
            'message' => 'Recipe updated successfully',
            'data' => $recipe
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {
        $recipe->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Recipe deleted  successfully'
        ]);
    }
    public function searchByIngredients(Request $request)
    {
        $ings = $request->ingredients;
        if ($ings == null) {
            $ings = [];
        }

        $recipes = Recipe::whereHas('ingredients', function ($query) use ($ings) {
            $query->whereIn('id', $ings);
        })->withAvg('reviews', 'rating')->paginate(12);

        return response()->json([
            'status' => 'success',
            'message' => 'recipes fetched successfully',
            'data' => $recipes
        ]);
    }
    public function strict_search(Request $request)
    {
        $ings = $request->ingredients;

        if (!isset($ings) || $ings == []) {
            return response()->json([
                'status' => 'success',
                'message' => 'no ingredients chosen',
                'data' => []
            ]);
        }

        $spiceCatId = IngredientCategory::where('name', 'Spices')->value('id');

        $recipes = Recipe::whereDoesntHave('ingredients', function ($query) use ($ings, $spiceCatId) {
            $query->whereNotIn('id', $ings)->where('category_id', '!=', $spiceCatId);
        })->withAvg('reviews', 'rating')->paginate(20);

        return response()->json([
            'status' => 'success',
            'data' => $recipes
        ]);
    }
}
