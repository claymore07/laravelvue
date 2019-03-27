<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfType extends Model
{
    //
    protected $table='conftypes';
    protected $fillable=[
        'name', 'minscore', 'maxscore'
    ];

    public function conferences(){
        return $this->hasMany('App\Models\Conference');
    }
}
