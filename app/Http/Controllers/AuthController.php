<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('username', $request->username)->orWhere('email', $request->username)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
               'msg' => 'Invalid username or password'
            ], 401);
        }
        $token = $user->createToken('apiToken')->plainTextToken;
        $res = [
            'user' => new UserResource($user),
            'token' => $token
        ];

        return response($res, 201);
    }
    public function logout(Request $request) {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out'] ,200);
    }

}
