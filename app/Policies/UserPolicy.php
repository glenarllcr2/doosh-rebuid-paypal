<?php
namespace App\Policies;

use App\Models\InternalMessage;
use App\Models\User;

class UserPolicy
{
    /**
     * Create a new Policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Check the user's active subscription and return the plan name.
     *
     * @param User $user
     * @return bool|string
     */
    private function checkSubscription(User $user)
    {
        // Check if the user has an active subscription
        $subscription = $user->activeSubscription;

        // If there's no active subscription or the plan is 'Plan C', deny access
        if (!$subscription || $subscription->plan->name === 'Plan C') {
            return false;
        }

        // Return the plan name if the subscription is valid
        return $subscription->plan->name;
    }

    /**
     * Check if the user has access to the inbox.
     *
     * @param User $user
     * @return bool
     */
    public function getInbox(User $user): bool
    {
        //return false;
        // Check the subscription and access rights
        return $this->checkSubscription($user) !== false;
    }

    /**
     * Check if the user can send a message.
     *
     * @param User $user
     * @param User $receiver
     * @return bool
     */
    public function sendMessage(User $user): bool
    {
        // Check subscription and access rights
        $plan = $this->checkSubscription($user);
        if ($plan === false) {
            return false;
        }

        // Allow sending messages only if the plan is 'Plan A' or 'Plan B'
        return in_array($plan, ['Plan A', 'Plan B']);
    }

    /**
     * Check if the user can view a message.
     *
     * @param User $user
     * @param InternalMessage $message
     * @return bool
     */
    public function viewMessage(User $user, InternalMessage $message): bool
    {
        // Check if the message belongs to the user (either as sender or receiver)
        if ($message->receiver_id !== $user->id && $message->sender_id !== $user->id) {
            return false; // If the user is neither the sender nor the receiver
        }

        // Check the subscription and access rights
        $plan = $this->checkSubscription($user);
        if ($plan === false) {
            return false;
        }

        // Special rule for Plan C: allow only emoji-only messages
        if ($plan === 'Plan C') {
            return $this->isEmojiOnly($message->message);
        }

        return true; // In all other cases, allow viewing the message
    }

    /**
     * Check if the message contains only emojis.
     *
     * @param string $text
     * @return bool
     */
    private function isEmojiOnly(string $text): bool
    {
        // Regex to match emojis
        $emojiRegex = '/^[\p{Emoji}\p{P}\p{S}]+$/u';

        // Trim and check the text
        $text = trim($text);
        return preg_match($emojiRegex, $text) === 1;
    }

    /**
     * Check if the user can send a reply.
     *
     * @param User $user
     * @return bool
     */
    public function sendReply(User $user): bool
    {
        return $this->checkSubscription($user) !== false;
    }

    /**
     * Check if the user can send a draft.
     *
     * @param User $user
     * @return bool
     */
    public function sendDraft(User $user): bool
    {
        return $this->checkSubscription($user) !== false;
    }

    /**
     * Check if the user can send a friend request.
     *
     * @param User $user
     * @return bool
     */
    public function sendFriendRequest(User $user): bool
    {
        return $this->checkSubscription($user) !== false;
    }

    /**
     * Check if the user can accept a friend request.
     *
     * @param User $user
     * @return bool
     */
    public function acceptFriendRequest(User $user): bool
    {
        return $this->checkSubscription($user) !== false;
    }

    /**
     * Check if the user can reject a friend request.
     *
     * @param User $user
     * @return bool
     */
    public function rejectFriendRequest(User $user): bool
    {
        return $this->checkSubscription($user) !== false;
    }

    /**
     * Check if the user can remove a friend.
     *
     * @param User $user
     * @return bool
     */
    public function removeFriend(User $user): bool
    {
        return $this->checkSubscription($user) !== false;
    }

    /**
     * Check if the user can block another user.
     *
     * @param User $user
     * @return bool
     */
    public function blockUser(User $user): bool
    {
        return $this->checkSubscription($user) !== false;
    }

    /**
     * Check if the user can unblock another user.
     *
     * @param User $user
     * @return bool
     */
    public function unBlockUser(User $user): bool
    {
        return $this->checkSubscription($user) !== false;
    }
}
