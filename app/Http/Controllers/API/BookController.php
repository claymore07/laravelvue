<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\BookResquest;
use App\Http\Requests\BookUpdateRequest;

use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\BookType;
use App\Models\Excerpt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use Auth;
use DB;

class BookController extends Controller
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
        $user = Auth::user('api')->load('profile');
        $books = Book::where(function ($query) use ($user) {
            if ($user->type == 'admin') {

            } else {
                $query->where('profile_id', '=', $user->profile->id);
            }
        })->orderBy('created_at', $order)->paginate($this->perPage);

        return BookResource::collection($books);

    }
    public function search(){
        //$this->authorize('IsUserOrIsAdmin');
        $order = \Request::get('order');
        $filter = \Request::get('filter');
        $user = Auth::user('api')->load('profile');
        if($filter == '5') {
            if ($search = \Request::get('q')) {
                // \DB::enableQueryLog();
                $books = Book::where(function ($query) use ($user) {
                    if ($user->type != 'admin') {
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
                        if ($user->type != 'admin') {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                        $query->where('title', 'LIKE', "%$search%");
                        $query->orWhere('subject', 'LIKE', "%$search%");
                    })->orWhereHas ('booktype',function ($query) use ($search,$user) {
                        if ($user->type != 'admin') {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                        $query->where('name', 'LIKE', "%$search%");
                    })
                    ->orderBy('created_at', $order)->paginate($this->perPage);
                //dd(\DB::getQueryLog());
            } else {
                $books = Book::where(function ($query) use ($user) {
                    if ($user->type != 'admin') {
                        $query->where('profile_id', '=', $user->profile->id);
                    }
                })
                    ->orderBy('created_at', $order)
                    ->paginate($this->perPage);
            }
        }else{
            if ($search = \Request::get('q')) {
                // \DB::enableQueryLog();
                $books = Book::where(function ($query) use ($user) {
                    if ($user->type != 'admin') {
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
                    })->orWhere(function ($query) use ($search,$filter,$user) {
                        if ($user->type != 'admin') {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                        $query->where('title', 'LIKE', "%$search%")->where('status', $filter);
                        $query->orWhere('subject', 'LIKE', "%$search%")->where('status', $filter);

                    })->orWhereHas ('booktype',function ($query) use ($search, $filter, $user) {
                        if ($user->type != 'admin') {
                            $query->where('profile_id', '=', $user->profile->id);
                        }
                        $query->where('name', 'LIKE', "%$search%")->where('status', $filter);
                    })->orderBy('created_at', $order)->paginate($this->perPage);
                // dd(\DB::getQueryLog());

            } else {

                $books = Book::where(function ($query) use ($user) {
                    if ($user->type != 'admin') {
                        $query->where('profile_id', '=', $user->profile->id);
                    }
                })
                    ->where('status', $filter)
                    ->orderBy('created_at', $order)
                    ->paginate($this->perPage);
            }
        }
        return BookResource::collection($books);

    }
    public function bookRelation(){
        $this->authorize('IsUserOrIsAdmin');
        $excerpts = Excerpt::all()->map(function ($item){
            return ['id'=> $item['id'], 'text'=>$item['name']];
        })->toArray();
        $booktypes = BookType::all()->map(function ($item){
            return ['id'=> $item['id'], 'text'=>$item['name']];
        })->toArray();

        return Response::json(array('excerpts'=>$excerpts, 'bookTypes'=>$booktypes));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return BookResource
     * @throws \Exception
     */
    public function store(BookResquest $request)
    {
        //
        DB::beginTransaction();
        try {
            $fileBag = $request->files;
            $authors = $request->authors;
            $affiliations = $request->affiliations;
            $request['profile_id'] =  auth('api')->user()->profile['id'];
            $request['status'] = 0;
            $book_db = Book::create($request->all());
            foreach ($authors as $key => $author) {
                $book_db->authors()->create(['name' => $author, 'affiliation' => $affiliations[$key]]);
            }

         foreach ($fileBag as $files) {
                foreach ($files as $file) {
                    $name = time() . rand() . '.' . $file->getClientOriginalExtension();
                    $file->move('files/books', $name);
                    $book_db->files()->create(['name' => $name]);
                }
            }


        }catch (\Exception $e){
            DB::rollback();
            return Response::json(['dberror'=> ["خطای در پایگاه داده رخ داده است"] ], 402);
        }
        DB::commit();
        return new BookResource($book_db);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return BookResource
     */
    public function show(Book $book)
    {
        //
        return new BookResource($book);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Book $book
     * @return BookResource
     * @throws \Exception
     */
    public function update(BookUpdateRequest $request, Book $book)
    {
        //
        DB::beginTransaction();
        try {
              $fileBag = $request->files;
            $authors = $request->authors;
            $affiliations = $request->affiliations;
            $request['profile_id'] =  auth('api')->user()->profile['id'];
            $request['status'] = 4;

            $book_db = $book->update($request->all());
            $book->authors()->delete();
            foreach ($authors as $key => $author) {
                $book->authors()->create(['name' => $author, 'affiliation' => $affiliations[$key]]);
            }

             if ($request->has('fileChangeType')) {
                if ($request->fileChangeType == '0') {
                    $files = $book->files;
                    foreach ($files as $file){
                            $file->delete();
                    }
                }
                foreach ($fileBag as $files) {
                    foreach ($files as $file) {
                        $name = time() . rand() . '.' . $file->getClientOriginalExtension();
                        $file->move('files/books', $name);
                        $book->files()->create(['name' => $name]);
                    }
                }
            }
            $book = Book::findOrFail($book->id);

       }catch (\Exception $e){
            DB::rollback();
            return Response::json(['dberror'=> ["خطای در پایگاه داده رخ داده است"] ], 402);
        }
        DB::commit();
        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book $book
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Book $book)
    {
        DB::beginTransaction();
        try {
            $files = $book->files;
            $book->checklists()->delete();
            $book->authors()->delete();
            foreach ($files as $file){
                $file->delete();
            }
            $book->delete();
        }catch (\Exception $e){
            DB::rollback();
            return Response::json(['dberror'=> ["خطای در پایگاه داده رخ داده است"] ], 402);
        }
        DB::commit();
        return Response::json(['کتاب مورد نظر با موفقیت حذف شد.'], 200);
    }
}
