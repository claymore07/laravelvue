<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposalUsage extends Model
{
    //
    protected $table = 'proposal_usages';
    protected $fillable = [
        'name'
    ];

    // Forward
    public function proposals(){
        return $this->hasMany(ResearchProposal::class);
    }
}
