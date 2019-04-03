<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectType extends Model
{
    //
    protected $table ='project_types';
    protected $fillable =[
        'name', 'maxscore', 'minscore'
    ];

    // Forward
    public function projects(){
        return $this->hasMany(Project::class);
    }
}
