<?php

use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InternalMessageController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Internal Messages Routes
    Route::prefix('internal-messages')->name('internal-messages.')->group(function () {
        Route::get('/', [InternalMessageController::class, 'inbox'])->name('inbox'); // Default to inbox
        Route::get('/inbox', [InternalMessageController::class, 'inbox'])->name('inbox');
        Route::get('/sent', [InternalMessageController::class, 'sent'])->name('sent');
        Route::get('/draft', [InternalMessageController::class, 'draft'])->name('draft');
        Route::get('/compose', [InternalMessageController::class, 'compose'])->name('compose');
        Route::get('/show/{messageId}', [InternalMessageController::class, 'viewMessage'])->name('viewMessage');

        // Post Routes
        Route::post('/send', [InternalMessageController::class, 'sendMessage'])->name('send');
        Route::post('/save-draft', [InternalMessageController::class, 'saveDraft'])->name('save-draft');

        Route::get('/reply/{messageId}', [InternalMessageController::class, 'reply'])->name('reply');
        Route::post('/reply/{messageId}', [InternalMessageController::class, 'sendReply'])->name('sendReply');


        // Additional Actions
        Route::post('/mark-as-read/{messageId}', [InternalMessageController::class, 'markAsRead'])->name('mark-as-read');
        Route::post('/send-draft/{id}', [InternalMessageController::class, 'sendDraft'])->name('send-draft');

        

    });

    //friendship
    Route::post('/friend-request/{friendId}', [FriendshipController::class, 'sendRequest'])->name('sendFriendRequest');
    Route::post('/friend-request/accept/{friendshipId}', [FriendshipController::class, 'acceptRequest'])->name('acceptFriendRequest');
    Route::post('/friend-request/reject/{friendshipId}', [FriendshipController::class, 'rejectRequest'])->name('rejectFriendRequest');
    Route::post('/block-user/{friendId}', [FriendshipController::class, 'blockUser'])->name('blockUser');
    Route::post('/unblock-user/{friendId}', [FriendshipController::class, 'unblockUser'])->name('unblockUser');

    Route::get('/friends', [FriendshipController::class, 'index'])->name('friends.index');
    Route::get('/friends/remove/{friendId}', [FriendshipController::class, 'removeFriend'])->name('friend.remove');
    Route::get('/friends/block/{friendId}', [FriendshipController::class, 'blockFriend'])->name('friend.block');
    Route::get('/friends/unblock/{friendId}', [FriendshipController::class, 'unblockFriend'])->name('friend.unblock');

    // User Search API
    Route::get('/api/search-user', [UserController::class, 'searchApi'])->name('api.search-user');
});

require __DIR__ . '/auth.php';
