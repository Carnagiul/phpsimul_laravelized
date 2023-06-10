<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorldRessourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();

        Schema::create('world_ressources', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('world_id');
            $table->string('name', 50);
            $table->longText('description')->nullable();
            $table->integer('default_amount')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['world_id', 'name']);
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
        Schema::dropIfExists('world_ressources');
    }
}
