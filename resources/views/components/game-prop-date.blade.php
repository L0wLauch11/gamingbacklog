@props(['gameProp'])

@php
    use App\Models\LocalGame;
    $game = LocalGame::where('id', $gameProp->game_id)->first();
@endphp

<x-game-show-link class="subcontainer-inline" :game="$game">
    <span class="date">({{ explode(' ', $gameProp->created_at)[0] }})</span> {{-- Omit time --}}
</x-game-show-link>
<br>
