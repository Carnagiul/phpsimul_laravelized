<?php

namespace Tests\Feature\World;

use App\Http\Controllers\WorldInterface;
use Database\Factories\UserFactory;
use Database\Factories\WorldFactory;
use Database\Factories\WorldRessourceFactory;
use Tests\TestCase;

class Ressources extends TestCase
{
    public function test_world_ressource_creation()
    {
        $world = WorldFactory::new()->create();
        $ressource = WorldRessourceFactory::new()->create([
            'world_id' => $world->id,
        ]);
        $this->assertTrue($ressource->exists());
        $world->delete();
    }
}
