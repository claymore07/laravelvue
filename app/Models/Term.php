<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Term extends Model
{
    //
    protected $fillable = [
      'name', 'status', 'starts_at', 'ends_at'
    ];
    protected $dates =['starts_at', 'ends_at'];
    //forward

    // Forward Relations
    public function papers(){
        return $this->hasMany(Paper::class);
    }
    public function books(){
        return $this->hasMany(Book::class);
    }
    public function theses(){
        return $this->hasMany(Thesis::class);
    }
    public function booklets(){
        return $this->hasMany(Booklet::class);
    }
    public function inventions(){
        return $this->hasMany(Invention::class);
    }
    public function projects(){
        return $this->hasMany(Project::class);
    }
    public function rewards(){
        return $this->hasMany(Reward::class);
    }
    public function tedChairs(){
        return $this->hasMany(TEDChair::class);
    }
    public function courses(){
        return $this->hasMany(Course::class);
    }
    public function referees(){
        return $this->hasMany(Referee::class);
    }
}
