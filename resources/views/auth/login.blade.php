<x-guest-layout>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

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
            <p class="login-box-msg">{{ __('auth.login.Sign in to start your session') }}</p>
            <form method="POST" action="{{ route('login') }}">
                @csrf



                <!-- Email Address -->
                <div>
                    <div class="input-group mb-1">
                        <div class="form-floating">
                            <input id="email" type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}" placeholder="" autofocus autocomplete="username">
                            <label for="email">{{ __('auth.Email') }}</label>
                        </div>
                        <div class="input-group-text">
                            <span class="bi bi-envelope"></span>
                        </div>

                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <div class="input-group mb-1">
                        <div class="form-floating">
                            <input id="password" type="password" class="form-control" name="password" placeholder=""
                                autocomplete="current-password">
                            <label for="email">{{ __('auth.Password') }}</label>
                        </div>
                        <div class="input-group-text">
                            <span class="bi bi-lock-fill"></span>
                        </div>

                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="row">
                    <div class="col-8 d-inline-flex align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="remember_me"
                                name="remember">
                            <label class="form-check-label" for="remember_me">
                                {{ __('auth.login.Remember Me') }}
                            </label>
                        </div>
                    </div> <!-- /.col -->
                    <div class="col-4">
                        <div class="d-grid gap-2"> <button type="submit"
                                class="btn btn-primary">{{ __('auth.login.Sign In') }}</button> </div>
                    </div> <!-- /.col -->
                </div>

                <p class="mb-1">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">{{ __('auth.login.I forgot my password') }}</a>
                    @endif
                </p>
                <p class="mb-0">
                    <a class="text-center" href="{{ route('register') }}">
                        {{ __('auth.login.Register a new membership') }}
                    </a>
                </p>
            </form>

</x-guest-layout>
