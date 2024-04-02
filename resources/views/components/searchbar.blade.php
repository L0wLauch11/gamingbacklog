@props(['searchRoute', 'placeholder', 'icon'])

<div class="text-field">
    <table class="full">
        <tr>
            <th><div class="material-symbol" style="padding-left: 8px">{{ $icon ?? 'search' }}</div></th>
            <th>
                <form method="get" action="{{ route($searchRoute) }}">
                    <input value="{{ $slot }}" type="text" class="game-search-bar" name="query" id="query" placeholder="{{ $placeholder ?? '' }}">
                    <button type="submit" hidden>Confirm</button>
                </form>
            </th>
        </tr>
    </table>
</div>
