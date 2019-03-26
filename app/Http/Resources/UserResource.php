<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $name = '';
        if(!is_null($this->profile)){
            $name = $this->profile->Fname.' '.$this->profile->Lname;
        }else{
            $name = 'بدون نام';
        }
        return [
            'id' => $this->id,
            'username' => $this->name,
            'type' => $this->type,
            'photo' => $this->photo,
            'name' => $name,
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
