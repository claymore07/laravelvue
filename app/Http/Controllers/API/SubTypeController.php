<?php

namespace App\Http\Controllers\API;

use App\Models\Book;
use App\Models\BookType;
use App\Models\Conference;
use App\Models\ConfType;
use App\Models\Invention;
use App\Models\InventionType;
use App\Models\Journal;
use App\Models\Jtype;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\Referee;
use App\Models\RefereeType;
use App\Models\ResearchActivity;
use App\Models\ResearchActivityType;
use App\Models\Score;
use App\Models\TEDChair;
use App\Models\TEDType;
use App\Models\ThesesType;
use App\Models\Thesis;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use DB;

class SubTypeController extends Controller
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
    public function getJournalType(){
        $this->authorize('IsAdminOrIsAuthor');

        $journalTypes = Jtype::all()->map(function ($item){
            return ['id'=> $item['id'], 'name'=>$item['name']];
        })->toArray();
        foreach ($journalTypes as $index => $journalType){
            $journalTypes[$index]['count'] = Journal::with(['jtype'])->whereHas('jtype', function ($query) use ($journalType){
                    $query->where('jtype_id',  $journalType['id']);
                })->count();
        }
        return Response::json(['journalTypeList'=>$journalTypes], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateJTypeTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $this->validate($request,
            [
                'name'=>'required',
            ],
            [
                'name.required'=>'نام زیر نوع باید وار شود',
            ]
        );
        $jType = Jtype::findOrFail($id);
        $jType->update($request->all());
        $jType = Jtype::findOrFail($id);
        return Response::json($jType);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function addJTypeTitle(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        DB::beginTransaction();
        try {
            $jType = Jtype::create($request->all());
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
        }
        DB::commit();
        $result['id'] = $jType->id;
        $result['name'] = $jType->name;
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
    public function deleteJTypeTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $count = Journal::with(['jtype'])->whereHas('jtype', function ($query) use ($id){
            $query->where('jtype_id',  $id);
        })->count();
        if($count == 0){
            DB::beginTransaction();
            try {
                $jType = Jtype::findOrFail($id);
                $jType->delete();
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
    public function getConfType(){
        $this->authorize('IsAdminOrIsAuthor');

        $confTypes = ConfType::all()->map(function ($item){
            return ['id'=> $item['id'], 'name'=>$item['name']];
        })->toArray();
        foreach ($confTypes as $index => $confType){
            $confTypes[$index]['count'] = Conference::with(['conftype'])->whereHas('conftype', function ($query) use ($confType){
                    $query->where('conftype_id',  $confType['id']);
                })->count();
        }
        return Response::json(['confTypeList'=>$confTypes], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateConfTypeTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $this->validate($request,
            [
                'name'=>'required',
            ],
            [
                'name.required'=>'نام زیر نوع باید وار شود',
            ]
        );
        $confType = ConfType::findOrFail($id);
        $confType->update($request->all());
        $confType = ConfType::findOrFail($id);
        return Response::json($confType);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function addConfTypeTitle(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        DB::beginTransaction();
        try {
            $confType = ConfType::create($request->all());
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
        }
        DB::commit();

        $result['id'] = $confType->id;
        $result['name'] = $confType->name;
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
    public function deleteConfTypeTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $count = Conference::with(['conftype'])->whereHas('conftype', function ($query) use ($id){
            $query->where('conftype_id',  $id);
        })->count();
        if($count == 0){
            DB::beginTransaction();
            try {
                $confType = ConfType::findOrFail($id);
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

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     */
    public function getBookType(){
        $this->authorize('IsAdminOrIsAuthor');

        $bookTypes = BookType::all()->map(function ($item){
            return ['id'=> $item['id'], 'name'=>$item['name']];
        })->toArray();
        foreach ($bookTypes as $index => $bookType){
            $bookTypes[$index]['count'] = Book::with(['booktype'])->whereHas('booktype', function ($query) use ($bookType){
                    $query->where('booktype_id',  $bookType['id']);
                })->count();
        }
        return Response::json(['bookTypeList'=>$bookTypes], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateBookTypeTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $this->validate($request,
            [
                'name'=>'required',
            ],
            [
                'name.required'=>'نام زیر نوع باید وار شود',
            ]
        );
        $bookType = BookType::findOrFail($id);
        $bookType->update($request->all());
        $bookType = BookType::findOrFail($id);
        return Response::json($bookType);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function addBookTypeTitle(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        DB::beginTransaction();
        try {
            $bookType = BookType::create($request->all());
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
        }
        DB::commit();
        $result['id'] = $bookType->id;
        $result['name'] = $bookType->name;
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
    public function deleteBookTypeTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $count = Book::with(['booktype'])->whereHas('booktype', function ($query) use ($id){
            $query->where('booktype_id',  $id);
        })->count();
        if($count == 0){
            DB::beginTransaction();
            try {
                $bookType = BookType::findOrFail($id);
                $bookType->delete();
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
    public function getThesesType(){
        $this->authorize('IsAdminOrIsAuthor');

        $thesesTypes = ThesesType::all()->map(function ($item){
            return ['id'=> $item['id'], 'name'=>$item['name']];
        })->toArray();
        foreach ($thesesTypes as $index => $thesesType){
            $thesesTypes[$index]['count'] = Thesis::with(['thesisType'])->whereHas('thesisType', function ($query) use ($thesesType){
                    $query->where('theses_types_id',  $thesesType['id']);
                })->count();
        }
        return Response::json(['thesesTypeList'=>$thesesTypes], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateThesesTypeTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $this->validate($request,
            [
                'name'=>'required',
            ],
            [
                'name.required'=>'نام زیر نوع باید وار شود',
            ]
        );
        $thesesType = ThesesType::findOrFail($id);
        $thesesType->update($request->all());
        $thesesType = ThesesType::findOrFail($id);
        return Response::json($thesesType);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function addThesesTypeTitle(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        DB::beginTransaction();
        try {
            $thesesType = ThesesType::create($request->all());
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
        }
        DB::commit();
        $result['id'] = $thesesType->id;
        $result['name'] = $thesesType->name;
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
    public function deleteThesesTypeTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $count = Thesis::with(['thesisType'])->whereHas('thesisType', function ($query) use ($id){
            $query->where('theses_types_id',  $id);
        })->count();
        if($count == 0){
            DB::beginTransaction();
            try {
                $thesesType = ThesesType::findOrFail($id);
                $thesesType->delete();
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
    public function getTEDType(){
        $this->authorize('IsAdminOrIsAuthor');

        $tedTypes = TEDType::all()->map(function ($item){
            return ['id'=> $item['id'], 'name'=>$item['name']];
        })->toArray();
        foreach ($tedTypes as $index => $tedType){
            $tedTypes[$index]['count'] = TEDChair::with(['TEDType'])->whereHas('TEDType', function ($query) use ($tedType){
                    $query->where('ted_types_id',  $tedType['id']);
                })->count();
        }
        return Response::json(['tedTypeList'=>$tedTypes], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateTEDTypeTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $this->validate($request,
            [
                'name'=>'required',
            ],
            [
                'name.required'=>'نام زیر نوع باید وار شود',
            ]
        );
        $tedType = TEDType::findOrFail($id);
        $tedType->update($request->all());
        $tedType = TEDType::findOrFail($id);
        return Response::json($tedType);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function addTEDTypeTitle(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        DB::beginTransaction();
        try {
            $tedType = TEDType::create($request->all());
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
        }
        DB::commit();
        $result['id'] = $tedType->id;
        $result['name'] = $tedType->name;
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
    public function deleteTEDTypeTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $count = TEDChair::with(['TEDType'])->whereHas('TEDType', function ($query) use ($id){
            $query->where('ted_types_id',  $id);
        })->count();
        if($count == 0){
            DB::beginTransaction();
            try {
                $tedType = TEDType::findOrFail($id);
                $tedType->delete();
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
    public function getRefereeType(){
        $this->authorize('IsAdminOrIsAuthor');

        $refereeTypes = RefereeType::all()->map(function ($item){
            return ['id'=> $item['id'], 'name'=>$item['name']];
        })->toArray();
        foreach ($refereeTypes as $index => $refereeType){
            $refereeTypes[$index]['count'] = Referee::with(['refereeType'])->whereHas('refereeType', function ($query) use ($refereeType){
                    $query->where('referee_types_id',  $refereeType['id']);
                })->count();
        }
        return Response::json(['refereeTypeList'=>$refereeTypes], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateRefereeTypeTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $this->validate($request,
            [
                'name'=>'required',
            ],
            [
                'name.required'=>'نام زیر نوع باید وار شود',
            ]
        );
        $refereeType = RefereeType::findOrFail($id);
        $refereeType->update($request->all());
        $refereeType = RefereeType::findOrFail($id);
        return Response::json($refereeType);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function addRefereeTypeTitle(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        DB::beginTransaction();
        try {
            $refereeType = RefereeType::create($request->all());
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
        }
        DB::commit();
        $result['id'] = $refereeType->id;
        $result['name'] = $refereeType->name;
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
    public function deleteRefereeTypeTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $count = Referee::with(['refereeType'])->whereHas('refereeType', function ($query) use ($id){
            $query->where('referee_types_id',  $id);
        })->count();
        if($count == 0){
            DB::beginTransaction();
            try {
                $refereeType = RefereeType::findOrFail($id);
                $refereeType->delete();
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
    public function getProjectType(){
        $this->authorize('IsAdminOrIsAuthor');

        $projectTypes = ProjectType::all()->map(function ($item){
            return ['id'=> $item['id'], 'name'=>$item['name']];
        })->toArray();
        foreach ($projectTypes as $index => $projectType){
            $projectTypes[$index]['count'] = Project::with(['projectType'])->whereHas('projectType', function ($query) use ($projectType){
                    $query->where('project_types_id',  $projectType['id']);
                })->count();
        }
        return Response::json(['projectTypeList'=>$projectTypes], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateProjectTypeTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $this->validate($request,
            [
                'name'=>'required',
            ],
            [
                'name.required'=>'نام زیر نوع باید وار شود',
            ]
        );
        $projectType = ProjectType::findOrFail($id);
        $projectType->update($request->all());
        $projectType = ProjectType::findOrFail($id);
        return Response::json($projectType);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function addProjectTypeTitle(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        DB::beginTransaction();
        try {
            $projectType = ProjectType::create($request->all());
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
        }
        DB::commit();
        $result['id'] = $projectType->id;
        $result['name'] = $projectType->name;
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
    public function deleteProjectTypeTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $count = Project::with(['projectType'])->whereHas('projectType', function ($query) use ($id){
            $query->where('project_types_id',  $id);
        })->count();
        if($count == 0){
            DB::beginTransaction();
            try {
                $projectType = ProjectType::findOrFail($id);
                $projectType->delete();
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
    public function getInventionType(){
        $this->authorize('IsAdminOrIsAuthor');

        $inventionTypes = InventionType::all()->map(function ($item){
            return ['id'=> $item['id'], 'name'=>$item['name']];
        })->toArray();
        foreach ($inventionTypes as $index => $inventionType){
            $inventionTypes[$index]['count'] = Invention::with(['inventionType'])->whereHas('inventionType', function ($query) use ($inventionType){
                    $query->where('invention_types_id',  $inventionType['id']);
                })->count();
        }
        return Response::json(['inventionTypeList'=>$inventionTypes], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateInventionTypeTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $this->validate($request,
            [
                'name'=>'required',
            ],
            [
                'name.required'=>'نام زیر نوع باید وار شود',
            ]
        );
        $inventionType = InventionType::findOrFail($id);
        $inventionType->update($request->all());
        $inventionType = InventionType::findOrFail($id);
        return Response::json($inventionType);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function addInventionTypeTitle(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        DB::beginTransaction();
        try {
            $inventionType = InventionType::create($request->all());
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
        }
        DB::commit();
        $result['id'] = $inventionType->id;
        $result['name'] = $inventionType->name;
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
    public function deleteInventionTypeTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $count = Invention::with(['inventionType'])->whereHas('inventionType', function ($query) use ($id){
            $query->where('invention_types_id',  $id);
        })->count();
        if($count == 0){
            DB::beginTransaction();
            try {
                $inventionType = InventionType::findOrFail($id);
                $inventionType->delete();
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
    public function getResearchActivityType(){
        $this->authorize('IsAdminOrIsAuthor');

        $researchActivityTypes = ResearchActivityType::all()->map(function ($item){
            return ['id'=> $item['id'], 'name'=>$item['name']];
        })->toArray();
        foreach ($researchActivityTypes as $index => $researchActivityType){
            $researchActivityTypes[$index]['count'] = ResearchActivity::with(['ResearchActivityType'])->whereHas('ResearchActivityType', function ($query) use ($researchActivityType){
                    $query->where('research_activity_types_id',  $researchActivityType['id']);
                })->count();
        }
        return Response::json(['researchActivityTypeList'=>$researchActivityTypes], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateResearchActivityTypeTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $this->validate($request,
            [
                'name'=>'required',
            ],
            [
                'name.required'=>'نام زیر نوع باید وار شود',
            ]
        );
        $researchActivityType = ResearchActivityType::findOrFail($id);
        $researchActivityType->update($request->all());
        $researchActivityType = ResearchActivityType::findOrFail($id);
        return Response::json($researchActivityType);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function addResearchActivityTypeTitle(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        DB::beginTransaction();
        try {
            $researchActivityType = ResearchActivityType::create($request->all());
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['dberror' => ["خطای در پایگاه داده رخ داده است"]], 402);
        }
        DB::commit();

        $result['id'] = $researchActivityType->id;
        $result['name'] = $researchActivityType->name;
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
    public function deleteResearchActivityTypeTitle(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');
        $count = ResearchActivity::with(['ResearchActivityType'])->whereHas('ResearchActivityType', function ($query) use ($id){
            $query->where('research_activity_types_id',  $id);
        })->count();
        if($count == 0){
            DB::beginTransaction();
            try {
                $researchActivityType = ResearchActivityType::findOrFail($id);
                $researchActivityType->delete();
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
