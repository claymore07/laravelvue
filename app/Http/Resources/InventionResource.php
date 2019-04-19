<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class InventionResource extends JsonResource
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
        if($request->is('api/invention')||$request->is('api/findInvention')) {

            $resource = [
                'id' => $this->id,
                'title' => $this->title,
                'invention_type' => $this->inventionType->name,
                'Author_name' => $name,
                'status' => $this->status,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            ];
        }elseif ($request->isMethod('PUT')||$request->isMethod('PATCH')
            ||$request->is('api/invention/*')||$request->is('api/inventionUpdate/*')) {
            $checkList = $this->checklists()->latest()->get();
            foreach ($checkList as $key => $item){
                $checkList[$key]['list'] = explode(",",$item['list']);
            }
            $resource = [
                'id' => $this->id,
                'invention_types_id'=> $this->invention_types_id,
                'invention_type' => $this->inventionType->name,
                'title' => $this->title,
                'Author_name'=> $name,
                'post' => $this->post,
                'authorities' => $this->authorities,
                'license' => $this->invention_types_id == 9 ? $this->license : '' ,
                'license_number' =>  $this->invention_types_id == 9 ? $this->license_number: '',
                'affiliation' =>  $this->invention_types_id == 9 ? $this->affiliation: '',
                'registration_number' => $this->invention_types_id == 8 ? $this->registration_number : '',
                'company_name' => $this->invention_types_id == 8 ? $this->company_name : '',
                'company_type' => $this->invention_types_id == 8 ? $this->company_type : '',
                'company_address' => $this->invention_types_id == 8 ? $this->company_address : '',
                'status' => $this->status,
                'score' => $this->score,
                'term_id' => $this->term_id,
                'term_name' => $this->term->name,
                'submit_date' => $this->submit_date,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
                'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
                'checkList' => $checkList,
                'files' => FileResource::collection($this->files),
            ];

        }
        return $resource ;
    }

}
