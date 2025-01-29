<tr class="{{ !$message->is_read ? 'table-primary' : '' }}">
    <td>
        <div class="icheck-primary">
            <input type="checkbox" id="check{{ $message->id }}">
            <label for="check{{ $message->id }}"></label>
        </div>
    </td>
    
    <td class="mailbox-name">
        @if ($mode === 'inbox')
            <!-- Show sender's profile image -->
            @if ($message->sender->profileImage)
                <img src="{{ asset('storage/' . $message->sender->profileImage) }}" alt="Sender's Profile" style="width: 40px; height: 40px;">
            @else
                <img src="{{ asset('storage/images/default-profile.jpg') }}" alt="Default Profile" style="width: 40px; height: 40px; border-radius: 50%;">
            @endif
        @else
            <!-- Show receiver's profile image -->
            @if ($message->receiver->profileImage)
                <img src="{{ asset('storage/' . $message->receiver->profileImage) }}" alt="Receiver's Profile" style="width: 40px; height: 40px; ">
            @else
                <img src="{{ asset('storage/images/default-profile.jpg') }}" alt="Default Profile" style="width: 40px; height: 40px;">
            @endif
        @endif
        <a href="{{ route('internal-messages.viewMessage', $message->id) }}">
            {{ $mode === 'inbox' ? $message->sender->display_name : $message->receiver->display_name }}
        </a>
    </td>
    <td class="mailbox-subject">
        {{ \Illuminate\Support\Str::limit($message->message, 100, '...') }}
    </td>
    <td class="mailbox-date">
        {{ \Carbon\Carbon::parse($message->sent_at)->diffForHumans() }}
    </td>
    <td class="mailbox-read-at-date">
        @if ($message->read_at)
            {{ \Carbon\Carbon::parse($message->read_at)->diffForHumans() }}
        @else
            <span class="text-muted">Not Read</span>
        @endif
    </td>
    
    
    
    
</tr>
