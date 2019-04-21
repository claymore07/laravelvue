<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class GrantResource extends JsonResource
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
        if($request->is('api/grant')||$request->is('api/findGrant')) {
            $resource = [
                'id' => $this->id,
                'Author_name' => $name,
                'status' => $this->status,
                'title' => $this->title,
                'type' => $this->type == 0? 'داخلی':'بین المللی',
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            ];
        }elseif ($request->isMethod('PUT')||$request->isMethod('PATCH')
            ||$request->is('api/grant/*')||$request->is('api/grantUpdate/*')){
            $checkList = $this->checklists()->latest()->get();
            foreach ($checkList as $key => $item){
                $checkList[$key]['list'] = explode(",",$item['list']);
            }
            $resource = [
                'id' => $this->id,
                'Author_name'=> $name,
                'status' => $this->status,
                'title' => $this->title,
                'budget' => $this->budget,
                'type' => $this->type,
                'type_name' => $this->type == 0? 'داخلی':'بین المللی',
                'submit_date' => $this->submit_date,
                'score' => $this->score != -1.00 ? $this->score : '',
                'minScore' => $this->scores->minscore,
                'maxScore' => $this->scores->maxscore,
                'term_id' => $this->term_id,
                'term_name' => $this->term->name,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
                'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
                'checkList' => $checkList,
                'files' => FileResource::collection($this->files),
            ];
        }
        return $resource;
    }
}
