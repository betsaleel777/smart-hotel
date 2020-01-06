<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProduits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('libelle',100) ;
            $table->string('image',250)->nullable() ;
            $table->unsignedInteger('prix') ;
            $table->unsignedMediumInteger('seuil')->nullable() ;
            $table->string('reference',10)->unique() ;
            $table->unsignedBigInteger('sous_famille')->index() ;
            $table->foreign('sous_famille')->references('id')->on('sous_familles')->onDelete('cascade') ;
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
        Schema::dropIfExists('produits');
    }
}
