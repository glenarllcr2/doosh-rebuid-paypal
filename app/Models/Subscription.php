<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Subscription
 * Represents a user's subscription to a plan.
 *
 * @property int $id
 * @property int $user_id
 * @property int $plan_id
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property-read \App\Models\Plan $plan
 * @property-read \App\Models\User $user
 */
class Subscription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'plan_id', 'start_date', 'end_date'];

    /**
     * The policy class associated with this model.
     *
     * @var string
     */
    protected static $policy = \App\Policies\SubscriptionPolicy::class;

    /**
     * Get the plan associated with the subscription.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get the user associated with the subscription.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
