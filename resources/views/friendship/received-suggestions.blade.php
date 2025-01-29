@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>Friendship Requests</h3>
            <div class="card">
                <div class="card-body">
                    @if ($requests->isEmpty())
                        <p>No pending friendship requests.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($requests as $request)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $request->sender->display_name }}
                                    <div class="btn-group">
                                        <a href="{{ route('friend.acceptRequest', $request->id) }}" class="btn btn-success btn-sm">Accept</a>
                                        <a href="{{ route('friend.rejectRequest', $request->id) }}" class="btn btn-danger btn-sm">Reject</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
