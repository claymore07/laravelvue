<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class BookType extends Model
{
    //
    protected $table = 'booktypes';

    protected $fillable = [
        'name', 'maxscore', 'minscore'
    ];

    public function books(){
        return $this->hasMany(Book::class);
    }
}
