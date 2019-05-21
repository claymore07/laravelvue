<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TEDReportResource extends JsonResource
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
            'ted_type_name' => $this->TEDType->name,
            'Author_name'=> $name,
            'faculty'=>$this->profile->faculty->name,
            'department'=>$this->profile->department->name,
            'location' => $this->location,
            'status' => $this->status,
            'term_name' => $this->term->name,
            'score' => $this->score != -1.00 ? $this->score : '-',
            'presentation_date' => $this->presentation_date,
            'council_aprovedate' => $this->council_aprovedate != null ? $this->council_aprovedate : '-',
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
           // 'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),

        ];

        return $resource ;    }
}
