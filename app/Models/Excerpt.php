<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Excerpt
 *
 * @property int $id
 * @property string $name مستخرج از
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Paper[] $papers
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Excerpt whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Excerpt whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Excerpt whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Excerpt whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Excerpt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Excerpt newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Excerpt query()
 */
class Excerpt extends Model
{
    //
    protected $fillable=['name'];

    // Forward
    public function papers(){
        return $this->hasMany('App\Models\Paper');
    }
}
