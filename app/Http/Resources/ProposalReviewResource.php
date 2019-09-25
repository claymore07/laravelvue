<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProposalReviewResource extends JsonResource
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
            'title' => $this->proposal->title,
            'comment' => $this->comment,
            'reviewer_name'=> $name,
            'status' => $this->status,
            'assigned_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'reviewed_at' => $this->reviewed_at != null ? Carbon::parse($this->reviewed_at)->format('Y-m-d'):'',
        ];
        return $resource;
    }
}
