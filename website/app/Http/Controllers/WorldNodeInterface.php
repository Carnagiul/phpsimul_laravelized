<?php

namespace App\Http\Controllers;

use App\Models\World;
use App\Models\WorldNode;
use App\Models\WorldUser;
use Illuminate\Support\Facades\Auth;

class WorldNodeInterface extends Controller
{
    public function canAcces(WorldNode $node, WorldUser $user) {
        if ($node->owner->id == $user->id) {
            return true;
        }
        return false;
    }

    public function nodeHome(World $world, WorldNode $node) {
        $worldUser = app(WorldInterface::class)->getUserInWorld($world, Auth::user());
        if ($this->canAcces($node, $worldUser)) {
            return view('auth.world.node.view', ['world' => $world, 'node' => $node]);
        } else {
            return redirect(route('auth.world.home', $world));
        }
    }
}
