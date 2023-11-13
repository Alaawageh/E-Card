<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'nick_name' => 'required|string|max:255',
            'theme' => 'required|string',
            'color' => 'required|string',
            'cover' => 'nullable|image|mimes:jpeg,jpg,png',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png',
            'emails' => 'nullable|unique:profiles,emails',
            'phoneNum' => 'nullable',
            'bio' => 'nullable|string',
            'about' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'links.*.link' => 'nullable|string',
            'links.*.name_link' => 'nullable|string|max:255',
            'media.*.url' => 'nullable|file|mimes:jpeg,jpg,png,pdf,mp4',
            'media.*.type' => 'nullable|in:image,file,video'
        ];
    }

}
