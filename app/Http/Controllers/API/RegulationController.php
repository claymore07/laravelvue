<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RegulationResource;
use App\Models\Regulation;
use Illuminate\Http\Request;

class RegulationController extends Controller
{
    public function __construct()
    {

        $this->middleware('jwt');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Regulation  $regulation
     * @return RegulationResource
     */
    public function show(Regulation $regulation)
    {
        //
        return new RegulationResource($regulation);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Regulation $regulation
     * @return RegulationResource
     */
    public function edit(Regulation $regulation)
    {
        //
        return new RegulationResource($regulation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Regulation $regulation
     * @return RegulationResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Regulation $regulation)
    {
        //
        $this->validate($request,
            [
                'detail' => 'required|min:16'
            ],
            [
                'detail.required' => 'توضیحات بخشنامه الزامی است.',
                'detail.min' => 'توضیحات بخشنامه حداقل 6 کاراکتر باشد.'
            ]);
        $regulation->update($request->all());
        $regulation = Regulation::findOrFail($regulation->id);
        return new RegulationResource($regulation);
    }

}
