@section('title')
    <h1>{{ Auth::user()->name }}</h1>
@endsection

<x-guest-layout>
    <p>{{ __("You're logged in!") }}</p>
</x-guest-layout>
