<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    //
    protected $fillable=[
      'name','paperable_id', 'paperable_type', 'corresponding','affiliation'
    ];

    // Backward
    public function authorable(){
         return $this->morphTo();
    }
}
