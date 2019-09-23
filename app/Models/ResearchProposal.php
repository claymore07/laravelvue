<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchProposal extends Model
{
    //
    protected $table = 'research_proposals';
    protected $fillable = [
        'profile_id', 'proposal_type_id', 'proposal_usage_id', 'faculty_id', 'title', 'en_title',
        'abstract', 'introduction', 'problem', 'innovation', 'requirements', 'status',
        'value', 'budget', 'duration', 'project_location'
    ];

    protected static function boot() {
        parent::boot();
        static::deleting(function($researchProposal) { // called BEFORE delete()
            $researchProposal->authors()->delete();
            $files = $researchProposal->files;
            foreach ($files as $file){
                $file->delete();
            }
        });
    }

    // Forward
    public function authors(){
        return $this->morphMany( Author::class, 'authorable');
    }
    public function author(){
        return $this->morphOne( Author::class, 'authorable');
    }
    public function files(){
        return $this->morphMany(Files::class, 'fileable');
    }
    public function reviews(){
        return $this->hasMany(ProposalReview::class, 'research_proposal_id');
    }

    // Backward
    public function proposalType(){
        return $this->belongsTo(ProposalType::class,'proposal_type_id');
    }
    public function proposalUsage(){
        return $this->belongsTo(ProposalUsage::class,'proposal_usage_id');
    }
    public function faculty(){
        return $this->belongsTo(Faculty::class);
    }
    public function profile(){
        return $this->belongsTo(Profile::class);
    }
}
