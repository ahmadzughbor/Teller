<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{


    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
    
            // Generate a personal access token
            $token = $user->createToken('API Token')->accessToken;
    
            return response()->json(['access_token' => $token]);
        }
    
        return response()->json(['error' => 'Unauthorized'], 401);
    }



    public function apiLogout(Request $request)
    {
        Auth::user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json(['message' => 'Logged out successfully']);
    }


    public function apiRefresh(Request $request)
    {
        $newToken = $request->user()->createToken('API Token')->accessToken;

        return response()->json(['access_token' => $newToken]);
    }
}
