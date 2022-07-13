<?php

namespace App\Http\Controllers;

use App\Models\World;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WorldInterface extends Controller
{
    public function createWorldFull(String $name, Carbon $registerAt, Carbon $openAt, ?Carbon $closeAt, ?String $description)
    {
        $world = new World();
        $world->name = $name;
        $world->register_at = $registerAt;
        $world->open_at = $openAt;
        $world->close_at = $closeAt;
        $world->description = $description;
        $world->save();

        return $world;
    }

    public function createWorldWithoutDescription(String $name, Carbon $registerAt, Carbon $openAt, ?Carbon $closeAt)
    {
        return $this->createWorldFull($name, $registerAt, $openAt, $closeAt, null);
    }

    public function createWorldSimplified(String $name, Carbon $registerAt, Carbon $openAt) {
        return $this->createWorldWithoutDescription($name, $registerAt, $openAt, null);
    }

    public function canView(World $world) {
        if ($world->close_at == null) {
            if ($world->register_at == null) {
                return false;
            }
            return $world->register_at->isPast();
        }

        if ($world->close_at->isPast()) {
            return false;
        }
        return true;
    }

    public function isDevWorld(World $world) {
        return $this->canView($world) && $world->is_dev;
    }
}
