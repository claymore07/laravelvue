<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referee extends Model
{
    //
    protected $fillable = [
        'profile_id', 'referee_types_id', 'title', 'status',
        'score', 'journal_name', 'journal_issn', 'referee_date', 'term_id'
    ];

    // Forward
    public function files(){
        return $this->morphMany(Files::class, 'fileable');
    }
    public function checklists(){
        return $this->morphMany(Checklist::class, 'checkable');
    }

    // Backward
    public function refereeType(){
        return $this->belongsTo(RefereeType::class,'referee_types_id');
    }
    public function profile(){
        return $this->belongsTo(Profile::class);
    }
    public function term()
    {
        return $this->belongsTo(Term::class);
    }
}
