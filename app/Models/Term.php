<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    //
    protected $fillable = [
      'name', 'status', 'starts_at', 'ends_at'
    ];
}
