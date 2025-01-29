@extends('layouts.app')

@section('content')
    <h1>{{ $question->question }}</h1>
    @if($question->answer_type =='single_select') 
        

    <x-PaDataTable
        :records="$question->options()->paginate(10)"
        :columns="['option_value' => 'Value']"
        :sortable-columns="['option_value']"
        :sort-column="request('sortColumn', 'id')"
        :sort-direction="request('sortDirection', 'asc')"
        route="question-options"
        
    />
    @endif
@endsection
