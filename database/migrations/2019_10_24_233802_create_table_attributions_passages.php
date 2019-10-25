<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAttributionsPassages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributions_passages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('batiment')->index() ;
            $table->unsignedBigInteger('passage')->index() ;
            $table->foreign('batiment')->references('id')->on('batiments')->onDelete('cascade') ;
            $table->foreign('passage')->references('id')->on('passages')->onDelete('cascade') ;
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
        Schema::dropIfExists('attributions_passages');
    }
}
