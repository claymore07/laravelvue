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
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('payload', 'AuthController@payload');

});


Route::apiResources([
    'user'=>'API\UserController',
    'paper'=>'API\PapersController',
    'faculty'=>'API\FacultiesController',
    'department'=>'API\DepartmentsController',
    'term'=>'API\TermsController',
    'book'=>'API\BookController',
    'thesis'=>'API\ThesisController',
]);

Route::get('profile','API\UserController@profile');
Route::get('profileRelation','API\UserController@profileRelation');
Route::get('paperRelation','API\PapersController@paperRelation');
Route::post('paperValidation','API\PapersController@paperValidation');
Route::post('paperUpdate/{paper}','API\PapersController@paperUpdate');
Route::post('paperCheckList','API\CheckListController@store');
Route::post('thesisCheckList','API\CheckListController@store');
Route::post('bookCheckList','API\CheckListController@store');
Route::get('paperCheckList/{paper}','API\CheckListController@index');
Route::delete('paperCheckList/{checklist}','API\CheckListController@destroy');
Route::delete('deleteCheckListItem/{checklist}','API\CheckListController@destroy');
Route::post('findPaper','API\PapersController@search');
Route::get('findBook','API\BookController@search');
Route::get('bookRelation','API\BookController@bookRelation');
Route::post('bookUpdate/{book}','API\BookController@update');

Route::get('findThesis','API\ThesisController@search');
Route::get('thesisRelation','API\ThesisController@thesisRelation');

Route::get('findUser','API\UserController@search');
Route::get('findFaculty','API\FacultiesController@search');
Route::get('findDepartment','API\DepartmentsController@search');


Route::get('getJournalType','API\ScoreController@getJournalType');
Route::get('getConfType','API\ScoreController@getConfType');
Route::put('updateConfType/{confType}','API\ScoreController@updateConfType');
Route::put('updateJType/{JType}','API\ScoreController@updateJType');
Route::put('termActive/{Term}','API\TermsController@termActivate');
Route::get('findPaper','API\PapersController@search');
Route::put('profile','API\UserController@updateProfile');
