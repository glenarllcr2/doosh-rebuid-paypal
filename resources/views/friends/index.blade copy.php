@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Mydashboard</h1>
    <!-- Success and Error Messages -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="brows-users-tab" data-bs-toggle="tab" href="#brows-users-tabpanel" role="tab"
                aria-controls="brows-tabpanel" aria-selected="true">Browse</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="friends-tab" data-bs-toggle="tab" href="#friends-tabpanel" role="tab"
                aria-controls="friends-tabpanel" aria-selected="true">Friends</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="blocked-users-tab" data-bs-toggle="tab" href="#blocked-users-tabpanel" role="tab"
                aria-controls="blocked-users-tabpanel" aria-selected="false">Blocked Users</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="pending-requests-tab" data-bs-toggle="tab" href="#pending-requests-tabpanel"
                role="tab" aria-controls="pending-requests-tabpanel" aria-selected="false">Pending Friend Requests</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="search-tab" data-bs-toggle="tab" href="#search-tabpanel" role="tab"
                aria-controls="search-tabpanel" aria-selected="false">Search</a>
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content" id="tab-content">
        <div class="tab-pane fade show active" id="brows-users-tabpanel" role="tabpanel" aria-labelledby="brows-users-tab">
            @include('friends.partials.browse')
        </div>
        <!-- Friends Tab -->
        <div class="tab-pane fade" id="friends-tabpanel" role="tabpanel" aria-labelledby="friends-tab">
            @include('friends.partials.friends-tabs')
        </div>
        <!-- Blocked Users Tab -->
        <div class="tab-pane fade" id="blocked-users-tabpanel" role="tabpanel" aria-labelledby="blocked-users-tab">
            @include('friends.partials.blocked-friends')
        </div>
        <!-- Pending Friend Requests Tab -->
        <div class="tab-pane fade" id="pending-requests-tabpanel" role="tabpanel" aria-labelledby="pending-requests-tab">
            @include('friends.partials.receive-requesteds')
        </div>
        <!-- Search Tab -->
        <div class="tab-pane fade" id="search-tabpanel" role="tabpanel" aria-labelledby="search-tab">
            @include('friends.partials.search')
        </div>

    </div>
@endsection
