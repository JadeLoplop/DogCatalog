<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\DogApiService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{

    public function __construct(protected DogApiService $dogApi)
    {
        $this->dogApi = $dogApi;
    }

    public function dashboard()
    {
        $users = User::all();
        $dogImgs = $this->dogApi->getRandomDog(30);

        return Inertia::render('Dashboard', [
            'users' => $users,
            'dogImgs' => $dogImgs
        ]);
    }
    public function getUsers()
    {
        return User::all();
    }
}
