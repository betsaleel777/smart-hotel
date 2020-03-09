<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDestockages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destockages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('produit')->index() ;
            $table->unsignedBigInteger('attribution_passage')->index()->nullable() ;
            $table->unsignedBigInteger('attribution_sejour')->index()->nullable() ;
            $table->unsignedBigInteger('user')->index()->nullable() ;
            $table->unsignedMediumInteger('quantite') ;
            $table->foreign('produit')->references('id')->on('produits')->onDelete('cascade') ;
            $table->foreign('attribution_sejour')->references('id')->on('attributions_sejours')->onDelete('cascade') ;
            $table->foreign('attribution_passage')->references('id')->on('attributions_passages')->onDelete('cascade') ;
            $table->foreign('user')->references('id')->on('users')->onDelete('cascade') ;
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
        Schema::dropIfExists('destockages');
    }
}
