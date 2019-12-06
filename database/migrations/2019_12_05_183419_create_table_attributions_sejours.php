<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAttributionsSejours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributions_sejours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('batiment')->index() ;
            $table->unsignedBigInteger('sejour')->index() ;
            $table->string('etat',20)->nullable() ;
            $table->foreign('batiment')->references('id')->on('batiments')->onDelete('cascade') ;
            $table->foreign('sejour')->references('id')->on('sejours')->onDelete('cascade') ;
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
        Schema::dropIfExists('attributions_sejours');
    }
}
