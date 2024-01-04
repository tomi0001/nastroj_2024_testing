<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->bigInteger("id_users")->unsigned()->nullable();
            //$table->foreign("id_users")->references("id")->on("users");
            $table->string('name')->unique();
            $table->string('email')->nullable();
            $table->tinyInteger('if_true')->nullable();
            $table->string("type",8)->default("user");
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('start_day')->default(0)->nullable();
            $table->smallInteger("minutes")->default(60)->nullable();
            $table->char("hash",36)->nullable();
            $table->char("styles",36)->nullable();
            $table->string('login2')->nullable();
            $table->bigInteger('id_user')->unsigned()->nullable();
            $table->float('level_mood_10',6,2)->nullable();
            $table->float('level_mood_9',6,2)->nullable();
            $table->float('level_mood_8',6,2)->nullable();
            $table->float('level_mood_7',6,2)->nullable();
            $table->float('level_mood_6',6,2)->nullable();
            $table->float('level_mood_5',6,2)->nullable();
            $table->float('level_mood_4',6,2)->nullable();
            $table->float('level_mood_3',6,2)->nullable();
            $table->float('level_mood_2',6,2)->nullable();
            $table->float('level_mood_1',6,2)->nullable();
            $table->float('level_mood0',6,2)->nullable();
            $table->float('level_mood1',6,2)->nullable();
            $table->float('level_mood2',6,2)->nullable();
            $table->float('level_mood3',6,2)->nullable();
            $table->float('level_mood4',6,2)->nullable();
            $table->float('level_mood5',6,2)->nullable();
            $table->float('level_mood6',6,2)->nullable();
            $table->float('level_mood7',6,2)->nullable();
            $table->float('level_mood8',6,2)->nullable();
            $table->float('level_mood9',6,2)->nullable();
            $table->float('level_mood10',6,2)->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
