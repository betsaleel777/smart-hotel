<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRestaurations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurations', function (Blueprint $table) {
            $table->unsignedBigInteger('departement')->nullable();
            $table->foreign('departement')->references('id')->on('departements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurations', function (Blueprint $table) {
            //
        });
    }
}
