<?php

use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('permission')->unique();
            $table->timestamps();
        });

        Permission::create(['permission' => 'administrate-all']);
        Permission::create(['permission' => 'administrate-users']);
        Permission::create(['permission' => 'administrate-worlds']);
        Permission::create(['permission' => 'administrate-permissions']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
