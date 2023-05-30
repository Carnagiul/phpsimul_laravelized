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
    private $ressourceWood;
    private $ressourceClay;
    private $ressourceIron;
    private $ressourceGold;
    private $ressourceFarm;

    private $buildingHeadquarter;
    private $buildingBarack;
    private $buildingStable;
    private $buildingWorkshop;

    private $buildingFarm;
    private $buildingWarehouse;
    private $buildingWood;
    private $buildingClay;
    private $buildingIron;
    private $buildingAcademy;
    private $buildingSmithy;
    private $buildingMarket;
    private $buildingWall;
    private $buildingHide;
    private $buildingPlace;
    private $buildingStatue;



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
        $this->ressourceWood = new WorldRessource([
            'name' => 'wood',
            'world_id' => $world->id,
            'description' => 'wood is a ressource',
        ]);
        $this->ressourceWood->save();

        $this->ressourceClay = new WorldRessource([
            'name' => 'clay',
            'world_id' => $world->id,
            'description' => 'clay is a ressource',
        ]);
        $this->ressourceClay->save();

        $this->ressourceIron = new WorldRessource([
            'name' => 'iron',
            'world_id' => $world->id,
            'description' => 'iron is a ressource',
        ]);
        $this->ressourceIron->save();

        $this->ressourceGold = new WorldRessource([
            'name' => 'gold',
            'world_id' => $world->id,
            'description' => 'gold is a ressource',
        ]);
        $this->ressourceGold->save();

        $this->ressourceFarm = new WorldRessource([
            'name' => 'food',
            'world_id' => $world->id,
            'description' => 'food is a ressource',
        ]);
        $this->ressourceFarm->save();

    }

    public function createBuildings(World $world) {
        $this->buildingHeadquarter = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Quartier général',
            'description' => 'A partir du Quartier général du village, vous pouvez gérer la construction de nouveaux bâtiments, améliorer leurs niveaux et les démolir à partir du niveau 15 du quartier général. En augmentant le niveau du quartier général, vous accélèrerez les travaux.',
            'max_level' => 30,
            'min_level' => 1,
            'default_level' => 1,
        ]);
        $this->buildingHeadquarter->save();
        $this->createBuildingTimer($this->buildingHeadquarter, 10, 1.2,
            90, 1.26,
            80, 1.275,
            70, 1.26
        );

        $this->buildingBarack = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Caserne',
            'description' => 'La Caserne est le bâtiment où est recrutée l\'infanterie (Lanciers, Porteurs d\'épée, Guerriers à la hache et Archers). Plus son niveau est élevé, plus les recrutements sont rapides.',
            'max_level' => 25,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $this->buildingBarack->save();
        $this->createBuildingTimer($this->buildingBarack, 30, 1.2,
            200, 1.26,
            170, 1.28,
            90, 1.26
        );

        $this->buildingStable = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Ecurie',
            'description' => 'L\'Ecurie permet le recrutement de la cavalerie (Éclaireurs, Cavaleries légères, Archers montés, Cavaleries lourdes). Comme pour la caserne, plus son niveau est élevé, plus les recrutements sont rapides.',
            'max_level' => 20,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $this->buildingStable->save();
        $this->createBuildingTimer($this->buildingStable, 100, 1.2,
            270, 1.26,
            240, 1.28,
            260, 1.26
        );

        $this->buildingWorkshop = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Atelier',
            'description' => 'Dans l\'Atelier, vous pouvez produire des Béliers et Catapultes. Comme pour la caserne et l\'écurie, la vitesse de production est accélérée lorsque les niveaux augmentent.',
            'max_level' => 15,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $this->buildingWorkshop->save();
        $this->createBuildingTimer($this->buildingWorkshop, 100, 1.2,
            300, 1.26,
            240, 1.28,
            260, 1.26
        );

        $this->buildingAcademy = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Académie',
            'description' => 'L\'éducation des nobles se passe dans l\'Académie. Ils sont la pierre angulaire de la victoire!',
            'max_level' => 1,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $this->buildingAcademy->save();
        $this->createBuildingTimer($this->buildingAcademy, 1080, 1.2,
            15000, 2,
            25000, 2,
            10000, 2);


        $this->buildingSmithy = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Forge',
            'description' => 'La Forge est le bâtiment où les forgerons, en échange d\'un certain prix, effectuent les recherches et améliorations des armes. Plus son niveau sera élevé, plus les forgerons travailleront vite et meilleures seront les armes à rechercher.',
            'max_level' => 20,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $this->buildingSmithy->save();
        $this->createBuildingTimer($this->buildingSmithy, 100, 1.2,
            220, 1.26,
            180, 1.275,
            240, 1.26
        );

        $this->buildingPlace = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Place de rassemblement',
            'description' => 'Vos combattants se rencontrent au Point de ralliement. De là, vous pouvez commander votre armée.',
            'max_level' => 1,
            'min_level' => 0,
            'default_level' => 1,
        ]);
        $this->buildingPlace->save();
        $this->createBuildingTimer($this->buildingPlace, 20, 1.2,
            10, 1.26,
            40, 1.275,
            30, 1.26
        );

        $this->buildingStatue = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Statue',
            'description' => 'La Statue est l\'endroit où vos villageois rendent hommage à votre paladin et où vous pouvez l\'équiper et l\'améliorer. S\'il meurt, vous pouvez en nommer un autre parmi vos combattants.',
            'max_level' => 1,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $this->buildingStatue->save();
        $this->createBuildingTimer($this->buildingStatue, 25, 1.2,
            220, 1.26,
            220, 1.275,
            220, 1.26
        );

        $this->buildingMarket = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Marché',
            'description' => 'Au Marché, il est possible de charger les marchands et effectuer ainsi des échanges de ressources avec les autres joueurs.',
            'max_level' => 25,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $this->buildingMarket->save();
        $this->createBuildingTimer($this->buildingMarket, 45, 1.2,
            100, 1.25,
            100, 1.275,
            100, 1.26
        );

        $this->buildingWood = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Camp de bûcherons',
            'description' => 'Dans les forêts sombres, vos bûcherons coupent des arbres massifs pour produire du bois, qui est l\'un des trois types de ressources, nécessaires aux constructions et recrutements. Améliorer les niveaux du Camp de Bois permet d\'augmenter sa production.',
            'max_level' => 30,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $this->buildingWood->save();
        $this->createBuildingTimer($this->buildingWood, 15, 1.2,
            50, 1.25,
            60, 1.275,
            40, 1.245
        );

        $this->buildingClay = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Carrière d\'argile',
            'description' => 'Dans cette carrière, vos ouvriers extraient l\'argile. A nouveau, améliorer les niveaux de la Carrière d\'Argile permet d\'augmenter la production.',
            'max_level' => 30,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $this->buildingClay->save();
        $this->createBuildingTimer($this->buildingClay, 15, 1.2,
            65, 1.27,
            50, 1.265,
            40, 1.24
        );

        $this->buildingIron = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Mine de fer',
            'description' => 'Les mineurs extraient le métal précieux à la guerre dans la Mine de Fer. De même que pour le camp de bois et la carrière d\'argile, les niveaux élevés permettent de produire le plus de matériel.',
            'max_level' => 30,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $this->buildingIron->save();
        $this->createBuildingTimer($this->buildingIron, 18, 1.2,
            75, 1.252,
            65, 1.275,
            70, 1.24
        );

        $this->buildingFarm = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Ferme',
            'description' => 'La Ferme loge et nourrit vos troupes, ainsi que vos travailleurs. Sans améliorations, votre village ne pourra pas se développer. La capacité de la ferme augmente avec chaque niveau.',
            'max_level' => 30,
            'min_level' => 1,
            'default_level' => 1,
        ]);
        $this->buildingFarm->save();
        $this->createBuildingTimer($this->buildingFarm, 20, 1.2,
            45, 1.3,
            40, 1.32,
            30, 1.29
        );

        $this->buildingWarehouse = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Entrepôt',
            'description' => 'Les ressources sont stockées dans l\'Entrepôt. Chaque niveau améliore les capacités de stockage de ressources.',
            'max_level' => 30,
            'min_level' => 1,
            'default_level' => 1,
        ]);
        $this->buildingWarehouse->save();
        $this->createBuildingTimer($this->buildingWarehouse, 17, 1.2,
            60, 1.265,
            50, 1.27,
            40, 1.245
        );

        $this->buildingHide = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Cachette',
            'description' => 'Ce bâtiment cache vos ressources des assauts de troupes ennemies, y compris les éclaireurs.',
            'max_level' => 10,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $this->buildingHide->save();
        $this->createBuildingTimer($this->buildingHide, 30, 1.2,
            50, 1.25,
            60, 1.25,
            50, 1.25
        );

        $this->buildingWall = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Muraille',
            'description' => 'La Muraille protège votre village des troupes ennemies et augmente la puissance défensive de vos troupes. Ses effets seront multipliés avec chaque augmentation de niveau.',
            'max_level' => 20,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $this->buildingWall->save();
        $this->createBuildingTimer($this->buildingWall, 60, 1.2,
            50, 1.26,
            100, 1.275,
            20, 1.26
        );
    }

    private function createBuildingTimer(WorldBuilding $building, int $initialTime, float $timeMultiplier, int $woodBase, float $woodEvo, int $clayBase, float $clayEvo, int $ironBase, float $ironEvo) {
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
            $this->createBuildingRessourceEvo($level, $this->ressourceWood, $woodBase, $woodEvo);
            $this->createBuildingRessourceEvo($level, $this->ressourceClay, $clayBase, $clayEvo);
            $this->createBuildingRessourceEvo($level, $this->ressourceIron, $ironBase, $ironEvo);

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
