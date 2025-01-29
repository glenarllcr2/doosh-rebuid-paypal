@extends('layouts.app')

@php
    /**
     * Determine the settings based on mode
     */
    $settings = match ($mode) {
        'inbox' => [
            'routePrefix' => 'internal-messages.inbox',
            'targetUserDisplayName' => 'mailbox.sender_display_name',
            'targetSort' => 'sender_id',
            'label' => __('mailbox.Inbox'),
        ],
        'sent' => [
            'routePrefix' => 'internal-messages.sent',
            'targetUserDisplayName' => 'mailbox.receiver_display_name',
            'targetSort' => 'receiver_id',
            'label' => __('mailbox.Sent'),
        ],
        'draft' => [
            'routePrefix' => 'internal-messages.draft',
            'targetUserDisplayName' => 'mailbox.receiver_display_name',
            'targetSort' => 'sender_id',
            'label' => __('mailbox.Draft'),
        ],
        default => [
            'routePrefix' => 'internal-messages.index',
            'targetUserDisplayName' => 'mailbox.sender_display_name',
            'targetSort' => 'sender_id',
            'label' => __('mailbox.Inbox'),
        ],
    };

    $routePrefix = $settings['routePrefix'];
    $targetUserDisplayName = $settings['targetUserDisplayName'];
    $targetSort = $settings['targetSort'];
    $label = $settings['label'];
@endphp

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('messages.partials.navigator')
        </div>
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">{{ $label }}</h3>
                    <div class="card-tools">
                        <form action="{{ route($routePrefix) }}" method="GET">
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
                </div>
                <div class="card-body p-0">
                    <div class="container d-flex justify-content-between">
                        <div>
                            <!-- Action buttons -->
                            @include('messages.partials.actions')
                        </div>
                        <div class="card-tools">
                            <x-pagination :paginator="$messages" />
                        </div>
                    </div>

                    <!-- Messages Table -->
                    <div class="table-responsive mailbox-messages">
                        <x-MessagesTable 
                            :messages="$messages" 
                            :mode="$mode" 
                            :sortColumn="$sortColumn" 
                            :sortDirection="$sortDirection" 
                            :routePrefix="$routePrefix"
                            :targetSort='$targetSort'
                            :targetUserDisplayName='$targetUserDisplayName' 
                            />
                    </div>
                </div>
                <div class="card-footer p-2">
                    {{ $messages->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
