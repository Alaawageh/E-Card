<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\ProfilyResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($uuid) {
        $user = User::where('uuid',$uuid)->with(['profile','profile.links','profile.primary','profile.sections'])->first();
        return UserResource::make($user);
        
    }
    public function index() {
        return UserResource::collection(User::all());
    }

    public function store(RegisterRequest $request) {

        $request->validated();
        
        $user = User::create(array_merge($request->except('password'),
            ['password' => bcrypt($request->password)]
        ));
        
        return response(['user' => UserResource::make($user)]);
        
    }
    public function update(EditUserRequest $request , User $user) {
        $this->authorize('update',[User::class , $user]);
            $user->update($request->validated());
            $user->sendEmailVerificationNotification();
        return response([ 'message' => 'check Your Email To verfiy']);
    }
    public function destroy(User $user) {
        $user->delete();
        return response()->json(['message' => 'Successfully Deleted'] ,200);
    }
}
