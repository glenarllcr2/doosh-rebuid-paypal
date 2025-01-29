@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>Search for Friends</h3>
            <form method="GET" action="{{ route('friend.search') }}">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search users..." name="query" value="{{ request('query') }}">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>

            @if ($users->isEmpty())
                <p>No users found.</p>
            @else
                <div class="list-group">
                    @foreach ($users as $user)
                        <a href="{{ route('friend.sendRequest', $user->id) }}" class="list-group-item list-group-item-action">
                            {{ $user->display_name }}
                            @if ($user->is_friend)
                                <span class="badge bg-success float-end">Friend</span>
                            @elseif ($user->has_pending_request)
                                <span class="badge bg-info float-end">Request Sent</span>
                            @else
                                <span class="badge bg-primary float-end">Send Request</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
