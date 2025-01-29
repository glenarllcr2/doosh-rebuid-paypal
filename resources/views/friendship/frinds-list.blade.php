@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>My Friends</h3>
            <div class="card">
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($friends as $friend)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $friend->display_name }}
                                <div class="btn-group">
                                    <a href="{{ route('friend.remove', $friend->id) }}" class="btn btn-danger btn-sm">Remove</a>
                                    <a href="{{ route('friend.block', $friend->id) }}" class="btn btn-warning btn-sm">Block</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
