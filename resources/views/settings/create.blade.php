@extends('layouts.app')

@section('content')
<div class="card">
    <x-pa-data-form 
    :fields="[
        ['name' => 'key', 'type' => 'text', 'label' => 'Key'],
        ['name' => 'value', 'type' => 'text', 'label' => 'Value'],
    ]"
    mode="create"
    :submitRoute="['create' => 'settings.store']"
/>
</div>
@endsection