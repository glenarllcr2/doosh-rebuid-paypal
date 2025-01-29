<?php

namespace App\Policies;

use App\Models\Subscription;
use App\Models\User;

class SubscriptionPolicy
{
    /**
     * Determine whether the user can view any subscriptions.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        // Example: Only Admins and Super Admins can view all subscriptions
        return in_array($user->role->name, ['Admin', 'Super Admin']);
    }

    /**
     * Determine whether the user can view a specific subscription.
     *
     * @param User $user
     * @param Subscription $subscription
     * @return bool
     */
    public function view(User $user, Subscription $subscription): bool
    {
        // Users can view their own subscriptions or Admins/Super Admins can view any
        return $user->id === $subscription->user_id || 
               in_array($user->role->name, ['Admin', 'Super Admin']);
    }

    /**
     * Determine whether the user can create a subscription.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        // Example: Only normal users can create new subscriptions
        return $user->role->name === 'Normal User';
    }

    /**
     * Determine whether the user can update a specific subscription.
     *
     * @param User $user
     * @param Subscription $subscription
     * @return bool
     */
    public function update(User $user, Subscription $subscription): bool
    {
        // Only the owner of the subscription can update it
        return $user->id === $subscription->user_id;
    }

    /**
     * Determine whether the user can delete a subscription.
     *
     * @param User $user
     * @param Subscription $subscription
     * @return bool
     */
    public function delete(User $user, Subscription $subscription): bool
    {
        // Example: Only Super Admins can delete a subscription
        return $user->role->name === 'Super Admin';
    }

    /**
     * Determine whether the user can restore a subscription.
     *
     * @param User $user
     * @param Subscription $subscription
     * @return bool
     */
    public function restore(User $user, Subscription $subscription): bool
    {
        // Example: Only Admins and Super Admins can restore subscriptions
        return in_array($user->role->name, ['Admin', 'Super Admin']);
    }

    /**
     * Determine whether the user can permanently delete a subscription.
     *
     * @param User $user
     * @param Subscription $subscription
     * @return bool
     */
    public function forceDelete(User $user, Subscription $subscription): bool
    {
        // Example: Only Super Admins can force delete a subscription
        return $user->role->name === 'Super Admin';
    }

    /**
     * Determine whether the user can access a specific feature of the subscription.
     *
     * @param User $user
     * @param Subscription $subscription
     * @param string $feature
     * @return bool
     */
    public function accessFeature(User $user, Subscription $subscription, string $feature): bool
    {
        // Check if the subscription's active plan has the requested feature
        $activePlan = $subscription->plan;

        if (!$activePlan || !in_array($feature, $activePlan->features)) {
            return false;
        }

        return true;    
    }
}
