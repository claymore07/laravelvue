<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BlackListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'issn' => $this->issn,
            'indexing' => $this->indexing,
            'url' => $this->url,
            'fake' => $this->fake_url,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
        ];
    }
}
