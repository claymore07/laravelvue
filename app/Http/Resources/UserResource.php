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
            'member_id' => $hasProfile? $this->profile->member_id:3,
            'last_login' => $this->last_login == null ?'ثبت نشده':$this->last_login->diffForHumans(),
            'ip_address' => $this->ip_address == null ?'ثبت نشده':$this->ip_address,
        ];
    }
}
