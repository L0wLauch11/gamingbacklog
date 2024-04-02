@props(['game', 'class'])

<a class="{{ $class ?? '' }}" href="{{ route('game.show', ['id' => $game->id]) }}">
    {{ $game->name }} <span class="text-normal">{{ $slot }}</span>
</a>
