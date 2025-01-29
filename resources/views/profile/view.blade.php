@extends('layouts.app')

@section('page-header')
    {{-- {{ __('messages.'.$page_title) }} --}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline mb-3">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img rounded-circle img-fluid" src="{{ asset($user->profile_photo_url) }}"
                                alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center">{{ $user->full_name }}</h3>
                        @isset($user->userQuestionsAndAnswers['industry'])
                            {{-- <p class="text-muted text-center">{{ $user->userQuestionsAndAnswers['industry'][0] }}</p> --}}
                            <p class="text-muted text-center">{{ $user->age }} years old</p>
                        @endisset
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">About Me</h3>
                    </div>

                    <div class="card-body">
                        @foreach ( $user->allUserAnswers as $key=>$answer)
                            <strong>{{ $key }}</strong>
                            <p class="text-muted"> {{ $answer }} </p>
                            <hr>
                        @endforeach
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@php
    // Function to convert questions to first-person
    function convertToFirstPerson($question)
    {
        // Change second-person pronouns to first-person
        $patterns = [
            '/your/i' => 'my',   // Replace "your" with "my"
            '/you are/i' => 'I am', // Replace "you are" with "I am"
            '/do you/i' => 'do I', // Replace "do you" with "do I"
            '/is your/i' => 'is my', // Replace "is your" with "is my"
            '/who is/i' => 'who am I', // Replace "who is" with "who am I"
        ];

        // Apply the changes based on patterns
        foreach ($patterns as $pattern => $replacement) {
            $question = preg_replace($pattern, $replacement, $question);
        }

        return $question;
    }
@endphp
