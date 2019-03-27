<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Degree extends Model
{
    //
    protected $fillable=['name'];
    // Forward
    public function profiles(){
        return $this->hasMany('App\Models\Profile');
    }
    public function theses(){
        return $this->hasMany(Thesis::class);
    }
}
