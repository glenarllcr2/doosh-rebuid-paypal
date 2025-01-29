@extends('layouts.app')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>{{ __('User Profile') }}</h3>
                {{-- @can('update', $user) <!-- فقط ادمین یا کاربری که دسترسی تغییر دارد، این گزینه را ببیند --> --}}
                    <form action="{{ route('users-manager.update-status', $user->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="input-group">
                            <select name="status" class="form-select" aria-label="Change Status">
                                <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="pending" {{ $user->status == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                <option value="suspended" {{ $user->status == 'suspended' ? 'selected' : '' }}>{{ __('Suspended') }}</option>
                                <option value="blocked" {{ $user->status == 'blocked' ? 'selected' : '' }}>{{ __('Blocked') }}</option>
                            </select>
                            <button type="submit" class="btn btn-primary ms-2">{{ __('Update Status') }}</button>
                        </div>
                    </form>
                {{-- @endcan --}}
            </div>
        </div>
        <div class="card-body">
            <!-- نمایش عکس پروفایل -->
            <div class="text-center">
                @if ($user->medias->isNotEmpty())
                    <!-- پیدا کردن عکس پروفایل -->
                    @php
                        $profileImage = $user->medias->where('pivot.is_profile', true)->first();
                    @endphp
                    @if ($profileImage)
                        <img src="{{ asset('storage/' . $profileImage->url) }}" alt="{{ $user->first_name }}'s Profile Image"
                            class="img-fluid  mb-3" style="width: 150px; height: 150px;">
                    @else
                        <img src="{{ asset('storage/images/default-profile.jpg') }}"
                            alt="{{ $user->first_name }}'s Profile Image" class="img-fluid  mb-3"
                            style="width: 150px; height: 150px;">
                    @endif
                @endif
            </div>

            <h4>{{ __('User Information') }}</h4>
            <p><strong>{{ __('Name') }}:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
            <p><strong>{{ __('Email') }}:</strong> {{ $user->email }}</p>
            <p><strong>{{ __('Phone Number') }}:</strong> {{ $user->phone_number }}</p>
            <p><strong>{{ __('Status') }}:</strong> {{ ucfirst($user->status) }}</p>
            <p><strong>{{ __('Gender') }}:</strong> {{ ucfirst($user->gender) }}</p>

            <h4 class="mt-4">{{ __('Album') }}</h4>

            <!-- نمایش آلبوم تصاویر -->
            <div class="row">
                @foreach ($user->medias->where('pivot.is_profile', false) as $media)
                    <div class="col-md-2 mb-3">
                        <div class="card">
                            <img src="{{ asset('storage/' . $media->url) }}" alt="User media" class="card-img-top">
                            <div class="card-body">
                                <!-- بررسی وضعیت تایید عکس -->
                                @if ($media->pivot->is_approved == false)
                                    <div class="ribbon position-absolute top-0 start-0">
                                        <span>{{ __('Not Approved') }}</span>
                                    </div>
                                @endif
                                {{-- <h5 class="card-title">{{ __('Media Image') }}</h5> --}}
                                <form action="{{ route('users-manager.update-media-status', $media->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    @if ($media->pivot->is_approved == false)
                                        <button type="submit" class="btn btn-success">{{ __('Approve') }}</button>
                                    @else
                                        <button type="submit" class="btn btn-warning">{{ __('Unapprove') }}</button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card-footer">
            <div class="text-end">
                <a href="{{ route('users-manager.index') }}" class="btn btn-secondary">{{ __('Back to Users List') }}</a>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        /* استایل‌های ربان */
        .ribbon {
            background-color: rgba(255, 0, 0, 0.7);
            color: white;
            padding: 5px 10px;
            font-size: 14px;
            font-weight: bold;
            transform: rotate(-45deg);
            top: 10px;
            left: 10px;
            z-index: 10;
            display: inline-block;
            position: absolute;
        }
    </style>
@endsection
