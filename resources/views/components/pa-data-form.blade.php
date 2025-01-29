<form
    action="{{ $mode === 'create'
        ? route($submitRoute['create'])
        : route($submitRoute['update'], [$data ? strtolower(class_basename($data)) : '' => $data->id ?? null]) }}"
    method="POST" class="card">

    @csrf
    @if ($mode === 'update')
        @method('PUT')
    @endif
    <div class="card-header">
        <h3>{{ Illuminate\Support\Str::ucfirst($mode) }} {{ class_basename($data) }}</h3>
    </div>
    <div class="card-body">
        @foreach ($fields as $field)
            <div class="row mb-3">
                <label for="{{ $field['name'] }}" class="col-sm-2 col-form-label">{{ $field['label'] }}</label>
                <div class="col-sm-10">
                    @switch($field['type'])
                        @case('text')
                            <input type="text" name="{{ $field['name'] }}" id="{{ $field['name'] }}" class="form-control"
                                value="{{ old($field['name'], $data->{$field['name']} ?? '') }}">
                        @break

                        @case('textarea')
                            <textarea name="{{ $field['name'] }}" id="{{ $field['name'] }}" class="form-control">{{ old($field['name'], $data->{$field['name']} ?? '') }}</textarea>
                        @break

                        @case('select')
                            <select name="{{ $field['name'] }}" id="{{ $field['name'] }}" class="form-control">
                                <option value="">Select {{ $field['label'] }}</option>
                                @foreach ($field['options'] as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old($field['name'], $data->{$field['name']} ?? '') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        @break

                        @case('checkbox')
                            <div class="form-check">
                                <input type="checkbox" name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                                    class="form-check-input"
                                    {{ old($field['name'], $data->{$field['name']} ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                            </div>
                        @break

                        @case('radio')
                            @foreach ($field['options'] as $value => $label)
                                <div class="form-check">
                                    <input type="radio" name="{{ $field['name'] }}"
                                        id="{{ $field['name'] }}_{{ $value }}" class="form-check-input"
                                        value="{{ $value }}"
                                        {{ old($field['name'], $data->{$field['name']} ?? '') == $value ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="{{ $field['name'] }}_{{ $value }}">{{ $label }}</label>
                                </div>
                            @endforeach
                        @break

                        @case('date')
                            <input type="date" name="{{ $field['name'] }}" id="{{ $field['name'] }}" class="form-control"
                                value="{{ old($field['name'], $data->{$field['name']} ?? '') }}">
                        @break

                        @case('boolean')
                            <div class="form-check form-switch">
                                <input type="hidden" name="{{ $field['name'] }}" value="0">
                                <input class="form-check-input" type="checkbox" name="{{ $field['name'] }}"
                                    id="{{ $field['name'] }}" value="1"
                                    {{ old($field['name'], $data->{$field['name']} ?? false) ? 'checked' : '' }}>
                                {{-- <label class="form-check-label" for="{{ $field['name'] }}">{{ $field['label'] }}</label> --}}
                            </div>
                        @break

                        @case('wysiwyg')
                            <x-QuillEditor theme="snow" id="{{ $field['id'] }}" name="{{ $field['name'] }}"
                                style="height: 300px;" placeholder="Start writing here..." modules="[]" />
                        @break

                        @default
                            <input type="text" name="{{ $field['name'] }}" id="{{ $field['name'] }}" class="form-control"
                                value="{{ old($field['name'], $data->{$field['name']} ?? '') }}">
                    @endswitch
                    @error($field['name'])
                        <div class="invalid-feedback">{{ $field['name'] }}</div>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                {{ $mode === 'create' ? 'Create' : 'Update' }}
            </button>
        </div>
    </div>
</form>
