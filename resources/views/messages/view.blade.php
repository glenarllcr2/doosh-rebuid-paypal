@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('messages.partials.navigator')
        </div>
        <div class="col-md-9">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="card-title">Read Mail</div>
                    <div class="card-tools">
                        @if ($previousMessage)
                            <a href="{{ route('internal-messages.viewMessage', ['messageId' => $previousMessage->id]) }}"
                                class="btn btn-tool" title="Previous">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif
                        @if ($nextMessage)
                            <a href="{{ route('internal-messages.viewMessage', ['messageId' => $nextMessage->id]) }}"
                                class="btn btn-tool" title="Next">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body p-0">
                    <!-- Display parent message if exists -->
                    @if ($message->parent)
                        <div class="mailbox-read-info bg-light p-3">
                            <h6>
                                <strong>Parent Message:</strong> <br>
                                From: {{ $message->parent->sender->display_name }}
                                <span class="mailbox-read-time float-end">
                                    {{ $message->parent->sent_at->format('d M.Y H:i') }}
                                </span>
                            </h6>
                            <p>{{ $message->parent->message }}</p>
                        </div>
                        <hr>
                    @endif

                    <!-- Display main message -->
                    <div class="mailbox-read-info">
                        <h6>
                            From: {{ $message->sender->display_name }}
                            <span class="mailbox-read-time float-end">
                                @if ($message->sent_at)
                                    {{ $message->sent_at->format('d M.Y H:i') }}
                                @else
                                    {{ __('mailbox.Unknown Sent Date') }}
                                @endif
                            </span>
                            
                        </h6>
                    </div>
                    <div class="mailbox-read-message p-3">
                        <p>{{ $message->message }}</p>
                    </div>
                    <hr>

                    <!-- Display replies if exist -->
                    @if ($message->replies->isNotEmpty())
                        <div class="mailbox-replies p-3">
                            <h6><strong>Replies:</strong></h6>
                            @foreach ($message->replies as $reply)
                                <div class="mailbox-reply bg-light mb-3 p-3 rounded">
                                    <h6>
                                        From: {{ $reply->sender->display_name }}
                                        <span class="mailbox-read-time float-end">
                                            {{ $reply->sent_at->format('d M.Y H:i') }}
                                        </span>
                                    </h6>
                                    <p>{{ $reply->message }}</p>
                                </div>
                            @endforeach
                        </div>
                        <hr>
                    @endif

                    <!-- Reply and action buttons -->
                    <div class="mailbox-controls with-border text-center">
                        <div class="btn-group">
                            <form action="{{ route('internal-messages.reply', ['messageId' => $message->id]) }}"
                                method="GET" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-default btn-sm" title="Reply">
                                    <i class="fas fa-reply"></i>
                                </button>
                            </form>
                            <button type="button" class="btn btn-default btn-sm" data-container="body" title="Forward">
                                <i class="fas fa-share"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
