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
            $table->unsignedBigInteger('chambre')->index() ;
            $table->unsignedBigInteger('user')->index() ;
            $table->unsignedMediumInteger('quantite') ;
            $table->foreign('produit')->references('id')->on('produits')->onDelete('cascade') ;
            $table->foreign('chambre')->references('id')->on('chambres')->onDelete('cascade') ;
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
