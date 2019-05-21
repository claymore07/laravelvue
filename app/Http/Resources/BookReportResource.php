<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BookReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $name = $this->profile->Fname.' '.$this->profile->Lname;
        $authors = $this->authors;
        $authors_name ='';
        foreach ($authors as $author){

            $authors_name = $authors_name.' '.$author->name;
            if($author->corresponding != -1){
                $authors_name = $authors_name.'*';
            }
        }
        $resource = [
            'title' => $this->title,
            'Author_name'=> $name,
            'Authors' => $authors_name,
            'excerpt_name' => $this->excerpt->name,
            'booktype_name' => $this->booktype->name,
            'publisher_name' => $this->publisher,
            'faculty'=>$this->profile->faculty->name,
            'department'=>$this->profile->department->name,
            'subject' => $this->subject,
            'isbn' => $this->isbn,
            'edited' => $this->edited == 0 ? 'ویرایش نشده':'ویرایش شده',
            'edited_number' => $this->edited == 0 ? '-':(int)$this->edited_number,
            'publish_number' => $this->publish_number,
            'publish_year' => $this->publish_year,
            'copy_number' => $this->copy_number,
            'pages' => $this->pages,
            'national_code' => $this->national_code != null? $this->national_code:'-',
            'congress_code' => $this->congress_code != null? $this->congress_code:'-',
            'dewey_code' => $this->dewey_code != null? $this->dewey_code:'-',
            'status' => $this->status,
            'score' => $this->score != -1.00 ? $this->score : '-',
            'term_name' => $this->term->name,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
           // 'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),


        ];
        return $resource;
    }
}
