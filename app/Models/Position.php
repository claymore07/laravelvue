<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Position
 *
 * @property int $id
 * @property string $name نوع همکاری
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Profile[] $profiles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position query()
 */
class Position extends Model
{
    //
    protected $fillable=['name'];
    // Forward
    public function profiles(){
        return $this->hasMany('App\Models\Profile');
    }
}
