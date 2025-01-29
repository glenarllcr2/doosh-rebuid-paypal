@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('question-options.update', $questionOption->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="option_value" class="form-label">Option Value</label>
                <input type="text" class="form-control @error('option_value') is-invalid @enderror" id="option_value"
                    name="option_value" value="{{ old('option_value', $questionOption->option_value) }}" required>
                @error('option_value')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('questions.show', $questionOption->question_id) }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
@endsection
