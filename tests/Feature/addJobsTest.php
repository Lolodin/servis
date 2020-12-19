<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class addJobsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->json('POST', '/api/send', ['to' => [1, 2, 3, 4, 5], 'message' => "Hello WOrld"]);
        $response->assertStatus(200);
        $response = $this->json('POST', '/api/send', ['to' => [1], 'message' => "Hello WOrld"]);
        $response->assertStatus(200);
        $response = $this->json('POST', '/api/send', ['to' => ["1", "2", "3", "4", "5"], 'message' => "Hello WOrld"]);
        $response->assertStatus(400);
    }
}
