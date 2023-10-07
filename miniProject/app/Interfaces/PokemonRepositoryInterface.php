<?php

namespace App\Interfaces;

interface PokemonRepositoryInterface 
{
    public function getAllPokemons($condition, $search = null);
    public function getPokemonsFromApi($queryParams);
    public function getPokemonById($pokemonId);
    public function createPokemon(array $pokemons);
    public function createManyPokemon(array $pokemons, bool $isExpire = false);
    public function deletePokemon($pokemonId);
}
