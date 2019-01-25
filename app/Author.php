<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Author
 *
 * @property int $id
 * @property string $name نام نویسنده
 * @property int $paper_id شماره مقاله
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Paper $papers
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author wherePaperId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $corresponding
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereCorresponding($value)
 * @property string|null $affiliation
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereAffiliation($value)
 * @property string $authorableType
 * @property int $authorableId
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $authorable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereAuthorableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereAuthorableType($value)
 */
class Author extends Model
{
    //
    protected $fillable=[
      'name','paperable_id', 'paperable_type', 'corresponding','affiliation'
    ];

    // Backward
    public function authorable(){
         return $this->morphTo();
    }
}
