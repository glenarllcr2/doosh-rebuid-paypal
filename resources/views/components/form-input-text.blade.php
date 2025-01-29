{{-- form-input-text.blade.php --}}
<x-base-form-input 
    {{-- qid="{{ $qid }}" --}}
    :id="$id"
    :name="$name"
    :value="$value"
    :label="$label"
    :required="$required"
    :class="$class"
    :style="$style"
    :floating="$floating"
>
    <input type="text" 
           id="{{ $id }}" 
           name="{{ $name }}" 
           class="form-control {{ $class }}" 
           value="{{ old($name, $value) }}" 
           @if ($required) required @endif>
</x-base-form-input>
