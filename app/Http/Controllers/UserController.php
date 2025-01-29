<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Plan;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\User;
use App\Models\UserAnswer;
use App\Models\UserQuestionAnswerView;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UserController extends BaseController
{
    use AuthorizesRequests;
    public static $menu_label = "User Management";
    public static $menu_icon = 'bi bi-people-fill';
    public static $base_route = 'users-manager';

    public static $actions = [
        [
            'label' => 'Users',
            'icon' => 'bi bi-people-fill',
            'route' => 'users-manager.index',
        ],
        // [
        //     'label' => 'Compose',
        //     'icon' => 'bi bi-envelope-plus-fill',
        //     'route' => 'internal-messages.create',
        // ],
    ];


    public function index(Request $request)
    {
        //Only admin can access t this section!!!!

        if(!auth()->user()->isAdmin())
            abort(403);
        $search = $request->input('search');
        $sortBy = $request->get('sortBy', 'users.id'); 
        $sortDirection = $request->get('sortDirection', 'asc');

        $sortBy = ($sortBy=='') ? 'id' : $sortBy;
        $sortDirection = ($sortDirection == '') ? 'id' : $sortDirection;
        
        $sortableColumns = ['users.id', 'users.first_name', 'users.last_name', 'users.display_name', 'users.email', 'users.phone_number', 'users.status', 'users.role_id', 'users.gender', 'plans.name'];

        // Check if the column to sort by is valid
        if (!in_array($sortBy, $sortableColumns)) {
            $sortBy = 'users.id'; // default column
        }

        // $users = User::when($search, function ($query, $search) {
        //     return $query->where('first_name', 'like', '%' . $search . '%')
        //         ->orWhere('last_name', 'like', '%' . $search . '%')
        //         ->orWhere('email', 'like', '%' . $search . '%')
        //         ->orWhere('phone_number', 'like', '%' . $search . '%');
        // })
        //     ->leftJoin('subscriptions', 'subscriptions.user_id', '=', 'users.id')
        //     ->leftJoin('plans', 'subscriptions.plan_id', '=', 'plans.id')
        //     ->orderBy($sortBy, $sortDirection)
        //     ->paginate(10);
        $users = User::select([
            'users.id',
            'users.first_name',
            'users.last_name',
            'users.display_name',
            'users.email',
            'users.phone_number',
            'users.status',
            'users.role_id',
            'users.gender',
            'plans.name as plan_name' 
        ])
            ->when($search, function ($query, $search) {
                return $query->where('users.first_name', 'like', '%' . $search . '%')
                    ->orWhere('users.last_name', 'like', '%' . $search . '%')
                    ->orWhere('users.email', 'like', '%' . $search . '%')
                    ->orWhere('users.phone_number', 'like', '%' . $search . '%');
            })
            ->leftJoin('subscriptions', 'subscriptions.user_id', '=', 'users.id')
            ->leftJoin('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->orderBy($sortBy, $sortDirection)
            ->paginate(10);

        return view('Users.index', [
            'users' => $users,
            'sortBy' => $sortBy,
            'sortDirection' => $sortDirection,
            'search' => $search, // ارسال متغیر search به ویو
        ]);
    }




    // public function index(Request $request)
    // {
    //     $perPage = 25;
    //     $users = User::paginate($perPage);

    //     return view('Users.index', [
    //         'users' => $users
    //     ]);
    // }

    public function show(User $user)
    {
        return view('Users.show', [
            'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        return view('Users.edit', [
            'user' => $user
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users-manager.index')->with('success', __('User deleted successfully'));
    }

    public function updateStatus(Request $request, $id)
    {
        // گرفتن کاربر از دیتابیس
        $user = User::findOrFail($id);

        // اعتبارسنجی درخواست
        $request->validate([
            'status' => 'required|in:active,pending,suspended,blocked',
        ]);

        // بروزرسانی وضعیت
        $user->status = $request->input('status');
        $user->save();

        // نمایش پیام موفقیت
        return redirect()->route('users-manager.show', $user->id)
            ->with('success', __('User status updated successfully.'));
    }


    public function showAllPictures()
    {
        $user = auth()->user();

        // گرفتن تمام عکس‌های کاربر از جدول medias
        $medias = $user->medias()->get();

        if ($medias->isEmpty()) {
            // اگر هیچ عکسی وجود نداشت
            return response()->json(['message' => 'No pictures found.'], 404);
        }

        // ایجاد آرایه‌ای از مسیر فایل‌ها و سایر اطلاعات عکس‌ها
        $pictures = $medias->map(function ($media) {
            return [
                'id' => $media->id,
                'file_path' => $media->url, // فرض بر این است که file_path در جدول medias ذخیره شده است
                'is_profile' => $media->pivot->is_profile,
                'is_approved' => $media->pivot->is_approved,
            ];
        });

        // ارسال تمام عکس‌ها به کاربر
        return response()->json($pictures);
    }

    // public function uploadPhotos(Request $request)
    // {
    //     // اعتبارسنجی فایل‌ها
    //     $request->validate([
    //         'photos' => 'required|array|max:12',  // حداکثر 10 عکس
    //         'photos.*' => 'mimes:jpg,jpeg,png,gif|max:10240',  // حداکثر 10MB برای هر عکس
    //     ]);

    //     $uploadedPhotos = [];

    //     // ذخیره کردن هر عکس
    //     foreach ($request->file('photos') as $photo) {
    //         // ذخیره کردن فایل در فولدر public/photos
    //         $path = $photo->store('photos', 'public');
    //         Log::info("salam");
    //         // ذخیره اطلاعات مربوط به عکس در دیتابیس
    //         $uploadedPhotos[] = Media::create([
    //             'url' => $path,
    //             'user_id' => $request->user()->id,  // فرض می‌کنیم که کاربر وارد شده است
    //         ]);
    //     }

    //     // بازگرداندن مسیرهای عکس‌های آپلود شده به کلاینت
    //     return response()->json([
    //         'success' => true,
    //         'photos' => $uploadedPhotos,  // برگرداندن داده‌های مربوط به عکس‌های آپلود شده
    //     ]);
    // }

    public function deletePhoto(User $user, $photoId)
    {
        $currentUser = auth()->user();

        // پیدا کردن رسانه
        $media = Media::find($photoId);

        if (!$media) {
            return response()->json(['success' => false, 'message' => 'Media not found'], 404);
        }

        // بررسی مالکیت رسانه
        $isOwner = $media->users()->where('users.id', $currentUser->id)->exists();

        if (!$isOwner) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        try {
            // حذف رسانه
            $media->delete();

            return response()->json(['success' => true, 'message' => 'Photo deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the photo.'], 500);
        }
    }



    public function uploadPhoto(Request $request, User $user)
    {
        Log::info('upload photos UserController->232');
        // اعتبارسنجی برای آرایه عکس‌ها
        $request->validate([
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // بررسی فرمت و اندازه هر عکس
        ]);

        Log::info('upload photos UserController->240 after validate');
        // برای ذخیره عکس‌ها و ایجاد اطلاعات در جدول medias
        $uploadedPhotos = [];

        foreach ($request->file('photos') as $photo) {
            Log::info('upload photos UserController->232 loop photo:'.$photo);
            // ذخیره هر عکس در مسیر مشخص
            $photoPath = $photo->store('images', 'public');
            Log::info('upload photos UserController->232 loop photo: copy to storage');
            Log::info($photo);
            // اطلاعات عکس برای ذخیره در جدول media
            $media = Media::create([
                'url' =>  $photoPath,
                'type' => $photo->getClientOriginalExtension(), // فرمت عکس (مثل jpg, png)
                'mime_type' => $photo->getMimeType(), // نوع MIME عکس
                'size' => $photo->getSize(), // اندازه عکس به بایت
            ]);
            Log::info('upload photos UserController->232 loop photo: update Media Table');
            Log::info($media);
            // اتصال این عکس به کاربر از طریق جدول پیوند (pivot)
            $user->medias()->attach($media->id, [
                'is_profile' => false, // به طور پیش‌فرض این عکس پروفایل نیست
            ]);
            Log::info('upload photos UserController->232 loop : attach media to user'.$photo);
            // ذخیره آدرس کامل عکس برای پاسخ
            $uploadedPhotos[] = $media->url;
        }

        // بازگشت پاسخ به کلاینت با لیست آدرس عکس‌های آپلود شده
        return response()->json([
            'message' => 'Photos uploaded successfully!',
            'photos' => $uploadedPhotos
        ], 200);
    }

    public function updateMediaStatus(Media $media)
    {
        // پیدا کردن کاربری که این عکس به آن تعلق دارد
        $user = $media->users()->first();

        if ($user) {
            // بررسی اینکه آیا تصویر در جدول واسط (pivot) تایید شده است یا خیر
            $pivot = $media->users()->where('user_id', $user->id)->first()->pivot;

            if ($pivot) {
                $isApproved = $pivot->is_approved;
                $newStatus = $isApproved ? false : true; // اگر تایید شده باشد، لغو تایید می‌شود و برعکس

                // بروزرسانی وضعیت تایید عکس
                $media->users()->updateExistingPivot($user->id, ['is_approved' => $newStatus]);

                // بازگشت به صفحه‌ی جزئیات کاربر
                return redirect()->route('users-manager.show', $user->id)
                    ->with('status', 'Media status updated successfully!');
            } else {
                return redirect()->route('users-manager.show', $user->id)
                    ->with('error', 'Media not found in user-media relationship.');
            }
        } else {
            return redirect()->route('users-manager.index')
                ->with('error', 'User not found.');
        }
    }

    public function resetPassword(User $user)
    {
        return view('Users.reset-password', compact('user'));
    }

    public function updatePasswordAjax(Request $request)
    {
        try {

            // اعتبارسنجی ورودی‌ها
            $validated = $request->validate([
                'currentPassword' => 'required|string',
                'newPassword' => 'required|string|min:8|confirmed',
            ]);

            // بررسی صحت پسورد فعلی
            if (!Hash::check($validated['currentPassword'], Auth::user()->password)) {
                return response()->json([
                    'errors' => [
                        'currentPassword' => ['The current password is incorrect.']
                    ]
                ], 422);
            }

            // به روز رسانی پسورد جدید
            Auth::user()->update([
                'password' => Hash::make($validated['newPassword']),
            ]);

            // ارسال پاسخ موفقیت‌آمیز
            return response()->json(['status' => 'Password updated successfully!']);
        } catch (ValidationException $e) {
            //$errorMessages = implode('<br>', Arr::flatten($e->errors()));

            //return response()->json(['status' => $errorMessages]);
            // در صورتی که اعتبارسنجی با خطا مواجه شد
            return response()->json([
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function updatePassword(Request $request, User $user)
    {
        //dd($user, $request);
        // اعتبارسنجی ورودی‌ها
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        // ذخیره پسورد جدید
        $user->password = bcrypt($validated['password']);
        $user->save();

        // ارسال پیام موفقیت به ویو
        return redirect()->route('users-manager.show', $user->id)
            ->with('success', 'Password updated successfully!');
    }



    public function search(Request $request)
    {
        $current_user = auth()->user();
        
        //dd($request);
        $age = explode(',', $request->input('age_values'));
        if(count($age )< 2) //Dummy code! in Search 2 we hage age1 
            $age = explode(',', $request->input('age1_values'));
        $filters = [
            'church' => $request->input('church'),
            'location' => $request->input('living_place'),
            'education' => $request->input('education_level'),
            'industry' => $request->input('industry'),
            'min_age' => $age[0], //$request->input('min_age'),
            'max_age' => $age[1], //$request->input('max_age'),
            'married' => $request->input('married'),
        ];
        //dd($filters, $request);
        $queryResults = [];
        //dd($filters);
        // فیلتر بر اساس church
        if ($filters['church']) {
            $queryResults['church'] = UserQuestionAnswerView::where('question_key', 'church')
                ->where('answer_value', $filters['church'])
                ->pluck('id');
        }

        // فیلتر بر اساس location
        if ($filters['location']) {
            $queryResults['location'] = UserQuestionAnswerView::where('question_key', 'country_live')
                ->where('answer_value', $filters['location'])
                ->pluck('id');
        }

        // فیلتر بر اساس education
        if ($filters['education']) {
            $queryResults['education'] = UserQuestionAnswerView::where('question_key', 'education')
                ->where('answer_value', $filters['education'])
                ->pluck('id');
        }

        // فیلتر بر اساس industry
        if ($filters['industry']) {
            $queryResults['industry'] = UserQuestionAnswerView::where('question_key', 'industry')
                ->where('answer_value', $filters['industry'])
                ->pluck('id');
        }

        // فیلتر بر اساس married
        $married = isset($filters['married']);
        if ($filters['married']) {
            $queryResults['married'] = UserQuestionAnswerView::where('question_key', 'married')
                ->where('answer_value', 1)
                ->pluck('id');
        }

        // فیلتر بر اساس سن
        if ($filters['min_age'] || $filters['max_age']) {
            $minAge = $filters['min_age'] ?? 0;
            $maxAge = $filters['max_age'] ?? 200;

            $queryResults['age'] = UserQuestionAnswerView::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN ? AND ?', [$minAge, $maxAge])
                ->pluck('id');
        }

        // محاسبه اشتراک بین تمام فیلترها
        $finalUserIds = collect($queryResults)->reduce(function ($carry, $item) {
            return isset($carry) ? $carry->intersect($item) : $item;
        });

        // دریافت کاربران نهایی
        if ($finalUserIds == null)
            $users = User::searchWithFilters($current_user->gender, $current_user->birth_date)->get();

        else
            $users = User::whereIn('id', $finalUserIds)
                ->searchWithFilters($current_user->gender, $current_user->birth_date)
                ->get();

        return view('users.search-result', compact('users'));
    }


    public function old_search(Request $request)
    {
        //$age = json_decode($request->input('age'), true);
        //dd($request);

        $age = explode(',', $request->input('age_values'));
        $height = explode(',', $request->input('height_values'));
        //dd($age);
        $filters = [
            'church' => $request->input('church'),
            'location' => $request->input('living_place'),
            'education' => $request->input('education_level'),
            'industry' => $request->input('industry'),
            'min_age' => $age[0],
            'max_age' => $age[1],
            'min_height' => $height[0],
            'max_height' => $height[1],
        ];
        $results = [];

        // فیلتر church
        if ($filters['church']) {
            $churchQuestion = Question::where('question_key', 'church')->first();
            if ($churchQuestion) {
                $result = $churchQuestion->options->where('id', $filters['church'])->first();
                if ($result) {
                    $results[] = UserAnswer::where('question_id', $churchQuestion->id)
                        ->where('answer_value', $result->option_value)
                        ->pluck('user_id');
                }
            }
        }

        // فیلتر location
        if ($filters['location']) {
            $locationQuestion = Question::where('question_key', 'country_live')->first();
            if ($locationQuestion) {
                $result = $locationQuestion->options->where('id', $filters['location'])->first();
                if ($result) {
                    $results[] = UserAnswer::where('question_id', $locationQuestion->id)
                        ->where('answer_value', $result->option_value)
                        ->pluck('user_id');
                }
            }
        }

        // فیلتر education
        if ($filters['education']) {
            $educationQuestion = Question::where('question_key', 'education')->first();
            if ($educationQuestion) {
                $result = $educationQuestion->options->where('id', $filters['education'])->first();
                if ($result) {
                    $results[] = UserAnswer::where('question_id', $educationQuestion->id)
                        ->where('answer_value', $result->option_value)
                        ->pluck('user_id');
                }
            }
        }

        // فیلتر industry
        if ($filters['industry']) {
            $industryQuestion = Question::where('question_key', 'industry')->first();
            if ($industryQuestion) {
                $result = $industryQuestion->options->where('id', $filters['industry'])->first();
                if ($result) {
                    $results[] = UserAnswer::where('question_id', $industryQuestion->id)
                        ->where('answer_value', $result->option_value)
                        ->pluck('user_id');
                }
            }
        }

        // فیلتر age
        if ($filters['min_age'] || $filters['max_age']) {
            $minAge = $filters['min_age'];
            $maxAge = $filters['max_age'];

            $ageQuery = User::query();

            if ($minAge) {
                $ageQuery->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) >= ?', [$minAge]);
            }

            if ($maxAge) {
                $ageQuery->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) <= ?', [$maxAge]);
            }

            $results[] = $ageQuery->pluck('id');
        }

        if ($filters['min_height'] || $filters['max_height']) {
            $minHeight = $filters['min_height'];
            $maxHeight = $filters['max_height'];

            $ageQuery = User::query();



            $results[] = $ageQuery->pluck('id');
        }

        // ترکیب اشتراکات
        $finalResults = collect($results)->reduce(function ($carry, $item) {
            return isset($carry) ? $carry->intersect($item) : $item;
        });

        // پیدا کردن کاربران بر اساس اشتراک نهایی
        $users = User::whereIn('id', $finalResults ?? [])
            ->where('gender', '!=', 'male')
            ->get();

        return view('users.search-result', compact('users'));
    }

    public function searchApi(Request $request)
    {
        $query = $request->get('query', '');
        if (strlen($query) < 3) {
            return response()->json([], 200);
        }

        // Get current user information
        $currentUser = auth()->user();
        if (!$currentUser) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // جستجو با فیلترهای محدود کننده
        $users = User::searchWithFilters($currentUser->gender, $currentUser->birth_date)
            ->where('display_name', 'like', "%$query%")
            ->take(10) // محدود کردن تعداد نتایج
            ->get(['id', 'display_name']);

        // اضافه کردن تصویر پروفایل به هر کاربر
        $users = $users->map(function ($user) {
            // فرض می‌کنیم که رابطه‌ی profileImage درست تنظیم شده است
            $profileImage = $user->profileImage()->first();
            $profileImageUrl = $profileImage ? $profileImage->url : 'default-profile.jpg';

            return [
                'id' => $user->id,
                'display_name' => $user->display_name,
                'profile_image' => $profileImageUrl, // اضافه کردن مسیر تصویر پروفایل
                'customProperties' => [
                    'profile_image' => $profileImageUrl,
                ],
            ];
        });

        return response()->json($users);
    }


    public function findSuggestions()
    {
        // دریافت کاربران مشابه
        $similarUsers = auth()->user()->findSimilarUsersBasedOnAnswers();

        // در اینجا می‌توانید پیشنهادات را به شکل دلخواه نمایش دهید
        // به طور مثال، نمایش لیست کاربران مشابه در صفحه
        return view('friends.suggestions', ['similarUsers' => $similarUsers]);
    }


    public function profile($userId)
    {
        $currentUser = auth()->user();
        if (!$currentUser->checkSubscription('viewUserProfile')) {
            $plans = Plan::where('is_active', 1)
                ->orderBy('is_recommended', 'desc')
                ->get();
            // هدایت به صفحه ارتقاء اشتراک در صورت عدم دسترسی
            return view('Subscription.upgrade',['plans'=>$plans]);
        }        
        $user = User::findOrFail($userId);
        // if (!$user->can('sendRequest')) {
        //     // هدایت به صفحه ارتقاء اشتراک در صورت عدم دسترسی
        //     return view('Subscription.upgrade');
        // }
        // بررسی اینکه آیا کاربر جاری می‌تواند پروفایل کاربر هدف را مشاهده کند
        $canViewProfile = User::searchWithFilters($currentUser->gender, $currentUser->birth_date)
            ->where('id', $user->id)
            ->exists();

        // اگر کاربر نمی‌تواند پروفایل را مشاهده کند، صفحه 403 نمایش داده می‌شود
        if (!$canViewProfile) {
            abort(403, 'You do not have permission to view this profile.');
        }
        return view('User.view', compact('user'));
    }
}
