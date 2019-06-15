<?php

namespace App\Http\Resources;

use App\Models\BlackList;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PaperResource extends JsonResource
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
        $resource = [];
        if($request->is('api/paper')||$request->is('api/findPaper')) {
            $resource = [
                'id' => $this->id,
                'paper_type' => $this->paperable_type == 'App\Models\Journal'? 'ژونالی' : 'کنفرانسی',
                'publisher_name' =>  $this->paperable->name ,
                'Author_name' => $name,
                'status' => $this->status,
                'title' => $this->title,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            ];
        }elseif ($request->isMethod('PUT')||$request->isMethod('PATCH')
            ||$request->is('api/paper/*')||$request->is('api/paperUpdate/*')){
            $checkList = $this->checklists()->latest()->get();
            foreach ($checkList as $key => $item){
                $checkList[$key]['list'] = explode(",",$item['list']);
            }
            if($this->paperable_type == 'App\Models\Journal'){
                $blacklistFlag = false;
                if($this->paperable->blacklist_id != null){
                    $blacklistFlag = true;
                    $blacklist = new BlackListResource(BlackList::where('id','=',$this->paperable->blacklist_id)->first());
                }else{
                    $blacklist = null;
                }
                $resource = [
                    'id' => $this->id,
                    'title' => $this->title,
                    'lang' => $this->lang,
                    'type' => 0,
                    'abstract' => $this->abstract,
                    'tags' => $this->tags,
                    'paper_type' =>  'ژونالی' ,
                    'jtype_id' => $this->paperable->jtype->id,
                    'jtype_name' => $this->paperable->jtype->name,
                    'excerpt_id' => $this->excerpt_id,
                    'excerpt_name' => $this->excerpt->name,
                    'paperable_id' =>  $this->paperable_id ,
                    'Author_name'=> $name,
                    'author_count'=> $this->author_count,
                    'author_place'=> $this->author_place,
                    'isresponsible'=> $this->isresponsible,
                    'doi' => $this->doi != null ? $this->doi : '',
                    'link' => $this->link != null ? $this->link : '',
                    'license' => $this->license != null ? $this->license : '',
                    'license_to' => $this->license_to != null ? $this->license_to : '',
                    'publish_date' => $this->publish_date,
                    'accept_date' => $this->accept_date,
                    'name' => $this->paperable->name,
                    'publisher' => $this->paperable->publisher,
                    'blacklist' =>$blacklist,
                    'blacklistFlag' =>$blacklistFlag,
                    'IFactor' => $this->paperable->IFactor != null ? $this->paperable->IFactor : '',
                    'FIF' => $this->paperable->FIF != null ? $this->paperable->FIF : '',
                    'JRK' => $this->paperable->JRK != null ? $this->paperable->JRK : '',
                    'JCR' => $this->paperable->JCR != null ? $this->paperable->JCR : '',
                    'issn' => $this->paperable->issn,
                    'pissn' => $this->paperable->pissn != null ? $this->paperable->pissn : '',
                    'status' => $this->status,
                    'reward' => (string)$this->reward ,
                    'score' => $this->score != -1.00 ? $this->score : '',
                    'minScore' => $this->paperable->jtype->minscore,
                    'maxScore' => $this->paperable->jtype->maxscore,
                    'term_id' => $this->term_id,
                    'term_name' => $this->term->name,
                    'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
                    'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
                    'checkList' => $checkList,
                    'Authors' => AuthorResource::collection($this->authors),
                    'files' => FileResource::collection($this->files),
                ];
            }else{
                $resource = [
                    'id' => $this->id,
                    'title' => $this->title,
                    'lang' => $this->lang,
                    'abstract' => $this->abstract,
                    'tags' => $this->tags,
                    'type' => 1,
                    'paper_type' =>  'کنفرانسی' ,
                    'conftype_id' => $this->paperable->conftype->id,
                    'conftype_name' => $this->paperable->conftype->name,
                    'excerpt_id' => $this->excerpt_id,
                    'excerpt_name' => $this->excerpt->name,
                    'paperable_id' =>  $this->paperable_id ,
                    'Author_name'=> $name,
                    'author_count'=> $this->author_count,
                    'author_place'=> $this->author_place,
                    'isresponsible'=> $this->isresponsible,
                    'doi' => $this->doi != null ? $this->doi : '',
                    'link' => $this->link != null ? $this->link : '',
                    'license' => $this->license != null ? $this->license : '',
                    'license_to' => $this->license_to != null ? $this->license_to : '',
                    'publish_date' => $this->publish_date,
                    'accept_date' => $this->accept_date,
                    'name' => $this->paperable->name,
                    'period' => $this->paperable->period,
                    'city' => $this->paperable->city ,
                    'organizer' => $this->paperable->organizer ,
                    'status' => $this->status,
                    'reward' => (string)$this->reward ,
                    'score' => $this->score != -1.00 ? $this->score : '',
                    'minScore' => $this->paperable->conftype->minscore,
                    'maxScore' => $this->paperable->conftype->maxscore,
                    'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
                    'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
                    'checkList' => $checkList,
                    'Authors' => AuthorResource::collection($this->authors),
                    'files' => FileResource::collection($this->files),
                ];
            }

        }
        return $resource;
    }
}
