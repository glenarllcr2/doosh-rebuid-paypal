@extends('layouts.app')

@section('content')
    <div>
        <h2>Inbox</h2>
        <ul>
            @foreach ($messages as $message)
                <li>
                    <strong>Sender:</strong> {{ $message->sender->name }}
                    <p>{{ Str::limit($message->message, 100) }}</p>
                    <a href="{{ route('messages.view', $message->id) }}">View Message</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
