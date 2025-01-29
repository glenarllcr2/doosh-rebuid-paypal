@extends('layouts.app')

@section('content')
    <div class="container text-center mt-5">
        <!-- Title -->
        <h1 class="text-danger">Account Suspended</h1>

        <!-- Warning alert -->
        <div class="alert alert-danger mt-4" role="alert">
            <strong>Your account has been temporarily suspended.</strong> You cannot access any part of the site at this moment. 
            Please contact support for more information.
        </div>

        <!-- Support contact information -->
        <div class="mt-4">
            <p>If you believe this is a mistake, please reach out to our support team:</p>
            <a href="mailto:support@example.com" class="btn btn-outline-primary">Contact Support</a>
        </div>

        <!-- No additional actions -->
        <p class="mt-5 text-muted">
            You cannot make any changes to your account while it is suspended. Thank you for your understanding.
        </p>
    </div>
@endsection
