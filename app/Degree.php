<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Degree
 *
 * @property int $id
 * @property string $name مدرک
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Profile[] $profiles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Degree whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Degree whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Degree whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Degree whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Degree extends Model
{
    //
    protected $fillable=['name'];
    // Forward
    public function profiles(){
        return $this->hasMany('App\Profile');
    }
}
