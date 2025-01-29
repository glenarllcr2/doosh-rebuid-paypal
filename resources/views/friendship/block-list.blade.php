@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>Blocked Users</h3>
            <div class="card">
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($blockedUsers as $blockedUser)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $blockedUser->display_name }}
                                <a href="{{ route('friend.unblock', $blockedUser->id) }}" class="btn btn-secondary btn-sm">Unblock</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
