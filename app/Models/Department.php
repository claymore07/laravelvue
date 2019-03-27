<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Department extends Model
{
    //
    protected $fillable=['name'];

    // Forward
    public function profiles(){
        return $this->hasMany('App\Models\Profile');
    }
}
