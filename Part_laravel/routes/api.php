<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IngredientCategoryController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\InstructionController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\RecipeCategoryController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::get('/hello', function () {
    return response()->json([
        'message' => 'The bridge is successfully connected!'
    ]);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user()->load('role');
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/recipes', [RecipeController::class, 'index']);
Route::get('/recipes/{recipe}', [RecipeController::class, 'show']);
Route::get('/ingredients', [IngredientController::class, 'index']);
Route::get('/users/{user}', [UserController::class, 'show']);

Route::get('/recipe_categories', [RecipeCategoryController::class, 'index']);
Route::get('/ingredient_categories', [IngredientCategoryController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/users/{user}', [UserController::class, 'update']);

    Route::apiResource('recipes', RecipeController::class)->except(['index', 'show']);
    Route::apiResource('ingredients', IngredientController::class)->except(['index', 'show']);
    Route::apiResource('recipes.instructions', InstructionController::class)->shallow();
    Route::apiResource('recipes.reviews', ReviewController::class)->shallow();
    Route::apiResource('recipe_categories', RecipeCategoryController::class)->except(['index']);
    Route::apiResource('ingredient_categories', IngredientCategoryController::class)->except(['index']);

    Route::post('/users/{user}/reviews', [UserController::class, 'store_review']);
    Route::get('/users/{user}/reviews', [UserController::class, 'index_reviews']);
    Route::put('/user_reviews/{review}', [UserController::class, 'update_review']);
    Route::delete('/user_reviews/{review}', [UserController::class, 'destroy_review']);

    Route::get('/my-fridge', [UserController::class, 'getFridge']);
    Route::post('/my-fridge', [UserController::class, 'syncFridge']);
    Route::apiResource('meals', MealController::class);

    Route::get('/my-recipes', [RecipeController::class, 'myRecipes']);

    Route::middleware('admin')->group(function () {
        Route::get('/admin/stats', [AdminController::class, 'getStats']);
        Route::get('/admin/users', [AdminController::class, 'getUsers']);
        Route::patch('/admin/users/{user}/ban', [AdminController::class, 'banUser']);
        Route::patch('/admin/users/{user}/unban', [AdminController::class, 'unbanUser']);
        Route::post('/admin/ingredients', [AdminController::class, 'storeIngredient']);
    });
});



Route::post('/recipes/search', [RecipeController::class, 'searchCoordinator']);
Route::post('password/reset', ForgotPasswordController::class);
