<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Thesis extends Model
{
    //
    protected $fillable = [
        'profile_id', 'degree_id', 'status', 'title', 'responsible',
        'group_aprovedate', 'council_aprovedate', 'code_date',
        'defense_edate', 'score'
    ];

    // Backward
    public function profile(){
        return $this->belongsTo(Profile::class);
    }
    public function degree(){
        return $this->belongsTo(Degree::class);
    }
}
