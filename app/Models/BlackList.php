<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlackList extends Model
{
    //
    protected $table='black_lists';
    protected $fillable = ['title','issn','indexing', 'url','fake_url'];

}
