@extends('layouts.app')

@section('content')

<div class="card">
    <x-PaDataForm 
    :fields="[
        ['name' => 'key', 'type' => 'text', 'label' => 'Key'],
        ['name' => 'value', 'type' => 'text', 'label' => 'Value'],
    ]"
    :data="$setting"
    mode="update"
    :submitRoute="['update' => 'settings.update']"
/>
</div>
@endsection