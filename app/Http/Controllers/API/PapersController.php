<?php

namespace App\Http\Controllers\API;

use App\Conference;
use App\ConfType;
use App\Excerpt;
use App\Files;
use App\Http\Requests\PaperRequest;
use App\Journal;
use App\Jtype;
use App\Paper;
use App\User;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class PapersController extends Controller
{
    protected $perPage=1;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $order = \Request::get('order');
        $papers =Paper::select('title','id','paperable_type','paperable_id','status','created_at')->with(['author'=>function($query){
            $query->select('name','authorable_type','authorable_id');
            }, 'paperable'=>function($query){
            $query->select('name','id');
        }])->orderBy('created_at', $order)->paginate($this->perPage);
        return Response::json(array('papers'=>$papers));
    }

    public function paperRelation(){
        $excerpts = Excerpt::all()->map(function ($item){
            return ['id'=> $item['id'], 'text'=>$item['name']];
        })->toArray();
        $conftypes = ConfType::all()->map(function ($item){
            return ['id'=> $item['id'], 'text'=>$item['name']];
        })->toArray();
        $jtypes = Jtype::all()->map(function ($item){
            return ['id'=> $item['id'], 'text'=>$item['name']];
        })->toArray();

        return Response::json(array('excerpts'=>$excerpts, 'jtypes'=>$jtypes, 'conftypes'=>$conftypes));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $paper = Paper::findOrFail($id);


/*
        foreach ($files as $file){
            $filePath = public_path('files/papers/').$file['name'];
            if(file_exists($filePath)){

                @unlink($filePath);
                $file->delete();
            }
        }*/
       // return Response::json($paperable, 200);
        DB::beginTransaction();
        try {
            $files = $paper->files;
            $paper->tags()->delete();
            $paper->authors()->delete();
            $paperable = $paper->paperable;
            $paperable->papers()->delete();
            $paperable->delete();
            foreach ($files as $file){
                $filePath = public_path('files/papers/').$file['name'];
                if(file_exists($filePath)){
                    @unlink($filePath);
                    $file->delete();
                }
            }
        }catch (\Exception $e){

            DB::rollback();
            return Response::json(['dberror'=> ["خطای در پایگاه داده رخ داده است"] ], 402);
            // return redirect('admin/home')->with('fail','عملیات ثبت کاربر ناموفق بود، از ابتدا شروع نمایید.');
        }

        DB::commit();
        return Response::json(['مقاله جدید با موفقیت ثبت شد.'], 200);
    }


    public function paperValidation(PaperRequest $request){
        //dd();
        //dd($request->all());

        DB::beginTransaction();
        try {
            $fileBag = $request->files;
            $authors = $request->authors;
            $affiliations = $request->affiliations;
            $isresposible = $request->isresponsible;
            $tags = $request->tags;
            $paper = [];
            $journal = [];
            $conference = [];
            $paper['profile_id'] = auth('api')->user()->profile['id'];
            $paper['lang'] = $request->lang;
            $paper['title'] = $request->title;
            $paper['abstract'] = $request->abstract;
            $paper['doi'] = $request->doi;
            $paper['link'] = $request->link;
            $paper['excerpt_id'] = $request->excerpt_id;
            $paper['license'] = $request->license;
            $paper['license_to'] = $request->license_to;
            $paper['publish_date'] = $request->publish_date;
            $paper['accept_date'] = $request->accept_date;

            $paperType = $request->paperType;
            if ($paperType == 'jur') {
                $journal['jtype_id'] = $request->jtype_id;
                $journal['name'] = $request->jname;
                $journal['publisher'] = $request->jpublisher;
                $journal['issn'] = $request->jISSN;
                $journal['pissn'] = $request->pISSN;
                $journal['IFactor'] = $request->pIF;
                $journal['FIF'] = $request->pFIF;
                $journal['JRK'] = $request->pJRK;
                $journal['JCR'] = $request->pJCR;
                $journal_db = Journal::create($journal);
                $paper_db = $journal_db->papers()->create($paper);
            } else {
                $conference['conftype_id'] = $request->conftype_id;
                $conference['name'] = $request->confname;
                $conference['organizer'] = $request->conforganizer;
                $conference['city'] = $request->confcity;
                $conference['period'] = $request->confperiod;
                $conference_db = Conference::create($conference);
                $paper_db = $conference_db->papers()->create($paper);
            }


            foreach ($tags as $tag) {
                $paper_db->tags()->create(['name' => $tag]);
            }
            foreach ($authors as $key => $author) {
                if ($key == $isresposible) {
                    $paper_db->authors()->create(['name' => $author, 'affiliation' => $affiliations[$key], 'corresponding' => $key]);
                } else {
                    $paper_db->authors()->create(['name' => $author, 'affiliation' => $affiliations[$key]]);
                }
            }
            foreach ($fileBag as $files) {
                foreach ($files as $file) {
                    $name = time() . rand() . '.' . $file->getClientOriginalExtension();
                    $file->move('files/papers', $name);
                    $paper_db->files()->create(['name' => $name]);
                }
            }
        }catch (\Exception $e){

            DB::rollback();
            return Response::json(['dberror'=> ["خطای در پایگاه داده رخ داده است"] ], 402);
            // return redirect('admin/home')->with('fail','عملیات ثبت کاربر ناموفق بود، از ابتدا شروع نمایید.');
        }

        DB::commit();
        return Response::json(['مقاله جدید با موفقیت ثبت شد.'], 200);

    }
}
