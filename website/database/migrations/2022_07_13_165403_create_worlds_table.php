<?php

use App\Models\World;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('worlds', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_dev')->default(false);
            $table->string('name', 255);
            $table->longText('description')->nullable();
            $table->timestamp('register_at')->nullable();
            $table->timestamp('open_at')->nullable();
            $table->timestamp('close_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
        $newWorld = new World();
        $newWorld->name = 'Dev World';
        $newWorld->is_dev = true;
        $newWorld->description = 'This is a dev world';
        $newWorld->register_at = now()->subSecond();
        $newWorld->open_at = now();
        $newWorld->close_at = null;
        $newWorld->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('worlds');
    }
}
