<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','first_name','last_name','nick_name',
        'theme','color','cover','photo','emails','phoneNum','bio','about','location'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function links()
    {
        return $this->hasMany(Link::class); 
    }
    public function media()
    {
        return $this->hasMany(Media::class);
    }
    public function setCoverAttribute($cover)
    {
       $newCoverName = uniqid() . '_' . 'cover' . '.' . $cover->extension();
       $cover->move(public_path('images/user'), $newCoverName);
       return $this->attributes['cover'] = '/images/user/' . $newCoverName;
    }
    public function setPhotoAttribute($photo)
    {
    $newPhotoName = uniqid() . '_' . 'photo' . '.' . $photo->extension();
    $photo->move(public_path('images/user'), $newPhotoName);
    return $this->attributes['photo'] = '/images/user/' . $newPhotoName;
    }
}
