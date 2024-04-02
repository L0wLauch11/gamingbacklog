@extends('welcome')

@php
    use MarcReichel\IGDBLaravel\Enums\Image\Size;
@endphp

@section('content')
    <h1>{{ __('Search Results') }} ({{ count($results) }})</h1>

    <div class="container">
        <x-searchbar searchRoute="game.search_results" icon="stadia_controller">
            {{ $query }}
        </x-searchbar>

        <hr>

        @if(count($results) > 0)
            @foreach ($results as $result)
                <a href="{{ route($gameRoute, ['id' => $result->id]) }}">
                    <div class="subcontainer game-info-container">
                        <table class="game-info-table">
                            <tr>
                                @if($result->cover_id != null)
                                    <td class="game-cover">
                                        <x-game-cover-small>{{ $result->cover_id }}</x-game-cover-small>
                                    </td>
                                @endif

                                <td class="game-info game-info-search">
                                    <div class="game-info-title">{!! $result->name !!}</div>
                                    @if (isset($result->description))
                                        @php
                                            $description = $result->description;

                                            if (strlen($description) >= 256) {
                                                $description = substr($description, 0, 256).'...';
                                            }
                                        @endphp
                                        <p class="game-description">{!! $description !!}</p>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </a>
            @endforeach
        @else
            <h3>{{ __('No results found. Try a different search.') }}</h3>
        @endif
    </div>

    <div class="spacer-small"></div>
@endsection
