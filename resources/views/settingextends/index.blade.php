@extends('layouts.app')

@section('content')
    {{-- <h1>Options for: {{ $question->question }}</h1> --}}
    <x-PaDataTable
        :records="$records"
        :columns="$columns"
        :sortable-columns="$sortableColumns"
        :sort-column="request('sortColumn', 'id')"
        :sort-direction="request('sortDirection', 'asc')"
        route="settings"
        create-route="settingextends.create"
        :actions="['edit']"
    />

@endsection
