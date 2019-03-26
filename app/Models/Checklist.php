<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Checklist
 *
 * @property int $id
 * @property string|null $fields
 * @property int $paper_id
 * @property string|null $result
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Paper $papers
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Checklist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Checklist whereFields($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Checklist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Checklist wherePaperId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Checklist whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Checklist whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Checklist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Checklist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Checklist query()
 */
class Checklist extends Model
{
    //
    protected $fillable=[
        'list','comment','checkable_type', 'checkable_id'
    ];
    public function checkable(){
        return $this->morphto();
    }
}
