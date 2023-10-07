<?php

namespace App\Interfaces;

interface PokemonFavoriteRepositoryInterface 
{
    public function getAllFavorites();
    public function getAbilities();
    public function getFavoriteById($id);
    public function deleteFavorite($favoriteId);
    public function createFavorite(array $pokemons);
}
