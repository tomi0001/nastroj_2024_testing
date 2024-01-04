<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoodsActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moods_actions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->bigInteger('id_moods')->unsigned();
            $table->foreign("id_moods")->references("id")->on("moods");
            $table->bigInteger('id_actions')->unsigned();
            $table->foreign("id_actions")->references("id")->on("actions");
            $table->smallInteger('percent_executing')->unsigned()->nullable();
            $table->integer('minute_exe')->unsigned()->nullable();
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
        Schema::dropIfExists('moods_actions');
    }
}
