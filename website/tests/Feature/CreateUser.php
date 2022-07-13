<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateUser extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_accessibility_register()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_accessibility_login()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_accessibility_logout()
    {
        $response = $this->get('/logout');
        $response->assertStatus(302);
    }

    public function test_creation_user()
    {
        $response = $this->post('/register', [
            'name' => 'Test',
            'email' => 'test@test.fr',
            'password' => 'test',
            'password_confirmation' => 'test',
        ]);
        $response->assertStatus(302);
    }
}
