<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'name',
        'pic',
        'difficulty',
        'prep_time',
        'rating',
        'user_id',
        'recipe_category_id'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function instructions()
    {
        return $this->hasMany(Instruction::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient')
            ->withPivot('amount')
            ->withTimestamps();
    }

    public function recipeCategory()
    {
        return $this->belongsTo(RecipeCategory::class);
    }
}
