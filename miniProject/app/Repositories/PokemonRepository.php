<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use App\Interfaces\PokemonRepositoryInterface;
use App\Models\Pokemon;

class PokemonRepository implements PokemonRepositoryInterface
{
    private $pokeApi;
    private $apiVersion;

    public function __construct()
    {
        $this->apiVersion = 'v2';
        $this->pokeApi = config('app.pokeApi').'/'.$this->apiVersion;
    }

    public function getAllPokemons($condition = [], $search = null, $filter = [])
    {
        $data = Pokemon::select('id', 'name')
                        ->where($condition);

        if($search)
        {
            $data = $data->where(function($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%');
                return $q;
            });
        }

        if(isset($filter['abilities']) && count($filter['abilities']) > 0)
        {
            $data = $data->addSelect('abilities');
            $data = $data->where(function($q) use ($filter) {
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

        if(isset($filter['stats']) && count($filter['stats']) > 0)
        {
            $data = $data->addSelect('stats');
            $data = $data->where(function($q) use ($filter) {
                foreach ($filter['stats'] as $i => $stat) {
                    if($i == 0)
                    {
                        $q = $q->where('stats.stat.name', $stat);
                    }else{
                        $q = $q->orWhere('stats.stat.name', $stat);
                    }
                }

                return $q;
            });
        }

        $data = $data->paginate(10);
        return $data;
    }

    public function getPokemonsFromApi($queryParams)
    {
        $response = Http::get($this->pokeApi.'/pokemon', $queryParams);
        return $response;
    }

    public function getPokemonDetailFromApi($name)
    {
        $response = Http::get($this->pokeApi.'/pokemon/'.$name);
        return $response;
    }

    public function getPokemonById($pokemonId)
    {
        return Pokemon::where('id', (int) $pokemonId)->first();
    }

    public function createPokemon($pokemon)
    {
        return Pokemon::create($pokemon);
    }

    public function createManyPokemon($pokemon, $isExpire = false)
    {
        if($isExpire)
        {
            Pokemon::raw(function($collection) {
                return $collection->createIndex([
                    'expireAt' => 1
                ], [
                    'expireAfterSeconds' => 0
                ]);
            });
        }

        return Pokemon::insert($pokemon);
    }

    public function deletePokemon($pokemonId)
    {
        return Pokemon::destroy($pokemonId);
    }
}
