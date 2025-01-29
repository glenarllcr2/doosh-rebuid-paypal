<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'medias';
    protected $fillable = [
        'url',
        'type',
        'mime_type',
        'size',
    ];


    public function users()
    {
        return $this->belongsToMany(User::class, 'user_media')->withPivot('is_profile', 'is_approved');
    }
}
