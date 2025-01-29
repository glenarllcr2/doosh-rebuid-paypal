<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Friendship;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FriendshipController extends BaseController
{

    public static $menu_label = "Home";
    public static $menu_icon = 'bi bi-house-fill';
    public static $base_route = 'friends';


    public static $actions = [
        [
            'label' => 'Mydashboard',
            'icon' => 'bi bi-speedometer',
            'route' => 'friends.index',
        ],


    ];
    /**
     * Display the list of friends, blocked users, and pending friend requests.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $currentUser = auth()->user();
        $userId = auth()->id();

        if ($currentUser->status == 'suspended')
            return view('Users.suspended');
        if ($currentUser->status == 'blocked')
            return view('Users.blocked');
        if ($currentUser->status == 'pending')
            return view('Users.not-active');
        if ($currentUser->status != 'active')
            return view('Users.not-active');


        // لیست دوستان
        $friends = $currentUser->friends();
        //dd($friends->get());
        // Friendship::where(function ($query) use ($userId) {
        //     $query->where('user_id', $userId)
        //         ->orWhere('friend_id', $userId);
        // })
        //     ->where('status', 'accepted') // وضعیت دوستی تایید شده
        //     ->with(['user', 'friend'])  // بارگذاری هر دو طرف دوستی
        //     ->get()
        //     ->map(function ($friendship) use ($userId) {
        //         return $friendship->user_id === $userId
        //             ? $friendship->friend // کاربر طرف مقابل دوستی
        //             : $friendship->user;   // خود کاربر
        //     });

        // کاربران بلاک‌شده (از مدل Block)
        $blockedUsers = Block::where('user_id', $userId)
            ->with('blockedUser')  // بارگذاری اطلاعات کاربران بلاک‌شده
            ->get()
            ->pluck('blockedUser');  // استخراج اطلاعات کاربران بلاک‌شده

        // درخواست‌های دوستی دریافت‌شده
        $pendingRequests = Friendship::with('user')
            ->where('friend_id', $userId)
            ->where('status', 'pending')

            ->get()
            ->where('user.status', 'active')
            ->pluck('user'); // درخواست‌هایی که به کاربر ارسال شده‌اند


        //dd($pendingRequests->get());
        // ارسال داده‌ها به ویو
        return view('friends.index', [
            'friends' => $friends->get(),            // لیست دوستان
            'blockedUsers' => $blockedUsers,  // لیست کاربران بلاک‌شده
            'pendingRequests' => $pendingRequests, // لیست درخواست‌های دوستی دریافت‌شده
            'suggestions' => $currentUser->findSimilarUsersBasedOnAnswers(),
        ]);
    }


    public function sendRequest($friendId)
    {
        $user = auth()->user();
        if (!$user->checkSubscription('sendRequest')) {

            $plans = Plan::where('is_active', 1)
                ->orderBy('is_recommended', 'desc')
                ->get();
            // هدایت به صفحه ارتقاء اشتراک در صورت عدم دسترسی
            return view('Subscription.upgrade',['plans'=>$plans]);
        }
        // بررسی اینکه آیا دوستی بین کاربران قبلاً وجود دارد یا خیر
        $existingFriendship = Friendship::where(function ($query) use ($user, $friendId) {
            $query->where('user_id', $user->id)
                ->where('friend_id', $friendId);
        })->orWhere(function ($query) use ($user, $friendId) {
            $query->where('user_id', $friendId)
                ->where('friend_id', $user->id);
        })->first();

        if ($existingFriendship) {
            // اگر دوستی قبلاً موجود است
            return back()->with('error', 'Friendship already exists.');
        }

        // ایجاد رکورد دوستی جدید
        Friendship::create([
            'user_id' => $user->id,
            'friend_id' => $friendId,
            'status' => 'pending',  // یا 'accepted' اگر می‌خواهید فوری پذیرفته شود
        ]);

        return back()->with('success', 'Friend request sent.');
    }


    public function acceptRequest($requesterId)
    {
        $userId = auth()->id(); // گرفتن ID کاربر فعلی
        if (!auth()->user()->checkSubscription('acceptRequest')) {
            // هدایت به صفحه ارتقاء اشتراک در صورت عدم دسترسی
            return view('Subscription.upgrade');
        }
        // پیدا کردن رکورد دوستی که در آن درخواست دوستی ارسال شده است
        $friendship = Friendship::where(function ($query) use ($userId, $requesterId) {
            $query->where('user_id', $userId)
                ->where('friend_id', $requesterId);
        })
            ->orWhere(function ($query) use ($userId, $requesterId) {
                $query->where('user_id', $requesterId)
                    ->where('friend_id', $userId);
            })
            ->where('status', 'pending') // فقط درخواست‌های دوستی که در وضعیت "در انتظار" هستند
            ->first();

        // اگر رکورد دوستی پیدا شد
        if ($friendship) {
            $friendship->status = 'accepted'; // تغییر وضعیت به پذیرفته‌شده
            $friendship->save(); // ذخیره‌سازی تغییرات
            return back()->with('success', 'Friend request accepted.');
        }

        // در صورتی که رکوردی پیدا نشد
        return back()->with('error', 'Friend request not found.');
    }


    public function rejectRequest($requesterId)
    {
        $userId = auth()->id(); // گرفتن ID کاربر فعلی
        if (!auth()->user()->checkSubscription('rejectRequest')) {
            // هدایت به صفحه ارتقاء اشتراک در صورت عدم دسترسی
            return view('Subscription.upgrade');
        }
        // پیدا کردن رکورد دوستی که در آن درخواست دوستی ارسال شده است
        $friendship = Friendship::where(function ($query) use ($userId, $requesterId) {
            $query->where('user_id', $userId)
                ->where('friend_id', $requesterId);
        })
            ->orWhere(function ($query) use ($userId, $requesterId) {
                $query->where('user_id', $requesterId)
                    ->where('friend_id', $userId);
            })
            ->where('status', 'pending') // فقط درخواست‌های دوستی که در وضعیت "در انتظار" هستند
            ->first();

        // اگر رکورد دوستی پیدا شد
        if ($friendship) {
            $friendship->status = 'rejected'; // تغییر وضعیت به رد شده
            $friendship->save(); // ذخیره‌سازی تغییرات
            return back()->with('success', 'Friend request rejected.');
        }

        // در صورتی که رکوردی پیدا نشد
        return back()->with('error', 'Friend request not found.');
    }


    public function blockUser($friendId)
    {
        $user = auth()->user();
        if (!auth()->user()->checkSubscription('blockUser')) {
            // هدایت به صفحه ارتقاء اشتراک در صورت عدم دسترسی
            return view('Subscription.upgrade');
        }
        // بررسی اینکه آیا کاربر قبلاً این کاربر را بلاک کرده است
        $existingBlock = Block::where('user_id', $user->id)
            ->where('blocked_user_id', $friendId)
            ->first();

        if ($existingBlock) {
            return back()->with('error', 'You have already blocked this user.');
        }

        // بلاک کردن کاربر
        Block::create([
            'user_id' => $user->id,
            'blocked_user_id' => $friendId,
        ]);

        Friendship::where(function ($query) use ($user, $friendId) {
            $query->where('user_id', $user->id)
                ->where('friend_id', $friendId);
        })->orWhere(function ($query) use ($user, $friendId) {
            $query->where('user_id', $friendId)
                ->where('friend_id', $user->id);
        })->update([
            'status' => 'rejected'  // یا هر وضعیت دیگری که مدنظر دارید
        ]);

        return back()->with('success', 'User blocked.');
    }


    public function unblockUser($friendId)
    {
        $user = auth()->user();
        if (!auth()->user()->checkSubscription('unBlockUser')) {
            // هدایت به صفحه ارتقاء اشتراک در صورت عدم دسترسی
            return view('Subscription.upgrade');
        }
        // حذف بلاک
        $user->blockedUsers()->detach($friendId);

        return back()->with('success', 'User unblocked.');
    }

    public function removeFriend($friendId)
    {
        $userId = auth()->id();  // گرفتن id کاربر فعلی
        if (!auth()->user()->checkSubscription('removeFriend')) {
            // هدایت به صفحه ارتقاء اشتراک در صورت عدم دسترسی
            return view('Subscription.upgrade');
        }
        // حذف دوستی از طرف اول
        Friendship::where('user_id', $userId)
            ->where('friend_id', $friendId)
            ->delete();

        // حذف دوستی از طرف دوم
        Friendship::where('user_id', $friendId)
            ->where('friend_id', $userId)
            ->delete();

        // نمایش پیغام موفقیت و برگشت به صفحه قبلی
        return back()->with('success', 'Friend removed successfully.');
    }

    //search

}
