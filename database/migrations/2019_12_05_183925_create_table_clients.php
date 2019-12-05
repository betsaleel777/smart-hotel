<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id') ;
            $table->string('nom',60) ;
            $table->string('prenom',150) ;
            $table->unsignedBigInteger('piece')->index() ;
            $table->string('numero_piece') ;
            $table->string('contact',20)->unique() ;
            $table->foreign('piece')->references('id')->on('types_pieces')->onDelete('cascade') ;
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
        Schema::dropIfExists('clients');
    }
}
