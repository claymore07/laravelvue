<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $fillable=[
        'profile_id', 'project_types_id', 'status', 'title', 'organization',
        'budget', 'council_aprovedate', 'defense_date', 'score'
    ];

    // Forward
    public function authors(){
        return $this->morphMany( Author::class, 'authorable');
    }
    public function author(){
        return $this->morphOne( Author::class, 'authorable');
    }
    public function files(){
        return $this->morphMany(Files::class, 'fileable');
    }
    public function checklists(){
        return $this->morphMany(Checklist::class, 'checkable');
    }


    // Backward
    public function projectType(){
        return $this->belongsTo(ProjectType::class,'project_types_id');
    }
    public function profile(){
        return $this->belongsTo(Profile::class);
    }
}
