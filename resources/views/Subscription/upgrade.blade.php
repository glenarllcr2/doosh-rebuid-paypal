@extends('layouts.app')
@section('content')
    <div class="container">
        <h4 class="text-center">Upgrade Your Account</h4>
        <div class="card border-0 shadow-none">
            <div class="card-header border-0 shadow-none">
                <div class="row">
                    <div class="col">
                        <h4>The features you'll get</h4>

                        <div class="card mb-3 border-0 shadow-none" style="max-width: 340px;">
                            <div class="row g-0">
                                <div class="col-md-2 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-images fs-1"></i>
                                </div>
                                <div class="col-md-10">
                                    <div class="card-body">
                                        <h5 class="card-title fs-5 fw-bold">Access Photos</h5><br />
                                        <p class="card-text">Get access to all users photos</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3 border-0 shadow-none" style="max-width: 340px;">
                            <div class="row g-0">
                                <div class="col-md-2 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-chat-dots fs-1"></i>
                                </div>
                                <div class="col-md-10">
                                    <div class="card-body">
                                        <h5 class="card-title fs-5 fw-bold">Messaging</h5><br />
                                        <p class="card-text">Send & receive with other paid subscribers.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3 border-0 shadow-none" style="max-width: 340px;">
                            <div class="row g-0">
                                <div class="col-md-2 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-envelope-check fs-1"></i>
                                </div>
                                <div class="col-md-10">
                                    <div class="card-body">
                                        <h5 class="card-title fs-5 fw-bold">Read Receipts</h5><br />
                                        <p class="card-text">See if and when other users have read your messages.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3 border-0 shadow-none" style="max-width: 340px;">
                            <div class="row g-0">
                                <div class="col-md-2 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-heart fs-1"></i>
                                </div>
                                <div class="col-md-10">
                                    <div class="card-body">
                                        <h5 class="card-title fs-5 fw-bold">Liked You</h5><br />
                                        <p class="card-text">See which users have liked your profile.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3 border-0 shadow-none" style="max-width: 340px;">
                            <div class="row g-0">
                                <div class="col-md-2 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-eye fs-1"></i>
                                </div>
                                <div class="col-md-10">
                                    <div class="card-body">
                                        <h5 class="card-title fs-5 fw-bold">Viewed You</h5><br />
                                        <p class="card-text">See who has been visiting your profile.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3 border-0 shadow-none" style="max-width: 340px;">
                            <div class="row g-0">
                                <div class="col-md-2 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-fill-lock fs-1"></i>
                                </div>
                                <div class="col-md-10">
                                    <div class="card-body">
                                        <h5 class="card-title fs-5 fw-bold ">Profile Display Controls</h5><br />
                                        <p class="card-text">Hide your online status and profile from Browse & Matches.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3 border-0 shadow-none" style="max-width: 340px;">
                            <div class="row g-0">
                                <div class="col-md-2 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-incognito fs-1"></i>
                                </div>
                                <div class="col-md-10">
                                    <div class="card-body">
                                        <h1 class="card-title fs-5 fw-bold">Browse Anonymously</h1><br />
                                        <p class="card-text">Anonymously browse user profiles (doesn't trigger a profile
                                            view).</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col">
                        {{-- @dd($plans) --}}
                        <h4 class="text-start">Pick your plan</h4>
                        @foreach ($plans as $plan)
                            <x-SubscriptionCard :duration="$plan->duration" :price="$plan->price" :name="$plan->name" :recommended="$plan->is_recommended" />
                            <form action="{{ route('payment.create') }}" method="POST">
                                @csrf
                                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                <button type="submit" class="btn btn-primary mt-2">
                                    Pay ${{ $plan->price }} for {{ $plan->duration }}
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
