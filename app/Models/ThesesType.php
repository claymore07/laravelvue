<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThesesType extends Model
{
    //
    protected $table = 'theses_types';

    protected $fillable = [
        'name', 'maxscore', 'minscore'
    ];

    // Forward
    public function theses(){
        return $this->hasMany(Thesis::class, 'theses_types_id');
    }
}
