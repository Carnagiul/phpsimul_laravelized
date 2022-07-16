<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorldBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();

        Schema::create('world_buildings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('world_id');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->integer('max_level')->default(30)->comment('Maximal level of the building, if 0 then it is unlimited');
            $table->integer('min_level')->default(0)->comment('Minimal level of the building, if 0 then building can be destroyed');
            $table->integer('default_level')->default(0)->comment('Default  level of the building when it is created on node');
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('world_buildings');
    }
}
