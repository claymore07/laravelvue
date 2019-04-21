<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ThesisResource extends JsonResource
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
        if($request->isMethod('post')||$request->is('api/thesis')||$request->is('api/findThesis')) {
            $resource = [
                'id' => $this->id,
                'status' => $this->status,
                'Author_name' => $name,
                'title' => $this->title,
                'thesisType_name' => $this->thesisType->name,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
                'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
            ];
        }elseif ($request->isMethod('PUT')||$request->isMethod('PATCH')||$request->is('api/thesis/*')) {
            $checkList = $this->checklists()->latest()->get();
            foreach ($checkList as $key => $item) {
                $checkList[$key]['list'] = explode(",", $item['list']);
            }
            $resource = [
                'id' => $this->id,
                'thesisType_name' => $this->thesisType->name,
                'theses_types_id' => $this->theses_types_id,
                'status' => $this->status,
                'Author_name'=> $name,
                'title' => $this->title,
                'group_aprovedate' => $this->group_aprovedate,
                'council_aprovedate' => $this->council_aprovedate,
                'code_date' => $this->code_date,
                'defense_date' => $this->defense_date,
                'score' => $this->score != -1.00 ? $this->score : '',
                'minScore' => $this->thesisType->minscore,
                'maxScore' => $this->thesisType->maxscore,
                'term_id' => $this->term_id,
                'term_name' => $this->term->name,
                'checkList' => $checkList,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
                'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
            ];
        }
        return $resource;
    }
}
