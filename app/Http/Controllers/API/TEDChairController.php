<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\TEDChairRequest;
use App\Http\Resources\TEDChairResource;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\TEDChair;
use App\Models\TEDType;
use App\Models\Term;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use Auth;
use DB;

class TEDChairController extends Controller
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
        //
        $order = \Request::get('order');
        $user = Auth::user('api')->load('profile');
        $theses = TEDChair::where(function ($query) use ($user) {
            if ($user->type == 'admin') {

            } else {
                $query->where('profile_id', '=', $user->profile->id);
            }
        })
            ->orderBy('created_at', $order)->paginate($this->perPage);
        return TEDChairResource::collection($theses);
    }

    public function search(){
        //$this->authorize('IsUserOrIsAdmin');
        $order = \Request::get('order');
        $filter = \Request::get('filter');
        $user = Auth::user('api')->load('profile');
        if($filter == '5') {
            if ($search = \Request::get('q')) {

                // \DB::enableQueryLog();
                $TEDChairs = TEDChair::where(function ($query) use ($user) {
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
                    })->orWhereHas ('TEDType',function ($query) use ($search,$user) {
                        if ($user->type != 'admin') {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                        $query->where('name', 'LIKE', "%$search%");
                    })->orderBy('created_at', $order)->paginate($this->perPage);
                //dd(\DB::getQueryLog());
            } else {

                $TEDChairs = TEDChair::where(function ($query) use ($user) {
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
                $TEDChairs = TEDChair::where(function ($query) use ($user) {
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
                    })->orWhere(function ($query) use ($search, $filter, $user) {
                        if ($user->type != 'admin') {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                        $query->where('title', 'LIKE', "%$search%")->where('status', $filter);
                    })->orWhereHas ('TEDType',function ($query) use ($search, $filter, $user) {
                        if ($user->type != 'admin') {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                        $query->where('name', 'LIKE', "%$search%")->where('status', $filter);
                    })->orderBy('created_at', $order)->paginate($this->perPage);
                // dd(\DB::getQueryLog());

            } else {

                $TEDChairs = TEDChair::where(function ($query) use ($user) {
                    if ($user->type != 'admin') {
                        $query->where('profile_id', '=', $user->profile->id);
                    }
                })
                    ->where('status', $filter)
                    ->orderBy('created_at', $order)
                    ->paginate($this->perPage);
            }
        }
        return TEDChairResource::collection($TEDChairs);

    }
    public function tedChairRelation(Request $request){
        //$this->authorize('IsUserOrIsAdmin');

        $ted_types = TEDType::all()->map(function ($item){
            return ['id'=> $item['id'], 'text'=>$item['name']];
        })->toArray();
        $termes = Term::all()->map(function ($item){
            return ['id'=> $item['id'], 'text'=>$item['name']];
        })->toArray();
        if($request->is('api/tedChairReportRelation')) {
            $departments = Department::all()->map(function ($item){
                return ['id'=> $item['id'], 'text'=>$item['name']];
            })->toArray();
            $faculties = Faculty::all()->map(function ($item){
                return ['id'=> $item['id'], 'text'=>$item['name']];
            })->toArray();
            return Response::json(array('ted_types'=>$ted_types,
                'terms'=> $termes, 'departments'=> $departments,
                'faculties' => $faculties));

        }else{
            return Response::json(array('ted_types'=>$ted_types, 'terms'=>$termes));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse | TEDChairResource
     * @throws \Exception
     */
    public function store(TEDChairRequest $request)
    {
        //
        //
        $term = Term::whereStatus(1)->first();

        if(Carbon::now()->between( $term->starts_at, $term->ends_at)) {
            $request['profile_id'] = auth('api')->user()->profile['id'];
            $request['status'] = 0;
            $request['term_id'] = $term->id;
            DB::beginTransaction();
            try {
                $fileBag = $request->files;
                $tedchair_db = TEDChair::create($request->all());

                foreach ($fileBag as $files) {
                    foreach ($files as $file) {
                        $name = time() . rand() . '.' . $file->getClientOriginalExtension();
                        $file->move('files/tedchairs', $name);
                        $tedchair_db->files()->create(['name' => $name]);
                    }
                }


            } catch (\Exception $e) {
                DB::rollback();
                return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
            }
            DB::commit();
            return new TEDChairResource($tedchair_db);
        }else{
            return Response::json(['message'=>'تاریخ ثبت اطلاعات برای ترم جاری به اتمام رسیده است'],405);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TEDChair  $tEDChair
     * @return TEDChairResource
     */
    public function show($id)
    {
        //
        $tEDChair = TEDChair::findOrFail($id);

        return new TEDChairResource($tEDChair);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\TEDChair $tEDChair
     * @return TEDChairResource
     * @throws \Exception
     */
    public function update(TEDChairRequest $request, $id)
    {
        //

        DB::beginTransaction();
        try {
            $tEDChair = TEDChair::findOrFail($id);
            $fileBag = $request->files;
            $request['status'] = 4;

            $tEDChair->update($request->all());
            if ($request->has('fileChangeType')) {
                if ($request->fileChangeType == '0') {
                    $files = $tEDChair->files;
                    foreach ($files as $file){
                        $file->delete();
                    }
                }
                foreach ($fileBag as $files) {
                    foreach ($files as $file) {
                        $name = time() . rand() . '.' . $file->getClientOriginalExtension();
                        $file->move('files/tedchairs', $name);
                        $tEDChair->files()->create(['name' => $name]);
                    }
                }
            }
            $tEDChair = TEDChair::findOrFail($tEDChair->id);

        }catch (\Exception $e) {
            DB::rollback();
            return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
        }
              DB::commit();
        return new TEDChairResource($tEDChair);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TEDChair $tEDChair
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $tEDChair = TEDChair::findOrFail($id);
            $tEDChair->checklists()->delete();
            $files = $tEDChair->files;

            foreach ($files as $file){
                $file->delete();
            }
            $tEDChair->delete();
        }catch (\Exception $e){
            DB::rollback();
            return Response::json(['dberror'=> ["خطای در پایگاه داده رخ داده است"] ], 402);
        }
        DB::commit();
        return Response::json(['اطلاعات جایزه مورد نظر با موفقیت حذف شد.'], 200);
    }
}
