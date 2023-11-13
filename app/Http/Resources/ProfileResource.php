<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'nick_name' => $this->nick_name,
            'theme' => $this->theme,
            'color' => $this->color,
            'cover' => url($this->cover),
            'photo' => url($this->photo),
            'emails' => json_decode($this->emails),
            'phoneNum' => json_decode($this->phoneNum),
            'bio' => $this->bio,
            'about' => $this->about,
            'location' => $this->location,
            'links' => LinkResource::collection($this->links),
            'media' => MediaResource::collection($this->media),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
        ];
    }
}
