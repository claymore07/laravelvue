<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
        return [
            'id' => $this->id,
            'booktype_id' => $this->booktype_id,
            'booktype' => $this->booktype->name,
            'Author_name'=> $name,
            'status' => $this->status,
            'title' => $this->title,
            'isbn' => $this->isbn,
            'subject' => $this->subject,
            'publisher' => $this->publisher,
            'edited' => $this->edited,
            'edited_number' => $this->edited == 0 ? null:$this->edited_number,
            'publish_number' => $this->publish_number,
            'publish_year' => $this->publish_year,
            'copy_number' => $this->copy_number,
            'pages' => $this->pages,
            'national_code' => $this->national_code? $this->national_code:null,
            'congress_code' => $this->congress_code? $this->congress_code:null,
            'dewey_code' => $this->dewey_code? $this->dewey_code:null,
            'score' => $this->score,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
            'Authors' => AuthorResource::collection($this->authors),
            'files' => FileResource::collection($this->files),
        ];
    }
}
