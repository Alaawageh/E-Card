<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id' , 'type' , 'url'
    ];

    public function setUrlAttribute($url) {
        $newUrlName = uniqid() . '_' . 'url' . '.' . $url->extension();
        $url->move(public_path('media/user'), $newUrlName);
        return $this->attributes['url'] = '/media/user/' . $newUrlName;
    }
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
