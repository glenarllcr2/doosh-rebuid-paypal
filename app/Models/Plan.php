<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'is_active',
        'is_recommended',
        'duration',
        'price',
        'description',
        'status',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'plan_permission');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function features()
    {
        $permissions = $this->permissions()->pluck('name')->toArray();

        $features = [
            'C' => [
                'send_message' => in_array('send_message', $permissions),
                'send_emoji' => in_array('send_emoji', $permissions),
                'view_message' => in_array('view_message', $permissions),
                'message_length_limit' => in_array('message_length_limit', $permissions) ? 0 : null, // ارسال پیام با طول صفر (emoji فقط)
            ],
            'B' => [
                'send_message' => in_array('send_message', $permissions),
                'send_emoji' => in_array('send_emoji', $permissions),
                'view_message' => in_array('view_message', $permissions),
                'message_length_limit' => in_array('message_length_limit', $permissions) ? 128 : null, // محدودیت طول پیام ۱۲۸ کاراکتر
            ],
            'A' => [
                'send_message' => in_array('send_message', $permissions),
                'send_emoji' => in_array('send_emoji', $permissions),
                'view_message' => in_array('view_message', $permissions),
                'message_length_limit' => in_array('message_length_limit', $permissions) ? 512 : null, // محدودیت طول پیام ۵۱۲ کاراکتر
            ]
        ];

        // بازگشت ویژگی‌ها براساس نام پلن
        return $features[$this->name] ?? [];
    }
}
