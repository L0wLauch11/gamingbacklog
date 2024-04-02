<?php
namespace App\Enums;

enum GameStatus: int {
    case NONE = 0;
    case PLANNED = 1;
    case PLAYING = 2;
    case FINISHED = 3;
    case DROPPED = 4;
    case PAUSED = 5;
}