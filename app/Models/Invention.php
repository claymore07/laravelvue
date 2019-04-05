<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invention extends Model
{
    //
    protected $fillable = [
        'profile_id', 'invention_types_id', 'status', 'title', 'post',
        'authorities', 'affiliation', 'license', 'registration_number',
        'company_name', 'company_type', 'company_address', 'submit_date', 'score'
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
    public function inventionType(){
        return $this->belongsTo(InventionType::class, 'invention_types_id');
    }
}
