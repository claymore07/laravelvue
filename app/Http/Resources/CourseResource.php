<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
        if($request->is('api/course')||$request->is('api/findCourse')) {

            $resource = [
                'id' => $this->id,
                'title' => $this->title,
                'role' => $this->role,
                'Author_name' => $name,
                'status' => $this->status,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            ];
        }elseif ($request->isMethod('PUT')||$request->isMethod('PATCH')
            ||$request->is('api/course/*')||$request->is('api/courseUpdate/*')) {
            $checkList = $this->checklists()->latest()->get();
            foreach ($checkList as $key => $item){
                $checkList[$key]['list'] = explode(",",$item['list']);
            }
            $resource = [
                'id' => $this->id,
                'title' => $this->title,
                'role' => $this->role,
                'organization' => $this->organization,
                'Author_name'=> $name,
                'duration' => $this->duration,
                'status' => $this->status,
                'score' => $this->score,
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
