<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = [
        'name',
        'pic',
        'ingredient_category_id',
        'calories_per_100',
        'protein_per_100',
        'carbs_per_100',
        'fat_per_100',
        'ml_to_g',
        'piece_to_g'
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'ingredient_recipe')
            ->withPivot('amount')
            ->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'ingredient_user')
            ->withPivot('amount', 'unit')
            ->withTimestamps();
    }

    public function ingredientCategory()
    {
        return $this->belongsTo(IngredientCategory::class);
    }
}
