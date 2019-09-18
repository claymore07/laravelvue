<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookletRequest;
use App\Http\Resources\BookletResource;
use App\Http\Resources\DegreeResource;
use App\Models\Booklet;
use App\Models\Degree;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Term;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use DB;
use Response;

class BookletController extends Controller
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
        $order = \Request::get('order');
        $this->perPage = \Request::get('perPage');

        $user = Auth::user('api')->load('profile');
        $booklets = Booklet::where(function ($query) use ($user) {
            if ($user->type == 'user')  {
                $query->where('profile_id', '=', $user->profile->id);
            }
        })->orderBy('created_at', $order)->paginate($this->perPage);

        return BookletResource::collection($booklets);
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
                $booklets = Booklet::where(function ($query) use ($user) {
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
                        $query->orWhere('name', 'LIKE', "%$search%");
                    })->orWhereHas ('degree',function ($query) use ($search, $filter, $user) {
                        if ($user->type == 'user') {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                        $query->where('name', 'LIKE', "%$search%");
                    })->orderBy('created_at', $order)->paginate($this->perPage);
                //dd(\DB::getQueryLog());
            } else {
                $booklets = Booklet::where(function ($query) use ($user) {
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

                $booklets = Booklet::where(function ($query) use ($user) {
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
                        $query->orWhere('name', 'LIKE', "%$search%")->where('status', $filter);

                    })->orWhereHas ('degree',function ($query) use ($search, $filter, $user) {
                        if ($user->type == 'user') {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                        $query->where('name', 'LIKE', "%$search%")->where('status', $filter);
                    })->orderBy('created_at', $order)->paginate($this->perPage);
                // dd(\DB::getQueryLog());

            } else {

                $booklets = Booklet::where(function ($query) use ($user) {
                    if ($user->type == 'user') {
                        $query->where('profile_id', '=', $user->profile->id);
                    }
                })
                    ->where('status', $filter)
                    ->orderBy('created_at', $order)
                    ->paginate($this->perPage);
            }
        }
        return BookletResource::collection($booklets);

    }

    public function bookletRelation(Request $request){
        $degrees = Degree::all()->map(function ($item){
            return ['id'=> $item['id'], 'text'=>$item['name']];
        })->toArray();
        $termes = Term::all()->map(function ($item){
            return ['id'=> $item['id'], 'text'=>$item['name']];
        })->toArray();
        if($request->is('api/bookletReportRelation')) {
            $departments = Department::all()->map(function ($item){
                return ['id'=> $item['id'], 'text'=>$item['name']];
            })->toArray();
            $faculties = Faculty::all()->map(function ($item){
                return ['id'=> $item['id'], 'text'=>$item['name']];
            })->toArray();
            return Response::json(array('degrees'=>$degrees,'terms'=> $termes,
                'departments'=> $departments,
                'faculties' => $faculties));

        }else{
            return Response::json(array('degrees'=>$degrees, 'terms'=>$termes));
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse | BookletResource
     * @throws \Exception
     */
    public function store(BookletRequest $request)
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
                $booklet_db = Booklet::create($request->all());

                foreach ($fileBag as $files) {
                    foreach ($files as $file) {
                        $name = time() . rand() . '.' . $file->getClientOriginalExtension();
                        $file->move('files/booklets', $name);
                        $booklet_db->files()->create(['name' => $name]);
                    }
                }


            } catch (\Exception $e) {
                DB::rollback();
                return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
            }
            DB::commit();
            return new BookletResource($booklet_db);
        }else{
            return Response::json(['message'=>'تاریخ ثبت اطلاعات برای ترم جاری به اتمام رسیده است'],405);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booklet  $booklet
     * @return BookletResource
     */
    public function show(Booklet $booklet)
    {
        //
        return new BookletResource($booklet);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Booklet $booklet
     * @return BookletResource
     * @throws \Exception
     */
    public function update(BookletRequest $request, Booklet $booklet)
    {
        //
        DB::beginTransaction();
        try {
            $fileBag = $request->files;
            $request['status'] = 4;

            $booklet->update($request->all());

            if ($request->has('fileChangeType')) {
                if ($request->fileChangeType == '0') {
                    $files = $booklet->files;
                    foreach ($files as $file){
                        $file->delete();
                    }
                }
                foreach ($fileBag as $files) {
                    foreach ($files as $file) {
                        $name = time() . rand() . '.' . $file->getClientOriginalExtension();
                        $file->move('files/booklets', $name);
                        $booklet->files()->create(['name' => $name]);
                    }
                }
            }
            $booklet = Booklet::findOrFail($booklet->id);

        }catch (\Exception $e){
            DB::rollback();
            return Response::json(['dberror'=> ["خطای در پایگاه داده رخ داده است"] ], 402);
        }
        DB::commit();
        return new BookletResource($booklet);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booklet $booklet
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Booklet $booklet)
    {
        DB::beginTransaction();
        try {
            $booklet->checklists()->delete();
            $files = $booklet->files;

            foreach ($files as $file){
                $file->delete();
            }
            $booklet->delete();
        }catch (\Exception $e){
            DB::rollback();
            return Response::json(['dberror'=> ["خطای در پایگاه داده رخ داده است"] ], 402);
        }
        DB::commit();
        return Response::json(['اطلاعات جایزه مورد نظر با موفقیت حذف شد.'], 200);
    }
}
