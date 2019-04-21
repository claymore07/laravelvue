<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RewardResource extends JsonResource
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
        if($request->is('api/reward')||$request->is('api/findReward')) {

            $resource = [
                'id' => $this->id,
                'name' => $this->name,
                'title' => $this->title,
                'Author_name' => $name,
                'status' => $this->status,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            ];
        }elseif ($request->isMethod('PUT')||$request->isMethod('PATCH')
            ||$request->is('api/reward/*')||$request->is('api/rewardUpdate/*')) {
            $checkList = $this->checklists()->latest()->get();
            foreach ($checkList as $key => $item){
                $checkList[$key]['list'] = explode(",",$item['list']);
            }
            $resource = [
                'id' => $this->id,
                'name' => $this->name,
                'title' => $this->title,
                'type' => $this->type,
                'Author_name'=> $name,
                'place' => $this->place,
                'period' => $this->period,
                'status' => $this->status,
                'score' => $this->score != -1.00 ? $this->score : '',
                'minScore' => $this->scores->minscore,
                'maxScore' => $this->scores->maxscore,
                'term_id' => $this->term_id,
                'term_name' => $this->term->name,
                'holding_date' => $this->holding_date,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
                'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
                'checkList' => $checkList,
                'files' => FileResource::collection($this->files),
            ];

        }
        return $resource ;
    }
}
