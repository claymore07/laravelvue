<?php

namespace App\Http\Controllers\API;

use App\Models\BookType;
use App\Models\ConfType;
use App\Models\InventionType;
use App\Models\Jtype;
use App\Models\ProjectType;
use App\Models\Referee;
use App\Models\RefereeType;
use App\Models\ResearchActivityType;
use App\Models\Score;
use App\Models\TEDType;
use App\Models\ThesesType;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class ScoreController extends Controller
{
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

        $journalTypes = Jtype::all();
        return Response::json(['journalTypeList'=>$journalTypes], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateJType(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');

        $this->validate($request,
            [
                'maxscore'=>'required|numeric',
                'minscore'=>'required|numeric|lte:maxscore'
            ],
            [
                'maxscore.required'=>'سقف امتیاز باید وارد شود',
                'minscore.required'=>'کف امتیاز باید وارد شود',
                'minscore.lte'=>'کف امتیاز باید از سف آن کمتر باشد.',
            ]
        );
        $jType = Jtype::findOrFail($id);
        $jType->update($request->all());
        $jType = Jtype::findOrFail($id);
        return Response::json($jType);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getConfType(){
        $this->authorize('IsAdminOrIsAuthor');

        $confTypes = ConfType::all();
        return Response::json(['confTypeList'=>$confTypes], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateConfType(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');

        $this->validate($request,
            [
                'maxscore'=>'required|numeric',
                'minscore'=>'required|numeric|lte:maxscore'
            ],
            [
                'maxscore.required'=>'سقف امتیاز باید وارد شود',
                'minscore.required'=>'کف امتیاز باید وارد شود',
                'minscore.lte'=>'کف امتیاز باید از سف آن کمتر باشد.',
            ]
        );
        $confType = ConfType::findOrFail($id);
        $confType->update($request->all());
        $confType = ConfType::findOrFail($id);
        return Response::json($confType);
    }
    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateBookType(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');

        $this->validate($request,
            [
                'maxscore'=>'required|numeric',
                'minscore'=>'required|numeric|lte:maxscore'
            ],
            [
                'maxscore.required'=>'سقف امتیاز باید وارد شود',
                'minscore.required'=>'کف امتیاز باید وارد شود',
                'minscore.lte'=>'کف امتیاز باید از سف آن کمتر باشد.',
            ]
        );
        $bookType = BookType::findOrFail($id);
        $bookType->update($request->all());
        $bookType = BookType::findOrFail($id);
        return Response::json($bookType);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     */
    public function getBookType(){
        $this->authorize('IsAdminOrIsAuthor');

        $bookTypes = BookType::all();
        return Response::json(['bookTypeList'=>$bookTypes], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateThesesType(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');

        $this->validate($request,
            [
                'maxscore'=>'required|numeric',
                'minscore'=>'required|numeric|lte:maxscore'
            ],
            [
                'maxscore.required'=>'سقف امتیاز باید وارد شود',
                'minscore.required'=>'کف امتیاز باید وارد شود',
                'minscore.lte'=>'کف امتیاز باید از سف آن کمتر باشد.',
            ]
        );
        $thesesType = ThesesType::findOrFail($id);
        $thesesType->update($request->all());
        $thesesType = ThesesType::findOrFail($id);
        return Response::json($thesesType);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     */
    public function getThesesType(){
        $this->authorize('IsAdminOrIsAuthor');

        $thesesTypes = ThesesType::all();
        return Response::json(['thesesTypeList'=>$thesesTypes], 200);
    }
    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateTEDType(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');

        $this->validate($request,
            [
                'maxscore'=>'required|numeric',
                'minscore'=>'required|numeric|lte:maxscore'
            ],
            [
                'maxscore.required'=>'سقف امتیاز باید وارد شود',
                'minscore.required'=>'کف امتیاز باید وارد شود',
                'minscore.lte'=>'کف امتیاز باید از سف آن کمتر باشد.',
            ]
        );
        $tedType = TEDType::findOrFail($id);
        $tedType->update($request->all());
        $tedType = TEDType::findOrFail($id);
        return Response::json($tedType);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     */
    public function getTEDType(){
        $this->authorize('IsAdminOrIsAuthor');

        $tedTypes = TEDType::all();
        return Response::json(['tedTypeList'=>$tedTypes], 200);
    }
    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateRefereeType(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');

        $this->validate($request,
            [
                'maxscore'=>'required|numeric',
                'minscore'=>'required|numeric|lte:maxscore'
            ],
            [
                'maxscore.required'=>'سقف امتیاز باید وارد شود',
                'minscore.required'=>'کف امتیاز باید وارد شود',
                'minscore.lte'=>'کف امتیاز باید از سف آن کمتر باشد.',
            ]
        );
        $refereeType = RefereeType::findOrFail($id);
        $refereeType->update($request->all());
        $refereeType = RefereeType::findOrFail($id);
        return Response::json($refereeType);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     */
    public function getRefereeType(){
        $this->authorize('IsAdminOrIsAuthor');

        $refereeTypes = RefereeType::all();
        return Response::json(['refereeTypeList'=>$refereeTypes], 200);
    }
    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateProjectType(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');

        $this->validate($request,
            [
                'maxscore'=>'required|numeric',
                'minscore'=>'required|numeric|lte:maxscore'
            ],
            [
                'maxscore.required'=>'سقف امتیاز باید وارد شود',
                'minscore.required'=>'کف امتیاز باید وارد شود',
                'minscore.lte'=>'کف امتیاز باید از سف آن کمتر باشد.',
            ]
        );
        $projectType = ProjectType::findOrFail($id);
        $projectType->update($request->all());
        $projectType = ProjectType::findOrFail($id);
        return Response::json($projectType);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     */
    public function getProjectType(){
        $this->authorize('IsAdminOrIsAuthor');

        $projectTypes = ProjectType::all();
        return Response::json(['projectTypeList'=>$projectTypes], 200);
    }
    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateInventionType(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');

        $this->validate($request,
            [
                'maxscore'=>'required|numeric',
                'minscore'=>'required|numeric|lte:maxscore'
            ],
            [
                'maxscore.required'=>'سقف امتیاز باید وارد شود',
                'minscore.required'=>'کف امتیاز باید وارد شود',
                'minscore.lte'=>'کف امتیاز باید از سف آن کمتر باشد.',
            ]
        );
        $inventionType = InventionType::findOrFail($id);
        $inventionType->update($request->all());
        $inventionType = InventionType::findOrFail($id);
        return Response::json($inventionType);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     */
    public function getInventionType(){
        $this->authorize('IsAdminOrIsAuthor');

        $inventionTypes = InventionType::all();
        return Response::json(['inventionTypeList'=>$inventionTypes], 200);
    }
    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateRewardType(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');

        $this->validate($request,
            [
                'maxscore'=>'required|numeric',
                'minscore'=>'required|numeric|lte:maxscore'
            ],
            [
                'maxscore.required'=>'سقف امتیاز باید وارد شود',
                'minscore.required'=>'کف امتیاز باید وارد شود',
                'minscore.lte'=>'کف امتیاز باید از سف آن کمتر باشد.',
            ]
        );
        $rewardType = Score::findOrFail($id);
        $rewardType->update($request->all());
        $rewardType = Score::findOrFail($id);
        return Response::json($rewardType);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     */
    public function getRewardType(){
        $this->authorize('IsAdminOrIsAuthor');

        $rewardType = score::findOrFail(1);
        return Response::json(['rewardTypeList'=>[$rewardType]], 200);
    }
    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateGrantType(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');

        $this->validate($request,
            [
                'maxscore'=>'required|numeric',
                'minscore'=>'required|numeric|lte:maxscore'
            ],
            [
                'maxscore.required'=>'سقف امتیاز باید وارد شود',
                'minscore.required'=>'کف امتیاز باید وارد شود',
                'minscore.lte'=>'کف امتیاز باید از سف آن کمتر باشد.',
            ]
        );
        $grantType = Score::findOrFail($id);
        $grantType->update($request->all());
        $grantType = Score::findOrFail($id);
        return Response::json($grantType);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     */
    public function getGrantType(){
        $this->authorize('IsAdminOrIsAuthor');

        $grantType = score::findOrFail(4);
        return Response::json(['grantTypeList'=>[$grantType]], 200);
    }
    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateCourseType(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');

        $this->validate($request,
            [
                'maxscore'=>'required|numeric',
                'minscore'=>'required|numeric|lte:maxscore'
            ],
            [
                'maxscore.required'=>'سقف امتیاز باید وارد شود',
                'minscore.required'=>'کف امتیاز باید وارد شود',
                'minscore.lte'=>'کف امتیاز باید از سف آن کمتر باشد.',
            ]
        );
        $courseType = Score::findOrFail($id);
        $courseType->update($request->all());
        $courseType = Score::findOrFail($id);
        return Response::json($courseType);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     */
    public function getCourseType(){
        $this->authorize('IsAdminOrIsAuthor');

        $courseType = score::findOrFail(2);
        return Response::json(['courseTypeList'=>[$courseType]], 200);
    }
    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateBookletType(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');

        $this->validate($request,
            [
                'maxscore'=>'required|numeric',
                'minscore'=>'required|numeric|lte:maxscore'
            ],
            [
                'maxscore.required'=>'سقف امتیاز باید وارد شود',
                'minscore.required'=>'کف امتیاز باید وارد شود',
                'minscore.lte'=>'کف امتیاز باید از سف آن کمتر باشد.',
            ]
        );
        $bookletType = Score::findOrFail($id);
        $bookletType->update($request->all());
        $bookletType = Score::findOrFail($id);
        return Response::json($bookletType);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     */
    public function getBookletType(){
        $this->authorize('IsAdminOrIsAuthor');
        $bookletType = score::findOrFail(3);
        return Response::json(['bookletTypeList'=>[$bookletType]], 200);
    }
    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     */
    public function getresearchActivityType(){
        $this->authorize('IsAdminOrIsAuthor');

        $researchActivityTypes = ResearchActivityType::all();
        return Response::json(['researchActivityTypeList'=>$researchActivityTypes], 200);
    }
    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateResearchActivityType(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');

        $this->validate($request,
            [
                'maxscore'=>'required|numeric',
                'minscore'=>'required|numeric|lte:maxscore'
            ],
            [
                'maxscore.required'=>'سقف امتیاز باید وارد شود',
                'minscore.required'=>'کف امتیاز باید وارد شود',
                'minscore.lte'=>'کف امتیاز باید از سف آن کمتر باشد.',
            ]
        );
        $researchActivityType = ResearchActivityType::findOrFail($id);
        $researchActivityType->update($request->all());
        $researchActivityType = ResearchActivityType::findOrFail($id);
        return Response::json($researchActivityType);
    }
}
