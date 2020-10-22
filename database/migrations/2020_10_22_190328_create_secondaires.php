<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecondaires extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secondaires', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedSmallInteger('quantite') ;
            $table->unsignedBigInteger('user') ;
            $table->unsignedBigInteger('produit') ;
            $table->unsignedBigInteger('departement') ;
            $table->foreign('user')->references('id')->on('users')->onDelete('cascade') ;
            $table->foreign('produit')->references('id')->on('produits')->onDelete('cascade') ;
            $table->foreign('departement')->references('id')->on('departements')->onDelete('cascade') ;
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
        Schema::dropIfExists('secondaires');
    }
}
