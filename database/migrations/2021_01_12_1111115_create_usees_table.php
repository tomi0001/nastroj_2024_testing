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
class CreateUseesTable extends Migration {
    public function up()
    {
        Schema::create('usees', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->float('portion')->unsigned();
            $table->bigInteger('id_users')->unsigned();
            $table->foreign("id_users")->references("id")->on("users");
            $table->bigInteger('id_products')->unsigned();
            $table->foreign("id_products")->references("id")->on("products");
            $table->datetime("date");
            //$table->integer("type_of_portion")->unsigned();
            $table->float("price")->unsigned();
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
        Schema::dropIfExists('usees');
    }
}
