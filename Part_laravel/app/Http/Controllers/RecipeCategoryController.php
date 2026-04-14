<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecipeCategoryRequest;
use App\Http\Requests\UpdateRecipeCategoryRequest;
use App\Models\RecipeCategory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class RecipeCategoryController extends Controller
{
    use SoftDeletes;

    public function index()
    {
        $categories = RecipeCategory::all();

        return response()->json([
            'status' => 'success',
            'message' => 'fetched Recipe categories  successfully',
            'data' => $categories
        ]);
    }

    public function store(StoreRecipeCategoryRequest $request)
    {
        $category = RecipeCategory::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully',
            'data' => $category
        ], 201);
    }

    public function update(UpdateRecipeCategoryRequest $request, RecipeCategory $cat)
    {
        $cat->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => "Category  $cat->name updated successfully",
            'data' => $cat
        ]);
    }

    public function destroy(RecipeCategory $recipeCategory)
    {
        $recipeCategory->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Recipe category deleted successfully'
        ]);
    }
}
