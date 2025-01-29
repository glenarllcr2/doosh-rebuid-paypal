@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('messages.partials.navigator', ['isCompose' => true])
        </div>
        <div class="col-md-9">
            <!-- Alert Messages -->
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

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Compose New Message</h3>
                </div>

                <form method="POST" action="{{ route('internal-messages.save-draft') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group mb-3">
                            @isset($receiver_user)
                                {{-- @dd($receiver_user) --}}
                            @endisset ($receiver_user)
                                
                            
                            <label for="receiver_id" class="form-label">To:</label>
                            <x-choices-dropdown id="receiver_id" name="receiver_id" searchUrl="{{ route('api.search-user') }}"
                                fieldName="display_name" placeholder="Type a name..." 
                                :receiverUser="$receiver_user ?? null"
                                />
                            @error('receiver_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <x-QuillEditor theme="snow" id="message" name="message" style="height: 300px;"
                                placeholder="Start writing here..." modules="[]" />
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                
                    <div class="card-footer">
                        <div class="float-end">
                            <button type="submit" class="btn btn-dark"><i class="fas fa-pencil-alt"></i> Draft</button>
                            <button type="submit" formaction="{{ route('internal-messages.send') }}" class="btn btn-dark">
                                <i class="far fa-envelope"></i> Send
                            </button>
                        </div>
                        <button type="reset" class="btn btn-dark"><i class="fas fa-times"></i> Discard</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
