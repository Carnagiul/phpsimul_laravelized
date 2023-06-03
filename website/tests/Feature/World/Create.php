<?php

namespace Tests\Feature\World;

use App\Http\Controllers\WorldAdminController;
use App\Http\Controllers\WorldInterface;
use App\Models\World;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Database\Factories\WorldFactory;
use Tests\TestCase;

class Create extends TestCase
{
    public function test_world_creation() {
        $world = WorldFactory::new()->create();
        $this->assertTrue($world->exists());
        $world->delete();
    }

    public function test_world_creation_api() {
        $world = app(WorldInterface::class)->createWorldSimplified('test_world', Carbon::now()->subDays(10), Carbon::now());
        $this->assertTrue($world->exists());
        $world->delete();
    }

    public function test_world_creation_2_api() {
        $world = app(WorldInterface::class)->createWorldSimplified('test_world_2', Carbon::now()->subDays(10), Carbon::now(), Carbon::now()->addDays(10));
        $this->assertTrue($world->exists());
        $world->delete();
    }

    public function test_world_creation_3_api() {
        $world = app(WorldInterface::class)->createWorldSimplified('test_world_3', Carbon::now()->subDays(10), Carbon::now(), Carbon::now()->addDays(10), 'test_description');
        $this->assertTrue($world->exists());
        $world->delete();
    }

    public function test_command_world_as_gt() {
        if (!(World::where('name', '=', 'Guerre Tribal - GTOne')->get()->first() != null))
           $this->artisan('phpsimul:world:newgt GTOne');
        $this->assertNotNull(World::where('name', '=', 'Guerre Tribal - GTOne')->get()->first());
    }

    public function test_command_world_as_gt_registerUsers() {
        $world = World::where('name', '=', 'Guerre Tribal - GTOne')->get()->first();

        $user = UserFactory::new()->create();
        app(WorldInterface::class)->addUserToWorld($world, $user);
        $this->assertNotNull($user);
    }

    public function test_command_world_as_gt_worldExistVerifyRessources() {
        $world = World::where('name', '=', 'Guerre Tribal - GTOne')->get()->first();

        $this->assertEquals(5, $world->ressources->count());
    }

    public function test_command_world_as_gt_worldExistVerifyBuildings() {
        $world = World::where('name', '=', 'Guerre Tribal - GTOne')->get()->first();

        $this->assertEquals(16, $world->buildings->count());
    }

    public function test_command_world_as_gt_worldExistVerifyRegisteredUsers() {
        $world = World::where('name', '=', 'Guerre Tribal - GTOne')->get()->first();

        $this->assertGreaterThanOrEqual(1, $world->worldUsers->count());


    }


}
