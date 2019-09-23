<?php

namespace App\Http\Controllers\API;

use App\Models\ProposalType;
use App\Models\ProposalUsage;
use App\Models\ResearchProposal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use DB;

class ProposalRelationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('jwt');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     */
    public function getProposalType(){
        $this->authorize('IsAdminOrIsAuthor');

        $proposalTypes = ProposalType::all()->map(function ($item){
            return ['id'=> $item['id'], 'name'=>$item['name']];
        })->toArray();
        foreach ($proposalTypes as $index => $proposalType){
            $proposalTypes[$index]['count'] = ResearchProposal::with(['proposalType'])->whereHas('proposalType',
                function ($query) use ($proposalType){
                $query->where('proposal_type_id',  $proposalType['id']);
            })->count();
        }
        return Response::json(['proposalTypeList'=>$proposalTypes], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateResearchProposalTypeTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $this->validate($request,
            [
                'name'=>'required',
            ],
            [
                'name.required'=>'نام زیر نوع باید وار شود',
            ]
        );
        $proposalType = ProposalType::findOrFail($id);
        $proposalType->update($request->all());
        $proposalType = ProposalType::findOrFail($id);
        return Response::json($proposalType);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function addResearchProposalTypeTitle(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        DB::beginTransaction();
        try {
            $proposalType = ProposalType::create($request->all());
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
        }
        DB::commit();
        $result['id'] = $proposalType->id;
        $result['name'] = $proposalType->name;
        $result['count'] = 0;
        return Response::json($result);

    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function deleteResearchProposalTypeTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $count = ResearchProposal::with(['proposalType'])->whereHas('proposalType', function ($query) use ($id){
            $query->where('proposal_type_id',  $id);
        })->count();
        if($count == 0){
            DB::beginTransaction();
            try {
                $proposalType = ProposalType::findOrFail($id);
                $proposalType->delete();
            } catch (\Exception $e) {
                DB::rollback();
                return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
            }
            DB::commit();
            return Response::json(['زیر نوع مورد نظر با موفقیت حذف شد.'], 200);
        }else{
            return Response::json(['dberror' => ["به دلیل وجود آثاری که عضو زیر نوع مورد نظر می باشند امکان حذف وجود ندارد!"]], 402);
        }
    }
    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     */
    public function getProposalUsageTypes(){
        $this->authorize('IsAdminOrIsAuthor');

        $proposalUsages = ProposalUsage::all()->map(function ($item){
            return ['id'=> $item['id'], 'name'=>$item['name']];
        })->toArray();
        foreach ($proposalUsages as $index => $proposalUsage){
            $proposalUsages[$index]['count'] = ResearchProposal::with(['proposalUsage'])->whereHas('proposalUsage', function ($query) use ($proposalUsage){
                $query->where('proposal_usage_id',  $proposalUsage['id']);
            })->count();
        }
        return Response::json(['proposalUsageList'=>$proposalUsages], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateResearchProposalUsageTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $this->validate($request,
            [
                'name'=>'required',
            ],
            [
                'name.required'=>'نام زیر نوع باید وار شود',
            ]
        );
        $proposalUsage = ProposalUsage::findOrFail($id);
        $proposalUsage->update($request->all());
        $proposalUsage = ProposalUsage::findOrFail($id);
        return Response::json($proposalUsage);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function addResearchProposalUsageTitle(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        DB::beginTransaction();
        try {
            $proposalUsage = ProposalUsage::create($request->all());
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
        }
        DB::commit();

        $result['id'] = $proposalUsage->id;
        $result['name'] = $proposalUsage->name;
        $result['count'] = 0;
        return Response::json($result);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function deleteResearchProposalUsageTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $count = ResearchProposal::with(['proposalUsage'])->whereHas('proposalUsage', function ($query) use ($id){
            $query->where('proposal_usage_id',  $id);
        })->count();
        if($count == 0){
            DB::beginTransaction();
            try {
                $confType = ProposalUsage::findOrFail($id);
                $confType->delete();
            } catch (\Exception $e) {
                DB::rollback();
                return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
            }
            DB::commit();
            return Response::json(['زیر نوع مورد نظر با موفقیت حذف شد.'], 200);
        }else{
            return Response::json(['dberror' => ["به دلیل وجود آثاری که عضو زیر نوع مورد نظر می باشند امکان حذف وجود ندارد!"]], 402);
        }
    }
}
