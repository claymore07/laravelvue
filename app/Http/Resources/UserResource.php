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
        $hasProfile = '';
        if(!is_null($this->profile)){
            $name = $this->profile->Fname.' '.$this->profile->Lname;
            $hasProfile = true;
        }else{
            $name = 'بدون نام';
            $hasProfile = false;
        }
        return [
            'id' => $this->id,
            'username' => $this->name,
            //'type' => $this->type,
            'photo' => $this->photo,
            'name' => $name,
            'hasProfile' => $hasProfile,
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
