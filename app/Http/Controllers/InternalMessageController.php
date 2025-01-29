<?php

namespace App\Http\Controllers;

use App\Models\InternalMessage;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Support\Facades\Gate;

class InternalMessageController extends BaseController
{
    use AuthorizesRequests;

    public static $menu_label = "mailbox.Mailbox";
    public static $menu_icon = 'bi bi-envelope-fill';
    public static $base_route = 'internal-messages';

    public static $actions = [
        [
            'label' => 'mailbox.Inbox',
            'icon' => 'bi bi-envelope-arrow-down-fill',
            'route' => 'internal-messages.inbox',
        ],
        // [
        //     'label' => 'Compose',
        //     'icon' => 'bi bi-envelope-plus-fill',
        //     'route' => 'internal-messages.create',
        // ],
    ];

    /**
     * Display a list of received messages for the authenticated user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return $this->inbox($request);
    }

    /**
     * Save a draft message.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveDraft(Request $request)
    {
        $currentUser = auth()->user();
        if (!$currentUser->checkSubscription('saveDraft')) {

            $plans = Plan::where('is_active', 1)
                ->orderBy('is_recommended', 'desc')
                ->get();
            // هدایت به صفحه ارتقاء اشتراک در صورت عدم دسترسی
            return view('Subscription.upgrade', ['plans' => $plans]);
        }

        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:512',
        ]);


        $receiver = User::findOrFail($request->receiver_id);

        if ($receiver->status !== 'active') {
            return redirect()->back()->with('error', 'The selected user is not active.');
        }

        InternalMessage::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'status' => 'draft',
        ]);

        return redirect()->back()->with('success', 'Message saved as draft.');
    }

    /**
     * Handle sending a new message.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function sendMessage(Request $request)
    {
        $currentUser = auth()->user();
        if (!$currentUser->checkSubscription('sendMessage')) {
            $plans = Plan::where('is_active', 1)
                ->orderBy('is_recommended', 'desc')
                ->get();
            // هدایت به صفحه ارتقاء اشتراک در صورت عدم دسترسی
            return view('Subscription.upgrade', ['plans' => $plans]);
        }

        // if(!auth()->user()->can('sendMessage')){
        //     return view('Subscription.upgrade');
        // }
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:512',
        ]);

        $cleanMessage = Purifier::clean($validated['message']);
        $receiver = User::findOrFail($validated['receiver_id']);

        if ($receiver->status !== 'active') {
            return redirect()->back()->withError('The selected user is not active.');
        }

        if (!Auth::user()->can('send', $receiver)) {
            // هدایت به صفحه ارتقاء اشتراک در صورت عدم دسترسی
            return redirect()->route('subscription.upgrade')
                ->withErrors('You need an active subscription to send messages.');
        }

        $message = InternalMessage::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiver->id,
            'message' => $cleanMessage,
            'status' => 'sent',
            'read' => false,
        ]);

        return redirect()->route('internal-messages.sent')
            ->with('success', 'Message sent successfully!');
    }


    public function sendReply(Request $request, $messageId)
    {
        $currentUser = auth()->user();
        if (!$currentUser->checkSubscription('sendReply')) {
            $plans = Plan::where('is_active', 1)
                ->orderBy('is_recommended', 'desc')
                ->get();
            // هدایت به صفحه ارتقاء اشتراک در صورت عدم دسترسی
            return view('Subscription.upgrade', ['plans' => $plans]);
        }

        // if(!auth()->user()->can('sendReply')){
        //     return view('Subscription.upgrade');
        // }
        $validated = $request->validate([
            'message' => 'required|string|max:512',
        ]);


        $originalMessage = InternalMessage::findOrFail($messageId);

        // بررسی دسترسی کاربر به پیام
        if (auth()->id() !== $originalMessage->receiver_id) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // ایجاد پیام پاسخ
        InternalMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $originalMessage->sender_id,
            'message' => $request->message,
            'status' => 'sent',
            'parent_id' => $originalMessage->id,
            'sent_at' => now(),
        ]);

        return redirect()->route('internal-messages.viewMessage', ['messageId' => $messageId])
            ->with('success', 'Reply sent successfully.');
    }


    /**
     * Send a saved draft message.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendDraft($id)
    {
        $currentUser = auth()->user();
        if (!$currentUser->checkSubscription('sendDraft')) {
            $plans = Plan::where('is_active', 1)
                ->orderBy('is_recommended', 'desc')
                ->get();
            // هدایت به صفحه ارتقاء اشتراک در صورت عدم دسترسی
            return redirect()->route('Subscription.upgrade', ['plans' => $plans]);
        }

        // if(!auth()->user()->can('sendDraft')){
        //     return view('Subscription.upgrade')
        //         ->withErrors('You need an active subscription to send messages.');
        // }
        $message = InternalMessage::findOrFail($id);

        if ($message->status !== 'draft') {
            return redirect()->back()->with('error', 'Message is not a draft.');
        }

        $message->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        return redirect()->route('internal-messages.index')->with('success', 'Draft sent successfully.');
    }

    /**
     * Mark a message as read.
     *
     * @param int $messageId
     * @return void
     */
    public function markAsRead($messageId)
    {
        $currentUser = auth()->user();
        if (!$currentUser->checkSubscription('sendDraft')) {

            $plans = Plan::where('is_active', 1)
                ->orderBy('is_recommended', 'desc')
                ->get();
            // هدایت به صفحه ارتقاء اشتراک در صورت عدم دسترسی
            return view('Subscription.upgrade', ['plans' => $plans]);
        }

        $message = InternalMessage::findOrFail($messageId);

        $this->authorize('view', $message);

        $message->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        Cache::forget('unread_messages_count_' . Auth::id());
    }

