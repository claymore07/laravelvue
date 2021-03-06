<?php

namespace App\Http\Controllers\API;

use App\Models\Department;
use App\Http\Requests\DepartmentResust;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class DepartmentsController extends Controller
{
    protected $perPage=10;
    public function __construct()
    {
        $this->middleware('auth:api');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        //
        $this->authorize('IsAdminOrIsAuthor');

        $order = \Request::get('order');
        /** @var Faculty $faculties */
        $departments = Department::orderBy('created_at', $order)->paginate($this->perPage);
        return Response::json(array('departments'=>$departments),200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function search(){
        $this->authorize('IsAdminOrIsAuthor');

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(DepartmentResust $request)
    {
        //
        $this->authorize('IsAdminOrIsAuthor');

        $department = Department::create($request->all());
        return Response::json(['department'=>$department], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id)
    {
        //
        $this->authorize('IsAdminOrIsAuthor');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(DepartmentResust $request, $id)
    {
        //
        $this->authorize('IsAdminOrIsAuthor');

        $department = Department::findOrFail($id);
        $department->update($request->all());
        return Response::json(['faculty'=>$department], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        //
        $this->authorize('IsAdminOrIsAuthor');

        $department = Department::withCount('profiles')->findOrFail($id);
        if($department->profiles_count > 0){
            return Response::json(['db_error'=>'امکان حذف وجود ندارد'], 402);
        }else{
            $department->delete();
        }
        return Response::json(['dep'=>$department->profiles_count], 200);
    }
}
