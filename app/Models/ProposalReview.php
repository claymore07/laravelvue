<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposalReview extends Model
{
    //
    protected $table = 'proposal_reviews';
    protected $fillable = [
        'research_proposal_id', 'profile_id', 'status', 'comment'
    ];

    // backward
    public function proposal(){
        return $this->belongsTo(ResearchProposal::class,'research_proposal_id');
    }
    public function profile(){
        return $this->belongsTo(Profile::class);
    }
}
