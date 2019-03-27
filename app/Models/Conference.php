<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    //
    protected $fillable=['name','organizer','conftype_id', 'period', 'city'];

    //forward
    public function papers(){
        return $this->morphMany('App\Models\Paper', 'paperable');
    }

    //backward
    public function conftype(){
        return $this->belongsTo('App\Models\ConfType');
    }
}
