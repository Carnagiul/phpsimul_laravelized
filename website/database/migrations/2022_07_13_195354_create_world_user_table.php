<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorldUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('world_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('world_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('world_id')->references('id')->on('worlds')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('world_user');
    }
}
