<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\GrantRequest;
use App\Http\Resources\GrantResource;
use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Models\Grant;
use App\Models\Term;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Response;
use Auth;
use DB;

class GrantController extends Controller
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
        $this->perPage = \Request::get('perPage');
        $order = \Request::get('order');
        $user = Auth::user('api')->load('profile');
        $grants = Grant::where(function ($query) use ($user) {
            if ($user->type == 'admin') {

            } else {
                $query->where('profile_id', '=', $user->profile->id);
            }
        })->orderBy('created_at', $order)->paginate($this->perPage);

        return GrantResource::collection($grants);

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
                $grants = Grant::where(function ($query) use ($user) {
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
                $grants = Grant::where(function ($query) use ($user) {
                    if ($user->type != 'admin') {
                        $query->where('profile_id', '=', $user->profile->id);
                    }
                })
                    ->orderBy('created_at', $order)
                    ->paginate($this->perPage);
            }
        }else{
            if ($search = \Request::get('q')) {
                // \DB::enableQueryLog();
                $grants = Grant::where(function ($query) use ($user) {
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
                $grants = Grant::where(function ($query) use ($user) {
                    if ($user->type != 'admin') {
                        $query->where('profile_id', '=', $user->profile->id);
                    }
                })
                    ->where('status', $filter)
                    ->orderBy('created_at', $order)
                    ->paginate($this->perPage);
            }
        }
        return GrantResource::collection($grants);

    }
    public function grantRelation(Request $request){
        $termes = Term::all()->map(function ($item){
            return ['id'=> $item['id'], 'text'=>$item['name']];
        })->toArray();
        if($request->is('api/grantReportRelation')) {
            $departments = Department::all()->map(function ($item){
                return ['id'=> $item['id'], 'text'=>$item['name']];
            })->toArray();
            $faculties = Faculty::all()->map(function ($item){
                return ['id'=> $item['id'], 'text'=>$item['name']];
            })->toArray();
            return Response::json(array('terms'=> $termes, 'departments'=> $departments,
                'faculties' => $faculties));

        }else{
            return Response::json(array('terms'=>$termes));
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse | GrantResource
     * @throws \Exception
     */
    public function store(GrantRequest $request)
    {
        //
        $term = Term::whereStatus(1)->first();

        if(Carbon::now()->between( $term->starts_at, $term->ends_at)) {
            $request['profile_id'] = auth('api')->user()->profile['id'];
            $request['status'] = 0;
            $request['term_id'] = $term->id;
            DB::beginTransaction();
            try {
                $fileBag = $request->files;

                $grant_db = Grant::create($request->all());

                foreach ($fileBag as $files) {

                    foreach ($files as $file) {

                        $name = time() . rand() . '.' . $file->getClientOriginalExtension();
                        $file->move('files/grants', $name);
                        $grant_db->files()->create(['name' => $name]);
                    }
                }


            } catch (\Exception $e) {
                DB::rollback();
                return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
            }
            DB::commit();
            return new GrantResource($grant_db);
        }else{
            return Response::json(['message'=>'تاریخ ثبت اطلاعات برای ترم جاری به اتمام رسیده است'],405);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grant  $grant
     * @return GrantResource
     */
    public function show(Grant $grant)
    {
        //
        return new GrantResource($grant);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grant  $grant
     * @return GrantResource
     */
    public function edit(Grant $grant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Grant $grant
     * @return \Illuminate\Http\JsonResponse | GrantResource
     * @throws \Exception
     */
    public function update(GrantRequest $request, Grant $grant)
    {
        //
        DB::beginTransaction();
        try {
            $fileBag = $request->files;
            $request['status'] = 4;

            $grant->update($request->all());
            if ($request->has('fileChangeType')) {

                if ($request->fileChangeType == '0') {

                    $files = $grant->files;
                    foreach ($files as $file){
                        $file->delete();
                    }
                }
                foreach ($fileBag as $files) {
                    foreach ($files as $file) {
                        $name = time() . rand() . '.' . $file->getClientOriginalExtension();
                        $file->move('files/grants', $name);
                        $grant->files()->create(['name' => $name]);
                    }
                }
            }
            $grant = Grant::findOrFail($grant->id);
        }catch (\Exception $e){
            DB::rollback();
            return Response::json(['dberror'=> ["خطای در پایگاه داده رخ داده است"] ], 402);
        }
        DB::commit();
        return new GrantResource($grant);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grant $grant
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Grant $grant)
    {
        //
        DB::beginTransaction();
        try {
            $grant->checklists()->delete();
            $files = $grant->files;

            foreach ($files as $file){
                $file->delete();
            }
            $grant->delete();
        }catch (\Exception $e){
            DB::rollback();
            return Response::json(['dberror'=> ["خطای در پایگاه داده رخ داده است"] ], 402);
        }
        DB::commit();
        return Response::json(['اطلاعات گرنت مورد نظر با موفقیت حذف شد.'], 200);
    }
}
