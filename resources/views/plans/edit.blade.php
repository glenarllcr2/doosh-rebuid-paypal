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
        <x-PaDataForm :fields="$fields" :data="$record" mode="update" :submitRoute="['update' => 'plans.update']" />
    </div>
@endsection
