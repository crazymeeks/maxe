<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use App\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    protected function getAccessToken()
    {
        factory(User::class)->create();

        $credentials = [
            'email' => 'user@example.com',
            'password' => 'password'
        ];

        $response = $this->json('POST', route('api.post.login'), $credentials);
        
        return [
            'Authorization' => 'Bearer ' . $response->original['access_token']
        ];
    }
}
