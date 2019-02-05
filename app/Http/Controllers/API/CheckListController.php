<?php

namespace App\Http\Controllers\API;

use App\Checklist;
use App\Paper;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckListController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //+
        $this->validate($request,
            [
                'status'=>'required'
            ],
            [
                'status.required'=>'وضعیت بررسی مقاله باید ثبت شود.'
            ]
            );
        $paper_db = Paper::findOrFail($request->id);
        DB::beginTransaction();
        try {
            $input = [];
            $input['status'] = $request->status;
            if (count($request->list)) {
                $input['comment'] = $request->comment;
                $input['list'] = implode(",", $request->list);
                $checkListItem = $paper_db->checklists()->create($input);
            }
            $paper_db->update($input);
        } catch (\Exception $e) {

            DB::rollback();
            return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
        }

        DB::commit();
        return 'dddd';
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
}
