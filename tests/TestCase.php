<?php

namespace Tests;

use App\Models\User;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install',['-vvv' => true]);
    }

    /**
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function createUser(array $attributes)
    {
        return User::factory()->create($attributes);
    }

    /**
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function makeUser(array $attributes)
    {
        return User::factory()->make($attributes);
    }

    /**
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function registerRequest(array $attributes)
    {
        return $this->postJson(route('register'), $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function loginRequest(array $attributes)
    {
        return $this->postJson(route('login'), $attributes);
    }

    /**
     * @return TestResponse
     */
    protected function logout()
    {
        return $this->postJson(route('logout'));
    }

    /**
     * @return TestCase
     */
    protected function login()
    {
        $this->createUser($attributes = [
            'name'     => 'Ahmad',
            'email'    => $email = 'ahmad@app.io',
            'password' => Hash::make($password = 123456),
        ]);

        $response = $this->loginRequest(['email' => $email, 'password' => $password]);

        return $this->withHeader(
            'Authorization',
            'Bearer ' . $response['data']['access_token']['token']
        );
    }
}
