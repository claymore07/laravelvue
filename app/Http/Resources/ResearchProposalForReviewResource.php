<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ResearchProposalForReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $name = $this->proposal->profile->Fname.' '.$this->proposal->profile->Lname;
        $resource = [
            'id' => $this->proposal->id,
            'title' => $this->proposal->title,
            'en_title' => $this->proposal->en_title,
            'tags' => $this->proposal->tags,
            'budget' => $this->proposal->budget,
            'value' => $this->proposal->value,
            'faculty_id' => $this->proposal->faculty_id,
            'faculty' => $this->proposal->faculty->name,
            'proposal_type_id' => $this->proposal->proposal_type_id,
            'proposal_type' => $this->proposal->proposalType->name,
            'proposal_usage' => $this->proposal->proposalUsage->name,
            'proposal_usage_id' => $this->proposal->proposal_usage_id,
            'Author_name'=> $name,
            'abstract' => $this->proposal->abstract,
            'introduction' => $this->proposal->introduction,
            'problem' => $this->proposal->problem,
            'innovation' => $this->proposal->innovation,
            'requirements' => $this->proposal->requirements,
            'duration' => $this->proposal->duration,
            'project_location' => $this->proposal->project_location,
            'status' => $this->status,
            'comment' => $this->comment,
            'created_at' => Carbon::parse($this->proposal->created_at)->format('Y-m-d'),
            'updated_at' => Carbon::parse($this->proposal->updated_at)->format('Y-m-d'),
            'Authors' => AuthorResource::collection($this->proposal->authors),
            'files' => FileResource::collection($this->proposal->files),
        ];

        return $resource;
    }
}
