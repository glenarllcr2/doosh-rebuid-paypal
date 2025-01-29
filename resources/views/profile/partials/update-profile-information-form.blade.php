<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            {{ __('Profile Information') }}
        </h2>
        <p class="card-text">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </div>

    <div class="card-body">
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}" class="mt-3">
            @csrf
            @method('patch')
            {{-- @dd($user) --}}
            <div class="row mb-3">
                <div class="col">
                    <label for="first_name" class="form-label">{{ __('First Name') }}</label>
                    <input type="text" id="first_name" name="first_name" class="form-control"
                        value="{{ old('first_name', $user->first_name) }}" required autofocus>
                    @if ($errors->has('first_name'))
                        <div class="text-danger mt-1">
                            {{ $errors->first('first_name') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-3">
                    <label for="mid_name" class="form-label">{{ __('Middle Name') }}</label>
                    <input type="text" id="mid_name" name="mid_name" class="form-control"
                        value="{{ old('mid_name', $user->mid_name) }}">
                    @if ($errors->has('mid_name'))
                        <div class="text-danger mt-1">
                            {{ $errors->first('mid_name') }}
                        </div>
                    @endif
                </div>
                <div class="col">
                    <label for="last_name" class="form-label">{{ __('Last Name') }}</label>
                    <input type="text" id="last_name" name="last_name" class="form-control"
                        value="{{ old('last_name', $user->last_name) }}" required>
                    @if ($errors->has('last_name'))
                        <div class="text-danger mt-1">
                            {{ $errors->first('last_name') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input type="email" id="email" name="email" class="form-control"
                        value="{{ old('email', $user->email) }}" required autocomplete="username" readonly>
                    @if ($errors->has('email'))
                        <div class="text-danger mt-1">
                            {{ $errors->first('email') }}
                        </div>
                    @endif

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                        <div class="mt-2">
                            <p class="text-muted">
                                {{ __('Your email address is unverified.') }}
                                <button form="send-verification"
                                    class="btn btn-link p-0">{{ __('Click here to re-send the verification email.') }}</button>
                            </p>
                            @if (session('status') === 'verification-link-sent')
                                <p class="text-success mt-2">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="col">
                    <label for="phone_number" class="form-label">{{ __('Phone Number') }}</label>
                    <input type="tel" id="phone_number" name="phone_number" class="form-control"
                        value="{{ old('phone_number', $user->phone_number) }}" readonly>
                    @if ($errors->has('phone_number'))
                        <div class="text-danger mt-1">
                            {{ $errors->first('phone_number') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="row mb-3 mt-3">
                <div class="col">
                    <fieldset>
                        <legend>{{ __('Gender') }}</legend>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="genderMale" value="male"
                                {{ old('gender', $user->gender) == 'male' ? 'checked' : '' }} required readonly>
                            <label class="form-check-label" for="genderMale">{{ __('Male') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="genderFemale"
                                value="female" {{ old('gender', $user->gender) == 'female' ? 'checked' : '' }} required
                                readonly>
                            <label class="form-check-label" for="genderFemale">{{ __('Female') }}</label>
                        </div>
                        @if ($errors->has('gender'))
                            <div class="text-danger mt-1">
                                {{ $errors->first('gender') }}
                            </div>
                        @endif
                    </fieldset>
                </div>
                <div class="col">
                    <label for="birth_date" class="form-label">{{ __('Birth Date') }}</label>
                    <input type="date" id="birth_date" name="birth_date" class="form-control"
                        value="{{ old('birth_date', $user->birth_date) }}" required readonly>
                    @if ($errors->has('birth_date'))
                        <div class="text-danger mt-1">
                            {{ $errors->first('birth_date') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="mb-3">

            </div>

            <div class="mb-3">

            </div>

            <div class="d-flex justify-content-between align-items-center">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                @if (session('status') === 'profile-updated')
                    <p class="text-muted mb-0" x-data="{ show: true }" x-show="show" x-transition
                        x-init="setTimeout(() => show = false, 2000)">
                        {{ __('Saved.') }}
                    </p>
                @endif
            </div>
        </form>
    </div>
</div>
