<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TEDType extends Model
{
    //
    protected $table = 'ted_types';

    protected $fillable = [
        'name', 'maxscore', 'minscore'
    ];

    // Forward
    public function TEDChairs(){
        return $this->hasMany(TEDChair::class);
    }
}
