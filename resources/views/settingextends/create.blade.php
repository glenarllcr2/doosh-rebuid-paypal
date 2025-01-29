@extends('layouts.app')

@section('content')
    {{-- نمایش پیام موفقیت --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- نمایش پیام‌های خطا --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card">
        <x-pa-data-form :fields="[
            ['name' => 'key', 'id' => 'key', 'type' => 'text', 'label' => 'Key'],
            ['name' => 'value', 'id' => 'value', 'type' => 'wysiwyg', 'label' => 'Value'],
        ]" mode="create" :submitRoute="['create' => 'settingextends.store']" />
    </div>
@endsection
