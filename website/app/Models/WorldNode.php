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

    public function getAttributesMaxStorage() {
        $storage = [];
        $this->buildings->each(function($item) use (&$storage) {
            WorldBuildingEvolution::where('world_building_id', '=', $item->world_building_id)->where('level', '=', $item->level)->get()->each(function($evolution) use (&$storage) {
                if ($evolution->storages != null)
                    $evolution->storages->each(function($store) use (&$storage) {
                        if (isset($storage[$store->world_ressource_id]))
                            $storage[$store->world_ressource_id] += $store->amount_once;
                        else
                            $storage[$store->world_ressource_id] = $store->amount_once;
                    });
            });
        });


        foreach ($storage as $key => $value) {
            foreach ($this->ressources as $ress) {
                if ($ress->world_ressource_id == $key) {
                    $ress->storage = $value;
                    $ress->save();
                }
            }
        }

        return $storage;
    }

    public function getAttributesRess($diff = 0) {
        $storage = [];
        $productions = [];
        $producted = [];
        $max = [];
        $this->buildings->each(function($item) use (&$storage, &$max, &$productions, ) {
            WorldBuildingEvolution::where('world_building_id', '=', $item->world_building_id)->where('level', '=', $item->level)->get()->each(function($evolution) use (&$storage, &$max, &$productions) {
                if ($evolution->productions != null)
                {
                    $evolution->productions->each(function($store) use (&$storage, &$productions, &$max) {
                        if (isset($productions[$store->world_ressource_id]))
                            $productions[$store->world_ressource_id] += $store->amount_per_hour;
                        else
                            $productions[$store->world_ressource_id] = $store->amount_per_hour;
                        if (isset($storage[$store->world_ressource_id]))
                            $storage[$store->world_ressource_id] += $store->amount_once;
                        else {
                            if ($store->amount_once > 0)
                                $storage[$store->world_ressource_id] = $store->amount_once;
                        }

                    });
                }
                if ($evolution->storages != null)
                {
                    $evolution->storages->each(function($store) use (&$storage) {
                        if (isset($storage[$store->world_ressource_id]))
                            $storage[$store->world_ressource_id] += $store->amount_once;
                        else
                            $storage[$store->world_ressource_id] = $store->amount_once;
                    });
                }
            });
        });
        foreach ($this->ressources as $ress) {
            if (isset($storage[$ress->world_ressource_id])) {
                $ress->storage = $storage[$ress->world_ressource_id];
            }
            if (isset($productions[$ress->world_ressource_id])) {
                $producted[$ress->world_ressource_id] = $diff * ($productions[$ress->world_ressource_id] / 3600);
                $ress->prod = $productions[$ress->world_ressource_id];
            }
            $ress->save();
        }
        return ['storages' => $storage, 'prod' => $productions, 'producted' => $producted, 'max' => $max];

    }

    public function updateNode()
    {
        $lastUpdate = $this->updated_at;
        $now = now();
        $diff = $now->diffInSeconds($lastUpdate);
        $datas = $this->getAttributesRess($diff);
        if (isset($datas['producted'])) {
            foreach ($datas['producted'] as $key => $value) {
                foreach($this->ressources as $ress) {
                    if ($ress->world_ressource_id == $key) {
                        $ress->amount += $value;
                        if ($ress->amount < 0)
                            $ress->amount = 0;
                        if ($ress->amount > $ress->storage)
                            $ress->amount = $ress->storage;
                        $ress->save();
                    }
                }
            }
            $this->touch();
        }

        if ($this->buildingQueue->count() > 0) {
            $buildingDiff = $diff;
            while ($buildingDiff > 0) {
                foreach ($this->buildingQueue as $queued) {
                    if ($queued->remaining > $buildingDiff) {
                        $queued->remaining = $queued->remaining - $buildingDiff;
                        $queued->save();
                        $buildingDiff = 0;
                        break ;
                    } else {
                        $buildingDiff -= $queued->remaining;
                        $queued->remaining = 0;
                        $building = $this->buildings()->where('world_building_id', $queued->world_building_id)->get()->first();
                        $building->level = $queued->level;
                        $evolution = WorldBuildingEvolution::where('world_building_id', $queued->world_building_id)->where('level', $queued->level)->get()->first();
                        $ressources = $evolution->productions()->where('amount_once', '>', 0)->get();
                        if ($ressources != null) {
                            foreach ($ressources as $buildRess) {
                                foreach ($this->ressources as $nodeRess) {
                                    if ($nodeRess->world_ressource_id == $buildRess->world_ressource_id) {
                                        $nodeRess->amount += $buildRess->amount_once;
                                        $nodeRess->storage += $buildRess->amount_once;
                                        $nodeRess->save();
                                    }
                                }
                            }

                        }

                        $building->save();
                        $queued->save();
                    }
                }
                break ;
            }
            $this->buildingQueue()->where('remaining', 0)->delete();
            $this->buildingQueue()->orderBy('position')->get()->map(function($item, $index){
                $item->position = $index;
                $item->save();
            });
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

    public function buildingQueue() {
        return $this->hasMany(WorldNodeBuildingQueue::class);
    }
}
