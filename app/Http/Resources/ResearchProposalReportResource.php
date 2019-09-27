<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ResearchProposalReportResource extends JsonResource
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
            'id' => $this->id,
            'Author_name'=> $name,
            'Authors' => $authors_name,

            'title' => $this->title,
            'en_title' => $this->en_title,
            'proposal_type' => $this->proposalType->name,
            'proposal_usage' => $this->proposalUsage->name,
            'faculty'=>$this->profile->faculty->name,
            'department'=>$this->profile->department->name,
            'budget' => $this->budget,
            'value' => $this->value,
            'project_location' => $this->project_location,
            'duration' => $this->duration,

            'status' => $this->status,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
        ];
        return $resource;
    }
}
