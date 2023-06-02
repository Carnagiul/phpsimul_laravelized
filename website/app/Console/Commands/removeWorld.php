<?php

namespace App\Console\Commands;

use App\Models\World;
use Illuminate\Console\Command;

class removeWorld extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phpsimul:world:remove {worldName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'remove world from database';

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
     *
     * @return int
     */
    public function handle()
    {
        $worldName = $this->argument('worldName');

        $this->info('remove world ' . $worldName);

        $world = World::where('name', '=', $worldName)->first();
        if ($world == null) {
            $this->error('World not found');
            return 1;
        }

        $world->forceDelete();

    }
}
