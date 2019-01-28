<?php

namespace App\Http\Controllers\API;

use App\ConfType;
use App\Excerpt;
use App\Http\Requests\PaperRequest;
use App\Jtype;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class PapersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function paperRelation(){
        $excerpts = Excerpt::all()->map(function ($item){
            return ['id'=> $item['id'], 'text'=>$item['name']];
        })->toArray();
        $conftypes = ConfType::all()->map(function ($item){
            return ['id'=> $item['id'], 'text'=>$item['name']];
        })->toArray();
        $jtypes = Jtype::all()->map(function ($item){
            return ['id'=> $item['id'], 'text'=>$item['name']];
        })->toArray();

        return Response::json(array('excerpts'=>$excerpts, 'jtypes'=>$jtypes, 'conftypes'=>$conftypes));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
    }


    public function paperValidation(PaperRequest $request){
        dd(json_decode($request->authorsjson));
        //dd($request->all());

    }
}
