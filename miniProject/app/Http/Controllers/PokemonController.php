<?php

namespace App\Http\Controllers;

use App\Interfaces\PokemonRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\GetPokemonsRequest;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use MongoDB\BSON\UTCDateTime;
use App\Traits\APIResponseTrait;
use App\Exports\PokemonsExport;

class PokemonController extends Controller
{
    use APIResponseTrait;

    private PokemonRepositoryInterface $pokemonRepository;
    private $page = 1;
    private $search = '';
    private $filter = [];

    public function __construct(PokemonRepositoryInterface $pokemonRepository)
    {
        $this->pokemonRepository = $pokemonRepository;
    }

    private function getAllPokemonsFromApi()
    {
        try {
            $result = $this->pokemonRepository->getAllPokemons();

            if($result->count() == 0)
            {
                $result = $this->pokemonRepository->getPokemonsFromApi([
                    'offset' => 0,
                    'limit' => 20
                ])->json();

                if(count($result['results']) > 0)
                {
                    $newResults = collect($result['results'])->map(function($v) {
                        $detail = $this->pokemonRepository->getPokemonDetailFromApi($v['name'])->json();
                        $newData = [
                            ...$v,
                            ...$detail
                        ];
                        $newData['createdAt'] = new \MongoDB\BSON\UTCDateTime(Carbon::now());
                        $newData['expireAt'] = new \MongoDB\BSON\UTCDateTime(Carbon::now()->addMinutes(60));
                        return $newData;
                    })->toArray();

                    $this->pokemonRepository->createManyPokemon($newResults, true);

                    $result = $this->pokemonRepository->getAllPokemons([], $this->search, $this->filter);
                }
            }else{
                $result = $this->pokemonRepository->getAllPokemons([], $this->search, $this->filter);
            }

        return $result;
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }
    }

    public function index(GetPokemonsRequest $request)
    {
        try {
            $this->page = $request->page ?? 1;
            $this->search = $request->search ?? '';
            $abilities = $request->abilities ?? [];
            $species = $request->species ?? '';
            $stats = $request->stats ?? [];

            $this->filter = [
                'abilities' => $abilities,
                'stats' => $stats,
                'species' => $species
            ];

            $pokemon_refresh = $this->getAllPokemonsFromApi();

            return $this->successResponse($pokemon_refresh);
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }
    }

    public function show($id)
    {
        try {
            $detail = $this->pokemonRepository->getPokemonById($id);
            return $this->successResponse($detail);
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }
    }

    public function delete($id)
    {
        try {
            $delete = $this->pokemonRepository->deletePokemon($id);
            return $this->successResponse($delete);
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }
    }

    public function export()
    {
        try {
            return Excel::download(new PokemonsExport, 'getPokemons.xlsx');
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }
    }
}
