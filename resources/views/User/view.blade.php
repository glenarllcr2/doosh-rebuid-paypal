@extends('layouts.app')

@php
    $page_header = 'Profile';
@endphp

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card card-primary card-outline mb-3">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid"
                            src="{{ asset('storage/' . $user->profileImage) }}" alt="{{ $user->display_name }}">
                    </div>
                    <h3 class="profile-username text-center">{{ $user->display_name }}</h3>

                    <p class="text-muted text-center">{{ $user->age }} years old</p>
                </div>
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Photo Album</h3>
                </div>
                <div class="card-body">
                    @if($user->medias->count() > 0)
                        <div class="row">
                            @foreach($user->medias as $media)
                                @if($media->pivot->is_approved) <!-- فقط رسانه‌های تایید شده -->
                                    <div class="col-md-3 mb-3">
                                        <img src="{{ asset('storage/' . $media->url) }}" alt="Photo" class="img-fluid rounded">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p>{{ __('No photos available.') }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-9">
            @php
                $userAnswers = $user->userAnswersWithQuestions();
            @endphp
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">About Me</h3>
                </div>
                <div class="card-body">
                    <strong>Job</strong>
                    <p class="text-muted"> {{ $userAnswers['industry'] }} </p>
                    <hr/>
                    <strong>Location</strong>
                    <p class="text-muted"> {{ $userAnswers['country_live'] }} </p>
                    <hr/>
                    <strong>Denomination</strong>
                    <p class="text-muted"> {{ $userAnswers['church'] }} </p>
                    <hr/>
                    <strong>Church Attendance</strong>
                    <p class="text-muted"> {{ $userAnswers['attend_church'] }} </p>
                    <hr/>
                    <strong>Divorced</strong>
                    <p class="text-muted"> {{ $userAnswers['married'] }} </p>
                    <hr/>
                    <strong>Kid(s)</strong>
                    <p class="text-muted"> {{ $userAnswers['kids'] }} </p>
                    <hr/>
                    <strong>Place of Birth</strong>
                    <p class="text-muted"> {{ $userAnswers['country_born'] }} </p>
                    <hr/>
                    <strong>Father's Full Name</strong>
                    <p class="text-muted"> {{ $userAnswers['father_name'] }} </p>
                    <hr/>
                    <strong>Mother's Full Name</strong>
                    <p class="text-muted"> {{ $userAnswers['mother_name'] }} </p>
                    <hr/>
                    <strong>Education Level</strong>
                    <p class="text-muted"> {{ $userAnswers['education'] }} </p>
                    <hr/>
                    <strong>Number of Sibling(s)</strong>
                    <p class="text-muted"> {{ $userAnswers['siblings'] }} </p>
                    <hr/>
                    <strong>Athlete</strong>
                    <p class="text-muted"> {{ $userAnswers['sports_play'] }} </p>
                    <hr/>
                    <strong>Interested in Sport</strong>
                    <p class="text-muted"> {{ $userAnswers['sports_watch'] }} </p>
                    <hr/>
                    <strong>My Favorite movie genre(s)</strong>
                    <p class="text-muted"> {{ $userAnswers['favorite_movie'] }} </p>
                    <hr/>
                    <strong>My Favorite New Media(s)</strong>
                    <p class="text-muted"> {{ $userAnswers['news_media'] }} </p>
                    <hr/>
                    <strong>My Ideal country to live/raise a family</strong>
                    <p class="text-muted"> {{ $userAnswers['ideal_family_place'] }} </p>
                    <hr/>
                    <strong>Interested in taking vacation(s)</strong>
                    <p class="text-muted"> {{ $userAnswers['vacation'] }} </p>
                    <hr/>
                    <strong>Cooking</strong>
                    <p class="text-muted"> {{ $userAnswers['cook'] }} </p>
                    <hr/>
                    <strong>Speaking Assyrian</strong>
                    <p class="text-muted"> {{ $userAnswers['assyrian_speak'] }} </p>
                    <hr/>
                    <strong>Social media</strong>
                    <p class="text-muted"> {{ $userAnswers['social_media'] }} </p>
                    <hr/>
                    <strong>Ability to read/write Assyrian language</strong>
                    <p class="text-muted"> {{ $userAnswers['assyrian_read_write'] }} </p>
                    <hr/>
                    <strong>Playing Music Instrument</strong>
                    <p class="text-muted"> {{ $userAnswers['music'] }} </p>
                    <hr/>
                    <strong>My Favorite Assyrian singer(s)</strong>
                    <p class="text-muted"> {{ $userAnswers['assyrian_singer'] }} </p>
                    <hr/>
                    <strong>My Favorite Assyrian Food</strong>
                    <p class="text-muted"> {{ $userAnswers['assyrian_food'] }} </p>
                    <hr/>
                    <strong>Holidays Celebrate</strong>
                    <p class="text-muted"> {{ $userAnswers['holidays'] }} </p>
                    <hr/>
                    <strong>Interested in Assyrian Heritage</strong>
                    <p class="text-muted"> {{ $userAnswers['heritage'] }} </p>
                    <hr/>
                    <strong>It is important to speak Assyrian in my household</strong>
                    <p class="text-muted"> {{ $userAnswers['family_speak'] }} </p>
                    <hr/>
                    <strong>Art Fan</strong>
                    <p class="text-muted"> {{ $userAnswers['art'] }} </p>
                    <hr/>
                    <strong>Height</strong>
                    <p class="text-muted"> {{ $userAnswers['height'] }} ft </p>
                    <hr/>
                    <strong>Comfortable to move to a different city/country</strong>
                    <p class="text-muted"> {{ $userAnswers['relocation'] }} </p>
                    <hr/>
                    <strong>Living with my parents</strong>
                    <p class="text-muted"> {{ $userAnswers['live_with_parents'] }} </p>
                    <hr/>
                    <strong>Parents still alive</strong>
                    <p class="text-muted"> {{ $userAnswers['parents_alive'] }} </p>
                    <hr/>
                </div>
            </div>

            <!-- بخش آلبوم عکس -->
            

        </div>
    </div>
@endsection
