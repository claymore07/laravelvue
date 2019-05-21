<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ThesesReportResource extends JsonResource
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
        $resource = [
            'title' => $this->title,
            'Author_name'=> $name,
            'faculty'=>$this->profile->faculty->name,
            'department'=>$this->profile->department->name,
            'thesis_type_name' => $this->thesisType->name,
            //'degree_name' => $this->degree->name,
            'group_aprovedate' => $this->group_aprovedate,
            'council_aprovedate' => $this->council_aprovedate,
            'code_date' => $this->code_date,
            'defense_date' => $this->defense_date,
            'status' => $this->status,
            'score' => $this->score != -1.00 ? $this->score : '-',
            'term_name' => $this->term->name,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            //'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
        ];
        return $resource;
    }
}
