@extends('welcome')

@section('content')
    <div class="spacer-small"></div>
    <div class="container container-nav-reactive">
        <x-searchbar
            placeholder="Search Users"
            searchRoute="profile.search_results"
            icon="data_loss_prevention"
        ></x-searchbar>
    </div>
@endsection
