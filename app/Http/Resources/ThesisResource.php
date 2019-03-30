<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ThesisResource extends JsonResource
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
        return [
            'id' => $this->id,
            'status' => $this->status,
            'Author_name'=> $name,
            'title' => $this->title,
            'responsible' => $this->responsible,
            'group_aprovedate' => $this->group_aprovedate,
            'council_aprovedate' => $this->council_aprovedate,
            'code_date' => $this->code_date,
            'defense_date' => $this->defense_date,
            'score' => $this->score,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
        ];
    }
}
