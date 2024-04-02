<?php

namespace App\Http\Controllers;

use MarcReichel\IGDBLaravel\Models\Game;
use MarcReichel\IGDBLaravel\Models\Genre;
use MarcReichel\IGDBLaravel\Models\InvolvedCompany;
use MarcReichel\IGDBLaravel\Models\Company;
use MarcReichel\IGDBLaravel\Models\Platform;

use App\Enums\GameStatus;
use App\Models\LocalGame;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public static function getGameByIGDBId(int $gameId) {
        $selectedAttributes = [
            'id', 'slug',
            'name', 'cover', 'first_release_date',
            'summary', 'involved_companies', 'platforms',
            'genres'
        ];

        // Check if game exists locally; if not add it to local_games and return it
        $localGame = LocalGame::where('igdb_id', $gameId)->first();
        if (!isset($localGame)) {
            $game = Game::where('id', $gameId)->select($selectedAttributes)->with(['cover'])->first();

            $developers = '';
            foreach ($game->involved_companies as $companyId) {
                $companyName = Company::where(
                    'id',
                    InvolvedCompany::where('id', $companyId)->first()->company
                )->first()->name;

                $developers .= $companyName . '#'; // # is the seperator
            }

            $platforms = '';
            foreach ($game->platforms as $platformId) {
                $platformName = Platform::where('id', $platformId)->first()->name;
                $platforms .= $platformName . '#';
            }

            $genres = '';
            foreach ($game->genres as $genreId) {
                $genreName = Genre::where('id', $genreId)->first()->name;
                $genres .= $genreName . '#';
            }

            // Cover is fine if null; all others not
            $cover = '';
            if (isset($game->cover)) {
                $cover = $game->cover->image_id;
            }

            $newLocalGame = [
                'igdb_id' => $gameId,
                'slug' => $game->slug,
                'name' => $game->name,
                'cover_id' => $cover,
                'release_date' => date('M j, Y', strtotime($game->first_release_date)),
                'description' => $game->summary,
                'developers' => $developers,
                'platforms' => $platforms,
                'genres' => $genres
            ];

            $localGame = LocalGame::create($newLocalGame);
        }

        return $localGame;
    }

    public function index(): View
    {
        return view('game.index');
    }

    public function showByIGDB(int $id) {
        $localGame = self::getGameByIGDBId($id); // Creates the local game if it didn't exist before
        return redirect(route('game.show', ['id' => $localGame->id]));
    }

    public function show(int $id): View
    {
        $game = LocalGame::where('id', $id)->first();
        return view('game.show', ['id' => $id, 'game' => $game]);
    }

    public function search(Request $request) {
        $request->validate([
            'query' => 'required|max:255'
        ]);

        $searchQuery = $request->input('query');

        $selectedAttributes = ['id', 'name', 'description', 'cover_id'];

        $results = LocalGame::where('name', 'LIKE', "%$searchQuery%")->select($selectedAttributes)->get()->reverse();
        $gameRoute = 'game.show';

        if (count($results) == 0) {
            // Couldn't find the game on local database; search for it online
            $resultsRaw = self::igdbSearch($searchQuery);
            $results = array(); // Need to be adjusted to the same format as LocalGame (cover => cover_id, summary => description)
            foreach ($resultsRaw as $result) {
                $resultConverted = (object) [
                    'id' => $result->id,
                    'cover_id' => isset($result->cover) ? $result->cover->image_id : '',
                    'description' => $result->summary,
                    'name' => $result->name,
                ];

                array_push($results, $resultConverted);
            }

            $gameRoute = 'game.show_by_igdb';
        }

        return view('game.search_results', ['query' => $searchQuery, 'results' => $results, 'gameRoute' => $gameRoute]);
    }

    public function igdbSearch(string $searchQuery)
    {
        $searchIn = ['name'];
        $selectedAttributes = ['name', 'summary'];

        // More accurate results
        $accurateResults = Game::search($searchQuery)
        ->take(25)
        ->orderBy('rating_count', 'desc')
        ->select($selectedAttributes)
        ->with(['cover'])->get();

        // Fuzzy results come later
        $fuzzyResults = Game::fuzzySearch(
            $searchIn,
            $searchQuery,
            false,
        )->take(25)
        ->where('summary', '!=', null)
        ->where('platforms', '!=', null)
        ->where('genres', '!=', null)
        ->where('involved_companies', '!=', null)
        ->where('first_release_date', '!=', null)
        ->orderBy('rating_count', 'desc')
        ->select($selectedAttributes)
        ->with(['cover'])->get();

        $results = $accurateResults->merge($fuzzyResults)->unique('id');

        return $results;
    }

    public function action(Request $request, int $gameId, string $action) {
        $user = Auth::user();

        switch ($action) {
            case 'favourite':
                $gameProperties = $user->gameProperties()->where('game_id', $gameId)->first();

                // Favourite property should be toggled
                if (isset($gameProperties)) {
                    $isFavourite = $gameProperties->favourite;
                }

                $setFavourite = true;
                if (isset($isFavourite)) {
                    $setFavourite = !$isFavourite;
                }

                $successMessage = 'Game removed from favourites!';
                if ($setFavourite) {
                    $successMessage = 'Game added to favourites!';
                }

                $user->gameProperties()->updateOrCreate(
                    ['game_id' => $gameId],
                    [
                        'favourite' => $setFavourite,
                    ]
                );

                return redirect(route('game.show', ['id' => $gameId]))->with('success', $successMessage);

            case 'backlog':
                $user->gameProperties()->updateOrCreate(
                    ['game_id' => $gameId],
                    [
                        'status' => GameStatus::PLANNED
                    ]
                );

                return redirect(route('game.show', ['id' => $gameId]))->with('success', 'You want to play this game!');

            case 'dropped':
                $user->gameProperties()->updateOrCreate(
                    ['game_id' => $gameId],
                    [
                        'status' => GameStatus::DROPPED
                    ]
                );

                return redirect(route('game.show', ['id' => $gameId]))->with('success', 'You dropped play this game!');

            case 'game_played_this':
                $request->validate([
                    'playtime' => 'required|numeric',
                    'rating' => 'required|numeric|max:10|min:1'
                ]);

                $user->gameProperties()->updateOrCreate(
                    ['game_id' => $gameId],
                    [
                        'status' => GameStatus::FINISHED,
                        'playtime' => $request->playtime,
                        'given_score' => $request->rating,
                    ]
                );

                return redirect(route('game.show', ['id' => $gameId]))->with('success', 'Game is now logged!');
        }
    }

    public function dumpdata(int $gameId) {
        // Mostly for debug purposes
        $game = Game::where('id', $gameId)->with(['cover'])->first();
        return view(dd($game));
    }

    public function slugs() {
        // Lists all games and their slugs; mostly for debug purposes
        ini_set('max_execution_time', 1200);

        $amount = 500;
        $maxRequestsPerSecond = 4;
        $finalGames = array();

        $games = ['placeholder'];
        $i = 0;
        while (count($games) != 0) {
            $i += $amount;
            $games = Game::select(['id', 'slug', 'name', 'first_release_date'])
                ->where('summary', '!=', '')
                ->where('rating_count', '>', 0)
                ->limit($amount)
                ->offset($i)
                ->get();

            foreach ($games as $game) {
                // Games older than 1980 will be ignored
                $releaseYear = explode('-', $game->first_release_date)[0];
                if ((int) $releaseYear < 1980) {
                    continue;
                }

                array_push($finalGames, $game);
            }

            sleep(1 / $maxRequestsPerSecond + 0.01);
        }

        return view('game.show_slugs', ['games' => $finalGames]);
    }
}
