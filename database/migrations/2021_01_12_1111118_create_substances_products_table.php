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
class CreateSubstancesProductsTable extends Migration {
    public function up()
    {
        Schema::create('substances_products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->bigInteger('id_substances')->unsigned();
            $table->foreign("id_substances")->references("id")->on("substances");
            $table->bigInteger('id_products')->unsigned();
            $table->foreign("id_products")->references("id")->on("products");
            $table->float('doseProduct')->unsigned()->nullable();
            $table->tinyInteger('Mg_Ug')->default(1)->unsigned();
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
        Schema::dropIfExists('substances_products');
    }
}
