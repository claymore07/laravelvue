<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    //
    protected $fillable = [
        'profile_id', 'name', 'type', 'title',
        'place', 'period', 'holding_date', 'score', 'status'
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
