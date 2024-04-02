<section>
    <h2>
        <span class="text-vertical-middle material-symbol">gamepad</span>
        <span class="text-vertical-middle">{{ __('Planned Games') }}:</span>
    </h2>

    @php use App\Models\LocalGame; @endphp

    <div>
        @if(count($plannedGames) == 0)
            <p>{{ __('This user has no plans!') }}</p>
        @endif

        @foreach($plannedGames as $plannedGame)
            <x-game-prop-date :gameProp="$plannedGame"></x-game-prop-date>
        @endforeach
    </div>
</section>
