<?php

namespace Tests\Feature;

use Tests\TestCase;

class TableDataTest extends TestCase
{

    /** @test */
    public function a_guest_does_not_have_access_to_table_data()
    {
        $response = $this->getJson(route('table-data'));

        $response->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_have_access_to_table_data()
    {
        $this->login();

        $response = $this->getJson(route('table-data'));

        $response->assertStatus(200);
        $this->assertArrayHasKey('data', $response);
        $this->assertArrayHasKey('draw', $response);
        $this->assertArrayHasKey('recordsTotal', $response);
        $this->assertArrayHasKey('recordsFiltered', $response);
    }

    /** @test */
    public function draw_parameter_must_be_an_integer()
    {
        $this->login();

        $params = [
            'draw' => 'string',
        ];

        $response = $this->getJson(route('table-data', $params));

        $response->assertStatus(422);
        $this->assertArrayHasKey('errors', $response);
        $this->assertArrayHasKey('draw', $response['errors']);
        $this->assertEquals('The draw must be an integer.', $response['errors']['draw'][0]);
    }

    /** @test */
    public function order_parameter_must_be_an_array_of_integer_column_and_asc_or_desc_dir()
    {
        $this->login();

        $params = [
            'order' => [
                [
                    'column' => 'string',
                    'dir'    => 'invalid'
                ]
            ]
        ];

        $response = $this->getJson(route('table-data', $params));

        $response->assertStatus(422);
        $this->assertArrayHasKey('errors', $response);
        $this->assertArrayHasKey('order.0.column', $response['errors']);
        $this->assertArrayHasKey('order.0.dir', $response['errors']);
        $this->assertEquals('The order.0.column must be an integer.', $response['errors']['order.0.column'][0]);
        $this->assertEquals('The selected order.0.dir is invalid.', $response['errors']['order.0.dir'][0]);
    }

    /** @test */
    public function start_parameter_must_be_an_integer()
    {
        $this->login();

        $params = [
            'start' => 'string',
        ];

        $response = $this->getJson(route('table-data', $params));

        $response->assertStatus(422);
        $this->assertArrayHasKey('errors', $response);
        $this->assertArrayHasKey('start', $response['errors']);
        $this->assertEquals('The start must be an integer.', $response['errors']['start'][0]);
    }

    /** @test */
    public function length_parameter_must_be_an_integer()
    {
        $this->login();

        $params = [
            'length' => 'string'
        ];

        $response = $this->getJson(route('table-data', $params));

        $response->assertStatus(422);
        $this->assertArrayHasKey('errors', $response);
        $this->assertArrayHasKey('length', $response['errors']);
        $this->assertEquals('The length must be an integer.', $response['errors']['length'][0]);
    }

    /** @test */
    public function search_regex_parameter_must_be_a_boolean()
    {
        $this->login();

        $params = [
            'search' => [
                'value' => '',
                'regex' => 'string'
            ],
        ];

        $response = $this->getJson(route('table-data', $params));

        $response->assertStatus(422);
        $this->assertArrayHasKey('errors', $response);
        $this->assertArrayHasKey('search.regex', $response['errors']);
        $this->assertEquals('The selected search.regex is invalid.', $response['errors']['search.regex'][0]);
    }
}
