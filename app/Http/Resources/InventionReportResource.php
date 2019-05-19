<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class InventionReportResource extends JsonResource
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
        $license = '';
        if($this->invention_types_id == 9 ){
            if($this->license == 0){
                $license = 'خیر';
            }else{
                $license = 'بله';
            }
        }
        $resource = [
            'title' => $this->title,
            'Author_name'=> $name,
            'inventiontype_name' => $this->inventionType->name,
            'post' => $this->post,
            'authorities' => $this->authorities,
            'license' => $this->invention_types_id == 9 ? $license : '-' ,
            'license_number' =>  $this->invention_types_id == 9 ? $this->license_number: '-',
            'affiliation' =>  $this->invention_types_id == 9 ? $this->affiliation: '-',
            'registration_number' => $this->invention_types_id == 8 ? $this->registration_number : '-',
            'company_name' => $this->invention_types_id == 8 ? $this->company_name : '-',
            'company_type' => $this->invention_types_id == 8 ? $this->company_type : '-',
            'company_address' => $this->invention_types_id == 8 ? $this->company_address : '-',
            'submit_date' => $this->submit_date,
            'status' => $this->status,
            'score' => $this->score != -1.00 ? $this->score : '-',
            'term_name' => $this->term->name,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            // 'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),


        ];
        return $resource;
    }
}
