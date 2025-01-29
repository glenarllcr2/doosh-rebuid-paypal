@extends('layouts.app')

@section('content')
    <x-PaDataTable
        :records="$records"
        :columns="$columns"
        :sortable-columns="$sortableColumns"
        :sort-column="request('sortColumn', 'id')"
        :sort-direction="request('sortDirection', 'asc')"
        route="user-reports"
        {{-- create-route="user-reports.create" --}}
        :actions="[
        'view'
    ]"
    />

@endsection
