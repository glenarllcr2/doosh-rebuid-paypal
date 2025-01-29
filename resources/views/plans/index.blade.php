@extends('layouts.app')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">{{ __('Plan Management') }}</h3>
        </div>
        <div class="card-body">
            <x-PaDataTable 
            :records="$records" 
            :columns="$columns" 
            :sortable-columns="$sortableColumns" 
            :sort-column="request('sortColumn', 'id')" 
            :sort-direction="request('sortDirection', 'asc')"
            route="plans" 
            create-route="plans.create" 
            :actions="['edit']" />
        </div>
        
        {{-- <div class="card-body table-responsive">
            <div class="d-flex justify-content-between align-items-center mb-3 p-3">
                <h2 class="mb-0">{{ __('Plans List') }}</h2>
                <!-- فرم جستجو -->
                <form method="GET" action="{{ route('plans.index') }}" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="{{ __('Search plans...') }}"
                            value="{{ $search }}">
                        <button class="btn btn-primary" type="submit">{{ __('Search') }}</button>
                    </div>
                </form>
            </div>

            <table class="table table-striped align-middle table-hover">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th>

                        </th>
                        <th>
                            <a
                                href="{{ route('plans.index', [
                                    'sortBy' => 'price',
                                    'sortDirection' => $sortDirection == 'asc' ? 'desc' : 'asc',
                                    'search' => request()->input('search'),
                                ]) }}">
                                {{ __('price') }}
                                @if ($sortBy == 'price')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a
                                href="{{ route('plans.index', [
                                    'sortBy' => 'desacription',
                                    'sortDirection' => $sortDirection == 'asc' ? 'desc' : 'asc',
                                    'search' => request()->input('search'),
                                ]) }}">
                                {{ __('Description') }}
                                @if ($sortBy == 'description')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                @if ($plans->isEmpty())
                    <tr>
                        <td colspan="10" class="text-center">
                            <div class="alert alert-warning" role="alert">
                                <strong>{{ __('No plans found') }}</strong>
                                {{ __('Try adjusting your search or filter options.') }}
                            </div>
                        </td>
                    </tr>
                @else
                    <tbody>
                        @foreach ($plans as $plan)
                            <tr>
                                <td>
                                    {{ $plan->name }}
                                </td>
                                <td>{{ $plan->price }}</td>
                                <td>{{ $plan->description }}</td>
                                <td>
                                    <a href="{{ route('plans.show', $plan) }}" class="btn btn-sm btn-dark"><i
                                            class="fas fa-eye"></i> {{ __('View') }}</a>

                                    <form action="{{ route('plans.destroy', $plan->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table> --}}
    </div>
    {{-- <div class="card-footer ">
        {{ $plans->links('pagination::bootstrap-5') }}
    </div> --}}
    </div>
    {{-- <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>
                            <a
                                href="{{ route('plans.index', [
                                    'sortBy' => 'name',
                                    'sortDirection' => $sortDirection == 'asc' ? 'desc' : 'asc',
                                    'search' => request()->input('search'),
                                ]) }}">
                                {{ __('Plan Name') }}
                                @if ($sortBy == 'name')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a
                                href="{{ route('plans.index', [
                                    'sortBy' => 'price',
                                    'sortDirection' => $sortDirection == 'asc' ? 'desc' : 'asc',
                                    'search' => request()->input('search'),
                                ]) }}">
                                {{ __('price') }}
                                @if ($sortBy == 'price')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a
                                href="{{ route('plans.index', [
                                    'sortBy' => 'desacription',
                                    'sortDirection' => $sortDirection == 'asc' ? 'desc' : 'asc',
                                    'search' => request()->input('search'),
                                ]) }}">
                                {{ __('Description') }}
                                @if ($sortBy == 'description')
                                    <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($plans->isEmpty())
                        <tr>
                            <td colspan="10" class="text-center">
                                <div class="alert alert-warning" role="alert">
                                    <strong>{{ __('No plans found') }}</strong>
                                    {{ __('Try adjusting your search or filter options.') }}
                                </div>
                            </td>
                        </tr>
                    @else
                        @foreach ($plans as $plan)
                            <tr>
                                <td>{{ $plan->name }}</td>
                                <td>{{ $plan->price }}</td>
                                <td>{{ $plan->description }}</td>
                                <td>
                                    <a href="{{ route('plans.show', $plan) }}" class="btn btn-sm btn-dark"><i
                                            class="fas fa-eye"></i> {{ __('View') }}</a>

                                    <form action="{{ route('plans.destroy', $plan->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}</button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="card-footer ">
                {{ $plans->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div> --}}
@endsection
