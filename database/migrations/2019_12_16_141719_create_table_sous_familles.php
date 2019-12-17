<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSousFamilles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sous_familles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('libelle',100) ;
            $table->unsignedBigInteger('famille')->index() ;
            $table->foreign('famille')->references('id')->on('familles')->onDelete('cascade') ;
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
        Schema::dropIfExists('sous_familles');
    }
}
