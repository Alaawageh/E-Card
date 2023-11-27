<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditLoginRequest;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {
        $request->validated();
        if (! Auth::attempt($request->only(['email','password']))) {
            return response( ['message' => 'Incorrect email or password'] , 422);
        }
        $user = User::where('email', $request->email)->first();
        $auth = auth()->user();
        return response([
            'token' => $user->createToken("API TOKEN")->plainTextToken,
            'user' => UserResource::make($auth)
        ],200);
    }

    public function logout() {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out'] ,200);
    }

    public function register(RegisterRequest $request) {

        $request->validated();
        
        $user = User::create(array_merge($request->except('password'),
            ['password' => bcrypt($request->password)]
        ));
    
        return response(['user' => UserResource::make($user)]);
        
    }
    public function update(EditUserRequest $request , User $user) {
        $request->validated();
        $user->update($request->only('email','password'));
        return response(['user' => UserResource::make($user)]);
    }
}
