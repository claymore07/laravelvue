<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {

    return $request->user();
});

Route::apiResources([
    'user'=>'API\UserController',
    'paper'=>'API\PapersController'
]);

Route::get('profile','API\UserController@profile');
Route::get('profileRelation','API\UserController@profileRelation');
Route::get('paperRelation','API\PapersController@paperRelation');
Route::post('paperValidation','API\PapersController@paperValidation');
Route::get('findUser','API\UserController@search');
Route::get('findPaper','API\PapersController@search');
Route::put('profile','API\UserController@updateProfile');
