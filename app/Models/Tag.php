<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Tag extends Model
{
    //
    protected $fillable=['name' , 'taggable_id', 'taggable_type'];

    // backward
    public function taggable(){
        return $this->morphTo();
    }
}
