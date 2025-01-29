<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingExtend extends Model
{
    public $fillable =[
        'key',
        'type',
        'value'
    ];
}
