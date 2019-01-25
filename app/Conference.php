<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Conference
 *
 * @property int $id
 * @property int $conftypeId شناسه نوع کنفرانس
 * @property string $name نام کنفرانس
 * @property string $organizer برگزار کننده کنفرانس
 * @property string $city شهر برگزاری
 * @property int $period دوره برگزاری
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conference newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conference newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conference query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conference whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conference whereConftypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conference whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conference whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conference whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conference whereOrganizer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conference wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Conference whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $conftypeId شناسه نوع کنفرانس
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property int $conftypeId شناسه نوع کنفرانس
 * @property \Illuminate\Support\Carbon|null $createdAt
 * @property \Illuminate\Support\Carbon|null $updatedAt
 * @property-read \App\ConfType $conftype
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Paper[] $papers
 */
class Conference extends Model
{
    //
    protected $fillable=['name','organizer','conftype_id', 'period', 'city'];

    //forward
    public function papers(){
        return $this->morphMany('App\Paper', 'paperable');
    }

    //backward
    public function conftype(){
        return $this->belongsTo('App\ConfType');
    }
}
