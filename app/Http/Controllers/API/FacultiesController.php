<?php

namespace App\Http\Controllers\API;

use App\Models\Faculty;
use App\Http\Requests\FacultyResust;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class FacultiesController extends Controller
{
    protected $perPage=3;
    public function __construct()
    {
        $this->middleware('auth:api');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //
        $this->authorize('isAdmin');
        $order = \Request::get('order');
        /** @var Faculty $faculties */
        $faculties = Faculty::orderBy('created_at', $order)->paginate($this->perPage);
        return Response::json(array('faculties'=>$faculties),200);

    }
    public function search(){
        $this->authorize('isAdmin');
        $order = \Request::get('order');

            if ($search = \Request::get('q')) {

                $faculties = Faculty::where('name','LIKE',"%$search%")
                    ->orderBy('created_at', $order)->paginate($this->perPage);

            } else {
                $faculties = Faculty::orderBy('created_at', $order)->paginate($this->perPage);
            }

        return Response::json(array('faculties'=>$faculties),200);

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FacultyResust $request)
    {
        //
        $this->authorize('isAdmin');
        $faculty = Faculty::create($request->all());
        return Response::json(['faculty'=>$faculty], 200);
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
        $this->authorize('isAdmin');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FacultyResust $request, $id)
    {
        //
        $this->authorize('isAdmin');
        $faculty = Faculty::findOrFail($id);
        $faculty->update($request->all());
        return Response::json(['faculty'=>$faculty], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
        $this->authorize('isAdmin');
        $faculty = Faculty::withCount('profiles')->findOrFail($id);
        if($faculty->profiles_count > 0){
            return Response::json(['db_error'=>'امکان حذف وجود ندارد'], 402);
        }else{
            $faculty->delete();
        }
        return Response::json(['fac'=>$faculty->profiles_count], 200);
    }
}
