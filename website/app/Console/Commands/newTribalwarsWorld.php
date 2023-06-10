<?php

namespace App\Console\Commands;

use App\Http\Controllers\UserInterface;
use App\Models\Permission;
use App\Models\User;
use App\Models\World;
use App\Models\WorldBuilding;
use App\Models\WorldBuildingCostEvolution;
use App\Models\WorldBuildingEvolution;
use App\Models\WorldBuildingProductionEvolution;
use App\Models\WorldBuildingStorageEvolution;
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
            'default_amount' => '1000',
        ]);
        $this->ressourceWood->save();

        $this->ressourceClay = new WorldRessource([
            'name' => 'clay',
            'world_id' => $world->id,
            'description' => 'clay is a ressource',
            'default_amount' => '1000',
        ]);
        $this->ressourceClay->save();

        $this->ressourceIron = new WorldRessource([
            'name' => 'iron',
            'world_id' => $world->id,
            'description' => 'iron is a ressource',
            'default_amount' => '1000',
        ]);
        $this->ressourceIron->save();

        $this->ressourceGold = new WorldRessource([
            'name' => 'gold',
            'world_id' => $world->id,
            'description' => 'gold is a ressource',
            'default_amount' => '0',
        ]);
        $this->ressourceGold->save();

        $this->ressourceFarm = new WorldRessource([
            'name' => 'food',
            'world_id' => $world->id,
            'description' => 'food is a ressource',
            'default_amount' => '240',
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
        $this->createBuildingTimer($this->buildingHeadquarter,
            ['initial' => 10, 'evolution' => 1.2],
            ['initial' => 90, 'evolution' => 1.26],
            ['initial' => 80, 'evolution' => 1.275],
            ['initial' => 70, 'evolution' => 1.26],
            ['initial' => 5, 'evolution' => 1.17],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ]
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
        $this->createBuildingTimer($this->buildingBarack,
            ['initial' => 30, 'evolution' => 1.2],
            ['initial' => 200, 'evolution' => 1.26],
            ['initial' => 170, 'evolution' => 1.28],
            ['initial' => 90, 'evolution' => 1.26],
            ['initial' => 7, 'evolution' => 1.17],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ]
        );

        $this->buildingStable = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Ecurie',
            'description' => 'L\'Ecurie permet le recrutement de la cavalerie ([Éclaireurs, Cavaleries légères, Archers montés, Cavaleries lourdes]). Comme pour la caserne, plus son] niveau est élevé, plus les] recrutements sont rapides.',
            'max_level' => 20,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $this->buildingStable->save();
        $this->createBuildingTimer($this->buildingStable,
            ['initial' => 100, 'evolution' => 1.2],
            ['initial' => 270, 'evolution' => 1.26],
            ['initial' => 240, 'evolution' => 1.28],
            ['initial' => 260, 'evolution' => 1.26],
            ['initial' => 8, 'evolution' => 1.17],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ]
        );

        $this->buildingWorkshop = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Atelier',
            'description' => 'Dans l\'Atelier, vous pouvez] produire des Béliers et Catapultes. Comme pour la caserne et l\'écurie, la vitesse] de production est accélérée lorsque les niveaux augmentent.',
            'max_level' => 15,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $this->buildingWorkshop->save();
        $this->createBuildingTimer($this->buildingWorkshop,
            ['initial' => 100, 'evolution' => 1.2],
            ['initial' => 300, 'evolution' => 1.26],
            ['initial' => 240, 'evolution' => 1.28],
            ['initial' => 260, 'evolution' => 1.26],
            ['initial' => 8, 'evolution' => 1.17],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ]
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
        $this->createBuildingTimer($this->buildingAcademy,
            ['initial' => 1080, 'evolution' => 1.2],
            ['initial' => 15000, 'evolution' => 2],
            ['initial' => 25000, 'evolution' => 2],
            ['initial' => 10000, 'evolution' => 2],
            ['initial' => 80, 'evolution' => 1.17],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ]
        );


        $this->buildingSmithy = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Forge',
            'description' => 'La Forge est le bâtiment où les forgerons, en échange d\'un certain prix, effectuent les recherches et améliorations des armes. Plus son niveau sera élevé, plus les forgerons travailleront vite et meilleures seront les armes à rechercher.',
            'max_level' => 20,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $this->buildingSmithy->save();
        $this->createBuildingTimer($this->buildingSmithy,
            ['initial' => 100, 'evolution' => 1.2],
            ['initial' => 220, 'evolution' => 1.26],
            ['initial' => 180, 'evolution' => 1.275],
            ['initial' => 240, 'evolution' => 1.26],
            ['initial' => 20, 'evolution' => 1.17],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ]
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
        $this->createBuildingTimer($this->buildingPlace,
            ['initial' => 20, 'evolution' => 1.2],
            ['initial' => 10, 'evolution' => 1.26],
            ['initial' => 40, 'evolution' => 1.275],
            ['initial' => 30, 'evolution' => 1.26],
            ['initial' => 0, 'evolution' => 1.17],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ]
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
        $this->createBuildingTimer($this->buildingStatue,
            ['initial' => 25, 'evolution' => 1.2],
            ['initial' => 220, 'evolution' => 1.26],
            ['initial' => 220, 'evolution' => 1.275],
            ['initial' => 220, 'evolution' => 1.26],
            ['initial' => 10, 'evolution' => 1.17],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ]
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
        $this->createBuildingTimer($this->buildingMarket,
            ['initial' => 45, 'evolution' => 1.2],
            ['initial' => 100, 'evolution' => 1.25],
            ['initial' => 100, 'evolution' => 1.275],
            ['initial' => 100, 'evolution' => 1.26],
            ['initial' => 20, 'evolution' => 1.17],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ]
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
        $this->createBuildingTimer($this->buildingWood,
            ['initial' => 15, 'evolution' => 1.2],
            ['initial' => 50, 'evolution' => 1.25],
            ['initial' => 60, 'evolution' => 1.275],
            ['initial' => 40, 'evolution' => 1.245],
            ['initial' => 5, 'evolution' => 1.155],
            [
                'hourly' => ['initial' => 30, 'evolution' => 1.17],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ]
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
        $this->createBuildingTimer($this->buildingClay,
            ['initial' => 15, 'evolution' => 1.2],
            ['initial' => 65, 'evolution' => 1.27],
            ['initial' => 50, 'evolution' => 1.265],
            ['initial' => 40, 'evolution' => 1.24],
            ['initial' => 10, 'evolution' => 1.14],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 30, 'evolution' => 1.17],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ]
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
        $this->createBuildingTimer($this->buildingIron,
            ['initial' => 18, 'evolution' => 1.2],
            ['initial' => 75, 'evolution' => 1.252],
            ['initial' => 65, 'evolution' => 1.275],
            ['initial' => 70, 'evolution' => 1.24],
            ['initial' => 10, 'evolution' => 1.17],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 30, 'evolution' => 1.17],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ]
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
        $this->createBuildingTimer($this->buildingFarm,
            ['initial' => 20, 'evolution' => 1.2],
            ['initial' => 45, 'evolution' => 1.3],
            ['initial' => 40, 'evolution' => 1.32],
            ['initial' => 30, 'evolution' => 1.29],
            ['initial' => 0, 'evolution' => 1],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 240, 'evolution' => 1.17]
            ]
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
        $this->createBuildingTimer($this->buildingWarehouse,
            ['initial' => 17, 'evolution' => 1.2],
            ['initial' => 60, 'evolution' => 1.265],
            ['initial' => 50, 'evolution' => 1.27],
            ['initial' => 40, 'evolution' => 1.245],
            ['initial' => 0, 'evolution' => 1.15],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            ['initial' => 1000, 'evolution' => 1.229]
        );

        $this->buildingHide = new WorldBuilding([
            'world_id' => $world->id,
            'name' => 'Cachette',
            'description' => 'Ce bâtiment cache vos ressources des assauts de troupes ennemies, => y compris les éclaireurs.',
            'max_level' => 10,
            'min_level' => 0,
            'default_level' => 0,
        ]);
        $this->buildingHide->save();
        $this->createBuildingTimer($this->buildingHide,
            ['initial' => 30, 'evolution' => 1.2],
            ['initial' => 50, 'evolution' => 1.25],
            ['initial' => 60, 'evolution' => 1.25],
            ['initial' => 50, 'evolution' => 1.25],
            ['initial' => 2, 'evolution' => 1.17],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ]
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
        $this->createBuildingTimer($this->buildingWall,
            ['initial' => 60, 'evolution' => 1.2],
            ['initial' => 50, 'evolution' => 1.26],
            ['initial' => 100, 'evolution' => 1.275],
            ['initial' => 20, 'evolution' => 1.26],
            ['initial' => 5, 'evolution' => 1.17],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ],
            [
                'hourly' => ['initial' => 0, 'evolution' => 0],
                'once' => ['initial' => 0, 'evolution' => 0]
            ]
        );
    }

    private function createBuildingRessourceStorageEvo(WorldBuildingEvolution $level, int $initialStorageOnce, float $factorStorageProd) {
        $storage = $initialStorageOnce;
        for ($i = 0; $i <= $level->level; $i++) {
            if ($i > 1)
            {
                $storage *= $factorStorageProd;
            }
        }
        if ($storage <= 0)
            return ;
        $storageWood = new WorldBuildingStorageEvolution([
            'world_building_evolution_id' => $level->id,
            'world_ressource_id' => $this->ressourceWood->id,
            'amount_per_hour' => 0,
            'amount_once' => intval($storage),
        ]);
        $storageWood->save();
        $storageClay = new WorldBuildingStorageEvolution([
            'world_building_evolution_id' => $level->id,
            'world_ressource_id' => $this->ressourceClay->id,
            'amount_per_hour' => 0,
            'amount_once' => intval($storage),
        ]);
        $storageClay->save();
        $storageIron = new WorldBuildingStorageEvolution([
            'world_building_evolution_id' => $level->id,
            'world_ressource_id' => $this->ressourceIron->id,
            'amount_per_hour' => 0,
            'amount_once' => intval($storage),
        ]);
        $storageIron->save();
    }

    private function createBuildingRessourceProductionEvo(WorldBuildingEvolution $level, WorldRessource $ressource, int $initialProdHourly, float $factorProdHourly, int $initialProdOnce, float $factorProdOnce) {
        $hourly = $initialProdHourly;
        $once = $initialProdOnce;
        for ($i = 0; $i <= $level->level; $i++) {
            if ($i > 1)
            {
                $hourly *= $factorProdHourly;
                $once *= $factorProdOnce;
            }
        }

        if ($once <= 0 && $hourly <= 0)
            return ;

        $production = new WorldBuildingProductionEvolution([
            'world_building_evolution_id' => $level->id,
            'world_ressource_id' => $ressource->id,
            'amount_per_hour' => intval($hourly),
            'amount_once' => intval($once),
        ]);
        $production->save();
    }

    private function createBuildingTimer(WorldBuilding $building, array $time, array $wood, array $clay, array $iron, array $farm, array $prodWood, array $prodClay, array $prodIron, array $prodFarm, array $storage = ['initial' => 0, 'evolution' => 0]) {
        // $this->info('Preparing Evolution of ' . $building->name . ' With Initial Time AT ' . $time['initial'] . ' And Evolution ' . $time['evolution']);
        $t = $time['initial'];
        for ($i = $building->min_level; $i <= $building->max_level; $i++) {
            if ($i >= 1)
                $t *= $time['evolution'];
            // $this->info('Creating evolution for ' . $building->name . ' level ' . $i . ' with time ' . intval($time));

            $level = new WorldBuildingEvolution([
                'world_building_id' => $building->id,
                'level' => $i,
                'duration' => intval($t),
            ]);
            $level->save();
            $this->createBuildingRessourceEvo($level, $this->ressourceWood, $wood['initial'], $wood['evolution']);
            $this->createBuildingRessourceEvo($level, $this->ressourceClay, $clay['initial'], $clay['evolution']);
            $this->createBuildingRessourceEvo($level, $this->ressourceIron, $iron['initial'], $iron['evolution']);
            $this->createBuildingRessourceEvo($level, $this->ressourceFarm, $farm['initial'], $farm['evolution'], true);
            $this->createBuildingRessourceProductionEvo($level, $this->ressourceWood, $prodWood['hourly']['initial'], $prodWood['hourly']['evolution'], $prodWood['once']['initial'], $prodWood['once']['evolution']);
            $this->createBuildingRessourceProductionEvo($level, $this->ressourceIron, $prodIron['hourly']['initial'], $prodIron['hourly']['evolution'], $prodIron['once']['initial'], $prodIron['once']['evolution']);
            $this->createBuildingRessourceProductionEvo($level, $this->ressourceClay, $prodClay['hourly']['initial'], $prodClay['hourly']['evolution'], $prodClay['once']['initial'], $prodClay['once']['evolution']);
            $this->createBuildingRessourceProductionEvo($level, $this->ressourceFarm, $prodFarm['hourly']['initial'], $prodFarm['hourly']['evolution'], $prodFarm['once']['initial'], $prodFarm['once']['evolution']);
            $this->createBuildingRessourceStorageEvo($level, $storage['initial'], $storage['evolution']);
        }
    }

    public function createBuildingRessourceEvo(WorldBuildingEvolution $evolution, WorldRessource $ressources, int $initialNeed, float $multiplicator, bool $isFarm = false) {
        $totalNeed = $farmNeed = $initialNeed;
        for ($i = 0; $i <= $evolution->level; $i++) {
            if ($i > 1)
            {
                $farmNeed = $totalNeed;
                $totalNeed *= $multiplicator;
            }
        }
        if ($totalNeed <= 0)
            return ;

        // $this->info("Creating cost for " . $ressources->name . " with amount " . intval($totalNeed) . " for level " . $evolution->level);
        if ($isFarm)
            $totalNeed -= $farmNeed;
        // $this->info("Creating cost for " . $ressources->name . " with amount " . intval($totalNeed) . " for level " . $evolution->level);


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
        $this->createRessources($newWorld);



        $this->info('Creating new world buildings');
        $this->createBuildings($newWorld);



    }
}
