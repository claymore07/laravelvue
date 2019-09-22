<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposalType extends Model
{
    //
    protected $table = 'proposal_types';
    protected $fillable = [
      'name'
    ];

    // Forward
    public function proposals(){
        return $this->hasMany(ResearchProposal::class);
    }


}
