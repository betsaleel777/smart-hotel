<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelsInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom');
            $table->string('region')->nullable();
            $table->string('ville');
            $table->string('quartier');
            $table->string('repere')->nullable();
            $table->string('phone')->unique();
            $table->string('email')->unique()->nullable();
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
        Schema::dropIfExists('hotels_infos');
    }
}
