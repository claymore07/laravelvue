<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventionType extends Model
{
    //
    protected $table = 'invention_types';

    protected $fillable = [
        'name', 'maxscore', 'minscore'
    ];

    // Forward
    public function inventions(){
        return $this->hasMany(Invention::class);
    }
}
