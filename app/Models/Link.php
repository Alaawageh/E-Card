<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;
    protected $fillable = [
        'profile_id' , 'name_link' , 'link' , 'views'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
