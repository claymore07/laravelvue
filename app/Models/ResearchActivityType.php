<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchActivityType extends Model
{
    protected $table = 'research_activity_types';

    protected $fillable = [
        'name', 'maxscore', 'minscore'
    ];

    // Forward
    public function researchActivities(){
        return $this->hasMany(ResearchActivity::class);
    }
}
