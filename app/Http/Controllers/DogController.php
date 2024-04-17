<?php

namespace App\Http\Controllers;

use App\Services\DogApiService;
use Illuminate\Http\Request;

class DogController extends Controller
{
    protected $dogApi;

    public function __construct(DogApiService $dogApi)
    {
        $this->dogApi = $dogApi;
    }

    public function getListBreeds()
    {
        $dogs = $this->dogApi->getListBreeds();
        return response()->json($dogs);
    }

    public function getRandomDog($count = 1)
    {
        $dog = $this->dogApi->getRandomDog($count);
        return response()->json($dog);
    }
}
