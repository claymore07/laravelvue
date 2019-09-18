<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchActivity extends Model
{

    protected $table = 'research_activities';
    //
    protected $fillable = [
        'profile_id', 'research_activity_types_id', 'status', 'title',
        'authorities', 'start_date', 'end_date', 'score', 'term_id'
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
    public function ResearchActivityType(){
        return $this->belongsTo(ResearchActivityType::class, 'research_activity_types_id');
    }
    public function term()
    {
        return $this->belongsTo(Term::class);
    }
}
