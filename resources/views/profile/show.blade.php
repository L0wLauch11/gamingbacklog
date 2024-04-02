@extends('welcome')

@section('content')
    <div class="container-nav-reactive userpage-master-container">
        <!-- User metadata -->
        <div class="profile-sidepanel side-container container">

            @if($user->image)
                <img class="profile-picture" src="{{ asset('/storage/images/' . $user->image) }}" alt="Profile Picture">
            @endif
            <p>
                <span class="text-vertical-middle material-symbol">person</span>
                <span class="text-vertical-middle">{{ $user->name }}</span>
            </p>

            <div class="subcontainer">
                    <p>
                        <span>&#9977; <b>{{ __('About Me') }}</b>:</span>
                        <br>

                        @if(isset($userpage->about_me))
                            <span class="profile-about-me">{{ $userpage->about_me }}</span>
                        @else
                            <span class="profile-about-me">{{ __('There is nothing interesting about this user.') }}</span>
                        @endif
                    </p>
            </div>

            <br>

            @auth
                @if($user->id == Auth::user()->id)
                    <a class="button" href="{{ route('profile.edit') }}">&#9998;{{__(' Edit')}}</a>
                @endif
            @endauth

            <div class="spacer-small"></div>
        </div>

        <!-- Main section -->
        <div class="profile-main-section side-container container">
            @include('profile.partials.games.favourite')
            @include('profile.partials.games.recently-added')
            @include('profile.partials.games.played')
            @include('profile.partials.games.planned')
        </div>
    </div>
@endsection
