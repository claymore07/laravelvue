<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ThesisResquest;
use App\Http\Resources\DegreeResource;
use App\Http\Resources\ThesisEditResource;
use App\Http\Resources\ThesisResource;
use App\Models\Degree;
use App\Models\Thesis;
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
        $this->perPage=3;
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
        $degrees = Degree::all();
        return  DegreeResource::collection($degrees);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThesisResquest $request)
    {
        //
        $request['profile_id'] = auth('api')->user()->profile['id'];
        $thesis = Thesis::create($request->all());

        return new ThesisResource($thesis);

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

        return new ThesisEditResource($thesis);
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
        $thesis->update($request->all());
        return new ThesisEditResource($thesis);
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
        $thesis = Thesis::findOrFail($id);
        $thesis->delete();
        return Response::json(['پابان نامه مورد نظر با موفقیت حذف شد.'], 200);
    }
}
