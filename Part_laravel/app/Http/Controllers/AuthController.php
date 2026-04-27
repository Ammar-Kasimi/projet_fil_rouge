<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    // public function register(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:35',
    //         'email' => 'required|string|email|max:50|unique:users',

    //         'password' => 'required|string|min:8',
    //         'isActive' =>'boolean',
    //         'isChef' =>'boolean',
    //         'role_id'=> 'required|integer'

    //     ]);
    //     $user = User::create($validated);
    //     if(User::count()==1){
    //         $user->role->id=1;
    //         $user->save();
    //     }

    //     Auth::login($user);
    //     if($user->role->name=='user'){
    //     return redirect()->route('dashboard');
    //     }
    //     return redirect()->route('admin.index');
    // }

    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     if (Auth::attempt($credentials, true)) {
    //         $request->session()->regenerate();
    //         $user=Auth::user();
    //         if($user->role_id==2){
    //         return redirect()->route('dashboard');
    //         }else{
    //         return redirect()->route('admin.index');

    //         }

    //     }
    //     return back()->withErrors(['the entered email or password is wrong']);


    // }
    // public function logout(Request $request){
    //     Auth::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();
    //     return redirect()->route('dashboard');
    // }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        if (User::count() === 0) {
            $role_id = Role::where('name','admin')->get();
            $validated['role_id'] = $role_id;
        } else {
            $validated['role_id'] = 2;
        }

        $validated['isActive'] = true;

        $user = DB::transaction(function () use ($validated) {
            return User::create($validated);
        });

        $token = $user->createToken("api_token")->plainTextToken;

        return response()->json([
            "status" => "success",
            "message" => "User created successfully",
            "data" => [
                "user_data" => $user,
                "token_type" => "Bearer",
                "access_token" => $token
            ]
        ], 201);
    }
    public function login(LoginRequest $request)
    {
        $creds = $request->validated();

        if (!Auth::attempt($creds)) {
            return response()->json([
                "status" => "failed",
                "message" => "The email or password is wrong"
            ], 401);
        }

        $user = $request->user()->load('role');
        $token = $user->createToken("api_token")->plainTextToken;

        return response()->json([
            "status" => "success",
            "message" => "User logged in successfully",
            "data" => [
                "user_data" => $user,
                "access_token" => $token
            ]
        ], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "status" => "success",
            "message" => "User logged out successfully"
        ], 200);
    }
}
