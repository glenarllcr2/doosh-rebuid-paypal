@extends('layouts.app')

@section('page-header')
{{-- {{ __('messages.'.$page_title) }} --}}
@endsection

@section('content')
<!-- Tabs navs -->
<ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
            aria-controls="profile" aria-selected="true">Update Profile</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="password-tab" data-bs-toggle="tab" href="#password" role="tab"
            aria-controls="password" aria-selected="false">Update Password</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="attributes-tab" data-bs-toggle="tab" href="#attributes" role="tab" aria-controls="attributes"
            aria-selected="false">User Attributes</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="photos-tab" data-bs-toggle="tab" href="#photos" role="tab" aria-controls="photos"
            aria-selected="false">User Photos</a>
    </li>
</ul>
<!-- Tabs navs -->

<!-- Tabs content -->
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        @include('profile.partials.update-profile-information-form')
    </div>
    <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
        @include('profile.partials.update-password-form')
        {{-- <div class="mt-3">
                @include('profile.partials.delete-user-form')
            </div> --}}
    </div>
    <div class="tab-pane fade" id="attributes" role="tabpanel" aria-labelledby="attributes-tab">
        <x-UserProfileWizard :step="1" />
    </div>
    <div class="tab-pane fade" id="photos" role="tabpanel" aria-labelledby="photos-tab">
        {{-- <x-PaUserPhotos :user="$user" /> --}}
    </div>
</div>
<!-- Tabs content -->




@endsection