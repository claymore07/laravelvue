<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RefereeResource extends JsonResource
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
        if($request->is('api/referee')||$request->is('api/findReferee')){
            $resource = [
                'id' => $this->id,
                'title' => $this->title,
                'referee_type' => $this->refereeType->name,
                'Author_name'=> $name,
                'status' => $this->status,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            ];
        }elseif ($request->isMethod('PUT')||$request->isMethod('PATCH')
            ||$request->is('api/referee/*')||$request->is('api/refereeUpdate/*')){
            $checkList = $this->checklists()->latest()->get();
            foreach ($checkList as $key => $item){
                $checkList[$key]['list'] = explode(",",$item['list']);
            }
            $resource = [
                'id' => $this->id,
                'title' => $this->title,
                'referee_types_id' => $this->referee_types_id,
                'referee_type' => $this->refereeType->name,
                'Author_name'=> $name,
                'journal_name' => $this->journal_name,
                'journal_issn' => $this->journal_issn,
                'referee_date' => $this->referee_date,
                'status' => $this->status,
                'score' => $this->score,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
                'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
                'checkList' => $checkList,
                'files' => FileResource::collection($this->files),
            ];
        }
        return $resource;
    }
}
