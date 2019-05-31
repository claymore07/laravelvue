<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Journal extends Model
{
    //
    protected $fillable=[
        'name', 'issn', 'IFactor', 'FIF', 'JCR', 'jtype_id','JRK', 'publisher',
        'city', 'period', 'organizer', 'conf_name','conf_type_name','pissn'
    ];

    //forward
    public function papers(){
        return $this->morphMany('App\Models\Paper', 'paperable');
    }
    public function paper(){
        return $this->morphOne('App\Models\Paper', 'paperable');
    }

    // Backward
    public function jtype(){
        return $this->belongsTo('App\Models\Jtype');
    }
}
