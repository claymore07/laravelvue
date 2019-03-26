<?php

namespace App\Http\Controllers\API;

use App\Models\Term;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class TermsController extends Controller
{
    protected $perPage=5;

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
        /** @var Term $terms */
        $terms = Term::orderBy('id', $order)->paginate($this->perPage);
        return Response::json(['terms'=>$terms], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //
        $this->authorize('isAdmin');

        $this->validate($request,
                [
                    'name' => 'required',
                    'starts_at'=>'required|date',
                    'ends_at'=>'required|date|after:starts_at'
                ],
                [
                    'name.required'=>'عنوان ترم الرامی است.',
                    'starts_at.required'=>'تاریخ شروغ ترم الرامی است.',
                    'ends_at.required'=>'تاریخ پایان ترم الرامی است.',
                    'ends_at.after'=>'تاریخ پایان ترم پس از تاریخ شروع آن باشد.',
                ]
            );
        $term = Term::create($request->all());

        return Response::json(['term'=>$term],200);
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->authorize('isAdmin');

        $this->validate($request,
            [
                'name' => 'required',
                'starts_at'=>'required|date',
                'ends_at'=>'required|date|after:starts_at'
            ],
            [
                'name.required'=>'عنوان ترم الرامی است.',
                'starts_at.required'=>'تاریخ شروغ ترم الرامی است.',
                'ends_at.required'=>'تاریخ پایان ترم الرامی است.',
                'ends_at.after'=>'تاریخ پایان ترم پس از تاریخ شروع آن باشد.',
            ]
        );
        $term = Term::findOrFail($id);
        $term->update($request->all());
        return Response::json(['term'=>$term],200);
    }

    public function termActivate(Request $request, $id){
        $this->authorize('isAdmin');

        $term = Term::findOrFail($id);
        Term::query()->update(['status'=>0]);
        $term->update(['status'=>1]);
        return Response::json(['term'=>$term],200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $this->authorize('isAdmin');

    }
}
