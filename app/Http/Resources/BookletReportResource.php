<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BookletReportResource extends JsonResource
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
            'name' => $this->name,
            'Author_name'=> $name,
            'booklet_type_name' => $this->booklet_type,
            'degree' => $this->degree->name,
            'compilation_date' => $this->compilation_date,
            'status' => $this->status,
            'score' => $this->score != -1.00 ? $this->score : '-',
            'term_name' => $this->term->name,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            //'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),

        ];
        return $resource ;
    }
}
