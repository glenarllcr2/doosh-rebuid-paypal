<div class="mb-3 {{ $floating ? 'form-floating' : '' }}" style="{{ $style }}">
    {{ $slot }}

    @error($name)
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>
