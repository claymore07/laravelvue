<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ProposalReviewResource;
use App\Models\ProposalReview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Response;

class ProposalReviewController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt');
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(){

        $profile_id = auth('api')->user()->profile['id'];
        $reviews = ProposalReview::with(['proposal', 'profile'])->where('profile_id', $profile_id)->orderBy('created_at', 'desc')->get();
        return ProposalReviewResource::collection($reviews);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function assign(Request $request)
    {
         $this->authorize('IsAdminOrIsAuthor');
        $this->validate($request,
            [
                'research_proposal_id'=>'required',
                'reviewers_ids'=>'required',
            ],
            [
                'researchProposal_id.required'=>'شماره شناسه پروپوزال باید وار شود',
                'reviewers_ids.required'=>'حداقل یک داور باید انتخاب شود',
            ]
        );
         $researchProposal_id = $request->research_proposal_id;
         $reviewers_ids = $request->reviewers_ids;
         $reviewers = [];
         $ids = [];
         foreach ($reviewers_ids as $index =>$reviewers_id){
             $reviewers[$index] = ProposalReview::create(['research_proposal_id'=>$researchProposal_id, 'profile_id'=>$reviewers_id]);
             $ids[$index] = $reviewers[$index]['id'];
         }
        $reviewers = ProposalReview::with(['proposal', 'profile'])->whereIn('id',$ids)->get();
        return ProposalReviewResource::collection($reviewers);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show($id)
    {
        //
        $reviews = ProposalReview::with(['proposal', 'profile'])->where('research_proposal_id', $id)
            ->orderBy('created_at', 'desc');
        if($reviews->count()>0){
            return ProposalReviewResource::collection($reviews->get());
        }else{
            return Response::json(['message'=>'داوری برای پروپوزال انتخاب نشده است!'],405);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return ProposalReviewResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function comment(Request $request, $id)
    {
        //
        $this->validate($request,
            [
                'comment'=>'required',
                'status'=>'required',
            ],
            [
                'comment.required'=>'نظرات بررسی باید وارد شود',
                'status.required'=>'نظر نهایی باید انتخاب شود',
            ]
        );
        $profile_id = auth('api')->user()->profile['id'];
        $research_proposal_id = $request->research_proposal_id;
        $reviews = ProposalReview::with(['proposal', 'profile'])->where('profile_id', $profile_id)
            ->where('research_proposal_id', $research_proposal_id)
            ->where('id', $id);
        if($reviews->count()>0){
            $review = $reviews->first();
            $review->update($request->all());
            $review = ProposalReview::findOrFail($id);
            return new ProposalReviewResource($review);
        }else{
            return Response::json(['message'=>'شما حق ثبت نظر داوری را در این پروپوزال ندارید!'],405);
        }


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
        DB::beginTransaction();
        try {
            $proposalReview = ProposalReview::findOrFail($id);
            $proposalReview->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
        }
        DB::commit();
        return Response::json(['نظر داور مورد نظر با موفقیت حذف شد.'], 200);

    }
}
