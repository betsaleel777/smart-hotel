<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableChambres extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chambres', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('libelle',150) ;
            $table->string('statut',150)->default('inoccupée') ;
            $table->unsignedBigInteger('batiment')->index() ;
            $table->foreign('batiment')->references('id')->on('batiments')->onDelete('cascade') ;
            $table->softDeletes() ;
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
        Schema::dropIfExists('chambres');
    }
}
