<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRestaurations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedMediumInteger('quantite') ;
            $table->unsignedBigInteger('produit')->index() ;
            $table->unsignedBigInteger('passage')->index()->nullable() ;
            $table->unsignedBigInteger('sejour')->index()->nullable() ;
            $table->foreign('produit')->references('id')->on('produits')->onDelete('cascade') ;
            $table->foreign('sejour')->references('id')->on('attributions_sejours')->onDelete('cascade') ;
            $table->foreign('passage')->references('id')->on('attributions_passages')->onDelete('cascade') ;
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
        Schema::dropIfExists('restaurations');
    }
}
