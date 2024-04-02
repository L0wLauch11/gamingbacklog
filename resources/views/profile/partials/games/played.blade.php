<section>
    @php use App\Models\LocalGame; @endphp

    <h2>
        <span class="text-vertical-middle material-symbol">gamepad</span>
        <span class="text-vertical-middle">{{ __('Played Games') }}:</span>
    </h2>

    @if(count($finishedGames) > 0)
        <table class="userpage-table">
            <tr>
                @php
                    $keysRelatedNames = [
                        'Cover', 'Game', 'Playtime', 'Score'
                    ];
                @endphp

                @foreach($keysRelatedNames as $key)
                    <th>{{ $key }}</th>
                @endforeach
            </tr>

            @foreach($finishedGames as $finishedGameProperty)
                <tr>
                    @foreach($keysRelatedNames as $key)
                        @php $game = LocalGame::where('id', $finishedGameProperty->game_id)->first(); @endphp

                        <td class="subcontainer @if($key == 'Cover') td-cover @endif">
                            @switch($key)
                                @case('Cover')
                                    <x-game-cover-small style="padding-top: 4px; width: 48px;">{{ $game->cover_id }}</x-game-cover-small>
                                    @break

                                @case('Game')
                                    <x-game-show-link :game="$game"></x-game-show-link>
                                    @break

                                @case('Playtime')
                                    <div class="center td-playtime">{{ $finishedGameProperty->playtime }}&nbsp;{{ __('Hours') }}</div>
                                    @break

                                @case('Score')
                                    @php
                                        $score = $finishedGameProperty->given_score;
                                        $color = $score <= 5 ? ($score <= 3 ? 'red' : 'orange') : 'lime';
                                    @endphp

                                    <div style="color: {{ $color }};" class="center td-given-score">&#9733;{{ $finishedGameProperty->given_score }}</div>
                                    @break
                            @endswitch
                        </td>

                    @endforeach
                </tr>
            @endforeach
        </table>
    @else
        <p>{{ __('This user has no played games!') }}</p>
    @endif
</section>
