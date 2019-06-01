<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\PaperResource;
use App\Models\Conference;
use App\Models\ConfType;
use App\Models\Department;
use App\Models\Excerpt;
use App\Models\Faculty;
use App\Models\Files;
use App\Http\Requests\PaperRequest;
use App\Http\Requests\PaperUpdateRequest;
use App\Models\Journal;
use App\Models\Jtype;
use App\Models\Paper;
use App\Models\Term;
use App\User;

use Auth;
use Carbon\Carbon;
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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        //
        $this->authorize('IsUserOrIsAdmin');
        $order = \Request::get('order');
        $user = Auth::user('api')->load('profile');

        $papers = Paper::where(function ($query) use ($user) {
                if ($user->type == 'admin') {

                } else {
                    $query->where('profile_id', '=', $user->profile->id);
                }
            })
            ->orderBy('created_at', $order)->paginate($this->perPage);

        return PaperResource::collection($papers);

    }

    public function search(){
        $this->authorize('IsUserOrIsAdmin');
        $order = \Request::get('order');
        $filter = \Request::get('filter');
        $user = Auth::user('api')->load('profile');
        if($filter == '5') {
            if ($search = \Request::get('q')) {
                  // \DB::enableQueryLog();
                $papers = Paper::where(function ($query) use ($user) {
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
                $papers = Paper::where(function ($query) use ($user) {
                        if ($user->type == 'admin') {

                        } else {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                    })
                    ->orderBy('created_at', $order)
                    ->paginate($this->perPage);

            }
        }else{
            if ($search = \Request::get('q')) {
               // \DB::enableQueryLog();

                $papers = Paper::where(function ($query) use ($user) {
                        if ($user->type != 'admin') {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                    })
                   ->where('status', $filter)
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
                        $query->where('title', 'LIKE', "%$search%")->where('status', $filter);
                    })->orderBy('created_at', $order)->paginate($this->perPage);
              // dd(\DB::getQueryLog());

            } else {

                $papers = Paper::where(function ($query) use ($user) {
                        if ($user->type == 'admin') {

                        } else {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                    })
                    ->where('status', $filter)
                    ->orderBy('created_at', $order)
                    ->paginate($this->perPage);
            }
        }
        return PaperResource::collection($papers);

    }


    public function paperRelation(Request $request){
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
        $termes = Term::all()->map(function ($item){
            return ['id'=> $item['id'], 'text'=>$item['name']];
        })->toArray();
        if($request->is('api/paperReportRelation')) {
            $departments = Department::all()->map(function ($item){
                return ['id'=> $item['id'], 'text'=>$item['name']];
            })->toArray();
            $faculties = Faculty::all()->map(function ($item){
                return ['id'=> $item['id'], 'text'=>$item['name']];
            })->toArray();
            return Response::json(array('excerpts'=> $excerpts, 'jtypes'=> $jtypes,
                'conftypes'=> $conftypes, 'terms'=> $termes, 'departments'=> $departments,
                'faculties' => $faculties));

        }else{
            return Response::json(array('excerpts'=>$excerpts, 'jtypes'=>$jtypes, 'conftypes'=>$conftypes, 'terms'=>$termes));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse | PaperResource
     * @throws \Exception
     */
    public function store(PaperRequest $request){
        $term = Term::whereStatus(1)->first();

        if(Carbon::now()->between( $term->starts_at, $term->ends_at)) {
            DB::beginTransaction();
            try {
                $fileBag = $request->files;
                $authors = $request->authors;
                $affiliations = $request->affiliations;
                $isresposible = $request->isresponsible;
                $tags = $request->tags;
                $request['profile_id'] = auth('api')->user()->profile['id'];
                $request['term_id'] = $term->id;
                $paperType = $request->paperType;
                if ($paperType == 'jur') {
                    $request['name'] = $request->jname;
                    $journal_db = Journal::create($request->all(['jtype_id', 'name', 'publisher','blacklist_id', 'issn', 'pissn', 'IFactor', 'FIF',
                        'JRK', 'JCR']));
                    $paper_db = $journal_db->papers()->create($request->all());
                } else {
                    $request['name'] = $request->confname;
                    $conference_db = Conference::create($request->all(['conftype_id', 'name', 'period', 'city', 'organizer']));
                    $paper_db = $conference_db->papers()->create($request->all());
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
            } catch (\Exception $e) {
                DB::rollback();
                return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
            }

            DB::commit();
            return new PaperResource($paper_db);
        }else{
            return Response::json(['message'=>'تاریخ ثبت اطلاعات برای ترم جاری به اتمام رسیده است'],405);
        }
    }



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
        return new PaperResource($paper);

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
    public function paperUpdate(PaperRequest $request, $id)
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
            // after every update on paper its status will be changed to 4 or اصلاح شده
            $request['status'] = 4;
            $paper_db->update($request->all());
            $paperType = $request->paperType;
           if ($paperType == 'jur') {
               $request['name'] = $request->jname;
                $paper_db->paperable->update($request->all(['jtype_id','name','publisher','blacklist_id','issn','pissn', 'IFactor','FIF',
                    'JRK', 'JCR']));
            } else {
               $request['name'] = $request->confname;
               $paper_db->paperable()->update($request->all(['conftype_id','name', 'period', 'city', 'organizer']));
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
        $paper_db = Paper::findOrFail($id);

        return new PaperResource($paper_db);
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


}
