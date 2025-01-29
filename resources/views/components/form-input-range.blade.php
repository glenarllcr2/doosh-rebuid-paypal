<x-base-form-input 
    {{-- :qid="$qid" --}}
    :id="$id"
    :name="$name"
    :label="$label"
    :required="$required"
    :class="$class"
    :style="$style"
    :floating="$floating"
>
    <input 
        type="range" 
        id="{{ $id }}" 
        name="{{ $name }}" 
        class="form-range {{ $class }}" 
        min="{{ $min }}" 
        max="{{ $max }}" 
        step="{{ $step }}" 
        value="{{ old($name, $value) }}" 
        @if ($required) required @endif
    >

    <!-- نمایش مقدار انتخاب‌شده -->
    <div class="mt-2">
        Selected Value: <span id="{{ $id }}-value">{{ old($name, $value) }}</span>
    </div>
</x-base-form-input>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('{{ $id }}');
        const display = document.getElementById('{{ $id }}-value');
        if (input && display) {
            input.addEventListener('input', function() {
                display.textContent = this.value;
            });
        }
    });
</script>
@endpush
