<?php

namespace App\Http\Controllers\API;

use App\Models\Degree;
use App\Models\Member;
use App\Models\Position;
use App\Models\Profile;
use App\Models\Rank;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class UserRelationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('jwt');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getRanks(){
        $this->authorize('IsAdminOrIsAuthor');

        $ranks = Rank::all()->map(function ($item){
            return ['id'=> $item['id'], 'name'=>$item['name']];
        })->toArray();
        foreach ($ranks as $index => $rank){
            $ranks[$index]['count'] = Profile::with(['rank'])->whereHas('rank', function ($query) use ($rank){
                $query->where('rank_id',  $rank['id']);
            })->count();
        }
        return Response::json(['ranks'=>$ranks], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateRankTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $this->validate($request,
            [
                'name'=>'required',
            ],
            [
                'name.required'=>'نام زیر نوع باید وار شود',
            ]
        );
        $rank = Rank::findOrFail($id);
        $rank->update($request->all());
        $rank = Rank::findOrFail($id);
        return Response::json($rank);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function addRankTitle(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        DB::beginTransaction();
        try {
            $rank = Rank::create($request->all());
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
        }
        DB::commit();
        $result['id'] = $rank->id;
        $result['name'] = $rank->name;
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
    public function deleteRankTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $count = Profile::with(['rank'])->whereHas('rank', function ($query) use ($id){
            $query->where('rank_id',  $id);
        })->count();
        if($count == 0){
            DB::beginTransaction();
            try {
                $rank = Rank::findOrFail($id);
                $rank->delete();
            } catch (\Exception $e) {
                DB::rollback();
                return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
            }
            DB::commit();
            return Response::json(['زیر نوع مورد نظر با موفقیت حذف شد.'], 200);
        }else{
            return Response::json(['dberror' => ["به دلیل وجود کاربرانی که عضو زیر نوع مورد نظر می باشند امکان حذف وجود ندارد!"]], 402);
        }
    }
    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getDegrees(){
        $this->authorize('IsAdminOrIsAuthor');

        $degrees = Degree::all()->map(function ($item){
            return ['id'=> $item['id'], 'name'=>$item['name']];
        })->toArray();
        foreach ($degrees as $index => $degree){
            $degrees[$index]['count'] = Profile::with(['degree'])->whereHas('degree', function ($query) use ($degree){
                $query->where('degree_id',  $degree['id']);
            })->count();
        }
        return Response::json(['degrees'=>$degrees], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateDegreeTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $this->validate($request,
            [
                'name'=>'required',
            ],
            [
                'name.required'=>'نام زیر نوع باید وار شود',
            ]
        );
        $degree = Degree::findOrFail($id);
        $degree->update($request->all());
        $degree = Degree::findOrFail($id);
        return Response::json($degree);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function addDegreeTitle(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        DB::beginTransaction();
        try {
            $degree = Degree::create($request->all());
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
        }
        DB::commit();
        $result['id'] = $degree->id;
        $result['name'] = $degree->name;
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
    public function deleteDegreeTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $count = Profile::with(['degree'])->whereHas('degree', function ($query) use ($id){
            $query->where('degree_id',  $id);
        })->count();
        if($count == 0){
            DB::beginTransaction();
            try {
                $degree = Degree::findOrFail($id);
                $degree->delete();
            } catch (\Exception $e) {
                DB::rollback();
                return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
            }
            DB::commit();
            return Response::json(['زیر نوع مورد نظر با موفقیت حذف شد.'], 200);
        }else{
            return Response::json(['dberror' => ["به دلیل وجود کاربرانی که عضو زیر نوع مورد نظر می باشند امکان حذف وجود ندارد!"]], 402);
        }
    }
    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getPositions(){
        $this->authorize('IsAdminOrIsAuthor');

        $positions = Position::all()->map(function ($item){
            return ['id'=> $item['id'], 'name'=>$item['name']];
        })->toArray();
        foreach ($positions as $index => $position){
            $positions[$index]['count'] = Profile::with(['position'])->whereHas('position', function ($query) use ($position){
                $query->where('position_id',  $position['id']);
            })->count();
        }
        return Response::json(['positions'=>$positions], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updatePositionTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $this->validate($request,
            [
                'name'=>'required',
            ],
            [
                'name.required'=>'نام زیر نوع باید وار شود',
            ]
        );
        $position = Position::findOrFail($id);
        $position->update($request->all());
        $position = Position::findOrFail($id);
        return Response::json($position);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function addPositionTitle(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        DB::beginTransaction();
        try {
            $position = Position::create($request->all());
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
        }
        DB::commit();
        $result['id'] = $position->id;
        $result['name'] = $position->name;
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
    public function deletePositionTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $count = Profile::with(['position'])->whereHas('position', function ($query) use ($id){
            $query->where('position_id',  $id);
        })->count();
        if($count == 0){
            DB::beginTransaction();
            try {
                $position = Position::findOrFail($id);
                $position->delete();
            } catch (\Exception $e) {
                DB::rollback();
                return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
            }
            DB::commit();
            return Response::json(['زیر نوع مورد نظر با موفقیت حذف شد.'], 200);
        }else{
            return Response::json(['dberror' => ["به دلیل وجود کاربرانی که عضو زیر نوع مورد نظر می باشند امکان حذف وجود ندارد!"]], 402);
        }
    }
    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getMembers(){
        $this->authorize('IsAdminOrIsAuthor');

        $members = Member::all()->map(function ($item){
            return ['id'=> $item['id'], 'name'=>$item['name']];
        })->toArray();
        foreach ($members as $index => $member){
            $members[$index]['count'] = Profile::with(['member'])->whereHas('member', function ($query) use ($member){
                $query->where('member_id',  $member['id']);
            })->count();
        }
        return Response::json(['members'=>$members], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateMemberTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $this->validate($request,
            [
                'name'=>'required',
            ],
            [
                'name.required'=>'نام زیر نوع باید وار شود',
            ]
        );
        $member = Member::findOrFail($id);
        $member->update($request->all());
        $member = Member::findOrFail($id);
        return Response::json($member);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function addMemberTitle(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        DB::beginTransaction();
        try {
            $member = Member::create($request->all());
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
        }
        DB::commit();
        $result['id'] = $member->id;
        $result['name'] = $member->name;
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
    public function deleteMemberTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $count = Profile::with(['member'])->whereHas('member', function ($query) use ($id){
            $query->where('member_id',  $id);
        })->count();
        if($count == 0){
            DB::beginTransaction();
            try {
                $member= Member::findOrFail($id);
                $member->delete();
            } catch (\Exception $e) {
                DB::rollback();
                return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
            }
            DB::commit();
            return Response::json(['زیر نوع مورد نظر با موفقیت حذف شد.'], 200);
        }else{
            return Response::json(['dberror' => ["به دلیل وجود کاربرانی که عضو زیر نوع مورد نظر می باشند امکان حذف وجود ندارد!"]], 402);
        }
    }

}
