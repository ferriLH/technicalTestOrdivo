<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use App\Interfaces\PokemonFavoriteRepositoryInterface;
use App\Models\PokemonFavorite;
use Carbon\Carbon;

class PokemonFavoritesRepository implements PokemonFavoriteRepositoryInterface
{
    private $pokeApi;
    private $apiVersion;

    public function __construct()
    {
        $this->apiVersion = 'v2';
        $this->pokeApi = config('app.pokeApi').'/'.$this->apiVersion;
    }

    public function getAllFavorites($condition = [], $filter = [])
    {
        $data = PokemonFavorite::with('pokemon')
                        ->where($condition);

        if(isset($filter['abilities']) && count($filter['abilities']) > 0)
        {
            $data = $data->whereHas('pokemon', function($q) use ($filter) {
                foreach ($filter['abilities'] as $i => $ability) {
                    if($i == 0)
                    {
                        $q = $q->where('abilities.ability.name', $ability);
                    }else{
                        $q = $q->orWhere('abilities.ability.name', $ability);
                    }
                }

                return $q;
            });
        }

        $data = $data->paginate(10);
        return $data;
    }

    public function getAbilities()
    {
        return PokemonFavorite::with('pokemon')->get()->pluck('pokemon');
    }

    public function getFavoriteById($id)
    {
        return PokemonFavorite::where('pokemonId', $id)->first();
    }

    public function createFavorite($favorite)
    {
        $favorite['createdAt'] = new \MongoDB\BSON\UTCDateTime(Carbon::now());

        return PokemonFavorite::insert($favorite);
    }

    public function deleteFavorite($pokemonId)
    {
        return PokemonFavorite::where('pokemon_id', $pokemonId)->delete();
    }
}
