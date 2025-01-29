@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('messages.partials.navigator')
        </div>
        <div class="col-md-9">
            <!-- نمایش پیام‌های فلش -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Reply to Message</h3>
                </div>
                <form action="{{ route('internal-messages.sendReply', ['messageId' => $message->id]) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="receiver">To:</label>
                            <input type="text" class="form-control" value="{{ $message->sender->display_name }}"
                                disabled>
                            <input type="hidden" name="receiver_id" value="{{ $message->sender->id }}">
                        </div>
                        <div class="form-group">
                            <label for="message">Your Reply:</label>
                            <x-QuillEditor theme="snow" id="message" name="message" style="height: 300px;"
                                placeholder="Start writing here..." modules="[]" />
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-reply"></i> Send Reply</button>
                        <a href="{{ url()->previous() }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
