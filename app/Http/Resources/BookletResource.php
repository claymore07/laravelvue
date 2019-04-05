<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BookletResource extends JsonResource
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
        if($request->is('api/booklet')||$request->is('api/findBooklet')) {

            $resource = [
                'id' => $this->id,
                'name' => $this->name,
                'title' => $this->title,
                'degree' => $this->degree->name,
                'Author_name' => $name,
                'status' => $this->status,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            ];
        }elseif ($request->isMethod('PUT')||$request->isMethod('PATCH')
            ||$request->is('api/booklet/*')||$request->is('api/bookletUpdate/*')) {
            $checkList = $this->checklists()->latest()->get();
            foreach ($checkList as $key => $item){
                $checkList[$key]['list'] = explode(",",$item['list']);
            }
            $resource = [
                'id' => $this->id,
                'name' => $this->name,
                'title' => $this->title,
                'type' => $this->booklet_type,
                'degree' => $this->degree->name,
                'degree_id' => $this->degree_id,
                'Author_name'=> $name,
                'status' => $this->status,
                'score' => $this->score,
                'compilation_date' => $this->compilation_date,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
                'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
                'checkList' => $checkList,
                'files' => FileResource::collection($this->files),
            ];

        }
        return $resource ;

    }
}
