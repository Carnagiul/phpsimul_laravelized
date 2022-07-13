<?php

namespace Tests\Feature\World;

use App\Http\Controllers\WorldInterface;
use Database\Factories\UserFactory;
use Database\Factories\WorldFactory;
use Tests\TestCase;

class Register extends TestCase
{
    public function test_world_user_not_exist_in_world()
    {
        $world = WorldFactory::new()->create();
        $user = UserFactory::new()->create();
        $this->assertFalse(app(WorldInterface::class)->userExistInWorld($world, $user));
        $world->delete();
        $user->delete();
    }

    public function test_world_user_exist_in_world()
    {
        $world = WorldFactory::new()->create();
        $user = UserFactory::new()->create();
        app(WorldInterface::class)->addUserToWorld($world, $user);
        $this->assertTrue(app(WorldInterface::class)->userExistInWorld($world, $user));
        $world->delete();
        $user->delete();
    }
}
