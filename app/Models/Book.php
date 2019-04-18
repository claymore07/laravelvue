<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Book extends Model
{
    //
    protected $fillable = [
        'booktype_id', 'profile_id', 'excerpt_id', 'status', 'title', 'isbn',
        'subject', 'publisher', 'edited', 'edited_number', 'publish_number',
        'publish_year', 'pages', 'copy_number','national_code', 'congress_code', 'dewey_code', 'score', 'term_id'
    ];

    // Forward
    public function authors(){
        return $this->morphMany( Author::class, 'authorable');
    }
    public function author(){
        return $this->morphOne( Author::class, 'authorable');
    }
    public function files(){
        return $this->morphMany(Files::class, 'fileable');
    }
    public function checklists(){
        return $this->morphMany(Checklist::class, 'checkable');
    }


    // Backward
    public function booktype(){
        return $this->belongsTo(BookType::class);
    }
    public function profile(){
        return $this->belongsTo(Profile::class);
    }
    public function excerpt(){
        return $this->belongsTo(Excerpt::class);
    }
    public function term()
    {
        return $this->belongsTo(Term::class);
    }
}
