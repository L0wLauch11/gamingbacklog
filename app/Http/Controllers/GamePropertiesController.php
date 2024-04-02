<?php

namespace App\Http\Controllers;

use App\Models\LocalGame;
use Illuminate\Foundation\Auth\User;

class GamePropertiesController extends Controller
{
    public static function getUserGamesFromProperty(User $user, string $property) {
        $gamesWithProperty = $user->gameProperties()->where($property, true)->get();

        $localGames = array();
        foreach ($gamesWithProperty as $foundGame) {
            array_push($localGames, LocalGame::where('id', $foundGame->game_id)->first());
        }

        return $localGames;
    }

    public static function getUserProperty(User $user, int $gameId, string $property) {
        $gameProperty = $user->gameProperties()->where('game_id', $gameId)->first();
        if (!isset($gameProperty)) {
            return false;
        }
        return $user->gameProperties()->where('game_id', $gameId)->first()->$property;
    }
}
