<?php

use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InternalMessageController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionOptionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SettingExtendController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserReportController;

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Dashboard route (only accessible to authenticated users)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/subscription/upgrade', [SubscriptionController::class, 'upgrade'])->name('subscription.upgrade');

// Grouped routes for authenticated users
Route::middleware('auth')->group(function () {

    // Profile Management Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        //Route::get('/profile/view/{user}', [ProfileController::class, 'view'])->name('profile.view');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Internal Messages Routes
    Route::prefix('internal-messages')->name('internal-messages.')->group(function () {
        // Default route for inbox, but can be accessed with specific routes too
        Route::get('/', [InternalMessageController::class, 'inbox'])->name('inbox');
        Route::get('/inbox', [InternalMessageController::class, 'inbox'])->name('inbox');
        Route::get('/sent', [InternalMessageController::class, 'sent'])->name('sent');
        Route::get('/draft', [InternalMessageController::class, 'draft'])->name('draft');
        Route::get('/compose/{receiver_id?}', [InternalMessageController::class, 'compose'])->name('compose');
        Route::get('/show/{messageId}', [InternalMessageController::class, 'viewMessage'])->name('viewMessage');

        // Post Routes for sending and saving messages
        Route::post('/send', [InternalMessageController::class, 'sendMessage'])->name('send');
        Route::post('/save-draft', [InternalMessageController::class, 'saveDraft'])->name('save-draft');

        // Routes for replying to messages
        Route::get('/reply/{messageId}', [InternalMessageController::class, 'reply'])->name('reply');
        Route::post('/reply/{messageId}', [InternalMessageController::class, 'sendReply'])->name('sendReply');

        // Additional actions like marking messages as read
        Route::post('/mark-as-read/{messageId}', [InternalMessageController::class, 'markAsRead'])->name('mark-as-read');
        Route::post('/send-draft/{id}', [InternalMessageController::class, 'sendDraft'])->name('send-draft');
    });

    // Friendship Management Routes
    Route::prefix('friends')->name('friends.')->group(function () {
        // View and remove friends
        Route::get('/', [FriendshipController::class, 'index'])->name('index');
        Route::get('index', [FriendshipController::class, 'index'])->name('index');
        Route::post('/remove/{friendId}', [FriendshipController::class, 'removeFriend'])->name('remove');
        Route::get('suggestions', [FriendshipController::class, 'findSuggestions'])->name('suggestions');
        // Block or unblock friends
        //Route::get('/block/{friendId}', [FriendshipController::class, 'blockFriend'])->name('block');
        //Route::get('/unblock/{friendId}', [FriendshipController::class, 'unblockFriend'])->name('unblock');
    });

    // Routes for sending, accepting, or rejecting friend requests
    Route::prefix('friend-request')->name('friend-request.')->group(function () {
        Route::post('/{friendId}', [FriendshipController::class, 'sendRequest'])->name('send');
        Route::post('/accept/{friendshipId}', [FriendshipController::class, 'acceptRequest'])->name('accept');
        Route::post('/reject/{friendshipId}', [FriendshipController::class, 'rejectRequest'])->name('reject');
    });

    // Block/Unblock user routes
    Route::prefix('block-user')->name('block-user.')->group(function () {
        Route::post('/{friendId}', [FriendshipController::class, 'blockUser'])->name('block');
        Route::post('/unblock/{friendId}', [FriendshipController::class, 'unblockUser'])->name('unblock');
    });

    //user profile
    Route::get('user-profile/{userId}', [UserController::class, 'profile'])->name('profile');
    // User Search API Route
    Route::get('/api/search-user', [UserController::class, 'searchApi'])->name('api.search-user');

    Route::get('/search/users', [UserController::class, 'search'])->name('search.users');

    //for user managemebt
    Route::prefix('users-manager')->name('users-manager.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('show/{user}', [UserController::class, 'show'])->name('show');
        //Route::get('edit', [UserController::class, 'edit'])->name('edit');
        Route::get('reset-password/{user}', [UserController::class, 'resetPassword'])->name('reset-password');
        Route::patch('update-password/{user}', [UserController::class, 'updatePassword'])->name('update-password');
        Route::put('/password/update/ajax', [UserController::class, 'updatePasswordAjax'])->name('password.update.ajax');
        Route::put('questions/update/ajax', [ProfileController::class, 'updateQuestions'])->name('questions.update.ajax');

        Route::delete('destroy/{user}', [UserController::class, 'destroy'])->name('destroy');

        Route::patch('update-status/{user}', [UserController::class, 'updateStatus'])->name('update-status');
        Route::patch('/media/{media}/update-status', [UserController::class, 'updateMediaStatus'])->name('update-media-status');

        Route::get('/user/{user}/media', [UserController::class, 'showAllPictures'])->name('user.all-pictures.show');
        Route::post('/user/{user}/upload-photo', [UserController::class, 'uploadPhoto'])->name('user.upload-photo');
        Route::delete('/user/{user}/delete-photo/{photoId}', [UserController::class, 'deletePhoto'])->name('user.delete-photo');


        //Route::post('upload-photos', [UserController::class, 'uploadPhotos'])->name('upload-photos'); // روت آپلود عکس‌ها

        //plans

    });
    Route::resource('plans', PlanController::class);
    Route::resource('questions', QuestionController::class);
    Route::resource('question-options', QuestionOptionController::class);
    Route::resource('settings', SettingController::class);
    Route::resource('settingextends', SettingExtendController::class);
    Route::resource('user-reports', UserReportController::class);
    Route::post('user-reports/{report}/accept', [UserReportController::class, 'accept'])->name('user-reports.accept');
    Route::post('user-reports/{report}/reject', [UserReportController::class, 'reject'])->name('user-reports.reject');
    

    //Paypal
    Route::post('payment/create', [PayPalController::class, 'createPayment'])->name('payment.create');
    Route::get('payment/status', [PayPalController::class, 'paymentStatus'])->name('payment.status');
    Route::get('payment/cancel', [PayPalController::class, 'paymentCancel'])->name('payment.cancel');
    Route::get('payment/success', [PayPalController::class, 'paymentSuccess'])->name('payment.success');
    //Route::get('/question-options/{id}', [QuestionOptionController::class, 'show'])->name('question-options.show');
    // Route::resource('question-options/{questionKey}', QuestionOptionController::class)
    //     ->names([
    //         'index' => 'question-options.index',
    //         'create' => 'question-options.create',
    //         'store' => 'question-options.store',
    //         'show' => 'question-options.show',
    //         'edit' => 'question-options.edit',
    //         'update' => 'question-options.update',
    //         'destroy' => 'question-options.destroy',
    //     ]);
});

require __DIR__ . '/auth.php';
