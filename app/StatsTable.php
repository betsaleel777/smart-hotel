<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatsTable extends Model
{
    protected $fillable = ['encaissement','nombre'] ;
    protected $dates = ['created_at','updated_at'] ;
    protected $table = 'stats_table' ;
}
