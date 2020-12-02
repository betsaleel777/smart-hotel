<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRestaurationsAddLatableColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurations', function (Blueprint $table) {
            $table->unsignedBigInteger('latable')->nullable();
            $table->foreign('latable')->references('id')->on('tables')->onDelete('cascade');
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
