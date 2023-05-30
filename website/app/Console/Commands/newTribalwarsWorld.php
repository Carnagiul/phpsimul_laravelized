<?php

namespace App\Console\Commands;

use App\Http\Controllers\UserInterface;
use App\Models\Permission;
use App\Models\User;
use App\Models\World;
use App\Models\WorldBuilding;
use App\Models\WorldBuildingCostEvolution;
use App\Models\WorldBuildingEvolution;
use App\Models\WorldRessource;
use CreateWorldBuildingCostEvolutionsTable;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Type\Integer;

class newTribalwarsWorld extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phpsimul:world:newgt {worldName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create a new tribalwars world';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function createRessources(World $world) {
        $wood = new WorldRessource([
            'name' => 'wood',
            'world_id' => $world->id,
            'description' => 'wood is a ressource',
        ]);
        $wood->save();

        $clay = new WorldRessource([
            'name' => 'clay',
            'world_id' => $world->id,
            'description' => 'clay is a ressource',
        ]);
        $clay->save();

        $iron = new WorldRessource([
            'name' => 'iron',
            'world_id' => $world->id,
            'description' => 'iron is a ressource',
        ]);
        $iron->save();

        $gold = new WorldRessource([
            'name' => 'gold',
            'world_id' => $world->id,
            'description' => 'gold is a ressource',
        ]);
        $gold->save();

        $farm = new WorldRessource([
            'name' => 'food',
            'world_id' => $world->id,
            'description' => 'food is a ressource',
        ]);
        $farm->save();

