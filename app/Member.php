<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Member
 *
 * @property int $id
 * @property string $name عضویت در باشگاه
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Profile[] $profiles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member query()
 */
class Member extends Model
{
    //
    protected $fillable=['name'];
    // Forward
    public function profiles(){
        return $this->hasMany('App\Profile');
    }
}
