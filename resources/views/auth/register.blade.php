<x-guest-layout>
    
    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- <div>
            <div class="input-group mb-1">
                <div class="form-floating">
                    <input id="name" name="name" type="text" class="form-control" placeholder="" autofocus
                        value="{{ old('name') }}">
                    <label for="name">{{ __('auth.Full Name') }}</label>
                </div>
                <div class="input-group-text"> <span class="bi bi-person"></span> </div>
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div> --}}
        <div>
            <div class="input-group mb-1">
                <div class="form-floating">
                    <input id="first_name" name="first_name" type="text" class="form-control" placeholder="" autofocus
                        value="{{ old('first_name') }}">
                    <label for="first_name">{{ __('auth.First Name') }}</label>
                </div>
                <div class="input-group-text"> <span class="bi bi-person"></span> </div>
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div>
            <div class="input-group mb-1">
                <div class="form-floating">
                    <input id="mid_name" name="mid_name" type="text" class="form-control" placeholder=""
                        value="{{ old('mid_name') }}">
                    <label for="mid_name">{{ __('auth.Mid Name') }}</label>
                </div>
                <div class="input-group-text"> <span class="bi bi-person"></span> </div>
            </div>
            <x-input-error :messages="$errors->get('mid_name')" class="mt-2" />
        </div>
        <div>
            <div class="input-group mb-1">
                <div class="form-floating">
                    <input id="last_name" name="last_name" type="text" class="form-control" placeholder=""
                        value="{{ old('last_name') }}">
                    <label for="last_name">{{ __('auth.Last Name') }}</label>
                </div>
                <div class="input-group-text"> <span class="bi bi-person"></span> </div>
            </div>
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <div>
            <div class="input-group mb-1">
                <div class="form-floating">
                    <input id="display_name" name="display_name" type="text" class="form-control" placeholder=""
                        value="{{ old('display_name') }}">
                    <label for="display_name">{{ __('auth.Display Name') }}</label>
                </div>
                <div class="input-group-text"> <span class="bi bi-person"></span> </div>
            </div>
            <x-input-error :messages="$errors->get('display_name')" class="mt-2" />
        </div>

        <div>
            <div class="input-group mb-1">
                <div class="form-floating">
                    <input id="email" name="email" type="email" class="form-control" placeholder=""
                        value="{{ old('email') }}">
                    <label for="email">{{ __('auth.Email') }}</label>
                </div>
                <div class="input-group-text"> <span class="bi bi-envelope"></span> </div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div>
            <div class="input-group mb-1">
                <div class="form-floating">
                    <input id="phone_number" name="phone_number" type="tel" class="form-control" placeholder=""
                        value="{{ old('phone_number') }}">
                    <label for="phone_number">{{ __('auth.Phone Number') }}</label>
                </div>
                <div class="input-group-text"> <span class="bi bi-telephone"></span> </div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="input-group mb-1">
                <div class="form-floating"> <input id="password" name="password" type="password" class="form-control"
                        placeholder="">
                    <label for="password">{{ __('auth.Password') }}</label>
                </div>
                <div class="input-group-text"> <span class="bi bi-lock-fill"></span> </div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <div class="input-group mb-1">
                <div class="form-floating"> <input id="password_confirmation" name="password_confirmation"
                        type="password" class="form-control" placeholder="">
                    <label for="password_confirmation">{{ __('auth.Password Confirmation') }}</label>
                </div>
                <div class="input-group-text"> <span class="bi bi-lock-fill"></span> </div>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger" />
        </div>
        <div class="mb-2 mt-2">
            <label>{{ __('auth.Gender') }}</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="gender_male" value="male" {{ old('gender') == 'male' ? 'checked' : '' }}>
                <label class="form-check-label" for="gender_male">
                    {{ __('auth.Male') }}
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="gender_female" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
                <label class="form-check-label" for="gender_female">
                    {{ __('auth.Female') }}
                </label>
            </div>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>
        <div>
            <div class="input-group mb-1">
                <div class="form-floating">
                    <input id="birth_date" name="birth_date" type="date" class="form-control" placeholder="" value="{{ old('birth_date') }}">
                    <label for="birth_date">{{ __('auth.Date of Birth') }}</label>
                </div>
                <div class="input-group-text"> <span class="bi bi-calendar"></span> </div>
            </div>
            <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
        </div>

        <hr/>
        <div class="row pt-3">
            <div class="col-8 d-inline-flex align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{ old('terms') ? 'on' : '' }}"
                        id="terms" name="terms" required>
                    <label class="form-check-label" for="terms">
                        {{ __('auth.I agree to the') }} <a href="#" data-bs-toggle="modal"
                            data-bs-target="#termsModal">{{__('auth.terms')}}</a>
                    </label>
                    @error('terms')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-4">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">{{ __('auth.Register') }}</button>
                </div>
            </div>
        </div>
        <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="termsModalLabel">Terms Of Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="terms-content" style="overflow-y: auto; height: 300px;">
                            {!! __('terms.terms')!!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <p class="mb-0"> <a class='link-primary text-center' href='{{ route('login') }}'>
            {{ __('auth.I already have a membership') }}
        </a> </p>
</x-guest-layout>
