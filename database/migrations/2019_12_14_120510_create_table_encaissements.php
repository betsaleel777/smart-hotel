<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEncaissements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encaissements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference')->unique() ;
            $table->string('passage_nature',15)->nullable() ;
            $table->unsignedSmallInteger('quantite') ;
            $table->unsignedInteger('prix_unitaire') ;
            $table->unsignedBigInteger('user')->index()->nullable() ;
            $table->unsignedTinyInteger('remise')->nullable() ;
            $table->unsignedTinyInteger('avance')->nullable() ;
            $table->unsignedBigInteger('client')->index()->nullable() ;
            $table->unsignedBigInteger('passage')->index()->nullable() ;
            $table->unsignedBigInteger('sejour')->index()->nullable() ;
            $table->foreign('user')->references('id')->on('users')->onDelete('cascade') ;
            $table->foreign('client')->references('id')->on('clients')->onDelete('cascade') ;
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
        Schema::dropIfExists('encaissements');
    }
}
