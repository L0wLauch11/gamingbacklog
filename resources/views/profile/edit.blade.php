@section('title')
    <h1>{{ __('Edit your Profile') }}</h1>
@endsection

<x-guest-layout>
    @include('profile.partials.update-userpage')
    @include('profile.partials.update-profile-information-form')
    @include('profile.partials.update-password-form')
    @include('profile.partials.delete-user-form')
</x-guest-layout>
