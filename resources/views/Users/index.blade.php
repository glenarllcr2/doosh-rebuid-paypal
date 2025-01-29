@extends('layouts.app')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">{{ __('User Management') }}</h3>
        </div>
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center mb-3 p-3">
                <h2 class="mb-0">{{ __('Users List') }}</h2>
                <!-- فرم جستجو -->
                <form method="GET" action="{{ route('users-manager.index') }}" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="{{ __('Search users...') }}"
                            value="{{ $search }}">
                        <button class="btn btn-primary" type="submit">{{ __('Search') }}</button>
                    </div>
                </form>
            </div>

            <table class="table table-striped table-hover">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th></th>
                        <th>
                            <a
                                href="{{ route('users-manager.index', [
                                    'sortBy' => 'first_name',
                                    'sortDirection' => $sortDirection == 'asc' ? 'desc' : 'asc',
                                    'search' => request()->input('search'),
                                ]) }}">
                                {{ __('First Name') }}
                                @if ($sortBy == 'first_name')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a
                                href="{{ route('users-manager.index', [
                                    'sortBy' => 'last_name',
                                    'sortDirection' => $sortDirection == 'asc' ? 'desc' : 'asc',
                                    'search' => request()->input('search'),
                                ]) }}">
                                {{ __('Last Name') }}
                                @if ($sortBy == 'last_name')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a
                                href="{{ route('users-manager.index', [
                                    'sortBy' => 'display_name',
                                    'sortDirection' => $sortDirection == 'asc' ? 'desc' : 'asc',
                                    'search' => request()->input('search'),
                                ]) }}">
                                {{ __('Display Name') }}
                                @if ($sortBy == 'display_name')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a
                                href="{{ route('users-manager.index', [
                                    'sortBy' => 'gender',
                                    'sortDirection' => $sortDirection == 'asc' ? 'desc' : 'asc',
                                    'search' => request()->input('search'),
                                ]) }}">
                                {{ __('Gender') }}
                                @if ($sortBy == 'gender')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a
                                href="{{ route('users-manager.index', [
                                    'sortBy' => 'email',
                                    'sortDirection' => $sortDirection == 'asc' ? 'desc' : 'asc',
                                    'search' => request()->input('search'),
                                ]) }}">
                                {{ __('Email') }}
                                @if ($sortBy == 'email')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a
                                href="{{ route('users-manager.index', [
                                    'sortBy' => 'phone_number',
                                    'sortDirection' => $sortDirection == 'asc' ? 'desc' : 'asc',
                                    'search' => request()->input('search'),
                                ]) }}">
                                {{ __('Phone Number') }}
                                @if ($sortBy == 'phone_number')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a
                                href="{{ route('users-manager.index', [
                                    'sortBy' => 'status',
                                    'sortDirection' => $sortDirection == 'asc' ? 'desc' : 'asc',
                                    'search' => request()->input('search'),
                                ]) }}">
                                {{ __('Status') }}
                                @if ($sortBy == 'status')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a
                                href="{{ route('users-manager.index', [
                                    'sortBy' => 'role_id',
                                    'sortDirection' => $sortDirection == 'asc' ? 'desc' : 'asc',
                                    'search' => request()->input('search'),
                                ]) }}">
                                {{ __('Role') }}
                                @if ($sortBy == 'role_id')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a
                                href="{{ route('users-manager.index', ['sortBy' => 'plans.name', 'sortDirection' => $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                                {{ __('Plan') }}
                                @if ($sortBy == 'plans.name')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>

                @if ($users->isEmpty())
                    <tr>
                        <td colspan="10" class="text-center">
                            <div class="alert alert-warning" role="alert">
                                <strong>{{ __('No users found') }}</strong>
                                {{ __('Try adjusting your search or filter options.') }}
                            </div>
                        </td>
                    </tr>
                @else
                    <tbody>
                        @foreach ($users as $user)
                            <tr>

                                <td>
                                    @if ($user->profile_image)
                                        <!-- بررسی می‌کنیم که آیا تصویر پروفایل وجود دارد یا نه -->
                                        <img src="{{ asset('storage/' . $user->profile_image) }}"
                                            alt="{{ $user->first_name }}'s Profile Image"
                                            style="width: 40px; height: 40px; ">
                                    @else
                                        <img src="{{ asset('images/default-profile.jpg') }}"
                                            alt="{{ $user->first_name }}'s Profile Image"
                                            style="width: 40px; height: 40px; ">
                                    @endif
                                </td>
                                {{-- @if ($user->first_name == 'Noel')
                                    @dd($user)
                                    
                                @endif --}}
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->display_name }}</td>
                                <td>{{ $user->gender }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone_number }}</td>
                                <td>{{ ucfirst($user->status) }}</td>
                                <td>{{ $user->role->name }}</td>
                                <td>
                                    @if ($user->activeSubscription)
                                        <span class="badge bg-success">
                                            {{ $user->activeSubscription->plan->name }}
                                        </span>
                                    @else
                                        <span class="badge bg-warning">{{ __('No Active Subscription') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('users-manager.show', $user) }}" class="btn btn-sm btn-dark"><i
                                            class="fas fa-eye"></i> {{ __('View') }}</a>
                                    <a href="{{ route('users-manager.reset-password', $user->id) }}"
                                        class="btn btn-sm btn-dark">
                                        <i class="fas fa-key"></i> {{ __('Reset Password') }}
                                    </a>
                                    {{-- <form action="{{ route('users-manager.destroy', $user->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}</button>
                                    </form> --}}
                                    <a href="https://www.google.com/search?q={{ $user->first_name }}+{{ $user->last_name }}" class="btn btn-sm btn-dark" target="_blank">Search Google</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
        </div>
        <div class="card-footer ">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
