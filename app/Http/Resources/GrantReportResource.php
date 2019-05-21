<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class GrantReportResource extends JsonResource
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
            'budget' => $this->budget,
            'type' => $this->type,
            'type_name' => $this->type == 0? 'داخلی':'بین المللی',
            'submit_date' => $this->submit_date,
            'status' => $this->status,
            'score' => $this->score != -1.00 ? $this->score : '-',
            'term_name' => $this->term->name,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            //'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),

        ];
        return $resource;
    }
}
