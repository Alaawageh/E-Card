<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditProfileRequest;
use App\Http\Requests\LinkRequest;
use App\Http\Requests\MediaRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\AdminResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\ShowResource;
use App\Models\Link;
use App\Models\Media;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(Profile $profile) {
        return new ProfileResource($profile->load('links','media'));
    }
    public function index(Profile $profile) {
        $userprofile = $profile->load('user','links','media');
        return new AdminResource($userprofile);
    }

    public function store(ProfileRequest $request) {
        $request->validated();

        $profile = Profile::create(array_merge($request->except('phoneNum','emails'),['phoneNum' => json_encode($request->phoneNum),
                                    'emails' => json_encode($request->emails)]));
        if(isset($request->links)) {
            foreach($request->links as $link) {
                Link::create([
                    'profile_id' => $profile->id,
                    'name_link' => $link['name_link'],
                    'link' => $link['link'],
                ]);
            }
        }
        if(isset($request->media)) {
            foreach($request->media as $one) {
                Media::create([
                    'profile_id' => $profile->id,
                    'type' => $one['type'],
                    'url' => $one['url']
                ]);
            }
        }
        return response()->json(['message' => 'Data Saved Succcessfully']);

    }
    public function update(EditProfileRequest $request ,Profile $profile) {
        $request->validated();
        $profile->update(array_merge($request->except('phoneNum','emails'),['phoneNum' => json_encode($request->phoneNum),
            'emails' => json_encode($request->emails)]));
        if(isset($request->links)) {
            foreach($request->links as $link) {
                Link::updateOrCreate(
                   [ 
                    'profile_id' => $profile->id,
                   'name_link' => $link['name_link'],
                   'link' => $link['link'],
                   ]
                );
            }
        }
        if(isset($request->media)) {
            foreach($request->media as $one) {
                Media::updateOrCreate(
                   [
                    'profile_id' => $profile->id,
                    'type' => $one['type'],
                    'url' => $one['url']
                   ]
                );
            }
        }
        return response()->json(['message' => 'Data Saved Succcessfully']);
    }
    public function delete(Profile $profile) {
        $profile->delete();
        return response()->json(['message' => 'Successfully Deleted Profile'] ,200);
    }

    public function counter(Link $link) {

        $link->update(['views' => $link->views +1]);
        return $link;
    }
    

    
}