    /**
     * View a received message.
     *
     * @param int $messageId
     * @return \Illuminate\View\View
     */
    public function viewMessage(Request $request, $messageId)
    {
        $currentUser = auth()->user();
        if (!$currentUser->checkSubscription('viewMessage')) {
            $plans = Plan::where('is_active', 1)
                ->orderBy('is_recommended', 'desc')
                ->get();
            // هدایت به صفحه ارتقاء اشتراک در صورت عدم دسترسی
            return redirect()->route('Subscription.upgrade', ['plans' => $plans]);
        }
        $mode = $request->get('mode', 'inbox'); // حالت پیش‌فرض inbox
        $message = InternalMessage::with(['parent.sender', 'replies.sender'])->findOrFail($messageId);

        //$this->authorize('view', $message);
        // if (!Auth::user()->can('view', $message)) {
        //     // هدایت به صفحه ارتقاء اشتراک در صورت عدم دسترسی
        //     return view('Subscription.upgrade')
        //         ->withErrors('You need an active subscription to send messages.');
        // }

        $user = auth()->user();
        if ($message->receiver_id === $user->id) {
            $this->markAsRead($messageId);
        }

        if ($mode === 'inbox') {
            $query = $user->messagesReceived();
        } elseif ($mode === 'sent') {
            $query = $user->messagesSent();
        } elseif ($mode === 'draft') {
            $query = $user->messagesDraft();
        } else {
            abort(404, 'Invalid mode'); // اگر حالت نامعتبر باشد
        }

        $previousMessage = (clone $query)
            ->where('id', '<', $messageId) // مقایسه شناسه پیام
            ->orderBy('sent_at', 'desc')
            ->first();

        $nextMessage = (clone $query)
            ->where('id', '>', $messageId) // مقایسه شناسه پیام
            ->orderBy('sent_at', 'asc')
            ->first();

        return view('messages.view', [
            'message' => $message,
            'previousMessage' => $previousMessage,
            'nextMessage' => $nextMessage,
            'mode' => $mode,
        ]);
    }



