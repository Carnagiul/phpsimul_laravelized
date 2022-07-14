<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorldBuildingProductionEvolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('world_building_production_evolutions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('world_building_evolution_id');
            $table->unsignedBigInteger('world_ressource_id');
            $table->unsignedInteger('amount_per_hour');
            $table->unsignedInteger('amount_once');
            $table->foreign('world_ressource_id')->references('id')->on('world_ressources')->onDelete('cascade');
            $table->foreign('world_building_evolution_id')->references('id')->on('world_building_evolutions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('world_building_production_evolutions');
    }
}
