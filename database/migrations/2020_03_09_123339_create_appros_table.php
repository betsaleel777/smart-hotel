<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvisionnements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user')->index()->nullable() ;
            $table->unsignedBigInteger('produit')->index() ;
            $table->unsignedMediumInteger('quantite') ;
            $table->foreign('user')->references('id')->on('users')->onDelete('cascade') ;
            $table->foreign('produit')->references('id')->on('produits')->onDelete('cascade') ;
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
        Schema::dropIfExists('approvisionnements');
    }
}
