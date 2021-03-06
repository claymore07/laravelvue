<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    //
    protected $fillable = [
        'profile_id', 'name', 'type', 'title',
        'place', 'period', 'holding_date', 'score', 'status', 'term_id'
    ];

    protected static function boot() {
        parent::boot();
        static::deleting(function($reward) { // called BEFORE delete()
            $reward->checklists()->delete();
            $files = $reward->files;
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
    public function term()
    {
        return $this->belongsTo(Term::class);
    }
    public function scores(){
        return $this->belongsTo(Score::class,'score_id');
    }
}
