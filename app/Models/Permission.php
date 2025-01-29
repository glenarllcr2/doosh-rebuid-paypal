<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plan_permission');
    }
}
