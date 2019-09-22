<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Profile extends Model
{
    //
    protected $fillable = [
        'user_id', 'Fname', 'Lname', 'base', 'degree_id', 'rank_id',
        'position_id', 'faculty_id', 'department_id', 'member_id',
        'phone', 'siba', 'personal_id',
    ];

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
    public function grants(){
        return $this->hasMany(Grant::class);
    }
    public function courses(){
        return $this->hasMany(Course::class);
    }
    public function referees(){
        return $this->hasMany(Referee::class);
    }
    public function researchActivity(){
        return $this->hasMany(ResearchActivity::class);
    }
    public function researchProposals(){
        return $this->hasMany(ResearchProposal::class);
    }
    public function ProposalReviews(){
        return $this->hasMany(ProposalReview::class);
    }

    // Backward Relations
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function rank(){
        return $this->belongsTo('App\Models\Rank');
    }
    public function degree(){
        return $this->belongsTo('App\Models\Degree');
    }
    public function position(){
        return $this->belongsTo('App\Models\Position');
    }
    public function faculty(){
        return $this->belongsTo('App\Models\Faculty');
    }
    public function department(){
        return $this->belongsTo('App\Models\Department');
    }
    public function member(){
        return $this->belongsTo('App\Models\Member');
    }
}
