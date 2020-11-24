<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{

    /** @test */
    public function an_email_is_required()
    {
        $attributes = [
            'email'    => '',
            'password' => 123456,
        ];

        $response = $this->loginRequest($attributes);

        $response->assertStatus(422);
        $this->assertArrayHasKey('email', $response['errors']);
        $this->assertEquals('The email field is required.', $response['errors']['email'][0]);
    }

    /** @test */
    public function email_must_be_valid()
    {
        $attributes = [
            'email'    => 'invalid-email',
            'password' => 123456,
        ];

        $response = $this->loginRequest($attributes);

        $response->assertStatus(422);
        $this->assertArrayHasKey('email', $response['errors']);
        $this->assertEquals('The email must be a valid email address.', $response['errors']['email'][0]);
    }

    /** @test */
    public function a_password_is_required()
    {
        $attributes = [
            'email'    => 'ahmad@app.io',
            'password' => '',
        ];

        $response = $this->loginRequest($attributes);

        $response->assertStatus(422);
        $this->assertArrayHasKey('password', $response['errors']);
        $this->assertEquals('The password field is required.', $response['errors']['password'][0]);
    }

    /** @test */
    public function a_user_can_login()
    {
        $this->createUser($attributes = [
            'name'     => 'Ahmad',
            'email'    => $email = 'ahmad@app.io',
            'password' => Hash::make($password = 123456),
        ]);

        $response = $this->loginRequest(['email' => $email, 'password' => $password]);

        $response->assertStatus(200);
    }

    /** @test */
    public function receive_a_token_when_login()
    {
        $this->createUser($attributes = [
            'name'     => 'Ahmad',
            'email'    => $email = 'ahmad@app.io',
            'password' => Hash::make($password = 123456),
        ]);

        $response = $this->loginRequest(['email' => $email, 'password' => $password]);

        $this->assertArrayHasKey('access_token', $response['data']);
        $this->assertArrayHasKey('token', $response['data']['access_token']);
    }

    /** @test */
    public function a_user_can_logout()
    {
        $this->login();

        $response = $this->logout();

        $response->assertStatus(200);
    }

    /** @test */
    public function a_guest_cannot_logout()
    {
        $response = $this->logout();

        $response->assertStatus(401);
    }
}
