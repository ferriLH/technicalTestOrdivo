<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\APIResponseTrait;
use App\Http\Requests\{
    GetPokemonFavoritesRequest,
    PostPokemonsRequest
};
use App\Interfaces\{
    PokemonFavoriteRepositoryInterface,
    PokemonRepositoryInterface
};

class PokemonFavoriteController extends Controller
{
    use APIResponseTrait;
    
    private PokemonFavoriteRepositoryInterface $pokemonFavoriteRepository;
    private PokemonRepositoryInterface $pokemonRepository;
    private $page = 1;
    private $search = '';
    private $filter = [];

    public function __construct(PokemonFavoriteRepositoryInterface $pokemonFavoriteRepository, PokemonRepositoryInterface $pokemonRepository) 
    {
        $this->pokemonFavoriteRepository = $pokemonFavoriteRepository;
        $this->pokemonRepository = $pokemonRepository;
    }

    public function index(GetPokemonFavoritesRequest $request)
    {
        $this->page = $request->page ?? 1;
        $this->search = $request->search ?? '';
        $abilities = $request->abilities ?? [];
        
        $this->filter = [
            'abilities' => $abilities
        ];

        $data = $this->pokemonFavoriteRepository->getAllFavorites([], $this->filter);

        return $this->successResponse($data);
    }

    public function getAbilities()
    {
        $data = $this->pokemonFavoriteRepository->getAbilities();

        return $this->successResponse($data);
    }

    public function store(PostPokemonsRequest $request)
    {
        try {
            $input = $request->all();

            $checkPokemon = $this->pokemonRepository->getPokemonById($input['pokemonId']);

            if(!$checkPokemon)
            {
                return $this->successResponse('Pokemon Id not found', 400);
            }

            $checkExist = $this->pokemonFavoriteRepository->getFavoriteById($input['pokemonId']);
            
            if($checkExist)
            {
                return $this->successResponse('Favorite already exist', 400);
            }

            $data = $this->pokemonFavoriteRepository->createFavorite($input);
            return $this->successResponse('data successfully created');
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }
    }
}