    /**
     * Get messages for the authenticated user.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $mode
     * @return \Illuminate\View\View
     */
    public function getMessagesOld(Request $request, $mode = 'inbox')
    {
        $user = Auth::user();
        $sortColumn = $request->get('sort', 'sent_at');
        $sortDirection = $request->get('direction', 'desc');

        $validColumns = ['sender_id', 'receiver_id', 'message', 'sent_at', 'read_at'];
        if (!in_array($sortColumn, $validColumns)) {
            $sortColumn = 'sent_at';
        }

        $search = $request->get('search', '');

        switch ($mode) {
            case 'inbox':
                if (!Auth::user()->can('getMessage', $message)) {
                    // هدایت به صفحه ارتقاء اشتراک در صورت عدم دسترسی
                    $plans = Plan::where('is_active', 1)
                        ->orderBy('is_recommended', 'desc')
                        ->get();
                    // هدایت به صفحه ارتقاء اشتراک در صورت عدم دسترسی
                    return view('Subscription.upgrade', ['plans' => $plans])
                        ->withErrors('You need an active subscription to send messages.');
                }
                $messages = $user->messagesReceived()->whereHas('sender', function ($query) {
                    $query->where('status', 'active');
                });
                break;
            case 'sent':
                if (!Auth::user()->can('sendMessage', $message)) {
                    // هدایت به صفحه ارتقاء اشتراک در صورت عدم دسترسی
                    $plans = Plan::where('is_active', 1)
                        ->orderBy('is_recommended', 'desc')
                        ->get();
                    // هدایت به صفحه ارتقاء اشتراک در صورت عدم دسترسی
                    return view('Subscription.upgrade', ['plans' => $plans])
                        ->withErrors('You need an active subscription to send messages.');
                }
                $messages = $user->messagesSent()->whereHas('receiver', function ($query) {
                    $query->where('status', 'active');
                });
                break;
            case 'draft':
                $messages = $user->messagesDraft();
                break;
        }

        $messages = $messages
            ->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('message', 'like', '%' . $search . '%')
                        ->orWhereHas('sender', function ($query) use ($search) {
                            $query->where('display_name', 'like', '%' . $search . '%');
                        });
                }
            })
            ->orderBy($sortColumn, $sortDirection)
            ->paginate(10);

        // اعمال Resource برای پیام‌ها
        $messagesResource = \App\Http\Resources\InternalMessageResource::collection($messages);

        return view('messages.inbox', [
            'messages' => $messagesResource,
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
            'mode' => $mode,
            'page_header' => __('mailbox.Inbox')
        ]);
    }

    public function getMessages(Request $request, $mode = 'inbox')
    {
        
        $user = Auth::user();
        // dd($user->status);
        if ($user->status == 'suspended')
            return view('Users.suspended');
        if ($user->status == 'blocked')
            return view('Users.blocked');
        if ($user->status == 'pending')
            return view('Users.not-active');
        if ($user->status != 'active')
            return view('Users.not-active');
        $sortColumn = $request->get('sort', 'sent_at');
        $sortDirection = $request->get('direction', 'desc');

        // اعتبارسنجی پارامترهای ورودی
        $request->validate([
            'sort' => 'in:sender_id,receiver_id,message,sent_at,read_at',
            'direction' => 'in:asc,desc',
        ]);

        $validColumns = ['sender_id', 'receiver_id', 'message', 'sent_at', 'read_at'];
        if (!in_array($sortColumn, $validColumns)) {
            $sortColumn = 'sent_at';
        }

        $search = $request->get('search', '');

        // انتخاب پیام‌ها بر اساس وضعیت (inbox, sent, draft)
        switch ($mode) {
            case 'inbox':

                $messagesQuery = $user->messagesReceived()->whereHas('sender', function ($query) {
                    $query->where('status', 'active');
                });
                break;
            case 'sent':
                $messagesQuery = $user->messagesSent()->whereHas('receiver', function ($query) {
                    $query->where('status', 'active');
                });
                break;
            case 'draft':
                $messagesQuery = $user->messagesDraft();
                break;
            default:
                $messagesQuery = $user->messagesReceived();
                break;
        }

        // اعمال جستجو بر روی پیام‌ها
        $messagesQuery = $messagesQuery->where(function ($query) use ($search) {
            if ($search) {
                $query->where('message', 'like', '%' . $search . '%')
                    ->orWhereHas('sender', function ($query) use ($search) {
                        $query->where('display_name', 'like', '%' . $search . '%');
                    });
            }
        });

        // اعمال ترتیب بر اساس ستون انتخابی
        $messagesQuery = $messagesQuery->orderBy($sortColumn, $sortDirection);

        // پگینیشن پیام‌ها
        $messagesPaginator = $messagesQuery->paginate(10);

        // بررسی دسترسی کاربر به هر پیام
        $messagesPaginator->getCollection()->transform(function ($message) use ($user) {
            if (!$user->can('view', $message)) {
                $message->message = 'you can not read this message, please upgrade your plan!';
            }
            return $message;
        });

        // تبدیل پیام‌ها به Resource
        $messagesResource = \App\Http\Resources\InternalMessageResource::collection($messagesPaginator);

        // بازگشت به ویو با ارسال داده‌ها
        return view('messages.inbox', [
            'messages' => $messagesResource,
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
            'mode' => $mode,
            'page_header' => __('mailbox.Inbox')
        ]);
    }


    public function reply($messageId)
    {
        $currentUser = auth()->user();
        if (!$currentUser->checkSubscription('reply')) {
            return redirect()->route('Subscription.upgrade');
        }
        $message = InternalMessage::with('sender')->findOrFail($messageId);

        // بررسی دسترسی کاربر به پیام
        if (auth()->id() !== $message->receiver_id && auth()->id() !== $message->sender_id) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        return view('messages.reply', compact('message'));
    }

    /**
     * Show the inbox messages.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function inbox(Request $request)
    {
        $currentUser = auth()->user();
        //dd($currentUser);
        //dd($currentUser->checkSubscription('getInbox'));
        if (!$currentUser->checkSubscription('getInbox')) {

            $plans = Plan::where('is_active', 1)
                ->orderBy('is_recommended', 'desc')
                ->get();
            // هدایت به صفحه ارتقاء اشتراک در صورت عدم دسترسی
            return view('Subscription.upgrade',['plans'=>$plans]);
        }
        //dd(Auth::user());
        // if (!Gate::allows('getInbox', auth()->user())) {
        //     // اگر دسترسی نداشت، نمایش صفحه ارتقاء اشتراک
        //     return view('Subscription.upgrade');
        // }

        // if(!Auth::user()->can('getInbox'))

        //     return view('Subscription.upgrade');
        return $this->getMessages($request, 'inbox');
    }

    /**
     * Show the sent messages.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function sent(Request $request)
    {
        $currentUser = auth()->user();

        if (!$currentUser->checkSubscription('readSent')) {
            return view('Subscription.upgrade');
        }


        return $this->getMessages($request, 'sent');
    }

    /**
     * Show the draft messages.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function draft(Request $request)
    {
        $currentUser = auth()->user();
        if (!$currentUser->checkSubscription('readDraft')) {
            return view('Subscription.upgrade');
        }
        return $this->getMessages($request, 'draft');
    }

    /**
     * Show the compose message form.
     *
     * @return \Illuminate\View\View
     */
    public function compose($receiver_id = null)
    {
        $currentUser = auth()->user();
        if (!$currentUser->checkSubscription('composeMessage')) {
            $plans = Plan::where('is_active', 1)
                ->orderBy('is_recommended', 'desc')
                ->get();
            // هدایت به صفحه ارتقاء اشتراک در صورت عدم دسترسی
            return view('Subscription.upgrade',['plans'=>$plans]);
            
        }

        // if (!Auth::user()->can('sendMessage', InternalMessage::class)) {

        //     // هدایت به صفحه ارتقاء اشتراک در صورت عدم دسترسی
        //     return view('Subscription.upgrade');
        // }
        if ($receiver_id) {
            $receiver_user = User::findOrFail($receiver_id);
            return view('messages.compose', [
                'receiver_user' => $receiver_user,
            ]);
        }

        return view('messages.compose');
    }

    // public function checkSubscription($access)
    // {
    //     $currentUser = auth()->user();
    //     $subscription = $currentUser->activeSubscription;
    //     switch($access) {
    //         case 'getInbox' :
    //             return ($subscription->plan->id != 3); //plan c
    //                    //return false;
    //             //break;
    //         case 'saveDraft':
    //             return ($subscription->plan->id != 3); //plan c
    //         case 'composeMessage':
    //             return ($subscription->plan->id != 3); //plan c
    //         case 'readSent':
    //             return ($subscription->plan->id != 3); //plan c
    //         case 'sendMessage':
    //             return ($subscription->plan->id != 3); //plan c
    //         case 'sendReply':
    //             return ($subscription->plan->id != 3); //plan c
    //         case 'readDraft':
    //             return ($subscription->plan->id != 3); //plan c
    //     }

    //     //dd($subscription->plan->id);
    //     if($subscription->plan->id == 3) {
    //         return false;
    //         //return view('Subscription.upgrade');
    //     }
    //     return true;
    // }
}
