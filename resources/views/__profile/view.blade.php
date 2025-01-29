@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>{{ $user->display_name }}'s Profile</h3>
            <div class="card">
                <div class="card-body">
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Gender:</strong> {{ $user->gender }}</p>
                    <p><strong>Age:</strong> {{ $user->age }}</p>

                    @if ($user->is_friend)
                        <button class="btn btn-success">Friend</button>
                    @elseif ($user->has_pending_request)
                        <button class="btn btn-info">Request Sent</button>
                    @else
                        <a href="{{ route('friend.sendRequest', $user->id) }}" class="btn btn-primary">Send Friend Request</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
