<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Testing\TestResponse;

class RegisterTest extends TestCase
{

    /** @test */
    public function a_name_is_required()
    {
        $attributes     = [
            'name'     => '',
            'email'    => 'ahmad@app.io',
            'password' => 123456,
        ];

        $response = $this->registerRequest($attributes);

        $response->assertStatus(422);
        $this->assertArrayHasKey('name', $response['errors']);
        $this->assertEquals('The name field is required.', $response['errors']['name'][0]);
    }

    /** @test */
    public function name_field_must_be_a_string()
    {
        $attributes     = [
            'name'     => 123,
            'email'    => 'ahmad@app.io',
            'password' =>  123456,
        ];

        $response = $this->registerRequest($attributes);

        $response->assertStatus(422);
        $this->assertArrayHasKey('name', $response['errors']);
        $this->assertEquals('The name must be a string.', $response['errors']['name'][0]);
    }

    /** @test */
    public function name_field_must_be_at_least_3_characters()
    {
        $attributes     = [
            'name'     => 'Ah',
            'email'    => 'ahmad@app.io',
            'password' => 123456,
        ];

        $response = $this->registerRequest($attributes);

        $response->assertStatus(422);
        $this->assertArrayHasKey('name', $response['errors']);
        $this->assertEquals('The name must be at least 3 characters.', $response['errors']['name'][0]);
    }

    /** @test */
    public function an_email_is_required()
    {
        $attributes     = [
            'name'     => 'Ahmad',
            'email'    => '',
            'password' => 123456,
        ];

        $response = $this->registerRequest($attributes);

        $response->assertStatus(422);
        $this->assertArrayHasKey('email', $response['errors']);
        $this->assertEquals('The email field is required.', $response['errors']['email'][0]);
    }

    /** @test */
    public function email_field_must_be_a_valid_email()
    {
        $attributes     = [
            'name'     => 'Ahmad',
            'email'    => 'invalid-email',
            'password' => 123456,
        ];

        $response = $this->registerRequest($attributes);

        $response->assertStatus(422);
        $this->assertArrayHasKey('email', $response['errors']);
        $this->assertEquals('The email must be a valid email address.', $response['errors']['email'][0]);
    }

    /** @test */
    public function a_password_is_required()
    {
        $attributes     = [
            'name'     => 'Ahmad',
            'email'    => 'ahmad@app.io',
            'password' => '',
        ];

        $response = $this->registerRequest($attributes);

        $response->assertStatus(422);
        $this->assertArrayHasKey('password', $response['errors']);
        $this->assertEquals('The password field is required.', $response['errors']['password'][0]);
    }

    /** @test */
    public function password_field_must_be_at_least_6_characters()
    {
        $attributes     = [
            'name'     => 'Ahmad',
            'email'    => 'ahmad@app.io',
            'password' => '12345',
        ];

        $response = $this->registerRequest($attributes);

        $response->assertStatus(422);
        $this->assertArrayHasKey('password', $response['errors']);
        $this->assertEquals('The password must be at least 6 characters.', $response['errors']['password'][0]);
    }

    /** @test */
    public function a_user_can_register_with_valid_attributes()
    {
        $attributes     = [
            'name'     => 'Ahmad',
            'email'    => 'ahmad@app.io',
            'password' => '123456',
        ];

        $response = $this->registerRequest($attributes);

        $response->assertStatus(200);
        $this->assertEquals('You have successfully created an account!', $response['message']);
    }
}
