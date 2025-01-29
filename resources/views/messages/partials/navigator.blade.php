@if (isset($isCompose) && $isCompose)
    <a href="{{ route('internal-messages.inbox') }}"
        class="btn btn-primary w-100 mb-3">{{ __('mailbox.back_to_Inbox') }}</a>
@else
    <a href="{{ route('internal-messages.compose') }}" class="btn btn-dark w-100 mb-3">{{ __('mailbox.Compose') }}</a>
@endif

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Folders</h3>

        <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i
                    data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse"
                    class="bi bi-dash-lg"></i> </button> </div>
    </div>
    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            @php
                $unreadCount = Auth::user()->unreadMessagesCount();
            @endphp

            <li class="nav-item active">
                <a href="{{ route('internal-messages.inbox') }}" class="nav-link">
                    <i class="fas fa-inbox"></i> {{ __('mailbox.Inbox') }}
                    @if ($unreadCount > 0)
                        <span class="badge bg-primary float-sm-end">{{ $unreadCount }}</span>
                    @endif
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('internal-messages.sent') }}" class="nav-link">
                    <i class="far fa-envelope"></i> {{ __('mailbox.Sent') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('internal-messages.draft') }}" class="nav-link">
                    <i class="far fa-file-alt"></i> {{ __('mailbox.Draft') }}
                </a>
            </li>

        </ul>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
