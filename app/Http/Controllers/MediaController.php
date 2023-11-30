<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use App\Models\Profile;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function getMedia(Profile $profile , Media $media) {
        abort_if(auth()->user()->id != $profile->user_id , 403 , 'unauthorized');
        return MediaResource::collection($profile->media()->get());
    }
    public function DeleteMedia(Profile $profile , Media $media) {
        abort_if(auth()->user()->id != $profile->user_id , 403 , 'unauthorized');
        $media->delete();
        return response()->json(['message' => 'Done']);
    }
}
