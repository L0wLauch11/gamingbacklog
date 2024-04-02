@extends('welcome')

@php
    // Sometimes a 'is not possible to declare again' for prettyListing throws
    // if there's another error in the file for some reason... remember
    use App\Http\Controllers\GamePropertiesController;

    function prettyListing(string $seperator, string $string) {
        $pretty = '';

        $split = explode($seperator, $string);
        $i = 0;
        foreach ($split as $entry) {
            $pretty .= $entry;

            // -2 because developers have a trailing '#', thus inflating array size
            if ($i < count($split) - 2) {
                $pretty .= ', ';
            }

            $i++;
        }
        return $pretty;
    }
@endphp

@section('head')
    <script src="{{ asset('js/element-visibility.js') }}"></script>
@endsection

@section('content')
    <div class="spacer-small"></div>
    <div class="container-nav-reactive container game-show-container">
        <table class="game-info-table">
            <tr>
                @if($game->cover_id != null)
                    <td class="game-cover">
                        @auth
                            @php
                                // Either add or remove
                                $favouriteIcon = "<span class='material-symbol'>heart_plus</span>";
                                $favouriteClass = "button-favourite";
                                if (GamePropertiesController::getUserProperty(Auth::user(), $game->id, 'favourite')) {
                                    $favouriteIcon = "<span class='material-symbol'>heart_minus</span>";
                                    $favouriteClass = "button-favourite button-danger";
                                }
                            @endphp

                            <x-game-action-button
                                :icon="$favouriteIcon"
                                action="favourite"
                                :id="$id"
                                :class="$favouriteClass"
                                formClass="fixed"
                            ></x-game-action-button>
                        @endauth
                        <x-game-cover>{{ $game->cover_id }}</x-game-cover>
                    </td>
                @endif

                <td class="right-seperator"></td>

                <td class="game-info">
                    {{-- If I ever allow adding games yourself to the DB I should check name and description beforehand --}}
                    {{-- Because I require unsanitized output here; some of the games got scraped weirdly --}}
                    <p class="game-title">{!! $game->name !!}</p>
                    <p class="game-summary">{!! $game->description !!}</p>

                    <p class="subcontainer game-key-data">
                        <b>{{ __('Release Date') }}</b>:
                        {{ $game->release_date }}
                        <br>

                        <b>{{ __('Developers') }}</b>:
                        {{ prettyListing('#', $game->developers) }}
                        <br>

                        <b>{{ __('Genres') }}</b>:
                        {{ prettyListing('#', $game->genres) }}
                        <br>

                        <b>{{ __('Platforms') }}</b>:
                        {{ prettyListing('#', $game->platforms) }}
                    </p>

                </td>
            </tr>
        </table> <!-- End Game Table -->

        @auth
            <section>
                <h2>
                    <span class="text-vertical-middle material-symbol">keyboard_double_arrow_right</span>
                    <span>{{ __('Actions') }}</span>
                </h2>

                {{-- game-played-this-container is a bit further down --}}
                <button onclick="toggleElementVisibility('game-played-this-container', 'block')" class='button button-small game-played-this'>
                    <span style="display: inline-block; font-size: 20px; vertical-align: middle; margin-bottom: 4px;">&#9786;</span>
                    <span class="text-vertical-middle">{{ __('I PLAYED this game!') }}</span>
                </button>

                <x-game-action-button
                    icon='<span style="font-size: 25px;" class="material-symbol text-vertical-middle">list_alt</span>'
                    action='backlog'
                    :id="$id"
                    class="game-on-backlog"
                >
                    {{ __('I WANT to play this!') }}
                </x-game-action-button>

                <x-game-action-button
                    icon='
                    <span style="display: inline-block; font-size: 20px; vertical-align: middle; margin-bottom: 4px;">
                        <span style="font-size: 14px; padding-left: 4px;">☹</span>
                    </span>'
                    action='dropped'
                    :id="$id"
                    class="game-dropped"
                >
                    {{ __('I DROPPED this game!') }}
                </x-game-action-button>

                {{-- Shown by button press --}}
                <div class="subcontainer fit-content" id="game-played-this-container" style="display: none;">
                    <form method="POST" action="{{ route('game.action', ['gameId' => $id, 'action' => 'game_played_this']) }}">
                        @csrf
                        @method('patch')

                        <label class="text-label inline-block" for="playtime">{{ __('Playtime') }}: </label>
                        <input
                            style="text-align: center; width: 48px;"
                            class="text-field text-field-small inline-block"
                            type="text" name="playtime" id="playtime"
                        >&nbsp;{{ __('Hours') }}
                        <br>
                        <label class="text-label inline-block" for="playtime">{{ __('My Rating') }}: </label>
                        <input
                            style="text-align: center; width: 24px;"
                            class="text-field text-field-small inline-block"
                            type="text" name="rating" id="rating"
                        >&nbsp;&nbsp;/&nbsp;10
                        <br><div style="margin: 4px;"></div>
                        <button type="submit" class="button">
                            &#10003; {{ __('Confirm') }}
                        </button>
                        <div style="margin: 4px;"></div>
                    </form>
                </div>
            </section>
        @endauth
        @guest
            <br>
            <div class="subcontainer">
                <span>{{ __('Log in for more actions!') }}</span>
            </div>
        @endguest

        @if(session()->has('success'))
            <br>
            <div class="subcontainer" style="outline-color: var(--color-accent)">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <x-show-errors></x-show-errors>

        @include('game.partials.igdb_credits')
    </div>
@endsection
