<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIngredientCategoryRequest;
use App\Http\Requests\UpdateIngredientCategoryRequest;
use App\Models\IngredientCategory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class IngredientCategoryController extends Controller
{
    use SoftDeletes;

    public function index()
    {
        $categories = IngredientCategory::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Ingredient categories fetched successfully',
            'data' => $categories
        ]);
    }

    public function store(StoreIngredientCategoryRequest $request)
    {
        $category = IngredientCategory::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Ingredient category created successfully',
            'data' => $category
        ], 201);
    }

    public function update(UpdateIngredientCategoryRequest $request, IngredientCategory $cat)
    {
        $cat->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => "Ingredient category $cat->name updated successfully",
            'data' => $cat
        ]);
    }

    public function destroy(IngredientCategory $ingredientCategory)
    {
        $ingredientCategory->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Ingredient category deleted successfully'
        ]);
    }
}
