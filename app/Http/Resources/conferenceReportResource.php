<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class conferenceReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $paper = $this->papers[0];
        $name = $this->papers[0]->profile->Fname.' '.$this->papers[0]->profile->Lname;
        $authors = $paper->authors;
        $authors_name ='';
        foreach ($authors as $author){

            $authors_name = $authors_name.', '.$author->name;

        }
        $license_to = '';
        if($paper->license_to != null && $paper->license_to == 0) {
            $license_to = 'موظفی طرح';
        } elseif ($paper->license_to != null && $paper->license_to == 1){
            $license_to = 'مازاد موظفی';
        }else{
            $license_to = '-';
        }
        return [
            'id' => $paper->id,
            'title' => $paper->title,
            'Authors' => $authors_name,
            'Author_name'=> $name,
            'author_count'=> $paper->author_count,
            'author_place'=> $paper->author_place,
            'isresponsible'=> $paper->isresponsible == 0? 'خیر':'بله',
            'lang' => $paper->lang == 0 ? 'فارسی':'لاتین',
            'paper_type' =>  'کنفرانسی' ,
            'conf_name' => $this->name,//str_limit($this->name,40, ' ...'),
            'faculty'=>$paper->profile->faculty->name,
            'department'=>$paper->profile->department->name,
            'organizer' => $this->organizer ,
            'period' => $this->period,
            'conftype_name' => $this->conftype->name,
            'excerpt_name' => $paper->excerpt->name,
            'doi' => $paper->doi != null ? $paper->doi : '-',
            'link' => $paper->link != null ? $paper->link : '-',
            'license' => $paper->license != null ? $paper->license : '-',
            'license_to' => $license_to,
            'publish_date' => $paper->publish_date,
            'accept_date' => $paper->accept_date,
            'city' => $this->city ,
            'status' => $paper->status,
            'reward' => (string)$paper->reward ,
            'score' => $paper->score != -1.00 ? $paper->score : '-',
            'term_name' => $paper->term->name,
            'created_at' => Carbon::parse($paper->created_at)->format('Y-m-d'),
            //'updated_at' => Carbon::parse($paper->updated_at)->format('Y-m-d'),

        ];
    }
}
