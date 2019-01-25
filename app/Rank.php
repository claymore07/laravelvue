<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Rank
 *
 * @property int $id
 * @property string $name رتبه علمی
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Profile[] $profiles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rank whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rank whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rank query()
 */
class Rank extends Model
{
    //
    protected $fillable=['name'];
    // Forward
    public function profiles(){
        return $this->hasMany('App\Profile');
    }
}
