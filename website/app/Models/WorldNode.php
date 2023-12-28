<?php

namespace App\Models;

use Doctrine\Inflector\Rules\Word;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorldNode extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static $morph = 'world_node';

    protected $casts = [
        'id' => 'integer',
        'world_id' => 'integer',
        'owner_id' => 'integer',
        'owner_type' => 'string',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'w' => 'integer',
        'x' => 'integer',
        'y' => 'integer',
        'z' => 'integer',
    ];

    protected $fillable = [
        'world_id',
        'owner_type',
        'owner_id',
        'name',
        'w',
        'x',
        'y',
        'z',
    ];

    public function world()
    {
        return $this->belongsTo(World::class);
    }

    public function owner()
    {
        return $this->morphTo()->nullable();
    }

    public function buildings()
    {
        return $this->hasMany(WorldNodeBuilding::class);
    }

    public function ressources()
    {
        return $this->hasMany(WorldNodeRessource::class);
    }

    public function updateNode()
    {
        $lastUpdate = $this->updated_at;
        $now = now();
        $diff = $now->diffInSeconds($lastUpdate);
        if ($diff > 0) {
            $this->buildings->each(function($item) use ($diff) {
                WorldBuildingEvolution::where('world_building_id', '=', $item->world_building_id)->where('level', '=', $item->level)->get()->each(function($evolution) use ($item, $diff) {
                    $this->ressources->each(function($ressource) use ($evolution, $diff) {
                        WorldBuildingProductionEvolution::where('world_building_evolution_id', '=', $evolution->id)->where('world_ressource_id', '=', $ressource->world_ressource_id)->get()->each(function($evolutionRessource) use ($ressource, $diff) {
                            $ressource->amount += ( $evolutionRessource->amount_per_hour / 3600 ) * $diff;
                            $ressource->save();
                        });
                    });
                });
            });
            $this->updated_at = $now;
            $this->save();
        }

    }

    public static function countPotentialVillagePositions($radius = 100) {
        $squareSide = $radius * 2; // Longueur du côté du carré englobant le cercle
        return $squareSide;
    }

    public static function calcPercentUsage($villageCount, $radius = 100) {
        return $villageCount / self::countPotentialVillagePositions($radius);
    }

    public static function generateRandomCoordinatesInRadius($centerX, $centerY, $radius, $width, $height)
    {
        $angle = mt_rand(0, 360); // Angle aléatoire
        $distance = mt_rand(0, $radius); // Distance aléatoire jusqu'au rayon

        // Calcule les coordonnées du village à partir du centre, de l'angle et de la distance
        $x = $centerX + $distance * cos(deg2rad($angle));
        $y = $centerY + $distance * sin(deg2rad($angle));

        // Vérifie si les coordonnées sortent de la carte, ajuste-les si nécessaire
        $x = max(0, min($x, $width));
        $y = max(0, min($y, $height));

        // Retourne les coordonnées du village
        return ['x' => intval($x), 'y' => intval($y)];
    }

    public static function findNewCoords(World $world) {
        $radius = 1;
        $calculated_percentage = 1;
        while ($calculated_percentage > 0.4) {
            $radius += 2;
            $calculated_percentage = self::calcPercentUsage($world->nodes->count(), $radius);
        }

        while (true) {
            $pos = self::generateRandomCoordinatesInRadius(500, 500, $radius, 2000, 2000);
            $node = WorldNode::where('x', '=', $pos['x'])->where('y', '=', $pos['y'])->where('world_id', '=', $world->id)->first();
            if ($node == null)
                break ;
        }
        return $pos;
    }
}
