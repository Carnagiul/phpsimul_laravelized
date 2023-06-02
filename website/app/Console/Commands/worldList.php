<?php

namespace App\Console\Commands;

use App\Models\World;
use Illuminate\Console\Command;

class listWorlds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phpsimul:world:list {worldName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'list world from database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *removeWorld
     * @return int
     */
    public function handle()
    {
        $worldName = $this->argument('worldName');

        World::all()->each(function ($world) {
            $this->info($world->name);
        });
    }
}
