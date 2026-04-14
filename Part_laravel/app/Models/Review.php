<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
    'recipe_id',
    'desc',
    'rating',
    'user_id'

];

    public function recipe()
{
    return $this->belongsTo(Recipe::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
}
