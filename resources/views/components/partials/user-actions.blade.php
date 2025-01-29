@php
    $buttons = [];
    switch ($mode) {
        case 'friends':
            $buttons = [
                ['route' => 'friends.remove', 'text' => 'Remove', 'method' => 'POST'],
                ['route' => 'block-user.block', 'text' => 'Block', 'method' => 'POST'],
                ['route' => 'profile', 'text' => 'View profile', 'method' => 'GET'],
                ['route' => 'internal-messages.compose', 'text' => 'Send Message', 'method' => 'GET'],
            ];
            break;
        case 'blocks':
            $buttons = [
                ['route' => 'block-user.unblock', 'text' => 'Unblock', 'method' => 'POST'],
            ];
            break;
        case 'receive-suggestion':
            $buttons = [
                ['route' => 'friend-request.accept', 'text' => 'Accept', 'method' => 'POST'],
                ['route' => 'friend-request.reject', 'text' => 'Reject', 'method' => 'POST'],
                ['route' => 'profile', 'text' => 'View profile', 'method' => 'GET'],
                ['route' => 'internal-messages.compose', 'text' => 'Send Message', 'method' => 'GET'],
            ];
            break;
        case 'suggestions':
            $buttons = [
                ['route' => 'friend-request.send', 'text' => 'Send Request', 'method' => 'POST'],
                ['route' => 'profile', 'text' => 'View profile', 'method' => 'GET'],
                ['route' => 'internal-messages.compose', 'text' => 'Send Message', 'method' => 'GET'],
            ];
            break;
    }
@endphp
@include('components.partials.action-buttons', ['buttons' => $buttons, 'user' => $user])


