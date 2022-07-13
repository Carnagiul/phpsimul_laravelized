<?php

namespace Tests\Feature\World;

use App\Http\Controllers\WorldInterface;
use Carbon\Carbon;
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
}
