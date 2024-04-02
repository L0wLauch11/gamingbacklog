<section>
    <h2>
        <span class="text-vertical-middle material-symbol">schedule</span>
        <span class="text-vertical-middle">{{ __('Recently added Games') }}:</span>
    </h2>

    @php use App\Models\LocalGame; @endphp

    <div>
        @if(count($recentGames) == 0)
            <p>{{ __('This user has no recent activity!') }}</p>
        @endif

        @foreach($recentGames as $recentGame)
            <x-game-prop-date :gameProp="$recentGame"></x-game-prop-date>
        @endforeach
    </div>
</section>
