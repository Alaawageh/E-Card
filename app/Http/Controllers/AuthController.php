<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {
        $request->validated();
        if (! Auth::attempt($request->only(['userName','email','password']))) {
            return response( ['message' => 'Incorrect email or password'] , 422);
        }
        
        $user = User::where('email', $request->email)->orWhere('userName', $request->userName)->first();
        $auth = auth()->user();
        return response([
            'token' => $user->createToken("TOKEN")->plainTextToken,
            'user' => UserResource::make($auth)
        ],200);
    }

    public function logout(Request $request) {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out'] ,200);
    }

}
