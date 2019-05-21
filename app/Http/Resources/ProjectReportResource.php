<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectReportResource extends JsonResource
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
            'Authors' => $authors_name,
            'Author_name'=> $name,
            'faculty'=>$this->profile->faculty->name,
            'department'=>$this->profile->department->name,
            'budget' => $this->budget,
            'project_type_name' => $this->projectType->name,
            'organization' => $this->organization,
            'council_aprovedate' => $this->council_aprovedate,
            'defense_date' => $this->defense_date,
            'status' => $this->status,
            'score' => $this->score != -1.00 ? $this->score : '-',
            'term_name' => $this->term->name,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            //'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),

        ];

        return $resource;
    }
}
