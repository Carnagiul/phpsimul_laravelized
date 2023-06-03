<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorldNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('world_nodes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('world_id');
            $table->nullableMorphs('owner');
            $table->string('name', 64);
            $table->integer('x');
            $table->integer('y');
            $table->integer('z')->nullable();
            $table->integer('w')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['world_id', 'x', 'y', 'z', 'w'], 'world_nodes_pos_unique');
            $table->foreign('world_id')->references('id')->on('worlds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('world_nodes');
    }
}
