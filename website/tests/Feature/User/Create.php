<?php

namespace Tests\Feature\User;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class Create extends TestCase
{
    public function test_accessibility_register()
    {
        $response = $this->get(route('guest.register'));
        $response->assertStatus(200);
    }

    public function test_accessibility_login()
    {
        $response = $this->get(route('guest.login'));
        $response->assertStatus(200);
    }

    public function test_accessibility_logout()
    {
        $user = UserFactory::new()->create();
        Auth::login($user);
        $response = $this->get(route('auth.logout'));
        $response->assertStatus(302);
        Auth::logout($user);
        $user->delete();
    }

    public function test_accessibility_login_form()
    {
        $user = UserFactory::new()->create();
        $response = $this->post(route('guest.login.post'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $user->delete();
        $response->assertStatus(302);
    }
}
