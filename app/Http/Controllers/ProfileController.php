<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditProfileRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\LinkResource;
use App\Http\Resources\ProfileResource;
use App\Models\Link;
use App\Models\Media;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Profile $profile) {
        return new ProfileResource($profile->load('links','media'));
    }
    public function getLinks(Profile $profile) {
        return new ProfileResource($profile->load('links'));
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
        return response()->json(['data' => new ProfileResource($profile) , 'message' => 'Data Saved Succcessfully']);

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
        return response()->json(['data' => new ProfileResource($profile),'message' => 'Data Saved Succcessfully']);
    }
    public function destroy(Profile $profile) {
        $profile->delete();
        return response()->json(['message' => 'Successfully Deleted Profile'] ,200);
    }

    public function visitLink(Link $link) {

        $link->update(['views' => $link->views +1]);
        return $link;
    }
    
    public function visitProfile(Profile $profile) {
        $profile->update(['views' => $profile->views +1]);
        return $profile;
    }
    public function getViews_profile(Request $request) {
        $year = $request->year;
        $month = $request->month;
        $day = $request->day;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $profile = Profile::where('user_id',auth()->user()->id);

        if ($year && $month && $day) {
            $profile->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->whereDay('created_at', $day)->select('views');
        } elseif ($year && $month) {
            $profile->whereYear('created_at', $year)
                  ->whereMonth('created_at', $month)->select('views');
        } elseif ($year) {
            $profile->whereYear('created_at', $year)->select('views');
        } elseif ($day) {
            $profile->whereDay('created_at', $day)->select('views');
        } elseif ($startDate && $endDate) {
            $profile->whereBetween('created_at', [$startDate, $endDate])->select('views');
        }
        $data = $profile->first();
        if (! $data) {
            return response(['views' => 0]);
        }
        return response(['views' => $data->views]);
    }
    public function getViews_link(Request $request, Link $link) {
        $year = $request->year;
        $month = $request->month;
        $day = $request->day;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $query = Link::where('id',$link->id);

        if ($year && $month && $day) {
            $query->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->whereDay('created_at', $day)->select('views');
        } elseif ($year && $month) {
            $query->whereYear('created_at', $year)
                  ->whereMonth('created_at', $month)->select('views');
        } elseif ($year) {
            $query->whereYear('created_at', $year)->select('views');
        } elseif ($day) {
            $query->whereDay('created_at', $day)->select('views');
        } elseif ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate])->select('views');
        }
        $data = $query->first();
        if (! $data) {
            return response(['views' => 0]);
        }
        return response(['views' => isset($data->views) ? $data->views : 0]);
    }
    
}
