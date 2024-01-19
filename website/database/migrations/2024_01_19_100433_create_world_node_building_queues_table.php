<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorldNodeBuildingQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('world_node_building_queues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('world_node_id');
            $table->unsignedBigInteger('world_building_id');
            $table->timestamp('start_at');
            $table->unsignedBigInteger('remaining');
            $table->unsignedInteger('level');
            $table->unsignedBigInteger('position')->default(0);
            $table->timestamps();

            $table->foreign('world_node_id')->references('id')->on('world_nodes')->onDelete('cascade');
            $table->foreign('world_building_id')->references('id')->on('world_buildings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('world_node_building_queues');
    }
}
