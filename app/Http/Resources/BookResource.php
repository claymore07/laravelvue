<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'booktype' => $this->booktype->name,
            'Author_name'=> $name,
            'status' => $this->status,
            'title' => $this->title,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
        ];
    }
}
