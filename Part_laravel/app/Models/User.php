<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Review;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Recipe::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)
            ->withPivot('amount')
            ->withTimestamps();
    }
    public function meals()
    {
        return $this->hasMany(Meal::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [

        'username',
        'email',
        'password',
        'isActive',
        'role_id',
        'gender',
        'weight',
        'height',
        'age',
        'target_calories',
        'target_protein',
        'target_carbs',
        'target_fat'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
 }
