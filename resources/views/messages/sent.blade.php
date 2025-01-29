@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('messages.partials.navigator')
        </div>
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">{{ __('mailbox.Inbox') }}</h3>
                    <div class="card-tools">
                        <form action="{{ route('internal-messages.inbox') }}" method="GET">
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" class="form-control"
                                    placeholder="{{ __('mailbox.search_mail') }}" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="container d-flex justify-content-between">
                        <div>
                            <!-- Check all button -->
                            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i
                                    class="far fa-square"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="fas fa-reply"></i>
                                </button>
                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="fas fa-share"></i>
                                </button>
                            </div>
                            <!-- /.btn-group -->
                            <button type="button" class="btn btn-default btn-sm">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                        <div class="card-tools">
                            <x-pagination :paginator="$messages" />
                        </div>

                    </div>

                    <div class="table-responsive mailbox-messages">
                        <table class="table table-hover table-striped">
                            <thead>
                                <th></th>
                                <th>
                                    <a
                                        href="{{ route('internal-messages.sent', ['sort' => 'sender_id', 'direction' => $sortColumn == 'sender_id' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                                        {{ __('mailbox.reciver_display_name') }}
                                        @if ($sortColumn == 'sender_id')
                                            <i class="fas fa-sort-{{ $sortDirection }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="{{ route('internal-messages.sent', ['sort' => 'message', 'direction' => $sortColumn == 'message' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                                        {{ __('mailbox.message_body') }}
                                        @if ($sortColumn == 'message')
                                            <i class="fas fa-sort-{{ $sortDirection }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="{{ route('internal-messages.sent', ['sort' => 'sent_at', 'direction' => $sortColumn == 'sent_at' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                                        {{ __('mailbox.message_sent_at') }}
                                        @if ($sortColumn == 'sent_at')
                                            <i class="fas fa-sort-{{ $sortDirection }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="{{ route('internal-messages.sent', ['sort' => 'read_at', 'direction' => $sortColumn == 'read_at' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                                        {{ __('mailbox.message_read_at') }}
                                        @if ($sortColumn == 'read_at')
                                            <i class="fas fa-sort-{{ $sortDirection }}"></i>
                                        @endif
                                    </a>
                                </th>
                            </thead>

                            <tbody>
                                @foreach ($messages as $message)
                                    <tr class="{{ !$message->is_read ? 'table-primary' : '' }}">
                                        <td>
                                            <div class="icheck-primary">
                                                <input type="checkbox" value="" id="check{{ $message->id }}">
                                                <label for="check{{ $message->id }}"></label>
                                            </div>
                                        </td>
                                        <td class="mailbox-name">
                                            <a
                                                href="{{ route('internal-messages.viewMessage', $message->id) }}">{{ $message->receiver->display_name }}</a>
                                        </td>
                                        <td class="mailbox-subject">
                                            {{ \Illuminate\Support\Str::limit($message->message, 100, '...') }}
                                        </td>
                                        <td class="mailbox-date">
                                            {{ \Carbon\Carbon::parse($message->sent_at)->diffForHumans() }}</td>
                                        <td class="mailbox-read-at-date">
                                            @if ($message->read_at)
                                                {{ \Carbon\Carbon::parse($message->read_at)->diffForHumans() }}
                                            @else
                                                <span class="text-muted">Not Read</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- /.table -->
                    </div>
                    <!-- /.mail-box-messages -->
                </div>
                <div class="card-footer p-2">
                    {{ $messages->links() }}
                    {{-- <x-pagination :paginator="$messages" /> --}}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
