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
        $resource = [];
        if($request->is('api/book')||$request->is('api/findBook')) {
            $resource = [
                'id' => $this->id,
                'booktype' => $this->booktype->name,
                'Author_name' => $name,
                'status' => $this->status,
                'title' => $this->title,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            ];
        }elseif ($request->isMethod('PUT')||$request->isMethod('PATCH')
            ||$request->is('api/book/*')||$request->is('api/bookUpdate/*')){
            $checkList = $this->checklists()->latest()->get();
            foreach ($checkList as $key => $item){
                $checkList[$key]['list'] = explode(",",$item['list']);
            }
            $resource = [
                'id' => $this->id,
                'booktype_id' => $this->booktype_id,
                'excerpt_id' => $this->excerpt_id,
                'excerpt' => $this->excerpt->name,
                'booktype' => $this->booktype->name,
                'Author_name'=> $name,
                'status' => $this->status,
                'title' => $this->title,
                'isbn' => $this->isbn,
                'subject' => $this->subject,
                'publisher' => $this->publisher,
                'edited' => $this->edited,
                'edited_number' => $this->edited == 0 ? '':(int)$this->edited_number,
                'publish_number' => $this->publish_number,
                'publish_year' => $this->publish_year,
                'copy_number' => $this->copy_number,
                'pages' => $this->pages,
                'national_code' => $this->national_code != null? $this->national_code:'',
                'congress_code' => $this->congress_code != null? $this->congress_code:'',
                'dewey_code' => $this->dewey_code != null? $this->dewey_code:'',
                'score' => $this->score != -1.00 ? $this->score : '',
                'minScore' => $this->booktype->minscore,
                'maxScore' => $this->booktype->maxscore,
                'term_id' => $this->term_id,
                'term_name' => $this->term->name,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
                'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
                'checkList' => $checkList,
                'Authors' => AuthorResource::collection($this->authors),
                'files' => FileResource::collection($this->files),
            ];
        }
        return $resource;
    }
}
