<section>
    <h2>&hearts; {{ __('Favourites') }} ({{ count($favourites) }}):</h2>
    @if(count($favourites) > 0)
        @php
            $favouritesReversed = array_reverse($favourites) // Newest ones should come on top
        @endphp
        @foreach($favouritesReversed as $favourite)
            <a class="subcontainer-inline hover-outline-accent"
                href="{{ route('game.show', ['id' => $favourite->id]) }}">
                {{-- 2nd index is release year --}}
                <span>{{ $favourite->name }}
                    <span class="text-normal">({{ explode(' ', $favourite->release_date)[2] }})</span>
                </span>
            </a>
        @endforeach
    @else
        <p>{{ __('This user has no favourites!') }}</p>
    @endif
</section>
