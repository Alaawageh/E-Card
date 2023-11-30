<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\LinkResource;
use App\Models\Link;
use App\Models\Profile;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function getLinks(Profile $profile , Link $link) {
        abort_if(auth()->user()->id != $profile->user_id , 403 , 'unauthorized');
        return LinkResource::collection($profile->links()->get());
    }
    public function DeleteLink(Profile $profile , Link $link) {
        abort_if(auth()->user()->id != $profile->user_id , 403 , 'unauthorized');
        $link->delete();
        return response()->json(['message' => 'Done']);
    }
}
