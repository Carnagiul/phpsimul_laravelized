<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorldBuildingRequirementBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('world_building_requirement_buildings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('world_building_id');
            $table->unsignedBigInteger('required_world_building_id');
            $table->integer('level')->default(1);

            $table->timestamps();

            $table->foreign('world_building_id')->references('id')->on('world_buildings')->onDelete('cascade');
            $table->foreign('required_world_building_id', 'req_build_id')->references('id')->on('world_buildings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('world_building_requirement_buildings');
    }
}
