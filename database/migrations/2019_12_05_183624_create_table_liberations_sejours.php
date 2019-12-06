<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLiberationsSejours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liberations_sejours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('attribution')->index() ;
            $table->foreign('attribution')->references('id')->on('attributions_sejours')->onDelete('cascade') ;
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
        Schema::dropIfExists('liberations_sejours');
    }
}
