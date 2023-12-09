<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'userName' => $this->userName,
            'email' => isset($this->email) ? $this->email : " ",
            'uuid' => $this->uuid,
            // 'is_admin' => isset($this->is_admin) ? $this->is_admin == true : false,
            'profile' =>  ProfileResource::make($this->whenLoaded('profile'))
        ];
    }
}
