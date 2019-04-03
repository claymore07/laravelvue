<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
        if($request->is('api/project')||$request->is('api/findProject')){
            $resource = [
                'id' => $this->id,
                'title' => $this->title,
                'project_type' => $this->projectType->name,
                'organization' => $this->organization,
                'Author_name'=> $name,
                'status' => $this->status,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            ];
        }elseif ($request->isMethod('PUT')||$request->isMethod('PATCH')
            ||$request->is('api/project/*')||$request->is('api/projectUpdate/*')){
            $checkList = $this->checklists()->latest()->get();
            foreach ($checkList as $key => $item){
                $checkList[$key]['list'] = explode(",",$item['list']);
            }
            $resource = [
                'id' => $this->id,
                'title' => $this->title,
                'project_type' => $this->projectType->name,
                'organization' => $this->organization,
                'Author_name'=> $name,
                'council_aprovedate' => $this->council_aprovedate,
                'defense_date' => $this->defense_date,
                'status' => $this->status,
                'score' => $this->score,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
                'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
                'checkList' => $checkList,
                'Authors' => AuthorResource::collection($this->authors),
                'files' => FileResource::collection($this->files),
            ];
        }
        return $resource;

    }
}
