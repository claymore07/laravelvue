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
    'reward'=>'API\RewardController',
    'project'=>'API\ProjectController',
    'tedChair'=>'API\TEDChairController',
    'referee'=>'API\RefereeController',
    'course'=>'API\CourseController',
    'booklet'=>'API\BookletController',
    'invention'=>'API\InventionController',
    'grant'=>'API\GrantController',
]);

Route::get('profile','API\UserController@profile');

// post route for update instead of PUT and Patch

Route::post('paperUpdate/{paper}','API\PapersController@paperUpdate');
Route::post('bookUpdate/{book}','API\BookController@update');
Route::post('rewardUpdate/{reward}','API\RewardController@update');
Route::post('projectUpdate/{project}','API\ProjectController@update');
Route::post('tedChairUpdate/{tedChair}','API\TEDChairController@update');
Route::post('refereeUpdate/{referee}','API\RefereeController@update');
Route::post('courseUpdate/{course}','API\CourseController@update');
Route::post('bookletUpdate/{booklet}','API\BookletController@update');
Route::post('inventionUpdate/{invention}','API\InventionController@update');
Route::post('grantUpdate/{grant}','API\GrantController@update');

// helper routes to get relations collections
Route::get('profileRelation','API\UserController@profileRelation');
Route::get('paperRelation','API\PapersController@paperRelation');
Route::get('bookRelation','API\BookController@bookRelation');
Route::get('thesisRelation','API\ThesisController@thesisRelation');
Route::get('projectRelation','API\ProjectController@projectRelation');
Route::get('tedChairRelation','API\TEDChairController@tedChairRelation');
Route::get('refereeRelation','API\RefereeController@refereeRelation');
Route::get('bookletRelation','API\BookletController@bookletRelation');
Route::get('inventionRelation','API\InventionController@inventionRelation');
Route::get('rewardRelation','API\RewardController@rewardRelation');
Route::get('courseRelation','API\CourseController@courseRelation');
Route::get('grantRelation','API\GrantController@grantRelation');

// Search Routes
Route::post('findPaper','API\PapersController@search');
Route::get('findBook','API\BookController@search');
Route::get('findTed','API\TEDChairController@search');
Route::get('findThesis','API\ThesisController@search');
Route::get('findReward','API\RewardController@search');
Route::get('findProject','API\ProjectController@search');
Route::get('findReferee','API\RefereeController@search');
Route::get('findCourse','API\CourseController@search');
Route::get('findBooklet','API\BookletController@search');
Route::get('findInvention','API\InventionController@search');
Route::get('findGrant','API\GrantController@search');
Route::get('findUser','API\UserController@search');
Route::get('findFaculty','API\FacultiesController@search');
Route::get('findDepartment','API\DepartmentsController@search');

// CheckList Routes
Route::post('paperCheckList','API\CheckListController@store');
Route::post('thesisCheckList','API\CheckListController@store');
Route::post('bookCheckList','API\CheckListController@store');
Route::post('tedCheckList','API\CheckListController@store');
Route::post('rewardCheckList','API\CheckListController@store');
Route::post('projectCheckList','API\CheckListController@store');
Route::post('refereeCheckList','API\CheckListController@store');
Route::post('courseCheckList','API\CheckListController@store');
Route::post('bookletCheckList','API\CheckListController@store');
Route::post('inventionCheckList','API\CheckListController@store');
Route::post('grantCheckList','API\CheckListController@store');
Route::get('paperCheckList/{paper}','API\CheckListController@index');
Route::delete('paperCheckList/{checklist}','API\CheckListController@destroy');
Route::delete('deleteCheckListItem/{checklist}','API\CheckListController@destroy');

// Terms Update route
Route::post('termChange','API\TermsController@termChange');

Route::get('getJournalType','API\ScoreController@getJournalType');
Route::get('getConfType','API\ScoreController@getConfType');
Route::put('updateConfType/{confType}','API\ScoreController@updateConfType');
Route::put('updateJType/{JType}','API\ScoreController@updateJType');
Route::put('termActive/{Term}','API\TermsController@termActivate');
Route::get('findPaper','API\PapersController@search');
Route::put('profile','API\UserController@updateProfile');
