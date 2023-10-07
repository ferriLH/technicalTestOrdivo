<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\{
    PokemonRepositoryInterface,
    PokemonFavoriteRepositoryInterface
};
use App\Repositories\{
    PokemonRepository,
    PokemonFavoritesRepository
};

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PokemonRepositoryInterface::class, PokemonRepository::class);
        $this->app->bind(PokemonFavoriteRepositoryInterface::class, PokemonFavoritesRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
