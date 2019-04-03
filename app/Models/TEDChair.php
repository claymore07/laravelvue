<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TEDChair extends Model
{
    //
    protected $table = 'tedchairs';
    protected $fillable = [
      'title', 'profile_id', 'ted_types_id', 'location',
        'council_aprovedate', 'status', 'score', 'presentation_date'
    ];

    // Forward
    public function files(){
        return $this->morphMany(Files::class, 'fileable');
    }
    public function checklists(){
        return $this->morphMany(Checklist::class, 'checkable');
    }


    // Backward
    public function TEDType(){
        return $this->belongsTo(TEDType::class,'ted_types_id');
    }
    public function profile(){
        return $this->belongsTo(Profile::class);
    }

    public function getRouteKeyName()
    {
        return 'id'; // TODO: Change the autogenerated stub
    }
}
