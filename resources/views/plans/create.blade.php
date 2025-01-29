@extends('layouts.app')

@section('content')
<div class="card">
    <x-pa-data-form 
    :fields="$fields"
    mode="create"
    :submitRoute="['create' => 'plans.store']"
/>
</div>
@endsection 