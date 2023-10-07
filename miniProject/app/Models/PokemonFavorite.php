<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class PokemonFavorite extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'pokemonFavorites';
    protected $fillable = [
        'pokemonId',
        'createdAt'
    ];
    protected $dates = ['createdAt'];

    public function pokemon()
    {
        return $this->belongsTo(\App\Models\Pokemon::class, 'pokemonId', 'id');
    }
}
