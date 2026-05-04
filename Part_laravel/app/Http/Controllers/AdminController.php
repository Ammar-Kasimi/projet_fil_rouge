<?php
 
namespace App\Http\Controllers;
 
use App\Http\Requests\StoreIngredientRequest;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;
 
class AdminController extends Controller
{
    public function getStats(Request $request)
    {
        if ($request->user()->role?->name !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }
 
        return response()->json([
            'status' => 'success',
            'data'   => [
                'total_users'        => User::count(),
                'total_recipes'      => Recipe::count(),
                'total_ingredients'  => Ingredient::count(),
                'new_users_week'     => User::where('created_at', '>=', now()->subDays(7))->count(),
                'banned_users'       => User::where('isActive', false)->count(),
                'recipes_this_week'  => Recipe::where('created_at', '>=', now()->subDays(7))->count(),
            ]
        ]);
    }
 
    public function getUsers(Request $request)
    {
        if ($request->user()->role?->name !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }
 
        $users = User::with('role')
            ->withCount('recipes')
            ->latest()
            ->paginate(15);
 
        return response()->json([
            'status' => 'success',
            'data'   => $users
        ]);
    }
 
    public function banUser(Request $request, User $user)
    {
        if ($request->user()->role?->name !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }
 
        $user->update(['isActive' => false]);
 
        return response()->json([
            'status'  => 'success',
            'message' => "User {$user->username} has been banned."
        ]);
    }
 
    public function unbanUser(Request $request, User $user)
    {
        if ($request->user()->role?->name !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }
 
        $user->update(['isActive' => true]);
 
        return response()->json([
            'status'  => 'success',
            'message' => "User {$user->username} has been unbanned."
        ]);
    }
 
    // StoreIngredientRequest extends FormRequest which also has user()
    // so we only need one parameter here
    
}