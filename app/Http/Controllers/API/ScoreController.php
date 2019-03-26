<?php

namespace App\Http\Controllers\API;

use App\Models\ConfType;
use App\Models\Jtype;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class ScoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function getJournalType(){
        $this->authorize('isAdmin');

        $journalTypes = Jtype::all();
        return Response::json(['journalTypeList'=>$journalTypes], 200);
    }

    public function updateJType(Request $request, $id){
        $this->authorize('isAdmin');

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

    public function getConfType(){
        $this->authorize('isAdmin');

        $confTypes = ConfType::all();
        return Response::json(['confTypeList'=>$confTypes], 200);
    }

    public function updateConfType(Request $request, $id){
        $this->authorize('isAdmin');

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
}
