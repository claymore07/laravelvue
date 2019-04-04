<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //
    protected $fillable = [
        'profile_id', 'status', 'title', 'role',
        'organization', 'holding_date', 'duration', 'score'
    ];

    // Forward
    public function checklists(){
        return $this->morphMany('App\Models\Checklist', 'checkable');
    }
    public function files(){
        return $this->morphMany(Files::class, 'fileable');
    }

    // Backward
    public function profile(){
        return $this->belongsTo(Profile::class);
    }
}
