<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ConfType
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ConfType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ConfType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ConfType query()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Conference[] $conferences
 */
class ConfType extends Model
{
    //
    protected $fillable=['name'];

    public function conferences(){
        return $this->hasMany('App\Conference');
    }
}
