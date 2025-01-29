<div class="mb-3 d-flex justify-content-between align-items-center">
    <div>
        @if ($createRoute)
            <a href="{{ route($createRoute) }}" class="btn btn-success">
                <i class="bi bi-plus-lg"></i> Create
            </a>
        @endif

        @if ($exportRoute)
            <a href="{{ route($exportRoute) }}" class="btn btn-primary">
                <i class="bi bi-file-earmark-arrow-up"></i> Export
            </a>
        @endif

        @if ($importRoute)
            <a href="{{ route($importRoute) }}" class="btn btn-secondary">
                <i class="bi bi-file-earmark-arrow-down"></i> Import
            </a>
        @endif
    </div>

    <div>
        <form action="{{ route($route . '.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control" placeholder="Search..."
                value="{{ request('search') }}">
            <button type="submit" class="btn btn-info ms-2">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                @foreach ($columns as $column => $label)
                    @php
                        if (is_array($label)) {
                            $label = $label['label'] ?? $column;
                        }
                    @endphp
                    <th class="text-center align-middle">
                        <a href="{{ route(
                            $route . '.index',
                            array_merge(request()->except('page'), [
                                'sortColumn' => $column,
                                'sortDirection' => $sortColumn === $column && $sortDirection === 'asc' ? 'desc' : 'asc',
                            ]),
                        ) }}"
                            class="text-decoration-none text-light d-flex align-items-center justify-content-center">

                            {{ $label }}
                            @if ($sortColumn === $column)
                                @if ($sortDirection === 'asc')
                                    <i class="bi bi-arrow-up ms-1"></i>
                                @else
                                    <i class="bi bi-arrow-down ms-1"></i>
                                @endif
                            @endif
                        </a>
                    </th>
                @endforeach
                <!-- ستون actions -->
                <th class="text-center align-middle">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $record)
                <tr>
                    @foreach ($columns as $column => $settings)
                        @php
                            $type = $settings['type'] ?? 'text';
                            $value = $record[$column];
                        @endphp
                        <td class="align-middle text-center">
                            @switch($type)
                                @case('text')
                                    {{ $value }}
                                @break

                                @case('boolean')
                                    <span class="badge {{ $value ? 'bg-success' : 'bg-danger' }}">
                                        {{ $value ? 'Yes' : 'No' }}
                                    </span>
                                @break

                                @case('date')
                                    {{ \Carbon\Carbon::parse($value)->format('Y-m-d') }}
                                @break
                                @case('wysiwyg')
                                    wysiwyg
                                @break
                                @default
                                    {{ $record[$column] }}
                            @endswitch

                        </td>
                    @endforeach
                    <!-- ستون actions -->
                    <td class="align-middle text-center">
                        {{-- @dd($actions) --}}
                        @foreach ($actions as $action)
                            @if (is_array($action))
                                <!-- بررسی اگر اکشن سفارشی باشد -->
                                <a href="{{ route($action['route'], $record->id) }}"
                                    class="btn btn-sm btn-{{ $action['class'] }}">
                                    <i class="bi {{ $action['icon'] }}"></i> {{ $action['title'] }}
                                </a>
                            @else
                                @switch($action)
                                    @case('view')
                                        <a href="{{ route($route . '.show', $record->id) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    @break

                                    @case('edit')
                                        <a href="{{ route($route . '.edit', $record->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                    @break
                                @endswitch
                            @endif
                        @endforeach
                        {{-- <a href="{{ route($route.'.show', ['id' => $record->id]) }}" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> View
                        </a> --}}


                        {{-- <a href="{{ route('question-options.edit', $record->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('question-options.destroy', $record->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form> --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>



    <div class="pagination">
        {{ $records->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
    </div>
</div>
