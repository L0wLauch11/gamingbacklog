<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalGame extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'igdb_id', 'slug', 'name', 'cover_id', 'release_date', 'description', 'developers', 'platforms', 'genres'
    ];
}
