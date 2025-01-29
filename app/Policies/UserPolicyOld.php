<?php
namespace App\Policies;

use App\Models\InternalMessage;
use App\Models\User;

class UserPolicyOld
{
    /**
     * Determine if the user has access as an admin.
     */
    public function accessAsAdmin(User $user): bool
    {
        // Check if the user's role_id is 1
        return $user->role_id === 1;
    }

    public function getInbox(User $user)
    {
        return true;
        $subscription = $user->activeSubscription;

        if (!$subscription) {
            return false; // اگر اشتراک فعال وجود نداشت
        }
        //dd('1');
        $plan = $subscription->plan->name;

        // قوانین مربوط به طرح‌های مختلف
        if ($plan === 'Plan C') {
            return false;
        }
        return true;
    }
    /**
     * Check if the user can send a message.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $receiver
     * @return bool
     */
    public function send(User $user, User $receiver): bool
    {
        // دریافت اشتراک فعال
        $subscription = $user->activeSubscription;

        if (!$subscription) {
            return false; // اگر اشتراک فعال وجود نداشت
        }
        //dd('1');
        $plan = $subscription->plan->name;

        // قوانین مربوط به طرح‌های مختلف
        if ($plan === 'Plan C') {
            return false;
            //dd('test');
            if (!$this->containsEmoji(request('message'))) {
                //dd(request('message'));
                return false; // اگر پیام حاوی متن غیر از ایموجی بود
            }

            $lastMessage = InternalMessage::where('sender_id', $user->id)
                ->where('receiver_id', $receiver->id)
                ->latest()
                ->first();
            // ارسال پیام فقط در صورت پاسخ از طرف مقابل
            return !$lastMessage || $lastMessage->replies->count() > 0;
        }

        if ($plan === 'Plan B' || $plan === 'Plan A' || $plan === 'Plan B') {
            return true; // اجازه ارسال پیام در این دو طرح
        }

        return false;
    }

    /**
     * Check if the user can view a received message.
     *
     * @param \App\Models\User $user
     * @param \App\Models\InternalMessage $message
     * @return bool
     */
    public function view(User $user, InternalMessage $message): bool
    {
        // بررسی اینکه پیام متعلق به کاربر است
        if ($message->receiver_id !== $user->id && $message->sender_id !== $user->id) {
            return false; // اگر کاربر نه فرستنده باشد و نه گیرنده
        }

        // دریافت اشتراک فعال
        $subscription = $user->activeSubscription;
        if (!$subscription) {
            return false; // اگر اشتراک فعال وجود نداشت
        }

        $plan = $subscription->plan->name;


        // قوانین مشاهده برای Plan C
        if ($plan === 'Plan C') {
            return false;
            // بررسی پیام که فقط ایموجی باشد
            if (!$this->isEmojiOnly($message->message)) {
                return false; // اگر پیام حاوی متن غیر از ایموجی بود
            }
        }

        return true; // سایر موارد مجاز به مشاهده
    }

    public function sendMessage(User $user): bool
    {
        //dd('123');
        return true;
        $subscription = $user->activeSubscription;
        
        if($subscription == "Plan C") 
            return false;
        return true;
    }

    public function sendRequest(User $user): bool
    {
        $subscription = $user->activeSubscription;

        if($subscription == "Plan C") 
            return false;
        return true;
    }
    public function acceptRequest(User $user): bool
    {
        $subscription = $user->activeSubscription;

        if($subscription == "Plan C") 
            return false;
        return true;
    }
    public function rejectRequest(User $user): bool
    {
        $subscription = $user->activeSubscription;

        if($subscription == "Plan C") 
            return false;
        return true;
    }
    
    public function removeFriend(User $user): bool
    {
        $subscription = $user->activeSubscription;

        if($subscription == "Plan C") 
            return false;
        return true;
    }

    public function sendReply(User $user): bool
    {
        $subscription = $user->activeSubscription;

        if($subscription == "Plan C") 
            return false;
        return true;
    }
    public function sendDraft(User $user): bool
    {
        $subscription = $user->activeSubscription;

        if($subscription == "Plan C") 
            return false;
        return true;
    }
    public function blockUser(User $user): bool
    {
        $subscription = $user->activeSubscription;

        if($subscription == "Plan C") 
            return false;
        return true;
    }
    public function unBlockUser(User $user): bool
    {
        $subscription = $user->activeSubscription;

        if($subscription == "Plan C") 
            return false;
        return true;
    }
    /**
     * بررسی اینکه آیا متن فقط شامل ایموجی است
     *
     * @param string $text
     * @return bool
     */
    private function isEmojiOnly(string $text): bool
    {
        // Regex برای تشخیص ایموجی‌ها
        $emojiRegex = '/^[\p{Emoji}\p{P}\p{S}]+$/u';

        // حذف فاصله‌های اضافی و بررسی متن
        $text = trim($text);
        return preg_match($emojiRegex, $text) === 1;
    }

    /**
     * بررسی اینکه آیا متن شامل ایموجی است
     *
     * @param string $text
     * @return bool
     */
    private function containsEmoji(string $text): bool
    {
        $cleanedText = strip_tags($text);

        // حذف کاراکترهای اضافی مثل \u{FEFF}
        $cleanedText = preg_replace('/[\x{FEFF}]+/u', '', $cleanedText);

        // Regex برای تشخیص ایموجی‌ها
        $emojiRegex = '/^[\p{Emoji}\p{P}\p{S}]+$/u';

        return preg_match($emojiRegex, $cleanedText) === 1;
    }
}
