<?php

namespace App\Http\Controllers\API;

use App\Models\Book;
use App\Models\Booklet;
use App\Models\Checklist;
use App\Models\Course;
use App\Models\Grant;
use App\Models\Invention;
use App\Models\Paper;
use App\Models\Project;
use App\Models\Referee;
use App\Models\ResearchActivity;
use App\Models\ResearchProposal;
use App\Models\Reward;
use App\Models\TEDChair;
use App\Models\Thesis;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class CheckListController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        //
        $this->authorize('isAdmin');
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

        $this->authorize('IsAdminOrIsAuthor');
        $this->validate($request,
            [
                'status' => 'required',
                'comment' => 'required',
                'score' => 'required_if:status,1'
            ],
            [
                'status.required' => 'وضعیت بررسی مقاله باید ثبت شود.',
                'score.required_if' => 'امتیاز در حالت تایید باید ثبت شود.',
                'comment.required' => 'توضیحات و راهنمایی ها برای ادامه روند توسط کاربر باید درج شود.'
            ]
        );
        $item_db = '';
        $path = $request->path();
        if ($path == 'api/paperCheckList') {
            $item_db = Paper::findOrFail($request->id);
        } elseif ($path == 'api/thesisCheckList') {
            $item_db = Thesis::findOrFail($request->id);
        } elseif ($path == 'api/bookCheckList') {
            $item_db = Book::findOrFail($request->id);
        } elseif ($path == 'api/rewardCheckList') {
            $item_db = Reward::findOrFail($request->id);
        }elseif ($path == 'api/projectCheckList') {
            $item_db = Project::findOrFail($request->id);
        }elseif ($path == 'api/tedCheckList') {
            $item_db = TEDChair::findOrFail($request->id);
        }elseif ($path == 'api/refereeCheckList') {
            $item_db = Referee::findOrFail($request->id);
        }elseif ($path == 'api/courseCheckList') {
            $item_db = Course::findOrFail($request->id);
        }elseif ($path == 'api/inventionCheckList') {
            $item_db = Invention::findOrFail($request->id);
        }elseif ($path == 'api/grantCheckList') {
            $item_db = Grant::findOrFail($request->id);
        }elseif ($path == 'api/bookletCheckList') {
            $item_db = Booklet::findOrFail($request->id);
        }elseif ($path == 'api/researchActivityCheckList') {
            $item_db = ResearchActivity::findOrFail($request->id);
        }elseif ($path == 'api/researchProposalCheckList') {
            $item_db = ResearchProposal::findOrFail($request->id);
        }else{
            return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
        }

        DB::beginTransaction();
        try {
            $input = [];
            $input['status'] = $request->status;
            $input['score'] = $request->score;

            if (count($request->list) > 0) {
                $input['list'] = implode(",", $request->list);

            } else {
                $input['list'] = null;
            }
            $input['comment'] = $request->comment;
            $input['reward'] = $request->reward;
            $checkListItem = $item_db->checklists()->create($input);
            $checkListItem['list'] = $request->list;
            $item_db->update($input);
        } catch (\Exception $e) {

            DB::rollback();
            return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
        }

        DB::commit();
        if ($path == 'api/researchProposalCheckList') {
            return Response::json(['checkListItem' => $checkListItem], 200);
        }else{
            return Response::json(['checkListItem' => $checkListItem, 'score' => $item_db->score, 'reward' => (string)$item_db->reward], 200);
        }
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
        $this->authorize('isAdmin');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, $id)
    {
        //
        $this->authorize('isAdmin');
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
        $this->authorize('IsAdminOrIsAuthor');
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
