<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLiberationsPassage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liberations_passages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('attribution')->index() ;
            $table->foreign('attribution')->references('id')->on('attributions_passages')->onDelete('cascade') ;
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
        Schema::dropIfExists('liberations_passages');
    }
}
