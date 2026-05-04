<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate(['email'=>'email|required|exists:users,email']);
        Password::sendResetLink($request->only('email'));
        return response()->json(['damn' => 'damn']); 
    }
}
