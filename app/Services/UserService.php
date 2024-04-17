<?php

namespace App\Services;

use App\Models\User;
use GuzzleHttp\Client;

class UserService
{
    protected $randomUserImageApi;

    public function __construct(protected User $model)
    {
        $this->randomUserImageApi = new Client([
            'base_uri' => 'https://randomuser.me/api'
        ]);

        $this->model = $model;
    }

    public function getRandomProfileImage($count)
    {
        $endpoint = "/?results={$count}";

        $response = $this->randomUserImageApi->request('GET', $endpoint);

        dd($response);
        return $responseData['results'];

        dd($response->getBody()->getContents());
        return $response;
    }

    public function userAttachedImage(){
        $users = $this->model->all();
        $profileImages = $this->getRandomProfileImage(count($users));

        foreach ($users as $index => $user) {
            // Update the user model with the profile image URL
            $user->picture = $profileImages[$index]['picture']['large'];
        }

        return $users;
    }


}
