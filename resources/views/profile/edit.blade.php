@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4 text-center">User Profile1</h1>

        <!-- Profile Header -->
        <div class="profile-header d-flex align-items-center mb-4">
            <img src="https://via.placeholder.com/150" id="profilePicture" class="profile-picture" alt="Profile Picture">
            <div class="ms-3">
                <h2 id="userName">{{ $user->first_name }} {{ $user->last_name }}</h2>

            </div>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs" id="profileTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link  active" id="photos-tab" data-bs-toggle="tab" data-bs-target="#photos"
                    type="button" role="tab" aria-controls="photos" aria-selected="false">Photos</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="wizard-tab" data-bs-toggle="tab" data-bs-target="#wizard" type="button"
                    role="tab" aria-controls="wizard" aria-selected="false">Questions And Asnwers</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button"
                    role="tab" aria-controls="password" aria-selected="false">Change Password</button>
            </li>
        </ul>

        <div class="tab-content mt-4" id="profileTabsContent">

            <!-- Tab: Photos -->
            <div class="tab-pane fade show active" id="photos" role="tabpanel" aria-labelledby="photos-tab">
                @include('profile.partials.photo-gallery')
            </div>

            <!-- Tab: Wizard -->
            <div class="tab-pane fade" id="wizard" role="tabpanel" aria-labelledby="wizard-tab">
                @include('profile.partials.wizard')
            </div>


            <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>



    <!-- Toast Container -->
    <div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
        <div id="toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto" id="toastTitle"></strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div id="toastBody" class="toast-body"></div>
        </div>
    </div>

    <div id="toastSuccess" class="toast toast-success" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header"> <i class="bi bi-circle me-2"></i> <strong class="me-auto">Dooshalah</strong> <small>11
                mins ago</small> <button type="button" class="btn-close" data-bs-dismiss="toast"
                aria-label="Close"></button> </div>
        <div class="toast-body">
            
        </div>
    </div>
@endsection
