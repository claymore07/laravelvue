<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ResearchActivityResource extends JsonResource
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
        if($request->is('api/researchActivity')||$request->is('api/findResearchActivity')) {
            $resource = [
                'id' => $this->id,
                'research_activity_type' => $this->ResearchActivityType->name,
                'Author_name' => $name,
                'status' => $this->status,
                'title' => $this->title,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            ];
        }elseif ($request->isMethod('PUT')||$request->isMethod('PATCH')
            ||$request->is('api/researchActivity/*')||$request->is('api/researchActivityUpdate/*')){
            $checkList = $this->checklists()->latest()->get();
            foreach ($checkList as $key => $item){
                $checkList[$key]['list'] = explode(",",$item['list']);
            }
            $resource = [
                'id' => $this->id,
                'research_activity_types_id' => $this->research_activity_types_id,
                'research_activity_types_name' => $this->ResearchActivityType->name,
                'Author_name'=> $name,
                'status' => $this->status,
                'title' => $this->title,
                'authorities' => $this->authorities,
                'score' => $this->score != -1.00 ? $this->score : '',
                'minScore' => $this->ResearchActivityType->minscore,
                'maxScore' => $this->ResearchActivityType->maxscore,
                'term_id' => $this->term_id,
                'term_name' => $this->term->name,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
                'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
                'checkList' => $checkList,
                'files' => FileResource::collection($this->files),
            ];
        }
        return $resource;
    }
}
