<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Passage extends Model
{
    protected $fillable = ['heure', 'chambre', 'passage', 'repos'];
    protected $dates = ['created_at', 'updated_at'];

    public function chambreLinked()
    {
        return $this->belongsTo(Chambre::class, 'chambre');
    }

    public function attributions_passages()
    {
        return $this->hasOne(AttributionsPassage::class, 'passage');
    }

    public function kind()
    {
        return $this->attributes['passage'] ? 'passage' : 'repos';
    }

}
