<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RewardEditResource extends JsonResource
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
        $checkList = $this->checklists()->latest()->get();
        foreach ($checkList as $key => $item){
            $checkList[$key]['list'] = explode(",",$item['list']);
        }
        return [
            'name' => $this->name,
            'title' => $this->title,
            'type' => $this->type,
            'Author_name'=> $name,
            'place' => $this->place,
            'period' => $this->period,
            'status' => $this->status,
            'score' => $this->score,
            'holding_date' => $this->holding_date,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
            'checkList' => $checkList,
            'files' => FileResource::collection($this->files),
        ];

    }

}
