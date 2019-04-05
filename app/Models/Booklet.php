<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booklet extends Model
{
    //
    protected $fillable = [
        'profile_id', 'degree_id', 'status',
        'title', 'name', 'compilation_date', 'score'
    ];

    // Forward
    public function files(){
        return $this->morphMany(Files::class, 'fileable');
    }
    public function checklists(){
        return $this->morphMany('App\Models\Checklist', 'checkable');
    }
    // Backward
    public function profile(){
        return $this->belongsTo(Profile::class);
    }
    public function degree(){
        return $this->belongsTo(Degree::class);
    }
}
