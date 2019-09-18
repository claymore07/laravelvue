<?php

namespace App\Http\Controllers\API;

use App\Models\Book;
use App\Models\Booklet;
use App\Models\Course;
use App\Models\Grant;
use App\Models\Invention;
use App\Models\Paper;
use App\Models\Project;
use App\Models\Referee;
use App\Models\ResearchActivity;
use App\Models\Reward;
use App\Models\TEDChair;
use App\Models\Term;
use App\Models\Thesis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class TermsController extends Controller
{
    protected $perPage=5;

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function index()
    {
        //
        $this->authorize('IsAdminOrIsAuthor');

        $order = \Request::get('order');
        /** @var Term $terms */
        $terms = Term::orderBy('id', $order)->paginate($this->perPage);
        return Response::json(['terms'=>$terms], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        //
        $this->authorize('IsAdminOrIsAuthor');

        $this->validate($request,
                [
                    'name' => 'required',
                    'starts_at'=>'required|date',
                    'ends_at'=>'required|date|after:starts_at'
                ],
                [
                    'name.required'=>'عنوان ترم الرامی است.',
                    'starts_at.required'=>'تاریخ شروغ ترم الرامی است.',
                    'ends_at.required'=>'تاریخ پایان ترم الرامی است.',
                    'ends_at.after'=>'تاریخ پایان ترم پس از تاریخ شروع آن باشد.',
                ]
            );
        $term = Term::create($request->all());

        return Response::json(['term'=>$term],200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function termChange(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        if($request->model == 'Thesis' ){
            $item_db = Thesis::findOrFail($request->id);
        }elseif ($request->model == 'TED'){
            $item_db = TEDChair::findOrFail($request->id);
        }elseif ($request->model == 'Reward'){
            $item_db = Reward::findOrFail($request->id);
        }elseif ($request->model == 'Referee'){
            $item_db = Referee::findOrFail($request->id);
        }elseif ($request->model == 'Project'){
            $item_db = Project::findOrFail($request->id);
        }elseif ($request->model == 'Paper'){
            $item_db = Paper::findOrFail($request->id);
        }elseif ($request->model == 'Invention'){
            $item_db = Invention::findOrFail($request->id);
        }elseif ($request->model == 'Course'){
            $item_db = Course::findOrFail($request->id);
        }elseif ($request->model == 'Book'){
            $item_db = Book::findOrFail($request->id);
        }elseif ($request->model == 'Booklet'){
            $item_db = Booklet::findOrFail($request->id);
        }elseif ($request->model == 'Grant'){
            $item_db = Grant::findOrFail($request->id);
        }elseif ($request->model == 'ResearchActivity'){
            $item_db = ResearchActivity::findOrFail($request->id);
        }

        $item_db->update(['term_id'=>$request['term_id']]);
       // dd($item_db);
        $term = Term::findOrFail($request['term_id']);
        return Response::json(['term_name'=>$term->name,'term_id'=>$term->id ], 200);
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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, $id)
    {
        //
        $this->authorize('IsAdminOrIsAuthor');

        $this->validate($request,
            [
                'name' => 'required',
                'starts_at'=>'required|date',
                'ends_at'=>'required|date|after:starts_at'
            ],
            [
                'name.required'=>'عنوان ترم الرامی است.',
                'starts_at.required'=>'تاریخ شروغ ترم الرامی است.',
                'ends_at.required'=>'تاریخ پایان ترم الرامی است.',
                'ends_at.after'=>'تاریخ پایان ترم پس از تاریخ شروع آن باشد.',
            ]
        );
        $term = Term::findOrFail($id);
        $term->update($request->all());
        return Response::json(['term'=>$term],200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function termActivate(Request $request, $id){
        $this->authorize('IsAdminOrIsAuthor');

        $term = Term::findOrFail($id);
        Term::query()->update(['status'=>0]);
        $term->update(['status'=>1]);
        return Response::json(['term'=>$term],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        //
        $this->authorize('IsAdminOrIsAuthor');

    }
}
