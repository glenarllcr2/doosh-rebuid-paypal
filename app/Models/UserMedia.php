<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMedia extends Model
{
    protected $fillable = [
        'user_id', 'media_id', 'is_profile', 'is_approved',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function media()
    {
        return $this->belongsTo(Media::class);
    }
}
