<section>
    <header>
        <h2>{{ __('Userpage') }}</h2>
        <p>{{ __('Edit your publicly available userpage information') }}</p>
    </header>

    <form action="{{ route('userpage.upload_profile_picture') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('post')

        <label class="logon-text-label text-label" for="image">{{ __('Profile Picture') }}</label><br>
        <input type="file" name="image" class='button'>
        <button type="submit" class='button logon-button'>{{ __('Upload') }}</button><br><br>
    </form>

    <br>

    <form method="post" action="{{ route('userpage.update') }}">
        @csrf
        @method('patch')
        
        <label class="logon-text-label text-label" for="about">{{ __('About me') }}</label>
        @if(isset($userpage->about_me))
            <textarea class="textarea-box" type="text" id="about" name="about" placeholder="About Me">{{ $userpage->about_me }}</textarea>
        @else
            <textarea class="textarea-box" type="text" id="about" name="about" placeholder="Tell us something about you!"></textarea>
        @endif
        <button type="submit" class='button logon-button'>{{ __('Save') }}</button>
    </form>

    @if(session()->has('success'))
        <p>{{ session('success') }}</p>
    @endif

    @include('components.show-errors')
</section>
<br>