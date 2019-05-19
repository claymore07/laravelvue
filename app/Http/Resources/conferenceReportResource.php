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

            $authors_name = $authors_name.' '.$author->name;
            if($author->corresponding != -1){
                $authors_name = $authors_name.'*';
            }
        }
        $license_to = '';
        if($paper->license_to != null && $paper->license_to == 0) {
            $license_to = 'موظفی طرح';
        } elseif ($paper->license_to != null && $paper->license_to == 1){
            $license_to = 'مازاد موظفی';
        }else{
            $license_to = '';
        }
        return [
            'title' => $paper->title,
            'Authors' => $authors_name,
            'Author_name'=> $name,
            'lang' => $paper->lang == 0 ? 'فارسی':'لاتین',
            'paper_type' =>  'کنفرانسی' ,
            'conf_name' => $this->name,
            'organizer' => $this->organizer ,
            'period' => $this->period,
            'conftype_name' => $this->conftype->name,
            'excerpt_name' => $paper->excerpt->name,
            'doi' => $paper->doi != null ? $paper->doi : '',
            'link' => $paper->link != null ? $paper->link : '',
            'license' => $paper->license != null ? $paper->license : '',
            'license_to' => $license_to,
            'publish_date' => $paper->publish_date,
            'accept_date' => $paper->accept_date,
            'city' => $this->city ,
            'status' => $paper->status,
            'score' => $paper->score != -1.00 ? $this->score : '',
            'term_name' => $paper->term->name,
            'created_at' => Carbon::parse($paper->created_at)->format('Y-m-d'),
            //'updated_at' => Carbon::parse($paper->updated_at)->format('Y-m-d'),

        ];
    }
}
