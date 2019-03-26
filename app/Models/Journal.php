<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Journal
 *
 * @property int $id
 * @property string|null $name نام ژونال
 * @property string|null $publisher
 * @property string|null $issn شماره ISSN
 * @property string|null $conf_name
 * @property int|null $period
 * @property string|null $organizer
 * @property string|null $city
 * @property string|null $IF
 * @property string|null $JCR
 * @property int|null $JRK
 * @property int $paper_id
 * @property int $jtype_id شماره نوع ژونال
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Jtype $jtype
 * @property-read \App\Paper $paper
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal whereConfName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal whereIF($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal whereIssn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal whereJCR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal whereJRK($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal whereJtypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal whereOrganizer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal wherePaperId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal wherePublisher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $pissn
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal wherePissn($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Paper[] $papers
 */
class Journal extends Model
{
    //
    protected $fillable=[
        'name', 'issn', 'IFactor', 'FIF', 'JCR', 'jtype_id','JRK', 'publisher',
        'city', 'period', 'organizer', 'conf_name','conf_type_name','pissn'
    ];

    //forward
    public function papers(){
        return $this->morphMany('App\Models\Paper', 'paperable');
    }

    // Backward
    public function jtype(){
        return $this->belongsTo('App\Models\Jtype');
    }
}
