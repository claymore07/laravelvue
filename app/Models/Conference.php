<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    //
    protected $fillable=[
        'name','organizer','conftype_id', 'period', 'city','presentation_type'
    ];

    //forward
    public function papers(){
        return $this->morphMany('App\Models\Paper', 'paperable');
    }
    public function paper(){
        return $this->morphOne('App\Models\Paper', 'paperable');
    }

    //backward
    public function conftype(){
        return $this->belongsTo('App\Models\ConfType');
    }
}
