<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;

    // جدول مرتبط
    protected $table = 'blocks'; 

    // فیلدهایی که قابل پر شدن هستند
    protected $fillable = [
        'user_id',
        'blocked_user_id',
    ];

    // تنظیمات ارتباط با مدل User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function blockedUser()
    {
        return $this->belongsTo(User::class, 'blocked_user_id');
    }
}
