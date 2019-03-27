<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Excerpt extends Model
{
    //
    protected $fillable=['name'];

    // Forward
    public function papers(){
        return $this->hasMany(Paper::class);
    }
    public function books(){
        return $this->hasMany(Book::class);
    }
}
