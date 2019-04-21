<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grant extends Model
{
    //
    protected $fillable = [
        'title', 'profile_id', 'budget', 'term_id',
        'type','submit_date','score', 'status',
    ];

    // Forward
    public function files(){
        return $this->morphMany(Files::class, 'fileable');
    }
    public function checklists(){
        return $this->morphMany(Checklist::class, 'checkable');
    }

    // Backward
    public function profile(){
        return $this->belongsTo(Profile::class);
    }
    public function term(){
        return $this->belongsTo(Term::class);
    }
    public function scores(){
        return $this->belongsTo(Score::class,'score_id');
    }
}
