<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ResearchActivityReportResource extends JsonResource
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
            'id' => $this->id,
            'research_activity_type_name' => $this->ResearchActivityType->name,
            'Author_name'=> $name,
            'title' => $this->title,
            'authorities' => $this->authorities,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'faculty'=>$this->profile->faculty->name,
            'department'=>$this->profile->department->name,
            'status' => $this->status,
            'score' => $this->score != -1.00 ? $this->score : '-',
            'term_name' => $this->term->name,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            //'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),

        ];
        return $resource;
    }
}
