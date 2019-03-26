<?php

namespace App\Models;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Degree newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Degree newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Degree query()
 */
class Degree extends Model
{
    //
    protected $fillable=['name'];
    // Forward
    public function profiles(){
        return $this->hasMany('App\Models\Profile');
    }
}
