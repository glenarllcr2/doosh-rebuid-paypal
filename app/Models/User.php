<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'first_name',
        'middle_name',
        'last_name',
        'display_name',
        'gender',
        'phone_number',
        'birth_date',
        'status',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the messages sent by this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messagesSent(): HasMany
    {
        return $this->hasMany(InternalMessage::class, 'sender_id');
    }

    /**
     * Get the messages received by this user with specific filters.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messagesReceived(): HasMany
    {
        return $this->hasMany(InternalMessage::class, 'receiver_id')
            ->where('status', 'sent')
            ->whereHas('sender', function ($query) {
                $query->where('status', 'active');
            });
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->birth_date)->age;
    }
    /**
     * Get the draft messages sent by this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messagesDraft(): HasMany
    {
        return $this->hasMany(InternalMessage::class, 'sender_id')->where('status', 'draft');
    }

    /**
     * Get the count of unread messages for the user, cached for 10 minutes.
     *
     * @return int
     */
    public function unreadMessagesCount(): int
    {
        $cacheKey = 'unread_messages_count_' . $this->id;

        return Cache::remember($cacheKey, now()->addMinutes(10), function () {
            return $this->messagesReceived()
                ->where('is_read', false)
                ->count();
        });
    }

    /**
     * Get the user's active subscription.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function activeSubscription()
    {
        $temp = $this->hasOne(Subscription::class)
            ->latest('created_at')
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>', now());
            });

        //dd($temp->get());
        return $temp;
    }

    /**
     * Check if the user has an active subscription.
     *
     * @return bool
     */
    public function hasActiveSubscription(): bool
    {
        return $this->activeSubscription()->exists();
    }

    /**
     * Scope for filtering users based on specific criteria.
     *
     * @param Builder $query
     * @param string $gender
     * @param string $birthDate
     * @return Builder
     */
    public function scopeSearchWithFilters(Builder $query, string $gender, string $birthDate): Builder
    {
        $userAge = Carbon::parse($birthDate)->age;

        $currentUser = auth()->user();
        $ageBetween = 10;
        $ageSetting = Setting::where('key', 'age_between')->first();
        //dd($ageBetween);
        if($ageSetting)
            $ageBetween = intVal($ageSetting->value);
        
        //dd($ageBetween);

        $blockedUserIds = $currentUser->blockedUsers()->pluck('users.id')->toArray();
        $blockedByUserIds = $currentUser->blockedByUsers()->pluck('users.id')->toArray();


        $excludedUserIds = array_merge($blockedUserIds, $blockedByUserIds);
        //dd($excludedUserIds);
        return $query->where('status', 'active')
            ->where('gender', '!=', $gender)
            ->where(function ($q) use ($gender, $userAge, $ageBetween) {
                if ($gender === 'male') {
                    $q->whereRaw("TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) <= ?", [$userAge])
                        ->whereRaw("TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) >= ?", [$userAge - $ageBetween]);
                } else {
                    $q->whereRaw("TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) >= ?", [$userAge])
                        ->whereRaw("TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) <= ?", [$userAge + $ageBetween]);
                }
            })
            ->whereNotIn('id', $excludedUserIds);
    }

    public function scopeCompatibleUsers($query, $filters, $gender, $birthDate)
    {
        // ابتدا فیلترهای موجود را اعمال می‌کنیم
        return $query
            // فیلتر برای سن
            ->when(!empty($filters['minAge']) && !empty($filters['maxAge']), function ($q) use ($filters) {
                $minBirthDate = now()->subYears($filters['maxAge'])->format('Y-m-d');
                $maxBirthDate = now()->subYears($filters['minAge'])->format('Y-m-d');
                $q->whereBetween('birth_date', [$minBirthDate, $maxBirthDate]);
            })
            //فیلتر برای محل سکونت
            ->when(!empty($filters['location']), function ($q) use ($filters) {
                $q->whereHas('userAnswers', function ($query) use ($filters) {
                    $query->where('answer_value', $filters['location'])
                        ->join('questions', 'questions.id', '=', 'user_answers.question_id')
                        ->where('questions.question_key', 'country_live');
                });
            })
            // فیلتر برای سطح تحصیلات
            ->when(!empty($filters['education']), function ($q) use ($filters) {
                $q->whereHas('userAnswers', function ($query) use ($filters) {
                    $query->where('answer_value', $filters['education'])
                        ->join('questions', 'questions.id', '=', 'user_answers.question_id')
                        ->where('questions.question_key', 'education_level');
                });
            })
            // فیلتر برای صنعت
            ->when(!empty($filters['industry']), function ($q) use ($filters) {
                $q->whereHas('userAnswers', function ($query) use ($filters) {
                    $query->where('answer_value', $filters['industry'])
                        ->join('questions', 'questions.id', '=', 'user_answers.question_id')
                        ->where('questions.question_key', 'industry');
                });
            })
            // فیلتر برای قد
            ->when(!empty($filters['minHeight']), function ($q) use ($filters) {
                $q->where('height', '>=', $filters['minHeight']);
            })
            ->when(!empty($filters['maxHeight']), function ($q) use ($filters) {
                $q->where('height', '<=', $filters['maxHeight']);
            })
            // فیلتر برای مذهب یا کلیسا
            ->when(!empty($filters['church']), function ($q) use ($filters) {
                $q->whereHas('userAnswers', function ($query) use ($filters) {
                    $query->where('answer_value', $filters['church'])
                        ->join('questions', 'questions.id', '=', 'user_answers.question_id')
                        ->where('questions.question_key', 'church');
                });
            })
            //اکنون از scopeSearchWithFilters استفاده می‌کنیم
            ->searchWithFilters($gender, $birthDate);
    }





    /**
     * Get all media associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function medias()
    {
        return $this->belongsToMany(Media::class, 'user_media')->withPivot('is_profile', 'is_approved');
    }

    /**
     * Get the user's profile image.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function profileImage()
    {
        return $this->belongsToMany(Media::class, 'user_media')->wherePivot('is_profile', true)->limit(1);
    }

    public function getProfileImageAttribute()
    {
        return $this->profileImage()->first()?->url ?? null;
    }
    /**
     * Get the blocked users by the current user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function blockedUsers()
    {
        return $this->belongsToMany(User::class, 'blocks', 'user_id', 'blocked_user_id');
    }

    public function blockedByUsers()
    {
        return $this->belongsToMany(User::class, 'blocks', 'blocked_user_id', 'user_id');
    }

    /**
     * Get the friendships that the user has sent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sentFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'user_id') // user_id کاربر ارسال‌کننده
            ->where('status', 'pending'); // فقط درخواست‌های در حالت 'pending'
    }

    /**
     * Get the friendships that the user has received.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receivedFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'friend_id') // friend_id کاربر دریافت‌کننده
            ->where('status', 'pending'); // فقط درخواست‌های در حالت 'pending'
    }

    public function friends()
    {
        $currentUser = auth()->user();

        // بررسی اولین حالت: user_id = a, friend_id = b, status = 'accepted'
        $firstQuery = DB::table('friendships')
            ->where('user_id', $currentUser->id)
            ->where('status', 'accepted')
            ->select('friend_id as user_id'); // فقط فیلد friend_id را انتخاب می‌کنیم و نام آن را به user_id تغییر می‌دهیم

        // بررسی دومین حالت: user_id = b, friend_id = a, status = 'accepted'
        $secondQuery = DB::table('friendships')
            ->where('friend_id', $currentUser->id)
            ->where('status', 'accepted')
            ->select('user_id');

        // ترکیب دو شرط: اگر یکی از دو شرط برقرار باشد، دوستی برقرار است
        $friendIds = $firstQuery->union($secondQuery)->pluck('user_id'); // گرفتن لیست idهای دوستان

        // بازگرداندن مدل‌های User که وضعیت 'active' دارند و کاربر بلوک‌شده نیست
        $friends = User::whereIn('id', $friendIds)->where('status', 'active');
        return $friends;
        //dd($friends->get());

        //->where('status', 'active'); // فقط کاربرانی که وضعیت 'active' دارند
    }


    /**
     * Check if the user is friends with another user.
     *
     * @param User $user
     * @return bool
     */
    public function isFriendWith(User $user)
    {
        // بررسی اینکه آیا کاربر در لیست دوستان است
        return $this->friends()->where('id', $user->id)->exists();
    }




    /**
     * Block a specific user.
     *
     * @param User $user
     * @return void
     */
    public function blockUser(User $user)
    {
        $this->blockedUsers()->attach($user);
    }

    /**
     * Unblock a specific user.
     *
     * @param User $user
     * @return void
     */
    public function unblockUser(User $user)
    {
        $this->blockedUsers()->detach($user);
    }

    /**
     * Get the user's answers to various questions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userAnswers(): HasMany
    {
        return $this->hasMany(UserAnswer::class);
    }

    public function userAnswersWithQuestionsRelation()
    {
        return $this->hasMany(UserAnswer::class)->with('question');
    }

    public function userAnswersWithQuestions_n()
    {

        return $this->hasMany(UserAnswer::class, 'user_id')
            ->join('questions', 'user_answers.question_id', '=', 'questions.id')
            ->select('user_answers.*', 'questions.question_key', 'questions.question');
    }
    public function userAnswersWithQuestions(): array
    {
        // گرفتن پاسخ‌های کاربر همراه با پرسش‌ها
        $userAnswers = $this->userAnswers()
            ->with('question') // بارگذاری پرسش‌ها
            ->get();

        // ساخت آرایه با question_key به عنوان کلید و answer_value به عنوان مقدار
        $answersArray = $userAnswers->reduce(function ($carry, $userAnswer) {
            // چک کردن نوع پاسخ، اگر boolean باشد
            if ($userAnswer->question->answer_type === 'boolean') {
                // اگر پاسخ 1 باشد Yes و اگر 0 باشد No
                $answerValue = $userAnswer->answer_value == 1 ? 'Yes' : 'No';
            } else {
                // در غیر این صورت، همان مقدار پاسخ را می‌گیریم
                $answerValue = $userAnswer->answer_value;
            }

            // اضافه کردن پاسخ به آرایه خروجی
            $carry[$userAnswer->question->question_key] = $answerValue;
            return $carry;
        }, []);

        return $answersArray;
    }


    /**
     * Find similar users based on answers and filters.
     *
     * @return \Illuminate\Support\Collection
     */
    public function findSimilarUsersBasedOnAnswers()
    {
        $currentUser = auth()->user();

        // 1. دریافت کاربران فیلتر شده از نظر جنسیت و تاریخ تولد
        $filteredUsersQuery = User::query()->searchWithFilters(
            $currentUser->gender,
            $currentUser->birth_date
        )->where('id', '!=', $currentUser->id); // حذف خود کاربر

        $filteredUserIds = $filteredUsersQuery->pluck('id');

        if ($filteredUserIds->isEmpty()) {
            return collect();
        }

        // 2. دریافت پاسخ‌های کاربر اصلی
        $userAnswers = $currentUser->userAnswers;
        $userSimilarityScores = [];

        // 3. بررسی شباهت پاسخ‌ها برای کاربران فیلتر شده
        foreach ($userAnswers as $userAnswer) {
            $similarUsers = UserAnswer::where('question_id', $userAnswer->question_id)
                ->where('answer_value', $userAnswer->answer_value)
                ->whereIn('user_id', $filteredUserIds)
                ->pluck('user_id');

            foreach ($similarUsers as $similarUserId) {
                if (!isset($userSimilarityScores[$similarUserId])) {
                    $userSimilarityScores[$similarUserId] = 0;
                }
                $userSimilarityScores[$similarUserId]++;
            }
        }

        // 4. مرتب‌سازی کاربران بر اساس امتیاز شباهت
        arsort($userSimilarityScores);
        $similarUserIds = array_keys($userSimilarityScores);

        // 5. حذف کاربرانی که درخواست دوستی ارسال شده برایشان
        $sentRequestsUserIds = $currentUser->sentFriendRequests()->pluck('friend_id')->toArray();
        $filteredUserIds = array_diff($similarUserIds, $sentRequestsUserIds);

        // 6. حذف کاربرانی که دوستان ما هستند
        $friendsUserIds = $currentUser->friends()->pluck('id')->toArray();
        $filteredUserIds = array_diff($filteredUserIds, $friendsUserIds);

        // 7. برگرداندن کاربران مشابه
        return User::whereIn('id', $filteredUserIds)->get();
    }

    public function isAdmin()
    {
        return ($this->role_id == 1);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // public function checkSubscription()
    // {
    //     // Check if the user has an active subscription
    //     $subscription = $this->activeSubscription;
    //     //dd($subscription);
    //     // If there's no active subscription or the plan is 'Plan C', deny access
    //     if (!$subscription || $subscription->plan->name === 'Plan C') {
    //         return false;
    //     }

    //     // Return the plan name if the subscription is valid
    //     return $subscription->plan->name;
    // }

    public function checkSubscription($access)
    {
        $subscription = $this->activeSubscription;
        if(!$subscription)
            return false;
        
        switch ($access) {
            case 'getInbox':
                //dd('getInbox', $subscription->plan_id != 3);
                return ($subscription->plan_id != 3); //plan c
            case 'saveDraft':
                return ($subscription->plan_id != 3); //plan c
            case 'composeMessage':
                return ($subscription->plan_id != 3); //plan c
            case 'readSent':
                return ($subscription->plan_id != 3); //plan c
            case 'sendMessage':
                return ($subscription->planplan_id != 3); //plan c
            case 'sendReply':
                return ($subscription->plan_id != 3); //plan c
            case 'readDraft':
                return ($subscription->plan_id != 3); //plan c
            case 'markAsRead':
                return ($subscription->plan_id != 3); //plan c
            case 'reply':
                return ($subscription->plan_id != 3); //plan c
            case 'sendRequest':
                return ($subscription->plan_id != 3); //plan c
            case 'acceptRequest':
                return ($subscription->plan_id != 3); //plan c
            case 'rejectRequest':
                return ($subscription->plan_id != 3); //plan c
            case 'blockUser':
                return ($subscription->plan_id != 3); //plan c
            case 'unBlockUser':
                return ($subscription->plan_id != 3); //plan c
            case 'removeFriend':
                return ($subscription->plan_id != 3); //plan c
            case 'viewUserProfile':
                return ($subscription->plan_id != 3); //plan c
        }

        //dd($subscription->plan->id);
        // if ($subscription->plan->id == 3) {
        //     return false;
        //     //return view('Subscription.upgrade');
        // }
        return true;
    }


    public function reports()
    {
        return $this->hasMany(UserReport::class, 'user_id');
    }
}
