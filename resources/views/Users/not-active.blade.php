@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Account pending approval</h1>

        <!-- Warning alert -->
        <div class="alert alert-warning" role="alert">
            <strong>Account pending approval</strong> Your profile is awaiting admin approval. Please be patient.
        </div>

        <!-- Info alert about profile status -->
        <div class="alert alert-info" role="alert">
            <strong>Note!</strong> Your profile may be incomplete. Please go to your settings and fill in all necessary
            information.
        </div>

        <!-- Button to navigate to profile settings -->
        <div class="mt-3">
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">Go to Profile Settings</a>
        </div>

        <!-- Next steps and suggestions -->
        <div class="mt-4">
            <h4>Next Steps</h4>
            <ul>
                <li>Make sure all your personal details are up-to-date.</li>
                <li>Upload any required documents (if requested by the admin).</li>
                <li>Once your profile is complete, you will have access to all the features of the site.</li>
            </ul>
        </div>
    </div>

@endsection
