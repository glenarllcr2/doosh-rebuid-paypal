@extends('layouts.app')

@section('content')
    <div class="container text-center mt-5">
        <!-- Title -->
        <h1 class="text-danger">Account Blocked</h1>

        <!-- Warning alert -->
        <div class="alert alert-dark mt-4" role="alert">
            <strong>Your account has been permanently blocked.</strong> You cannot access any part of the site. 
            If you think this is a mistake, please contact support.
        </div>

        <!-- Support contact information -->
        <div class="mt-4">
            <p>If you believe your account was blocked in error, you can reach out to our support team for assistance:</p>
            <a href="mailto:support@example.com" class="btn btn-outline-primary">Contact Support</a>
        </div>

        <!-- No additional actions -->
        <p class="mt-5 text-muted">
            This action is final and cannot be reversed without admin intervention. Thank you for your understanding.
        </p>
    </div>
@endsection
