<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

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
            return User::latest()->paginate(2);
        }
        //$this->authorize('isAdmin');

    }
    public function search(){
        if ($search = \Request::get('q')) {
            $users = User::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                    ->orWhere('email','LIKE',"%$search%");
            })->paginate(2);
        }else{
            $users = User::latest()->paginate(2);
        }
        return $users;
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
        return User::create([
            'name'=> $request['name'],
            'email'=>$request['email'],
            'type'=>$request['type'],
            'password'=>bcrypt($request['password']),
            'bio'=>$request['bio'],
            'photo'=>$request['photo']
        ]);
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
        $user = User::findOrFail($id);
        $user->update($request->all());
        return ['message'=>'this a update'];
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
        $this->authorize('isAdmin');
        $user = User::findOrFail($id);

        // delete the user
        $user->delete();

        return ['message'=>'User is Deleted'];
    }
}
