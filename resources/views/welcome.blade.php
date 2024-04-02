<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gaming Backlog</title>

        <script src="{{ asset('js/modal.js') }}"></script>

        <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
        <link rel="stylesheet" href="{{ asset('css/material-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
        <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
        <link rel="stylesheet" href="{{ asset('css/userpage.css') }}">
        <link rel="stylesheet" href="{{ asset('css/games.css') }}">
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
        <link rel="stylesheet" href="{{ asset('css/util.css') }}">
        <link rel="stylesheet" href="{{ asset('css/screen-adjustments.css') }}">

        @yield('head') {{-- Any extra data supplied by the children --}}
    </head>
    <body>
        <div class="background"></div>

        <header>
            @include('navigation')
        </header>

        <main>
            @yield('content')
        </main>
    </body>
</html>
