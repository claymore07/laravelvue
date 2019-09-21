<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ResearchActivityRequest;
use App\Http\Resources\ResearchActivityResource;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\ResearchActivity;
use App\Models\ResearchActivityType;
use App\Models\Term;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use Auth;
use DB;

class ResearchActivityController extends Controller
{
    protected $perPage;
    public function __construct()
    {

        $this->middleware('jwt');
        $this->perPage=2;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        //
        $this->perPage = \Request::get('perPage');
        $order = \Request::get('order');
        $user = Auth::user('api')->load('profile');
        $researchActivites = ResearchActivity::where(function ($query) use ($user) {
            if ($user->type == 'user') {
                $query->where('profile_id', '=', $user->profile->id);
            }
        })->orderBy('created_at', $order)->paginate($this->perPage);


        return ResearchActivityResource::collection($researchActivites);

    }

    public function search(){
        //$this->authorize('IsUserOrIsAdmin');
        $this->perPage = \Request::get('perPage');
        $order = \Request::get('order');
        $filter = \Request::get('filter');
        $user = Auth::user('api')->load('profile');
        if($filter == '5') {
            if ($search = \Request::get('q')) {
                // \DB::enableQueryLog();
                $researchActivites = ResearchActivity::where(function ($query) use ($user) {
                    if ($user->type == 'user') {
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
                        if ($user->type == 'user') {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                        $query->where('title', 'LIKE', "%$search%");

                    })->orWhereHas ('ResearchActivityType',function ($query) use ($search,$user) {
                        if ($user->type == 'user') {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                        $query->where('name', 'LIKE', "%$search%");
                    })
                    ->orderBy('created_at', $order)->paginate($this->perPage);
                //dd(\DB::getQueryLog());
            } else {
                $researchActivites = ResearchActivity::where(function ($query) use ($user) {
                    if ($user->type == 'user') {
                        $query->where('profile_id', '=', $user->profile->id);
                    }
                })
                    ->orderBy('created_at', $order)
                    ->paginate($this->perPage);
            }
        }else{
            if ($search = \Request::get('q')) {
                // \DB::enableQueryLog();
                $researchActivites = ResearchActivity::where(function ($query) use ($user) {
                    if ($user->type == 'user') {
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
                        if ($user->type == 'user') {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                        $query->where('title', 'LIKE', "%$search%")->where('status', $filter);


                    })->orWhereHas ('ResearchActivityType',function ($query) use ($search, $filter, $user) {
                        if ($user->type == 'user') {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                        $query->where('name', 'LIKE', "%$search%")->where('status', $filter);
                    })->orderBy('created_at', $order)->paginate($this->perPage);
                // dd(\DB::getQueryLog());

            } else {

                $researchActivites = ResearchActivity::where(function ($query) use ($user) {
                    if ($user->type == 'user') {
                        $query->where('profile_id', '=', $user->profile->id);
                    }
                })
                    ->where('status', $filter)
                    ->orderBy('created_at', $order)
                    ->paginate($this->perPage);
            }
        }
        return ResearchActivityResource::collection($researchActivites);

    }
    public function researchActivityRelation(Request $request){
        // $this->authorize('IsUserOrIsAdmin');

        $research_activity_types = ResearchActivityType::all()->map(function ($item){
            return ['id'=> $item['id'], 'text'=>$item['name']];
        })->toArray();
        $termes = Term::all()->map(function ($item){
            return ['id'=> $item['id'], 'text'=>$item['name']];
        })->toArray();
        if($request->is('api/researchActivityReportRelation')) {
            $departments = Department::all()->map(function ($item){
                return ['id'=> $item['id'], 'text'=>$item['name']];
            })->toArray();
            $faculties = Faculty::all()->map(function ($item){
                return ['id'=> $item['id'], 'text'=>$item['name']];
            })->toArray();
            return Response::json(array('research_activity_types'=>$research_activity_types,
                'terms'=> $termes, 'departments'=> $departments,
                'faculties' => $faculties));

        }else{
            return Response::json(array( 'research_activity_types'=>$research_activity_types, 'terms'=>$termes));
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return ResearchActivityResource
     * @throws \Exception
     */
    public function store(ResearchActivityRequest $request)
    {
        //
        $term = Term::whereStatus(1)->first();

        if(Carbon::now()->between( $term->starts_at, $term->ends_at)) {
            DB::beginTransaction();
            try {
                $fileBag = $request->files;

                $request['profile_id'] = auth('api')->user()->profile['id'];
                $request['status'] = 0;
                $request['term_id'] = $term->id;
                $research_activity_db = ResearchActivity::create($request->all());

                foreach ($fileBag as $files) {
                    foreach ($files as $file) {
                        $name = time() . rand() . '.' . $file->getClientOriginalExtension();
                        $file->move('files/research_activity', $name);
                        $research_activity_db->files()->create(['name' => $name]);
                    }
                }


            } catch (\Exception $e) {
                DB::rollback();
                return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
            }
            DB::commit();
            return new ResearchActivityResource($research_activity_db);
        }else{
            return Response::json(['message'=>'تاریخ ثبت اطلاعات برای ترم جاری به اتمام رسیده است'],405);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param ResearchActivity $ResearchActivity
     * @return ResearchActivityResource
     */
    public function show($id)
    {
        //
        $ResearchActivity = ResearchActivity::findOrFail($id);
        return new ResearchActivityResource($ResearchActivity);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ResearchActivity $ResearchActivity
     * @return void
     */
    public function edit(ResearchActivity $ResearchActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param ResearchActivity $ResearchActivity
     * @return ResearchActivityResource
     * @throws \Exception
     */
    public function update(ResearchActivityRequest $request, $id)
    {

        //
        $ResearchActivity = ResearchActivity::findOrFail($id);
        DB::beginTransaction();
        try {
            $fileBag = $request->files;

           // $request['profile_id'] =  auth('api')->user()->profile['id'];
            $request['status'] = 4;

            $ResearchActivity_db = $ResearchActivity->update($request->all());


            if ($request->has('fileChangeType')) {
                if ($request->fileChangeType == '0') {
                    $files = $ResearchActivity->files;
                    foreach ($files as $file){
                        $file->delete();
                    }
                }
                foreach ($fileBag as $files) {
                    foreach ($files as $file) {
                        $name = time() . rand() . '.' . $file->getClientOriginalExtension();
                        $file->move('files/research_activity', $name);
                        $ResearchActivity->files()->create(['name' => $name]);
                    }
                }
            }
            $ResearchActivity = ResearchActivity::findOrFail($id);

        }catch (\Exception $e){
            DB::rollback();
            return Response::json(['dberror'=> ["خطای در پایگاه داده رخ داده است"] ], 402);
        }
        DB::commit();
        return new ResearchActivityResource($ResearchActivity);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ResearchActivity $ResearchActivity
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        //
        $ResearchActivity = ResearchActivity::findOrFail($id);
        DB::beginTransaction();
        try {
            $ResearchActivity->delete();
        }catch (\Exception $e){
            DB::rollback();
            return Response::json(['dberror'=> ["خطای در پایگاه داده رخ داده است"] ], 402);
        }
        DB::commit();
        return Response::json(['فعالیت پژوهشی مورد نظر با موفقیت حذف شد.'], 200);
    }
}
