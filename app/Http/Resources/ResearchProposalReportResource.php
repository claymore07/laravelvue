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
            'title' => $this->title,
            'proposal_type' => $this->proposalType->name,
            'Author_name'=> $name,
            'Authors' => $authors_name,
            'status' => $this->status,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
        ];
        return $resource;
    }
}
