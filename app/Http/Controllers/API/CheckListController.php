<?php

namespace App\Http\Controllers\API;

use App\Checklist;
use App\Paper;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function store(Request $request)
    {
        //+
        $this->validate($request,
            [
                'status'=>'required',
                'comment'=>'required'
            ],
            [
                'status.required'=>'وضعیت بررسی مقاله باید ثبت شود.',
                'comment.required'=>'توضیحات و راهنمایی ها برای ادامه روند توسط کاربر باید درج شود.'
            ]
            );
        $paper_db = Paper::findOrFail($request->id);

         DB::beginTransaction();
       try {
             $input = [];
             $input['status'] = $request->status;

             if (count($request->list)>0) {
                 $input['list'] = implode(",", $request->list);

             }else{
                 $input['list'] = null;
             }
             $input['comment'] = $request->comment;
             $checkListItem = $paper_db->checklists()->create($input);
             $checkListItem['list'] = $request->list;
             $paper_db->update($input);
         } catch (\Exception $e) {

             DB::rollback();
             return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
         }

         DB::commit();
         return Response::json(['checkListItem' => $checkListItem], 200);
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
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        //
        $checkListItem = Checklist::findOrFail($id);
        $checkable = $checkListItem->checkable;
        //dd($checkable->checklists()->latest()->first());
        if(is_null($checkable->checklists()->latest()->first()->list)){

            $checkable->update(['status'=>2]);
        }
        $checkListItem->delete();
        return Response::json(['checkListItem' => $checkListItem], 200);
    }
}
