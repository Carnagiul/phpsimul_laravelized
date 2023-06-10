<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorldNodeBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('world_node_buildings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('world_node_id');
            $table->unsignedBigInteger('world_building_id');
            $table->integer('level')->default(0);
            $table->foreign('world_node_id')->references('id')->on('world_nodes')->onDelete('cascade');
            $table->foreign('world_building_id')->references('id')->on('world_buildings')->onDelete('cascade');
            $table->unique(['world_node_id', 'world_building_id'], 'world_node_buildings_unique');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('world_node_buildings');
    }
}
