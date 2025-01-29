@extends('layouts.app')

@section('content')
    <div class="tab-pane fade show active" id="brows-users-tabpanel" role="tabpanel" aria-labelledby="brows-users-tab">
        @if ($users->isEmpty())
            <p class="text-muted">You have not suggestion any users.</p>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($users as $user)
                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                        <x-UserCard :user="$user" mode="suggestions" />
                    </div>
                @endforeach
            </div>
        @endif
    </div>

@endsection
