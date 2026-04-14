<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = [
        'name',
        'pic',
        'ingredient_category_id'
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
            ->withPivot('amount')
            ->withTimestamps();
    }

    public function ingredientCategory()
    {
        return $this->belongsTo(IngredientCategory::class);
    }
}
