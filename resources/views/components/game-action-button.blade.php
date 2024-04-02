@props(['action', 'icon', 'id', 'formClass'])

<form class="{{ $formClass ?? 'game-action' }}" method="post" action="{{ route('game.action', ['gameId' => $id, 'action' => $action]) }}">
    @csrf
    @method('patch')

    <button type="submit" {{ $attributes->merge(['class' => 'button button-small']) }}>
        {!! $icon !!}
        <span class="text-vertical-middle">{{ $slot }}</span>
    </button>
</form>