<?php

namespace Tests\Feature\Controllers\Api;

use App\User;

class AuthControllerTest extends \Tests\TestCase
{

    public function setUp(): void
    {
        parent::setUp();

        factory(User::class)->create();

    }


    /**
     * @dataProvider credentialDataProvider
     *
     * @return void
     */
    public function testLogin(array $credentials)
    {
        $response = $this->json('POST', route('api.post.login'), $credentials);
        $response->assertStatus(200);
        $this->assertArrayHasKey('access_token', $response->original);
    }
    
    public function credentialDataProvider()
    {
        $data = [
            'email' => 'user@example.com',
            'password' => 'password'
        ];

        return [
            array($data)
        ];
    }


}