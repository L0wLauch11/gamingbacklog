@extends('welcome')

@section('content')
    @yield('title')
    <div class="container logon-container">
        {{ $slot }}
    </div>

    <div class="spacer-small"></div>
@endsection