<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TEDChairResource extends JsonResource
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
        if($request->is('api/tedChair')||$request->is('api/findTed')) {

            $resource = [
                'id' => $this->id,
                'title' => $this->title,
                'ted_type' => $this->TEDType->name,
                'Author_name' => $name,
                'status' => $this->status,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            ];
        }elseif ($request->isMethod('PUT')||$request->isMethod('PATCH')
            ||$request->is('api/tedChair/*')||$request->is('api/tedChairUpdate/*')) {
            $checkList = $this->checklists()->latest()->get();
            foreach ($checkList as $key => $item){
                $checkList[$key]['list'] = explode(",",$item['list']);
            }
            $resource = [
                'id' => $this->id,
                'title' => $this->title,
                'ted_types_id' => $this->ted_types_id,
                'ted_type' => $this->TEDType->name,
                'Author_name'=> $name,
                'location' => $this->location,
                'status' => $this->status,
                'score' => $this->score,
                'term_id' => $this->term_id,
                'term_name' => $this->term->name,
                'presentation_date' => $this->presentation_date,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
                'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
                'checkList' => $checkList,
                'files' => FileResource::collection($this->files),
            ];

        }
        return $resource ;
    }
}
