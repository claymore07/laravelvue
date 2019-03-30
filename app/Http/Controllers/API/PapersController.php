<?php

namespace App\Http\Controllers\API;

use App\Models\Conference;
use App\Models\ConfType;
use App\Models\Excerpt;
use App\Models\Files;
use App\Http\Requests\PaperRequest;
use App\Http\Requests\PaperUpdateRequest;
use App\Models\Journal;
use App\Models\Jtype;
use App\Models\Paper;
use App\User;

use Auth;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class PapersController extends Controller
{
    protected $perPage;
    public function __construct()
    {

        $this->middleware('jwt');
        $this->perPage=5;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //
        $this->authorize('IsUserOrIsAdmin');
        $order = \Request::get('order');
        $user = Auth::user('api')->load('profile');

        $papers = Paper::select('title', 'id', 'profile_id', 'paperable_type', 'paperable_id', 'status', 'created_at')
            //->where('profile_id','=',$profile->id)
            ->where(function ($query) use ($user) {
                if ($user->type == 'admin') {

                } else {
                    $query->where('profile_id', '=', $user->profile->id);
                }
            })
            ->with(['paperable:name,id', 'profile:Fname,Lname,id'])
            ->orderBy('created_at', $order)->paginate($this->perPage);

        return Response::json(array('papers' => $papers));

    }

    public function search(){
        $this->authorize('IsUserOrIsAdmin');
        $order = \Request::get('order');
        $filter = \Request::get('filter');
        $user = Auth::user('api')->load('profile');
        if($filter == '5') {
            if ($search = \Request::get('q')) {
                  // \DB::enableQueryLog();
                $papers = Paper::select('title', 'id', 'profile_id', 'paperable_type', 'paperable_id', 'status', 'created_at')
                    ->with(['paperable:name,id', 'profile:Fname,Lname,id'])
                    ->where(function ($query) use ($user) {
                        if ($user->type != 'admin') {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                    })
                    ->whereHas('profile', function ($query) use ($search,$user) {
                        if ($search == trim($search) && strpos($search, ' ') !== false) {
                            $searchParts = explode(' ', $search);
                            $query->where('Fname', 'LIKE', "%$searchParts[0]%")
                                ->where('Lname', 'LIKE', "%$searchParts[1]%");
                        } else {
                            $query->where('Fname', 'LIKE', "%$search%")
                                ->orWhere('Lname', 'LIKE', "%$search%");
                        }
                    })->orWhere(function ($query) use ($search,$user) {
                        if ($user->type != 'admin') {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                        $query->where('title', 'LIKE', "%$search%");

                    })->orderBy('created_at', $order)->paginate($this->perPage);
                   //dd(\DB::getQueryLog());
            } else {
                $papers = Paper::select('title', 'id', 'profile_id', 'paperable_type', 'paperable_id', 'status', 'created_at')
                    ->where(function ($query) use ($user) {
                        if ($user->type == 'admin') {

                        } else {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                    })
                    ->with(['paperable:name,id', 'profile:Fname,Lname,id'])
                    ->orderBy('created_at', $order)
                    ->paginate($this->perPage);

            }
        }else{
            if ($search = \Request::get('q')) {
               // \DB::enableQueryLog();

                $papers = Paper::select('title', 'id', 'profile_id', 'paperable_type', 'paperable_id', 'status', 'created_at')
                    ->where(function ($query) use ($user) {
                        if ($user->type != 'admin') {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                    })
                   ->where('status', $filter)
                    ->with(['paperable:name,id', 'profile:Fname,Lname,id'])
                    ->whereHas('profile', function ($query) use ($search,$filter) {
                        if ($search == trim($search) && strpos($search, ' ') !== false) {
                            $searchParts = explode(' ', $search);
                            $query->where('Fname', 'LIKE', "%$searchParts[0]%")
                                ->where('Lname', 'LIKE', "%$searchParts[1]%");
                        } else {
                            $query->where('Fname', 'LIKE', "%$search%")
                                ->orWhere('Lname', 'LIKE', "%$search%");

                        }
                    })->orWhere(function ($query) use ($search,$filter,$user) {
                        if ($user->type != 'admin') {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                        $query->where('title', 'LIKE', "%$search%")

                        ->where('status', $filter);
                    })->orderBy('created_at', $order)->paginate($this->perPage);
              // dd(\DB::getQueryLog());

            } else {

                $papers = Paper::select('title', 'id', 'profile_id', 'paperable_type', 'paperable_id', 'status', 'created_at')
                    ->where(function ($query) use ($user) {
                        if ($user->type == 'admin') {

                        } else {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                    })
                    ->with(['paperable:name,id', 'profile:Fname,Lname,id'])
                    ->where('status', $filter)
                    ->orderBy('created_at', $order)
                    ->paginate($this->perPage);
            }
        }
        return Response::json(array('papers'=>$papers));

    }


    public function paperRelation(){
        $this->authorize('IsUserOrIsAdmin');
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
    public function store(Request $request){}



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('IsUserOrIsAdmin');
        $paper = Paper::with(['paperable','authors','tags','files','excerpt'])->findOrFail($id);
        $checkList = $paper->checklists()->latest()->get();
        foreach ($checkList as $key => $item){
            $checkList[$key]['list'] = explode(",",$item['list']);
        }
        $paperable = $paper->paperable;
        if($paper->paperable_type == "App\Models\Journal")
        {
            $jtype = $paperable->jtype;
            return Response::json(array('paper'=>$paper,'checklist'=>$checkList, 'jtypename'=>$jtype['name'], 'conftypename'=>'', 'type'=>0),200);
        }else{
            $conftype =$paperable->conftype;
            return Response::json(array('paper'=>$paper,'checklist'=>$checkList, 'jtypename'=>'','conftypename'=>$conftype['name'], 'type'=>1),200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->authorize('IsUserOrIsAdmin');
    }
    public function paperUpdate(Request $request, $id)
    {
        $this->authorize('IsUserOrIsAdmin');
        $paper_db = Paper::findOrFail($id);
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
            $paper['title'] = $request->title;
            $paper['abstract'] = $request->abstract;
            $paper['doi'] = $request->doi;
            $paper['link'] = $request->link;
            $paper['excerpt_id'] = $request->excerpt_id;
            $paper['license'] = $request->license;
            $paper['license_to'] = $request->license_to;
            $paper['publish_date'] = $request->publish_date;
            $paper['accept_date'] = $request->accept_date;

            // after every update on paper its status will be changed to 4 or اصلاح شده
            $paper['status'] = 4;
            $paper_db->update($paper);
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
               $paper_db->paperable->update($journal);
            } else {
                $conference['conftype_id'] = $request->conftype_id;
                $conference['name'] = $request->confname;
                $conference['organizer'] = $request->conforganizer;
                $conference['city'] = $request->confcity;
                $conference['period'] = $request->confperiod;
                $paper_db->paperable()->update($conference);
            }
            $paper_db->tags()->delete();
            foreach ($tags as $tag) {
                $paper_db->tags()->create(['name' => $tag]);
            }
            $paper_db->authors()->delete();
           foreach ($authors as $key => $author) {
                if ($key == $isresposible) {
                    $paper_db->authors()->create(['name' => $author, 'affiliation' => $affiliations[$key], 'corresponding' => $key]);
                } else {
                    $paper_db->authors()->create(['name' => $author, 'affiliation' => $affiliations[$key]]);
                }
            }
            if ($request->has('fileChangeType')) {
                if ($request->fileChangeType == '0') {
                    $files = $paper_db->files;
                    foreach ($files as $file){
                            $file->delete();
                    }
                }
                foreach ($fileBag as $files) {
                    foreach ($files as $file) {
                        $name = time() . rand() . '.' . $file->getClientOriginalExtension();
                        $file->move('files/papers', $name);
                        $paper_db->files()->create(['name' => $name]);
                    }
                }
            }
      }catch (\Exception $e){

            DB::rollback();
            return Response::json(['dberror'=> ["خطای در پایگاه داده رخ داده است"] ], 402);
        }

        DB::commit();
        $paper_db = Paper::with(['paperable','authors','tags','files','excerpt'])->findOrFail($id);
        $paperable = $paper_db->paperable;

        if($paper_db->paperable_type == "App\Journal")
        {
            $jtype = $paperable->jtype;
            return Response::json(array('paper'=>$paper_db, 'jtypename'=>$jtype['name'], 'conftypename'=>'', 'type'=>0),200);
        }else{
            $conftype =$paperable->conftype;
            return Response::json(array('paper'=>$paper_db, 'jtypename'=>'','conftypename'=>$conftype['name'], 'type'=>1),200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy($id)
    {
        $this->authorize('IsUserOrIsAdmin');
        //
        $paper = Paper::findOrFail($id);
        DB::beginTransaction();
        try {
            $files = $paper->files;
            $paper->tags()->delete();
            $paper->authors()->delete();
            $paper->checklists()->delete();
            $paperable = $paper->paperable;
            $paperable->papers()->delete();
            $paperable->delete();
            foreach ($files as $file){
                    $file->delete();
            }
        }catch (\Exception $e){
            DB::rollback();
            return Response::json(['dberror'=> ["خطای در پایگاه داده رخ داده است"] ], 402);
        }
        DB::commit();
        return Response::json(['مقاله مورد نظر با موفقیت حذف شد.'], 200);
    }


    public function paperValidation(PaperRequest $request){
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
        }

        DB::commit();
        return Response::json(['مقاله جدید با موفقیت ثبت شد.'], 200);

    }
}
