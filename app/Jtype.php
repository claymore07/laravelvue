<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Jtype
 *
 * @property int $id
 * @property string $name نوع ژونال
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Journal[] $journals
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jtype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jtype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jtype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jtype whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jtype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jtype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jtype query()
 */
class Jtype extends Model
{
    //
    protected $fillable=[
        'name', 'minscore', 'maxscore'
    ];

    // Forward
    public function journals(){
        return $this->hasMany('App\Journal');
    }
}
