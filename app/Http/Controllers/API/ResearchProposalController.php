<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Http\Requests\ResearchProposalRequest;
use App\Http\Resources\ResearchProposalResource;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\ProposalType;
use App\Models\ProposalUsage;
use App\Models\ResearchProposal;
use Carbon\Carbon;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use Auth;
use DB;
use Response;

class ResearchProposalController extends Controller
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
        $this->perPage = \Request::get('perPage');

        $user = Auth::user('api')->load('profile');
        $researchProposals = ResearchProposal::where(function ($query) use ($user) {
            if ($user->type == 'user') {
                $query->where('profile_id', '=', $user->profile->id);
            }
        })->orderBy('created_at', $order)->paginate($this->perPage);

        return ResearchProposalResource::collection($researchProposals);
    }
    public function search(){
        //$this->authorize('IsUserOrIsAdmin');
        $this->perPage = \Request::get('perPage');
        $order = \Request::get('order');
        $filter = \Request::get('filter');
        $user = Auth::user('api')->load('profile');

        if($filter == '8') {
            if ($search = \Request::get('q')) {
                // \DB::enableQueryLog();
                $researchProposals = ResearchProposal::where(function ($query) use ($user) {
                    if ($user->type == 'user') {
                        $query->where('profile_id', '=', $user->profile->id);
                    }
                })
                    ->whereHas('profile', function ($query) use ($search,$user) {
                        if ($search == trim($search) && strpos($search, ' ') !== false) {
                            $searchParts = explode(' ', $search);
                            $query->where('Fname', 'LIKE', "%$searchParts[0]%")
                                ->where('Lname', 'LIKE', "%$searchParts[1]%");
                        } else {
                            $query->where('Fname', 'LIKE', "%$search%")
                                ->orWhere('Lname', 'LIKE', "%$search%");
                        }
                    })->orWhere(function ($query) use ($search,$user) {
                        if ($user->type == 'user') {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                        $query->where('title', 'LIKE', "%$search%");
                        $query->orWhere('en_title', 'LIKE', "%$search%");
                    })->orWhereHas ('proposalType',function ($query) use ($search,$user) {
                        if ($user->type == 'user') {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                        $query->where('name', 'LIKE', "%$search%");
                    })->orderBy('created_at', $order)->paginate($this->perPage);
                //dd(\DB::getQueryLog());
            } else {
                $researchProposals = ResearchProposal::where(function ($query) use ($user) {
                    if ($user->type == 'user') {
                        $query->where('profile_id', '=', $user->profile->id);
                    }
                })
                    ->orderBy('created_at', $order)
                    ->paginate($this->perPage);
            }
        }else{
            if ($search = \Request::get('q')) {
                // \DB::enableQueryLog();
                $researchProposals = ResearchProposal::where(function ($query) use ($user) {
                    if ($user->type == 'user') {
                        $query->where('profile_id', '=', $user->profile->id);
                    }
                })
                    ->where('status', $filter)
                    ->whereHas('profile', function ($query) use ($search,$filter) {
                        if ($search == trim($search) && strpos($search, ' ') !== false) {
                            $searchParts = explode(' ', $search);
                            $query->where('Fname', 'LIKE', "%$searchParts[0]%")
                                ->where('Lname', 'LIKE', "%$searchParts[1]%");
                        } else {
                            $query->where('Fname', 'LIKE', "%$search%")
                                ->orWhere('Lname', 'LIKE', "%$search%");

                        }
                    })->orWhere(function ($query) use ($search, $filter, $user) {
                        if ($user->type == 'user') {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                        $query->where('title', 'LIKE', "%$search%")->where('status', $filter);
                        $query->orWhere('en_title', 'LIKE', "%$search%")->where('status', $filter);

                    })->orWhereHas ('proposalType',function ($query) use ($search, $filter, $user) {
                        if ($user->type == 'user') {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                        $query->where('name', 'LIKE', "%$search%")->where('status', $filter);
                    })->orderBy('created_at', $order)->paginate($this->perPage);
                // dd(\DB::getQueryLog());

            } else {

                $researchProposals = ResearchProposal::where(function ($query) use ($user) {
                    if ($user->type == 'user') {
                        $query->where('profile_id', '=', $user->profile->id);
                    }
                })
                    ->where('status', $filter)
                    ->orderBy('created_at', $order)
                    ->paginate($this->perPage);
            }
        }
        return ResearchProposalResource::collection($researchProposals);

    }
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function researchProposalRelation(Request $request){
        //$this->authorize('IsUserOrIsAdmin');

        $proposal_types = ProposalType::all()->map(function ($item){
            return ['id'=> $item['id'], 'text'=>$item['name']];
        })->toArray();
        $proposal_usages = ProposalUsage::all()->map(function ($item){
            return ['id'=> $item['id'], 'text'=>$item['name']];
        })->toArray();
        $faculties = Faculty::all()->map(function ($item){
            return ['id'=> $item['id'], 'text'=>$item['name']];
        })->toArray();
        if($request->is('api/projectReportRelation')) {
            $departments = Department::all()->map(function ($item){
                return ['id'=> $item['id'], 'text'=>$item['name']];
            })->toArray();
            return Response::json(array('proposal_types'=>$proposal_types,
                'proposal_usages'=>$proposal_usages,
                'departments'=> $departments,
                'faculties' => $faculties));

        }else{
            return Response::json(array('proposal_types'=>$proposal_types, 'proposal_usages'=>$proposal_usages,'faculties' => $faculties));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return ResearchProposalResource
     * @throws \Exception
     */
    public function store(ResearchProposalRequest $request)
    {
        //
        DB::beginTransaction();
        try {
            $fileBag = $request->files;
            $authors = $request->authors;
            $affiliations = $request->affiliations;
            $tags = $request->tags;
            $request['profile_id'] = auth('api')->user()->profile['id'];
            $request['status'] = 0;

            $researchProposal_db = ResearchProposal::create($request->all());
            foreach ($authors as $key => $author) {
                $researchProposal_db->authors()->create(['name' => $author, 'affiliation' => $affiliations[$key]]);
            }

            foreach ($tags as $tag) {
                $researchProposal_db->tags()->create(['name' => $tag]);
            }
            foreach ($fileBag as $files) {
                foreach ($files as $file) {
                    $name = time() . rand() . '.' . $file->getClientOriginalExtension();
                    $file->move('files/proposals', $name);
                    $researchProposal_db->files()->create(['name' => $name]);
                }
            }


        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
        }
        DB::commit();
        return new ResearchProposalResource($researchProposal_db);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ResearchProposalResource
     */
    public function show($id)
    {
        //
        $researchProposal_db = ResearchProposal::findOrFail($id);
        return new ResearchProposalResource($researchProposal_db);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function updateProposalStatus(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $this->validate($request,
            [
                'status'=>'required',
            ],
            [
                'status.required'=>'نظر نهایی باید انتخاب شود',
            ]
        );
        DB::beginTransaction();
        try {
            $researchProposal_db = ResearchProposal::findOrFail($id);
            $researchProposal_db->update($request->all());
        }catch (\Exception $e){
            DB::rollback();
            return Response::json(['dberror'=> ["خطای در پایگاه داده رخ داده است"] ], 402);
        }
        DB::commit();
        return Response::json(['message'=> ["وضعیت بررسی با موفقیت بروزرسانی شد."] ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return ResearchProposalResource
     * @throws \Exception
     */
    public function update(ResearchProposalRequest $request, $id)
    {
        //
        $researchProposal = ResearchProposal::findOrFail($id);

        DB::beginTransaction();
        try {
            $fileBag = $request->files;
            $authors = $request->authors;
            $affiliations = $request->affiliations;

            $request['status'] = 4;

            $researchProposal_db = $researchProposal->update($request->all());
            $researchProposal->authors()->delete();
            foreach ($authors as $key => $author) {
                $researchProposal->authors()->create(['name' => $author, 'affiliation' => $affiliations[$key]]);
            }

            if ($request->has('fileChangeType')) {
                if ($request->fileChangeType == '0') {
                    $files = $researchProposal->files;
                    foreach ($files as $file){
                        $file->delete();
                    }
                }
                foreach ($fileBag as $files) {
                    foreach ($files as $file) {
                        $name = time() . rand() . '.' . $file->getClientOriginalExtension();
                        $file->move('files/proposals', $name);
                        $researchProposal->files()->create(['name' => $name]);
                    }
                }
            }
            $researchProposal = ResearchProposal::findOrFail($researchProposal->id);

        }catch (\Exception $e){
            DB::rollback();
            return Response::json(['dberror'=> ["خطای در پایگاه داده رخ داده است"] ], 402);
        }
        DB::commit();

        return new ResearchProposalResource($researchProposal);
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
        $researchProposal = ResearchProposal::findOrFail($id);
        DB::beginTransaction();
        try {
            $researchProposal->delete();
        }catch (\Exception $e){
            DB::rollback();
            return Response::json(['dberror'=> ["خطای در پایگاه داده رخ داده است"] ], 402);
        }
        DB::commit();
        return Response::json(['پروپوزال مورد نظر با موفقیت حذف شد.'], 200);
    }
}
