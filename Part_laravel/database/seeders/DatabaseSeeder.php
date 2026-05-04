<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\IngredientCategory;
use App\Models\RecipeCategory;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([RoleSeeder::class]);
        User::create([
            'username' => 'ChefTest',
            'email' => 'test@test.com',
            'password' => Hash::make('password123'),
            'isActive' => true,
            'role_id' => 1
        ]);

        $spices = IngredientCategory::create(['name' => 'Spices']);
        $meats = IngredientCategory::create(['name' => 'Meats']);
        $dairy = IngredientCategory::create(['name' => 'Dairy']);
        $produce = IngredientCategory::create(['name' => 'Produce']);

        RecipeCategory::create(['name' => 'Breakfast']);
        RecipeCategory::create(['name' => 'Lunch']);
        RecipeCategory::create(['name' => 'Dinner']);

        Ingredient::create([
            'name' => 'Salt',
            'ingredient_category_id' => $spices->id,
            'calories_per_100' => 0,
            'protein_per_100' => 0,
            'carbs_per_100' => 0,
            'fat_per_100' => 0,
        ]);
        Ingredient::create([
            'name' => 'Black Pepper',
            'ingredient_category_id' => $spices->id,
            'calories_per_100' => 255,
            'protein_per_100' => 10,
            'carbs_per_100' => 64,
            'fat_per_100' => 3,
        ]);


        Ingredient::create([
            'name' => 'Chicken Breast',
            'ingredient_category_id' => $meats->id,
            'calories_per_100' => 165,
            'protein_per_100' => 31,
            'carbs_per_100' => 0,
            'fat_per_100' => 3.6,
            'piece_to_g' => 200, // Assuming 1 chicken breast = 200g
        ]);


        Ingredient::create([
            'name' => 'Whole Milk',
            'ingredient_category_id' => $dairy->id,
            'calories_per_100' => 61,
            'protein_per_100' => 3.2,
            'carbs_per_100' => 4.8,
            'fat_per_100' => 3.3,
            'ml_to_g' => 1.03, // Milk is slightly heavier than water
        ]);
        Ingredient::create([
            'name' => 'Eggs',
            'ingredient_category_id' => $dairy->id,
            'calories_per_100' => 155,
            'protein_per_100' => 13,
            'carbs_per_100' => 1.1,
            'fat_per_100' => 11,
            'piece_to_g' => 50, // 1 large egg = 50g
        ]);


        Ingredient::create([
            'name' => 'Garlic',
            'ingredient_category_id' => $produce->id,
            'calories_per_100' => 149,
            'protein_per_100' => 6.4,
            'carbs_per_100' => 33,
            'fat_per_100' => 0.5,
            'piece_to_g' => 5, // 1 clove = 5g
        ]);
        Ingredient::create([
            'name' => 'Onion',
            'ingredient_category_id' => $produce->id,
            'calories_per_100' => 40,
            'protein_per_100' => 1.1,
            'carbs_per_100' => 9,
            'fat_per_100' => 0.1,
            'piece_to_g' => 110, // 1 medium onion = 110g
        ]);
        Ingredient::create([
            'name' => 'Olive Oil',
            'ingredient_category_id' => $produce->id,
            'calories_per_100' => 884,
            'protein_per_100' => 0,
            'carbs_per_100' => 0,
            'fat_per_100' => 100,
            'ml_to_g' => 0.91, // Oil is lighter than water
        ]);
        Ingredient::create([
            'name' => 'Pasta',
            'ingredient_category_id' => $produce->id,
            'calories_per_100' => 131,
            'protein_per_100' => 5,
            'carbs_per_100' => 25,
            'fat_per_100' => 1,
        ]);
        Ingredient::create([
            'name' => 'Tomato',
            'ingredient_category_id' => $produce->id,
            'calories_per_100' => 18,
            'protein_per_100' => 0.9,
            'carbs_per_100' => 3.9,
            'fat_per_100' => 0.2,
            'piece_to_g' => 120, // 1 medium tomato = 120g
        ]);
        $this->call([RecipeSeeder::class]);


        // $chef = User::create([
        //     'username' => 'GordonRamsay',
        //     'email' => 'chef@test.com',
        //     'password' => Hash::make('password123'),
        //     'isActive' => true,
        // ]);

        // $garlic = Ingredient::create(['name' => 'Garlic']);
        // $tomato = Ingredient::create(['name' => 'Tomato']);
        // $pasta  = Ingredient::create(['name' => 'Pasta']);
        // $egg    = Ingredient::create(['name' => 'Eggs']);
        // $cheese = Ingredient::create(['name' => 'Cheddar Cheese']);


        // $pastaRecipe = Recipe::create([
        //     'user_id' => $chef->id,
        //     'name' => 'Classic Tomato Pasta',
        //     'difficulty' => 'beginner',
        //     'prep_time' => 20,

        // ]);
    }
}
