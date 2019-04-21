<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ThesisResquest;
use App\Http\Resources\DegreeResource;

use App\Http\Resources\ThesisResource;
use App\Models\Degree;
use App\Models\Term;
use App\Models\ThesesType;
use App\Models\Thesis;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use Auth;
use DB;

class ThesisController extends Controller
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
        $theses = Thesis::where(function ($query) use ($user) {
            if ($user->type == 'admin') {

            } else {
                $query->where('profile_id', '=', $user->profile->id);
            }
        })
            ->orderBy('created_at', $order)->paginate($this->perPage);
        return ThesisResource::collection($theses);
    }

    public function search(){
        //$this->authorize('IsUserOrIsAdmin');
        $order = \Request::get('order');
        $filter = \Request::get('filter');
        $user = Auth::user('api')->load('profile');
        if($filter == '5') {
            if ($search = \Request::get('q')) {
                // \DB::enableQueryLog();
                $theses = Thesis::where(function ($query) use ($user) {
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
                $theses = Thesis::where(function ($query) use ($user) {
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
                $theses = Thesis::where(function ($query) use ($user) {
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
                        $query->where('title', 'LIKE', "%$search%")
                            ->where('status', $filter);
                    })->orderBy('created_at', $order)->paginate($this->perPage);
                // dd(\DB::getQueryLog());

            } else {

                $theses = Thesis::where(function ($query) use ($user) {
                        if ($user->type != 'admin') {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                    })
                    ->where('status', $filter)
                    ->orderBy('created_at', $order)
                    ->paginate($this->perPage);
            }
        }
        return ThesisResource::collection($theses);

    }

    public function thesisRelation(){
        $theses_types = ThesesType::all()->map(function ($item){
            return ['id'=> $item['id'], 'text'=>$item['name']];
        })->toArray();
        $termes = Term::all()->map(function ($item){
            return ['id'=> $item['id'], 'text'=>$item['name']];
        })->toArray();
        return Response::json(array('theses_types'=>$theses_types, 'terms'=>$termes));

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  ThesisResquest  $request
     * @return \Illuminate\Http\JsonResponse | ThesisResource
     */
    public function store(ThesisResquest $request)
    {
        //
        $term = Term::whereStatus(1)->first();

        if(Carbon::now()->between( $term->starts_at, $term->ends_at)){
            $request['profile_id'] = auth('api')->user()->profile['id'];
            $request['status'] = 0;
            $request['term_id'] = $term->id;
            $thesis = Thesis::create($request->all());

            return new ThesisResource($thesis);
        }else{
            return Response::json(['message'=>'تاریخ ثبت اطلاعات برای ترم جاری به اتمام رسیده است'],405);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Thesis  $thesis
     * @return ThesisResource
     */
    public function show($id)
    {
        //
        $thesis = Thesis::findOrFail($id);

        return new ThesisResource($thesis);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Thesis  $thesis
     * @return ThesisResource
     */
    public function update(ThesisResquest $request, $id)
    {
        //
        $thesis = Thesis::findOrFail($id);
        $request['status'] = 4;

        $thesis->update($request->all());
        return new ThesisResource($thesis);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Thesis $thesis
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        //
        DB::beginTransaction();
        try {
            $thesis = Thesis::findOrFail($id);
            $thesis->checklists()->delete();
            $thesis->delete();
       }catch (\Exception $e){
            DB::rollback();
            return Response::json(['dberror'=> ["خطای در پایگاه داده رخ داده است"] ], 402);
        }
        DB::commit();

        return Response::json(['پابان نامه مورد نظر با موفقیت حذف شد.'], 200);
    }
}
