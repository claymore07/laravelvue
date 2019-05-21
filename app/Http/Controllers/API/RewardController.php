<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RewardRequest;

use App\Http\Resources\RewardResource;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Reward;
use App\Models\Term;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Response;

class RewardController extends Controller
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

        $user = Auth::user('api')->load('profile');
        $rewards = Reward::where(function ($query) use ($user) {
            if ($user->type == 'admin') {

            } else {
                $query->where('profile_id', '=', $user->profile->id);
            }
        })->orderBy('created_at', $order)->paginate($this->perPage);

        return RewardResource::collection($rewards);
    }
    public function search(){
        //$this->authorize('IsUserOrIsAdmin');
        $order = \Request::get('order');
        $filter = \Request::get('filter');
        $user = Auth::user('api')->load('profile');
        if($filter == '5') {
            if ($search = \Request::get('q')) {

                // \DB::enableQueryLog();
                $rewards = Reward::where(function ($query) use ($user) {
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
                        $query->orWhere('name', 'LIKE', "%$search%");
                    })->orderBy('created_at', $order)->paginate($this->perPage);
                //dd(\DB::getQueryLog());
            } else {
                $rewards = Reward::where(function ($query) use ($user) {
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

                $rewards = Reward::where(function ($query) use ($user) {
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
                        $query->orWhere('name', 'LIKE', "%$search%")->where('status', $filter);

                    })->orderBy('created_at', $order)->paginate($this->perPage);
                // dd(\DB::getQueryLog());

            } else {

                $rewards = Reward::where(function ($query) use ($user) {
                    if ($user->type != 'admin') {
                        $query->where('profile_id', '=', $user->profile->id);
                    }
                })
                    ->where('status', $filter)
                    ->orderBy('created_at', $order)
                    ->paginate($this->perPage);
            }
        }
        return RewardResource::collection($rewards);

    }
    public function rewardRelation(Request $request){
        $termes = Term::all()->map(function ($item){
            return ['id'=> $item['id'], 'text'=>$item['name']];
        })->toArray();
        if($request->is('api/rewardReportRelation')) {
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
     * @return RewardResource
     * @throws \Exception
     */
    public function store(RewardRequest $request)
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
                $reward_db = Reward::create($request->all());

                foreach ($fileBag as $files) {
                    foreach ($files as $file) {
                        $name = time() . rand() . '.' . $file->getClientOriginalExtension();
                        $file->move('files/rewards', $name);
                        $reward_db->files()->create(['name' => $name]);
                    }
                }


            } catch (\Exception $e) {
                DB::rollback();
                return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
            }
            DB::commit();
            return new RewardResource($reward_db);
        }else{
            return Response::json(['message'=>'تاریخ ثبت اطلاعات برای ترم جاری به اتمام رسیده است'],405);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reward  $reward
     * @return RewardResource
     */
    public function show(Reward $reward)
    {
        //
        return new RewardResource($reward);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Reward $reward
     * @return RewardResource
     * @throws \Exception
     */
    public function update(RewardRequest $request, Reward $reward)
    {
        //
        DB::beginTransaction();
        try {
            $fileBag = $request->files;
            $request['status'] = 4;

            $reward->update($request->all());
            if ($request->has('fileChangeType')) {
                if ($request->fileChangeType == '0') {
                    $files = $reward->files;
                    foreach ($files as $file){
                        $file->delete();
                    }
                }
                foreach ($fileBag as $files) {
                    foreach ($files as $file) {
                        $name = time() . rand() . '.' . $file->getClientOriginalExtension();
                        $file->move('files/rewards', $name);
                        $reward->files()->create(['name' => $name]);
                    }
                }
            }
            $reward = Reward::findOrFail($reward->id);

        }catch (\Exception $e){
            DB::rollback();
            return Response::json(['dberror'=> ["خطای در پایگاه داده رخ داده است"] ], 402);
        }
        DB::commit();
        return new RewardResource($reward);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reward $reward
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Reward $reward)
    {
        //
        DB::beginTransaction();
        try {
            $reward->checklists()->delete();
            $files = $reward->files;

            foreach ($files as $file){
                $file->delete();
            }
            $reward->delete();
        }catch (\Exception $e){
            DB::rollback();
            return Response::json(['dberror'=> ["خطای در پایگاه داده رخ داده است"] ], 402);
        }
        DB::commit();
        return Response::json(['اطلاعات جایزه مورد نظر با موفقیت حذف شد.'], 200);
    }
}
