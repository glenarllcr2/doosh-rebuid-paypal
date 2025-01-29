<table class="table table-hover table-striped align-middle">
    <thead>
        <tr>
            <th></th>
            <th>
                <a href="{{ route($routePrefix, ['sort' => $targetSort, 'direction' => $sortColumn == $targetSort && $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                    {{ __($targetUserDisplayName) }}
                    @if ($sortColumn == $targetSort)
                        <i class="fas fa-sort-{{ $sortDirection }}"></i>
                    @endif
                </a>
            </th>
            <th>
                <a href="{{ route($routePrefix, ['sort' => 'message', 'direction' => $sortColumn == 'message' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                    {{ __('mailbox.message_body') }}
                    @if ($sortColumn == 'message')
                        <i class="fas fa-sort-{{ $sortDirection }}"></i>
                    @endif
                </a>
            </th>
            <th>
                <a href="{{ route($routePrefix, ['sort' => 'sent_at', 'direction' => $sortColumn == 'sent_at' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                    {{ __('mailbox.message_sent_at') }}
                    @if ($sortColumn == 'sent_at')
                        <i class="fas fa-sort-{{ $sortDirection }}"></i>
                    @endif
                </a>
            </th>
            <th>
                <a href="{{ route($routePrefix, ['sort' => 'read_at', 'direction' => $sortColumn == 'read_at' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                    {{ __('mailbox.message_read_at') }}
                    @if ($sortColumn == 'read_at')
                        <i class="fas fa-sort-{{ $sortDirection }}"></i>
                    @endif
                </a>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($messages as $message)
            <x-MessagesRow :message="$message" :mode="$mode" />
        @endforeach
    </tbody>
</table>
