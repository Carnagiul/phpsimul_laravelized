<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorldBuildingEvolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();

        Schema::create('world_building_evolutions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('world_building_id');
            $table->unsignedInteger('level');
            $table->unsignedInteger('duration');
            $table->foreign('world_building_id')->references('id')->on('world_buildings')->onDelete('cascade');
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
        Schema::dropIfExists('world_building_evolutions');
    }
}
