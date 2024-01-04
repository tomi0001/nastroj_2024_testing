<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
/**
 * Description of 2021_01_12_1111111_create_groups_table
 *
 * @author tomi
 */
class CreateUsersDescriptionsTable extends Migration {
    public function up()
    {
        Schema::create('users_descriptions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->bigInteger('id_usees')->unsigned();
            $table->foreign("id_usees")->references("id")->on("usees");
            $table->bigInteger('id_descriptions')->unsigned();
            $table->foreign("id_descriptions")->references("id")->on("descriptions");
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
        Schema::dropIfExists('users_descriptions');
    }
}
