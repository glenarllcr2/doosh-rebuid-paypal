@extends('layouts.app')

@section('content')

<div class="card">
    <x-PaDataForm 
    :fields="[
        ['name' => 'key', 'type' => 'text', 'label' => 'Key'],
        ['name' => 'value', 'type' => 'wysiwyg', 'label' => 'Value'],
    ]"
    :data="$setting"
    mode="update"
    :submitRoute="['update' => 'settingextends.update']"
/>
</div>
@endsection