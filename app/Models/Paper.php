<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Paper
 *
 * @property int $id
 * @property int $lang
 * @property string|null $fa_title
 * @property string|null $en_title
 * @property int $profile_id
 * @property string|null $fa_text
 * @property string|null $en_text
 * @property string|null $doi
 * @property string|null $link
 * @property string $datetype
 * @property string|null $accept_date
 * @property string|null $publish_date
 * @property int|null $status
 * @property int $excerpt_id
 * @property string|null $license
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Author[] $authors
 * @property-read \App\Checklist $checklist
 * @property-read \App\Excerpt $excerpt
 * @property-read \App\Journal $journal
 * @property-read \App\Profile $profile
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paper whereAcceptDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paper whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paper whereDatetype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paper whereDoi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paper whereEnText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paper whereEnTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paper whereExcerptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paper whereFaText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paper whereFaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paper whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paper whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paper whereLicense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paper whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paper whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paper wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paper whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paper whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $paperableType
 * @property int $paperableId
 * @property int|null $licenseTo نوع مجوز
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paper newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paper newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paper query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paper whereLicenseTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paper wherePaperableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paper wherePaperableType($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Files[] $files
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $paperable
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Tag[] $tags
 */
class Paper extends Model
{
    //
    protected $fillable=[
        'title', 'abstract', 'profile_id', 'doi','link', 'paperable_id', 'paperable_type',
        'accept_date','score','status', 'publish_date', 'excerpt_id', 'license','license_to', 'lang'
    ];

    // Forward
    public function authors(){
        return $this->morphMany('App\Models\Author', 'authorable');
    }
    public function author(){
        return $this->morphOne('App\Models\Author', 'authorable');
    }
    public function files(){
        return $this->morphMany('App\Models\Files', 'fileable');
    }
    public function checklists(){
        return $this->morphMany('App\Models\Checklist', 'checkable');
    }
    public function tags(){
        return $this->morphMany('App\Models\Tag', 'taggable');
    }


    // Backward
    public function paperable(){
        return $this->morphTo();
    }
    public function profile(){
        return $this->belongsTo('App\Models\Profile');
    }
    public function excerpt(){
        return $this->belongsTo('App\Models\Excerpt');
    }

}
