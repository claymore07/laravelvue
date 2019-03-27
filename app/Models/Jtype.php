<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Jtype extends Model
{
    //
    protected $fillable=[
        'name', 'minscore', 'maxscore'
    ];

    // Forward
    public function journals(){
        return $this->hasMany('App\Models\Journal');
    }
}
