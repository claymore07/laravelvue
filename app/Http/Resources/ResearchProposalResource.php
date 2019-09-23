<?php

namespace App\Http\Resources;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ResearchProposalResource extends JsonResource
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
        if($request->is('api/researchProposal')||$request->is('api/findResearchProposal')){
            $resource = [
                'id' => $this->id,
                'title' => $this->title,
                'proposal_type' => $this->proposalType->name,
                'Author_name'=> $name,
                'status' => $this->status,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            ];
        }elseif ($request->isMethod('PUT')||$request->isMethod('PATCH')
            ||$request->is('api/researchProposal/*')||$request->is('api/researchProposalUpdate/*')){
            $resource = [
                'id' => $this->id,
                'title' => $this->title,
                'en_title' => $this->en_title,
                'budget' => $this->budget,
                'value' => $this->value,
                'faculty_id' => $this->faculty_id,
                'faculty' => $this->faculty->name,
                'proposal_type_id' => $this->proposal_type_id,
                'proposal_type' => $this->proposalType->name,
                'proposal_usage' => $this->proposalUsage->name,
                'proposal_usage_id' => $this->proposal_usage_id,
                'Author_name'=> $name,
                'abstract' => $this->abstract,
                'introduction' => $this->introduction,
                'problem' => $this->problem,
                'innovation' => $this->innovation,
                'requirements' => $this->requirements,
                'duration' => $this->duration,
                'project_location' => $this->project_location,
                'status' => $this->status,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
                'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
                'Authors' => AuthorResource::collection($this->authors),
                'files' => FileResource::collection($this->files),
            ];
        }
        return $resource;
    }
}
