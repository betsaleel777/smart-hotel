<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSejours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sejours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('debut') ;
            $table->date('fin') ;
            $table->unsignedBigInteger('chambre')->index() ;
            $table->foreign('chambre')->references('id')->on('chambres')->onDelete('cascade') ;
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
        Schema::dropIfExists('sejours');
    }
}
