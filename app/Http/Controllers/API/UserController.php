<?php

namespace App\Http\Controllers\API;

use App\Degree;
use App\Department;
use App\Faculty;
use App\Http\Requests\UserRequest;
use App\Member;
use App\Position;
use App\Profile;
use App\Rank;
use DB;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Response;
use Session;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(Gate::allows('isAdmin')||Gate::allows('isAuthor')){
            $order = \Request::get('order');
            $users =User::with('profile')->orderBy('created_at', $order)->paginate(10);

            $degrees = Degree::all()->map(function ($item){
                return ['id'=> $item['id'], 'text'=>$item['name']];
            })->toArray();

            $departments = Department::all()->map(function ($item){
                return ['id'=> $item['id'], 'text'=>$item['name']];
            })->toArray();
            $faculties = Faculty::all()->map(function ($item){
                return ['id'=> $item['id'], 'text'=>$item['name']];
            })->toArray();
            $positions = Position::all()->map(function ($item){
                return ['id'=> $item['id'], 'text'=>$item['name']];
            })->toArray();
            $members = Member::all()->map(function ($item){
                return ['id'=> $item['id'], 'text'=>$item['name']];
            })->toArray();
            $ranks = Rank::all()->map(function ($item){
                return ['id'=> $item['id'], 'text'=>$item['name']];
            })->toArray();
            return Response::json(array('users'=>$users,'degrees'=>$degrees,
                'departments'=>$departments, 'ranks'=>$ranks,'members'=>$members,
                'positions'=>$positions, 'faculties' => $faculties
                ));

        }
        //$this->authorize('isAdmin');

    }
    public function search(){
        $order = \Request::get('order');
        if ($search = \Request::get('q')) {
            $users = User::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                    ->orWhere('email','LIKE',"%$search%");
            })->orderBy('created_at', $order)->paginate(2);
        }else{
            $users = User::orderBy('created_at', $order)->paginate(2);
        }
        $degrees = Degree::pluck('name', 'id')->all();
        $departments = Department::pluck('name', 'id')->all();
        $faculties = Faculty::pluck('name', 'id')->all();
        $positions = Position::pluck('name', 'id')->all();
        $members = Member::pluck('name', 'id')->all();
        $ranks = Rank::pluck('name', 'id')->all();
        return Response::json(array('users'=>$users,'degrees'=>$degrees,'departments'=>$departments));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        //
       // sleep(8);
        //

        $input = $request->all();
        DB::beginTransaction();
        try {
            $user['name'] = $input['name'];
            $user['password'] = bcrypt($input['password']);
            $user['email']=$input['email'];
            $user['type']=$input['type'];
            $user['bio']=$input['bio'];

            $users = User::create($user);

            $profile['user_id'] = $users->id;
            $profile['Fname'] = $input['Fname'];
            $profile['Lname'] = $input['Lname'];
            $profile['base'] = $input['base'];
            $profile['siba'] = $input['siba'];
            $profile['personal_id'] = $input['personal_id'];
            $profile['phone'] = $input['phone'];
            $profile['degree_id'] = $input['degree_id'];
            $profile['rank_id'] = $input['rank_id'];
            $profile['faculty_id'] = $input['faculty_id'];
            $profile['department_id'] = $input['department_id'];
            $profile['position_id'] = $input['position_id'];
            $profile['member_id'] = $input['member_id'];

            $profiles = Profile::create($profile);
        }catch (\Exception $e){

            DB::rollback();
           return Response::json(['dberror'=> ["خطای در پایگاه داده رخ داده است"] ], 403);
           // return redirect('admin/home')->with('fail','عملیات ثبت کاربر ناموفق بود، از ابتدا شروع نمایید.');
        }

        DB::commit();

        Session::flash('success', 'اطلاعات کاربر جدید با موفقیت ثبت شده است.');

        return $users;

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        //
        return auth('api')->user();

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(UserRequest $request)
    {
        //
        $user = auth('api')->user();
        $currentPhoto = $user->photo;

        if($request->photo != $currentPhoto){

            $name = time().'.' . explode('/',
                    explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            Image::make($request->photo)->save(public_path('img/profile/').$name);
            $request->merge(['photo' => $name]);
            $userPhoto = public_path('img/profile/').$currentPhoto;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }
        }

        if(!empty($request->password)){
            $request->merge(['password' => bcrypt($request['password'])]);
        }
        $user->update($request->all());
        return $request['photo'];

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        //
        $user_db = User::findOrFail($id);
        $input = $request->all();
        DB::beginTransaction();
        try {
            $user['name'] = $input['name'];
            if(/*$request->has('password')*/is_null($input['password'])){

                $user['password'] = bcrypt($input['password']);
            }
            $user['email']=$input['email'];
            $user['type']=$input['type'];
            $user['bio']=$input['bio'];
            /*
            if(empty($input['role_id'])){
                $user['role_id']=2;
            }else{
                $user['role_id']=$input['role_id'];
            }*/
            $users = $user_db->update($user);

            $profile['user_id'] = $user_db->id;
            $profile['Fname'] = $input['Fname'];
            $profile['Lname'] = $input['Lname'];
            $profile['base'] = $input['base'];
            $profile['siba'] = $input['siba'];
            $profile['personal_id'] = $input['personal_id'];
            $profile['phone'] = $input['phone'];
            $profile['degree_id'] = $input['degree_id'];
            $profile['rank_id'] = $input['rank_id'];
            $profile['faculty_id'] = $input['faculty_id'];
            $profile['department_id'] = $input['department_id'];
            $profile['position_id'] = $input['position_id'];
            $profile['member_id'] = $input['member_id'];
            if($user_db->profile==''){
                $profiles = Profile::create($profile);
            }else{
                $profiles = $user_db->profile->update($profile);
            }
        }catch (\Exception $e){

            DB::rollback();
           // dd($e);
            return Response::json(['message'=> ["خطای در پایگاه داده رخ داده است"] ], 403);
        }

        DB::commit();

        return Response::json(['success'=> ["با موققیت انجام شد!"] ], 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        //$this->authorize('isAdmin');
        $user = User::findOrFail($id);
        DB::beginTransaction();
        try {
            if($user->profile != '') {
                $profile = $user->profile;
                /* $papers = $profile->papers;
                 foreach ($papers as $paper) {
                     $paper->authors()->delete();
                     $paper->journal()->delete();
                     $paper->delete();
                 }*/
                $profile->delete();
            }
            $user->delete();
        } catch (\Exception $e) {

            DB::rollback();
            return Response::json(['message'=> ["خطای در پایگاه داده رخ داده است"] ], 403);
        }

        DB::commit();
       // Session::flash('success', 'اطلاعات کاربر با موفقیت حذف شد.');
        // delete the user
       // $user->delete();

        return Response::json(['success'=> ["اطلاعات کاربر با موفقیت حذف شد."] ], 200);
    }
}
