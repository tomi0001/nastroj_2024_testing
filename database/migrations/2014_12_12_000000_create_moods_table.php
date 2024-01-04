<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moods', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->bigInteger('id_users')->unsigned();
            $table->foreign("id_users")->references("id")->on("users");
            $table->dateTime('date_start');
            $table->dateTime('date_end');
            $table->float('level_mood',6,2)->nullable();
            $table->float('level_anxiety',6,2)->nullable();
            $table->float('level_nervousness',6,2)->nullable();
            $table->float('level_stimulation',6,2)->nullable();
            $table->smallInteger('epizodes_psychotik')->default(0);
            $table->text('what_work')->nullable();
            $table->enum('type', ['mood', 'sleep'])->default("mood");
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
        Schema::dropIfExists('moods');
    }
}
