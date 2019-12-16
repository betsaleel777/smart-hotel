<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableSejours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sejours', function (Blueprint $table) {
            $table->unsignedBigInteger('client') ;
            $table->foreign('client')->references('id')->on('clients')->onDelete('cascade') ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sejours', function (Blueprint $table) {
            //
        });
    }
}
