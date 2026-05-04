<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\RecipeCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $category = RecipeCategory::firstOrCreate(['name' => 'General']);

        $chicken = Ingredient::where('name', 'Chicken Breast')->first();
        $garlic  = Ingredient::where('name', 'Garlic')->first();
        $tomato  = Ingredient::where('name', 'Tomato')->first();
        $onion   = Ingredient::where('name', 'Onion')->first();
        $pasta   = Ingredient::where('name', 'Pasta')->first();

        // --- Recipe 1: Garlic Chicken ---
        if ($user && $chicken && $garlic) {
            $recipe = Recipe::create([
                'name' => 'Garlic Chicken',
                'prep_time' => 20,
                'difficulty' => 'beginner',
                'user_id' => $user->id,
                'recipe_category_id' => $category->id,
            ]);
            $recipe->ingredients()->attach([
                $chicken->id => ['amount' => 2, 'unit' => 'piece'],
                $garlic->id  => ['amount' => 3, 'unit' => 'clove'],
            ]);
        }

        // --- Recipe 2: Tomato Onion Salad ---
        if ($user && $tomato && $onion) {
            $recipe = Recipe::create([
                'name' => 'Tomato & Onion Salad',
                'prep_time' => 10,
                'difficulty' => 'beginner',
                'user_id' => $user->id,
                'recipe_category_id' => $category->id,
            ]);
            $recipe->ingredients()->attach([
                $tomato->id => ['amount' => 3, 'unit' => 'piece'],
                $onion->id  => ['amount' => 1, 'unit' => 'piece'],
            ]);
        }

        // --- Recipe 3: Simple Pasta ---
        if ($user && $pasta && $tomato && $garlic) {
            $recipe = Recipe::create([
                'name' => 'Simple Tomato Pasta',
                'prep_time' => 15,
                'difficulty' => 'medium',
                'user_id' => $user->id,
                'recipe_category_id' => $category->id,
            ]);
            $recipe->ingredients()->attach([
                $pasta->id  => ['amount' => 250, 'unit' => 'g'],
                $tomato->id => ['amount' => 2, 'unit' => 'piece'],
                $garlic->id => ['amount' => 1, 'unit' => 'clove'],
            ]);
        }
    }

}