        return [
            'wood' => $wood,
            'clay' => $clay,
            'iron' => $iron,
            'gold' => $gold,
            'food' => $farm,
        ];
    }

    public function createBuildings(World $world, WorldRessource $wood, WorldRessource $clay, WorldRessource $iron, WorldRessource $gold, WorldRessource $food) {
        $qg = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Quartier général',
            'description' => 'A partir du Quartier général du village, vous pouvez gérer la construction de nouveaux bâtiments, améliorer leurs niveaux et les démolir à partir du niveau 15 du quartier général. En augmentant le niveau du quartier général, vous accélèrerez les travaux.',
            'max_level' => 30,
            'min_level' => 1,
            'default_level' => 1,
        ]);
        $qg->save();
        $this->createBuildingTimer($qg, 10, 1.2,
            $wood, 90, 1.26,
            $clay, 80, 1.275,
            $iron, 70, 1.26
        );

        $caserne = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Caserne',
            'description' => 'La Caserne est le bâtiment où est recrutée l\'infanterie (Lanciers, Porteurs d\'épée, Guerriers à la hache et Archers). Plus son niveau est élevé, plus les recrutements sont rapides.',
            'max_level' => 25,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $caserne->save();
        $this->createBuildingTimer($caserne, 30, 1.2,
            $wood, 200, 1.26,
            $clay, 170, 1.28,
            $iron, 90, 1.26
        );

        $stable = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Ecurie',
            'description' => 'L\'Ecurie permet le recrutement de la cavalerie (Éclaireurs, Cavaleries légères, Archers montés, Cavaleries lourdes). Comme pour la caserne, plus son niveau est élevé, plus les recrutements sont rapides.',
            'max_level' => 20,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $stable->save();
        $this->createBuildingTimer($stable, 100, 1.2,
            $wood, 270, 1.26,
            $clay, 240, 1.28,
            $iron, 260, 1.26
        );

        $workshop = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Atelier',
            'description' => 'Dans l\'Atelier, vous pouvez produire des Béliers et Catapultes. Comme pour la caserne et l\'écurie, la vitesse de production est accélérée lorsque les niveaux augmentent.',
            'max_level' => 15,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $workshop->save();
        $this->createBuildingTimer($workshop, 100, 1.2,
            $wood, 300, 1.26,
            $clay, 240, 1.28,
            $iron, 260, 1.26
        );

        $academie = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Académie',
            'description' => 'L\'éducation des nobles se passe dans l\'Académie. Ils sont la pierre angulaire de la victoire!',
            'max_level' => 1,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $academie->save();
        $this->createBuildingTimer($academie, 1080, 1.2,
            $wood, 15000, 2,
            $clay, 25000, 2,
            $iron, 10000, 2);


        $forge = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Forge',
            'description' => 'La Forge est le bâtiment où les forgerons, en échange d\'un certain prix, effectuent les recherches et améliorations des armes. Plus son niveau sera élevé, plus les forgerons travailleront vite et meilleures seront les armes à rechercher.',
            'max_level' => 20,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $forge->save();
        $this->createBuildingTimer($forge, 100, 1.2,
            $wood, 220, 1.26,
            $clay, 180, 1.275,
            $iron, 240, 1.26
        );

        $rally = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Place de rassemblement',
            'description' => 'Vos combattants se rencontrent au Point de ralliement. De là, vous pouvez commander votre armée.',
            'max_level' => 1,
            'min_level' => 0,
            'default_level' => 1,
        ]);
        $rally->save();
        $this->createBuildingTimer($rally, 20, 1.2,
            $wood, 10, 1.26,
            $clay, 40, 1.275,
            $iron, 30, 1.26
        );

        $statue = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Statue',
            'description' => 'La Statue est l\'endroit où vos villageois rendent hommage à votre paladin et où vous pouvez l\'équiper et l\'améliorer. S\'il meurt, vous pouvez en nommer un autre parmi vos combattants.',
            'max_level' => 1,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $statue->save();
        $this->createBuildingTimer($statue, 25, 1.2,
            $wood, 220, 1.26,
            $clay, 220, 1.275,
            $iron, 220, 1.26
        );

        $market = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Marché',
            'description' => 'Au Marché, il est possible de charger les marchands et effectuer ainsi des échanges de ressources avec les autres joueurs.',
            'max_level' => 25,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $market->save();
        $this->createBuildingTimer($market, 45, 1.2,
            $wood, 100, 1.25,
            $clay, 100, 1.275,
            $iron, 100, 1.26
        );

        $timber = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Camp de bûcherons',
            'description' => 'Dans les forêts sombres, vos bûcherons coupent des arbres massifs pour produire du bois, qui est l\'un des trois types de ressources, nécessaires aux constructions et recrutements. Améliorer les niveaux du Camp de Bois permet d\'augmenter sa production.',
            'max_level' => 30,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $timber->save();
        $this->createBuildingTimer($timber, 15, 1.2,
            $wood, 50, 1.25,
            $clay, 60, 1.275,
            $iron, 40, 1.245
        );

        $clayPit = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Carrière d\'argile',
            'description' => 'Dans cette carrière, vos ouvriers extraient l\'argile. A nouveau, améliorer les niveaux de la Carrière d\'Argile permet d\'augmenter la production.',
            'max_level' => 30,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $clayPit->save();
        $this->createBuildingTimer($clayPit, 15, 1.2,
            $wood, 65, 1.27,
            $clay, 50, 1.265,
            $iron, 40, 1.24
        );

        $ironMine = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Mine de fer',
            'description' => 'Les mineurs extraient le métal précieux à la guerre dans la Mine de Fer. De même que pour le camp de bois et la carrière d\'argile, les niveaux élevés permettent de produire le plus de matériel.',
            'max_level' => 30,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $ironMine->save();
        $this->createBuildingTimer($ironMine, 18, 1.2,
            $wood, 75, 1.252,
            $clay, 65, 1.275,
            $iron, 70, 1.24
        );

        $farm = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Ferme',
            'description' => 'La Ferme loge et nourrit vos troupes, ainsi que vos travailleurs. Sans améliorations, votre village ne pourra pas se développer. La capacité de la ferme augmente avec chaque niveau.',
            'max_level' => 30,
            'min_level' => 1,
            'default_level' => 1,
        ]);
        $farm->save();
        $this->createBuildingTimer($farm, 20, 1.2,
            $wood, 45, 1.3,
            $clay, 40, 1.32,
            $iron, 30, 1.29
        );

        $warhouse = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Entrepôt',
            'description' => 'Les ressources sont stockées dans l\'Entrepôt. Chaque niveau améliore les capacités de stockage de ressources.',
            'max_level' => 30,
            'min_level' => 1,
            'default_level' => 1,
        ]);
        $warhouse->save();
        $this->createBuildingTimer($warhouse, 17, 1.2,
            $wood, 60, 1.265,
            $clay, 50, 1.27,
            $iron, 40, 1.245
        );

        $hide = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Cachette',
            'description' => 'Ce bâtiment cache vos ressources des assauts de troupes ennemies, y compris les éclaireurs.',
            'max_level' => 10,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $hide->save();
        $this->createBuildingTimer($hide, 30, 1.2,
            $wood, 50, 1.25,
            $clay, 60, 1.25,
            $iron, 50, 1.25
        );

        $wall = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Muraille',
            'description' => 'La Muraille protège votre village des troupes ennemies et augmente la puissance défensive de vos troupes. Ses effets seront multipliés avec chaque augmentation de niveau.',
            'max_level' => 20,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $wall->save();
        $this->createBuildingTimer($wall, 60, 1.2,
            $wood, 50, 1.26,
            $clay, 100, 1.275,
            $iron, 20, 1.26
        );
    }

    private function createBuildingTimer(WorldBuilding $building, int $initialTime, float $timeMultiplier, WorldRessource $wood, int $woodBase, float $woodEvo, WorldRessource $clay, int $clayBase, float $clayEvo, WorldRessource $iron, int $ironBase, float $ironEvo) {
        $this->info('Preparing Evolution of ' . $building->name . ' With Initial Time AT ' . $initialTime . ' And Evolution ' . $timeMultiplier);

        $time = $initialTime;
        for ($i = $building->min_level; $i <= $building->max_level; $i++) {
            if ($i >= 1)
                $time *= $timeMultiplier;
            $this->info('Creating evolution for ' . $building->name . ' level ' . $i . ' with time ' . intval($time));

            $level = new WorldBuildingEvolution([
                'world_building_id' => $building->id,
                'level' => $i,
                'duration' => intval($time),
            ]);
            $level->save();
            $this->createBuildingRessourceEvo($level, $wood, $woodBase, $woodEvo);
            $this->createBuildingRessourceEvo($level, $clay, $clayBase, $clayEvo);
            $this->createBuildingRessourceEvo($level, $iron, $ironBase, $ironEvo);

        }
    }

    public function createBuildingRessourceEvo(WorldBuildingEvolution $evolution, WorldRessource $ressources, int $initialNeed, float $multiplicator) {
        $totalNeed = $initialNeed;

        for ($i = 0; $i <= $evolution->level; $i++) {
            if ($i > 1)
                $totalNeed *= $multiplicator;
        }
        $cost = new WorldBuildingCostEvolution([
            'world_building_evolution_id' => $evolution->id,
            'world_ressource_id' => $ressources->id,
            'amount' => intval($totalNeed),
        ]);
        $cost->save();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $worldName = $this->argument('worldName');

        $this->info('Creating new world GT');

        $newWorld = new World();
        $newWorld->name = 'Guerre Tribal - ' . $worldName;
        $newWorld->is_dev = false;
        $newWorld->description = 'This is a GT Game World';
        $newWorld->register_at = now()->subSecond();
        $newWorld->open_at = now();
        $newWorld->close_at = null;
        $newWorld->save();

        $this->info('Creating new world ressources');
        $ressources = $this->createRessources($newWorld);



        $this->info('Creating new world buildings');
        $this->createBuildings($newWorld, $ressources['wood'], $ressources['clay'], $ressources['iron'], $ressources['gold'], $ressources['food']);



    }
}
