<li class="nav-item dropdown user-menu">
    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
        <img src="{{ asset('storage/' . $user->profileImage) }}" class="user-image rounded-circle shadow" alt="User Image">
        <span class="d-none d-md-inline">{{ $user->last_name }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        <li class="user-header text-bg-primary">
            <img src="{{ asset('storage/' . $user->profileImage) }}" class="rounded-circle shadow" alt="User Image">
            <p>
                {{ $user->display_name }}
                <small>{{ \Carbon\Carbon::parse($user->created_at)->format('Y-m-d') }}</small>
            </p>
        </li>
        <li class="user-body">
            <div class="row">
                {{-- <div class="col-4 text-center"><a href="#">Followers</a></div> --}}
                {{-- <div class="col-4 text-center"><a href="#">Sales</a></div> --}}
                <div class="col-4 text-center"><a href="#">Friends</a></div>
            </div>
        </li>
        <li class="user-footer">
            <a href="{{ route('profile.edit') }}" class="btn btn-default btn-flat">{{ __('Profile') }}</a>
            <a href="#" class="btn btn-default btn-flat float-end" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('auth.Sign out') }}</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</li>
