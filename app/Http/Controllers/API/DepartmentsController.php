<?php

namespace App\Http\Controllers\API;

use App\Department;
use App\Http\Requests\DepartmentResust;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class DepartmentsController extends Controller
{
    protected $perPage=5;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //
        $order = \Request::get('order');
        /** @var Faculty $faculties */
        $departments = Department::orderBy('created_at', $order)->paginate($this->perPage);
        return Response::json(array('departments'=>$departments),200);
    }
    public function search(){
        $order = \Request::get('order');

        if ($search = \Request::get('q')) {

            $departments = Department::where('name','LIKE',"%$search%")
                ->orderBy('created_at', $order)->paginate($this->perPage);

        } else {
            $departments = Department::orderBy('created_at', $order)->paginate($this->perPage);
        }

        return Response::json(array('departments'=>$departments),200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DepartmentResust $request)
    {
        //
        $department = Department::create($request->all());
        return Response::json(['department'=>$department], 200);
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DepartmentResust $request, $id)
    {
        //
        $department = Department::findOrFail($id);
        $department->update($request->all());
        return Response::json(['faculty'=>$department], 200);
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
        $department = Department::withCount('profiles')->findOrFail($id);
        if($department->profiles_count > 0){
            return Response::json(['db_error'=>'امکان حذف وجود ندارد'], 402);
        }else{
            $department->delete();
        }
        return Response::json(['dep'=>$department->profiles_count], 200);
    }
}
