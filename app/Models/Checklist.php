<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    //
    protected $fillable=[
        'list','comment','checkable_type', 'checkable_id'
    ];
    public function checkable(){
        return $this->morphto();
    }
}
