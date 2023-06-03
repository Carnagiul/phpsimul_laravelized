<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\World;
use App\Models\WorldNode;
use App\Models\WorldUser;
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

    public function createWorldSimplified(String $name, Carbon $registerAt, Carbon $openAt)
    {
        return $this->createWorldWithoutDescription($name, $registerAt, $openAt, null);
    }

    public function canRegisterInWorld(World $world)
    {
        if ($world->register_at == null) {
            return false;
        }
        if (!Carbon::parse($world->register_at)->isPast()) {
            return false;
        }

        if ($world->close_at != null) {
            if ($world->close_at->isPast()) {
                return false;
            }
        }

        return true;
    }

    public function canEnterInWorld(World $world)
    {
        if (!$this->canRegisterInWorld($world)) {
            return false;
        }

        if ($world->open_at == null) {
            return false;
        }
        if (!$world->open_at->isPast()) {
            return false;
        }

        return true;
    }

    public function userCanRegister(World $world, User $user)
    {
        return $this->canRegisterInWorld($world) && !$this->userExistInWorld($world, $user);
    }

    public function getUserExistInWorld(World $world, User $user)
    {
        return WorldUser::where('world_id', $world->id)->where('user_id', $user->id)->exists();
    }

    public function getUserInWorld(World $world, User $user):WorldUser
    {
        return WorldUser::where('world_id', $world->id)->where('user_id', $user->id)->get()->first();
    }

    public function addUserToWorld(World $world, User $user)
    {
        $worldUser = new WorldUser();
        $worldUser->world_id = $world->id;
        $worldUser->user_id = $user->id;
        $worldUser->save();
        // dd($worldNode);
    }

    public function createNodeOnWorldUser(World $world, WorldUser $worldUser) {
        $pos = WorldNode::findNewCoords($world);

        $worldNode = new WorldNode([
            'world_id' => $world->id,
            'owner_id' => $worldUser->id,
            'owner_type' => WorldUser::$morph,
            'name' => 'Village of ' . $worldUser->user->name,
            'x' => $pos['x'],
            'y' => $pos['y'],
        ]);
        $worldNode->save();
        return $worldNode;
    }

    public function removeUserFromWorld(World $world, User $user)
    {
        WorldUser::where('world_id', $world->id)->where('user_id', $user->id)->delete();
    }
}
