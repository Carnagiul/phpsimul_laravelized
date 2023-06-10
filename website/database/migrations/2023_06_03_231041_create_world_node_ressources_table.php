<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorldNodeRessourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('world_node_ressources', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('world_node_id');
            $table->unsignedBigInteger('world_ressource_id');
            $table->integer('amount');

            $table->foreign('world_node_id')->references('id')->on('world_nodes')->onDelete('cascade');
            $table->foreign('world_ressource_id')->references('id')->on('world_ressources')->onDelete('cascade');

            $table->unique(['world_node_id', 'world_ressource_id'], 'world_node_ressources_unique');
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
        Schema::dropIfExists('world_node_ressources');
    }
}
