<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\BlackListResource;
use App\Models\BlackList;
use App\Imports\BlackListImport;
use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Nexmo\Response;

class BlackListController extends Controller
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
        $blacklists = BlackList::orderBy('created_at', $order)->paginate($this->perPage);
        return BlackListResource::collection($blacklists);
    }

    public function search(Request $request){
        $order = $request->get('order');
        $search = $request->get('q');

        $blacklists = BlackList::where('title', 'LIKE', "%$search%")
            ->orWhere('issn', 'LIKE',"%$search%")
            ->orderBy('created_at', $order)
            ->paginate($this->perPage);
        return BlackListResource::collection($blacklists);
    }
    public function blackListCheck(Request $request){

        $search = $request->get('q');

        $blacklist = BlackList::where('issn', 'LIKE',"%$search%")
            ->first();
        $flag = false;
        if(!is_null($blacklist)){
            $flag = true;
            return \Response::json(['data' =>new BlackListResource($blacklist),'flag'=>$flag],200);
        }else{
            $flag = false;
            return \Response::json(['data' =>'','flag'=>$flag],200);
        }

    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function import(Request $request)
    {
        $this->validate($request,[
           'file'=>'required|mimes:xls,xlsx'
        ],[
            'file.required'=>'فایل حاوی لیست مجلات ضروری می باشد.',
            'file.mimes'=>'نوع فایل حاوی لیست مجلات باید xls یا xlsx باشد.'
        ]);
        Excel::import(new BlackListImport,  $request->file('file'));

        return redirect('/')->with('success', 'All good!');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\BlackList  $blackList
     * @return \Illuminate\Http\Response
     */
    public function show(BlackList $blackList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BlackList  $blackList
     * @return \Illuminate\Http\Response
     */
    public function edit(BlackList $blackList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BlackList  $blackList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlackList $blackList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BlackList  $blackList
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $blackList = BlackList::findOrFail($id);
        $counts = Journal::where('blacklist_id', $blackList->id)->count();
        if($counts > 0){
            return \Response::json(['message'=>'به دلیل وجود مقالات وابسته امکان حذف وجود ندارد.'],403);
        }else{
            $blackList->delete();
            return \Response::json(['message'=>'با موفیت حذف شد.'],200);
        }
    }
}
