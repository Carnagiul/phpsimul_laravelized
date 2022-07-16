<?php

namespace App\Console\Commands;

use App\Http\Controllers\UserInterface;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Console\Command;

class setUserToAdministrator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phpsimul:user:setAdmin {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set an user admin';

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
        $user = $this->argument('user');
        if (!is_numeric($user)) {
            $this->error('Argument must be an user id');
            return 1;
        }
        $user = User::find($user);
        if (!$user) {
            $this->error('User not found');
            return 1;
        }
        $permission = Permission::where('permission', '=', 'administrate-all')->first();
        if ($permission == null) {
            $this->error('Permission administrate-all not found');
            return 1;
        }

        if (app(UserInterface::class)->verifyPermissionOfUser($user, $permission)) {
            $this->error('User already has permission administrate-all');
            return 1;
        }
        app(UserInterface::class)->addPermissionToUser($user, $permission);
        $this->info('User ' . $user->id . ' is now an administrator');
        return 0;
    }
}
