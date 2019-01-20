<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Department
 *
 * @property int $id
 * @property string $name نام گروه
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Profile[] $profiles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Department extends Model
{
    //
    protected $fillable=['name'];

    // Forward
    public function profiles(){
        return $this->hasMany('App\Profile');
    }
}
