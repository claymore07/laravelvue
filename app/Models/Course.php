<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //
    protected $fillable = [
        'profile_id', 'status', 'title', 'role',
        'organization', 'holding_date', 'duration', 'score', 'term_id'
    ];

    protected static function boot() {
        parent::boot();
        static::deleting(function($course) { // called BEFORE delete()
            $course->checklists()->delete();
            $files = $course->files;
            foreach ($files as $file){
                $file->delete();
            }
        });
    }
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
    public function term(){
        return $this->belongsTo(Term::class);
    }
    public function scores(){
        return $this->belongsTo(Score::class,'score_id');
    }
}
