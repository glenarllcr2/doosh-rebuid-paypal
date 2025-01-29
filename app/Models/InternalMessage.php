<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InternalMessage
 *
 * Represents an internal message exchanged between users.
 *
 * @property int $id
 * @property int $sender_id
 * @property int $receiver_id
 * @property string|null $message
 * @property bool $is_read
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\User $sender
 * @property-read \App\Models\User $receiver
 */
class InternalMessage extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id', 'receiver_id', 'message', 'is_read', 'read_at', 'parent_id', 'status', 'sent_at'];
    protected $casts = [
        'read_at' => 'datetime',
        'sent_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The policy class associated with this model.
     *
     * @var string
     */
    public static $policy = \App\Policies\InternalMessagePolicy::class;
    /**
     * Get the sender of the message.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the receiver of the message.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Get the parent message (if any).
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get replies to this message.
     */
    public function replies()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
