<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserDetailsRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use SoftDeletes;

    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $users = User::withCount('recipes')
            ->withAvg('reviews', 'rating')
            ->latest()
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $users
        ]);
    }
    public function show_offers()
    {
        $chefs = User::has('recipes')->withCount('recipes')->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating')->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $chefs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['recipes'])->loadCount('recipes')->loadAvg('reviews', 'rating');

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'User profile updated successfully',
            'data' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Account deactivated successfully'
        ]);
    }
    public function updateUserDetails(UpdateUserDetailsRequest $request){
     $request->user()->update($request->validated);

    }
    //BMR:Basal Metabolic Rate
    //TDEE:Total Daily Energy Expenditure
    //TDEE 3adatan =BMR*1.2;
    d
}
