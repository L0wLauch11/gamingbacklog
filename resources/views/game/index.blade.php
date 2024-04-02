@extends('welcome')

@section('content')
    <div class="spacer-small"></div>
    <div class="container container-nav-reactive">
        <x-searchbar placeholder='Search Games' icon="stadia_controller" searchRoute="game.search_results"></x-searchbar>
    </div>
@endsection
