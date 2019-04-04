<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefereeType extends Model
{
    //
    protected $fillable = [
        'name', 'maxscore', 'minscore'
    ];

    // Forward
    public function referees(){
        return $this->hasMany(Referee::class);
    }
}
