<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameProperties extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'game_id', 'playtime', 
        'played_on_platform', 'given_score', 'favourite', 
        'started_playing_at', 'ended_playing_at',
        'status', 'recommends', 'score',
    ];
}
