<?php

namespace App\Models;

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

    public static function countPotentialVillagePositions($radius = 100) {
        $squareSide = $radius * 2; // Longueur du côté du carré englobant le cercle
        $gridSize = ceil($squareSide / ($radius * 2)); // Taille de la grille (nombre de positions possibles)
        $potentialPositions = pow($gridSize, 2); // Nombre total de positions possibles

        return $potentialPositions;
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
        $radius = 4;
        $calculated_percentage = self::calcPercentUsage($world->nodes->count(), $radius);
        while ($calculated_percentage > 0.4) {
            $radius += 4;
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
