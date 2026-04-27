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
    public function updateUserDetails(UpdateUserDetailsRequest $request)
    {
        $user = $request->user();
        $user->update($request->validated());
        $this->calculate_daily_macros($user);
        $user->refresh();
        //mam2kdch wach y7taj ndir liha refresh() wlla la fa drtha o safi
        return response()->json([
            'status' => 'success',
            'message' => 'user details updated successfully',
            'data' => $user
        ]);
    }
    //BMR:Basal Metabolic Rate
    //TDEE:Total Daily Energy Expenditure
    //TDEE 3adatan =BMR*1.2;
    public function calculate_daily_macros(User $user)
    {
        $bmr = (10 * $user->weight) + (6.25 * $user->height) - (5 * $user->age);
        if ($user->gender == 'male') {
            $bmr += 5;
        } else {
            $bmr -= 161;
        }
        $TDEE = $bmr * 1.2;
        $user->update([
            'target_calories' => round($TDEE),
            'target_protein'  => round(($TDEE * 0.3) / 4),
            'target_carbs'    => round(($TDEE * 0.4) / 4),
            'target_fat'      => round(($TDEE * 0.3) / 9)
        ]);
    }

    // public function calculate_daily_macros2(){
    //     $bmr=(10 * $this->weight) + (6.25 * $this->height) - (5 * $this->age);
    //     if($this->gender=='male'){
    //         $bmr+=5;
    //     }else{
    //         $bmr-=161;
    //     }
    //     $TDEE=$bmr*1.2;

    //         $this->target_calories = round($TDEE);
    // $this->target_protein = round(($TDEE * 0.3) / 4);
    // $this->target_carbs = round(($TDEE * 0.4) / 4);
    // $this->target_fat = round(($TDEE * 0.3) / 9);

    // $this->save();
    // }
}
