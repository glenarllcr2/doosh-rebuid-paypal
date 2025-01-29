@extends('layouts.app')

@section('content')
<div class="container">
    
    {{-- <h1>Options for: {{ $question->question }}</h1> --}}
    
    <!-- استفاده از کامپوننت جدول -->
    <x-PaDataTable
        :records="$questions"
        :columns="$columns"
        :sortable-columns="$sortableColumns"
        {{-- :questionKey="$questionKey" --}}
        :sort-column="request('sortColumn', 'id')"
        :sort-direction="request('sortDirection', 'asc')"
        :route="route('question-options.index')"
    />
</div>
@endsection
