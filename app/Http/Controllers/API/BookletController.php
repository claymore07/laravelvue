<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booklet;
use Illuminate\Http\Request;
use Auth;
use DB;
use Response;

class BookletController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booklet  $booklet
     * @return \Illuminate\Http\Response
     */
    public function show(Booklet $booklet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booklet  $booklet
     * @return \Illuminate\Http\Response
     */
    public function edit(Booklet $booklet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booklet  $booklet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booklet $booklet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booklet  $booklet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booklet $booklet)
    {
        //
    }
}
