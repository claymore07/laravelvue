<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Paper extends Model
{
    //
    protected $fillable=[
        'title', 'abstract', 'profile_id', 'doi','link', 'paperable_id', 'paperable_type',
        'accept_date','status', 'reward', 'publish_date', 'excerpt_id', 'license','license_to', 'lang',
        'score', 'term_id','isresponsible', 'author_count', 'author_place'
    ];

    protected static function boot() {
        parent::boot();
        static::deleting(function($paper) { // called BEFORE delete()
            $files = $paper->files;
            $paper->tags()->delete();
            $paper->authors()->delete();
            $paper->checklists()->delete();
            $paper->paperable->delete();
            foreach ($files as $file){
                $file->delete();
            }
        });
    }

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
    public function term(){
        return $this->belongsTo(Term::class);
    }


}
