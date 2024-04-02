@foreach ($games as $game)
{{ $game->id }},{{ $game->slug }},"{{ $game->name }}"
@endforeach