@extends('welcome')

@php
    use MarcReichel\IGDBLaravel\Enums\Image\Size;
@endphp

@section('content')
    <h1>{{ __('Search Results') }} ({{ count($results) }})</h1>

    <div class="container">
        <x-searchbar searchRoute="profile.search_results">
            {{ $query }}
        </x-searchbar>

        <hr>

        @if(count($results) > 0)
            @foreach ($results as $result)
                <a href="{{ route('profile.show', ['user' => $result]) }}">
                    <div class="subcontainer game-info-container">
                        @if($result->image)
                            <img class="profile-picture-small" src="{{ asset('/storage/images/' . $result->image) }}" alt="Profile Picture">
                        @endif
                        
                        {{ $result->name }}
                    </div>
                </a>
            @endforeach
        @else
            <h3>{{ __('No results found. Try a different search.') }}</h3>
        @endif
    </div>

    <div class="spacer-small"></div>
@endsection