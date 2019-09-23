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
    'researchActivity'=>'API\ResearchActivityController',
    'blacklist'=>'API\BlackListController',
    'researchProposal'=>'API\ResearchProposalController',
]);

Route::get('profile','API\UserController@profile');
Route::post('blacklistimport','API\BlackListController@import');

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
Route::post('researchActivityUpdate/{researchactivity}','API\ResearchActivityController@update');
Route::post('researchProposalUpdate/{researchProposal}','API\ResearchProposalController@update');

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
Route::get('researchActivityRelation','API\ResearchActivityController@researchActivityRelation');
Route::get('researchProposalRelation','API\ResearchProposalController@researchProposalRelation');

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
Route::get('findResearchActivity','API\ResearchActivityController@search');
Route::get('findUser','API\UserController@search');
Route::get('findFaculty','API\FacultiesController@search');
Route::get('findDepartment','API\DepartmentsController@search');
Route::get('findResearchProposal','API\ResearchProposalController@search');
Route::get('findBlackList','API\BlackListController@search');
Route::get('blackListCheck','API\BlackListController@blackListCheck');

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
Route::post('researchActivityCheckList','API\CheckListController@store');
Route::get('paperCheckList/{paper}','API\CheckListController@index');
Route::delete('paperCheckList/{checklist}','API\CheckListController@destroy');
Route::delete('deleteCheckListItem/{checklist}','API\CheckListController@destroy');

/***
 *
 * Proposal Routes
 *
 */

Route::get('getResearchProposalTypes','API\ProposalRelationController@getProposalType');
Route::get('getProposalUsageTypes','API\ProposalRelationController@getProposalUsageTypes');

Route::put('updateResearchProposalTypeTitle/{ResearchActivityType}','API\ProposalRelationController@updateResearchProposalTypeTitle');
Route::put('updateResearchProposalUsageTitle/{ResearchProposalUsage}','API\ProposalRelationController@updateResearchProposalUsageTitle');

Route::post('addResearchProposalTypeTitle','API\ProposalRelationController@addResearchProposalTypeTitle');
Route::post('addResearchProposalUsageTitle','API\ProposalRelationController@addResearchProposalUsageTitle');

Route::delete('deleteResearchProposalTypeTitle/{ResearchActivityType}','API\ProposalRelationController@deleteResearchProposalTypeTitle');
Route::delete('deleteResearchProposalUsageTitle/{ResearchActivityType}','API\ProposalRelationController@deleteResearchProposalUsageTitle');


Route::get('getUserReviewList','API\ProposalReviewController@index');
Route::get('getProposalReviewList/{researchProposal}','API\ProposalReviewController@show');

Route::post('assignReviewer','API\ProposalReviewController@assign');
Route::post('ReviewerComment/{ProposalReview}','API\ProposalReviewController@comment');

Route::delete('deleteReview/{ProposalReview}','API\ProposalReviewController@destroy');




/***

SubType title Update, Add, and Delete routes

 ***/


Route::get('getJournalTypes','API\SubTypeController@getJournalType');
Route::get('getConfTypes','API\SubTypeController@getConfType');
Route::get('getBookTypes','API\SubTypeController@getBookType');
Route::get('getThesesTypes','API\SubTypeController@getThesesType');
Route::get('getTEDTypes','API\SubTypeController@getTEDType');
Route::get('getRefereeTypes','API\SubTypeController@getRefereeType');
Route::get('getProjectTypes','API\SubTypeController@getProjectType');
Route::get('getInventionTypes','API\SubTypeController@getInventionType');
Route::get('getResearchActivityTypes','API\SubTypeController@getResearchActivityType');


Route::put('updateConfTypeTitle/{confType}','API\SubTypeController@updateConfTypeTitle');
Route::put('updateJTypeTitle/{JType}','API\SubTypeController@updateJTypeTitle');
Route::put('updateBookTypeTitle/{BookType}','API\SubTypeController@updateBookTypeTitle');
Route::put('updateThesesTypeTitle/{ThesesType}','API\SubTypeController@updateThesesTypeTitle');
Route::put('updateTEDTypeTitle/{TEDType}','API\SubTypeController@updateTEDTypeTitle');
Route::put('updateRefereeTypeTitle/{RefereeType}','API\SubTypeController@updateRefereeTypeTitle');
Route::put('updateProjectTypeTitle/{ProjectType}','API\SubTypeController@updateProjectTypeTitle');
Route::put('updateInventionTypeTitle/{InventionType}','API\SubTypeController@updateInventionTypeTitle');
Route::put('updateResearchActivityTypeTitle/{ResearchActivityType}','API\SubTypeController@updateResearchActivityTypeTitle');


Route::post('addConfTypeTitle','API\SubTypeController@addConfTypeTitle');
Route::post('addJTypeTitle','API\SubTypeController@addJTypeTitle');
Route::post('addBookTypeTitle','API\SubTypeController@addBookTypeTitle');
Route::post('addThesesTypeTitle','API\SubTypeController@addThesesTypeTitle');
Route::post('addTEDTypeTitle','API\SubTypeController@addTEDTypeTitle');
Route::post('addRefereeTypeTitle','API\SubTypeController@addRefereeTypeTitle');
Route::post('addProjectTypeTitle','API\SubTypeController@addProjectTypeTitle');
Route::post('addInventionTypeTitle','API\SubTypeController@addInventionTypeTitle');
Route::post('addResearchActivityTypeTitle','API\SubTypeController@addResearchActivityTypeTitle');


Route::delete('deleteConfTypeTitle/{confType}','API\SubTypeController@deleteConfTypeTitle');
Route::delete('deleteJTypeTitle/{JType}','API\SubTypeController@deleteJTypeTitle');
Route::delete('deleteBookTypeTitle/{BookType}','API\SubTypeController@deleteBookTypeTitle');
Route::delete('deleteThesesTypeTitle/{ThesesType}','API\SubTypeController@deleteThesesTypeTitle');
Route::delete('deleteTEDTypeTitle/{TEDType}','API\SubTypeController@deleteTEDTypeTitle');
Route::delete('deleteRefereeTypeTitle/{RefereeType}','API\SubTypeController@deleteRefereeTypeTitle');
Route::delete('deleteProjectTypeTitle/{ProjectType}','API\SubTypeController@deleteProjectTypeTitle');
Route::delete('deleteInventionTypeTitle/{InventionType}','API\SubTypeController@deleteInventionTypeTitle');
Route::delete('deleteResearchActivityTypeTitle/{ResearchActivityType}','API\SubTypeController@deleteResearchActivityTypeTitle');

/***

SubType Score Update routes

 ***/

Route::get('getJournalType','API\ScoreController@getJournalType');
Route::get('getConfType','API\ScoreController@getConfType');
Route::get('getBookType','API\ScoreController@getBookType');
Route::get('getThesesType','API\ScoreController@getThesesType');
Route::get('getTEDType','API\ScoreController@getTEDType');
Route::get('getRefereeType','API\ScoreController@getRefereeType');
Route::get('getProjectType','API\ScoreController@getProjectType');
Route::get('getInventionType','API\ScoreController@getInventionType');
Route::get('getRewardType','API\ScoreController@getRewardType');
Route::get('getGrantType','API\ScoreController@getGrantType');
Route::get('getCourseType','API\ScoreController@getCourseType');
Route::get('getBookletType','API\ScoreController@getBookletType');
Route::get('getresearchActivityType','API\ScoreController@getresearchActivityType');

Route::put('updateConfType/{confType}','API\ScoreController@updateConfType');
Route::put('updateJType/{JType}','API\ScoreController@updateJType');
Route::put('updateBookType/{BookType}','API\ScoreController@updateBookType');
Route::put('updateThesesType/{ThesesType}','API\ScoreController@updateThesesType');
Route::put('updateTEDType/{TEDType}','API\ScoreController@updateTEDType');
Route::put('updateRefereeType/{RefereeType}','API\ScoreController@updateRefereeType');
Route::put('updateProjectType/{RefereeType}','API\ScoreController@updateProjectType');
Route::put('updateInventionType/{InventionType}','API\ScoreController@updateInventionType');
Route::put('updateRewardType/{RewardType}','API\ScoreController@updateRewardType');
Route::put('updateGrantType/{GrantType}','API\ScoreController@updateGrantType');
Route::put('updateCourseType/{CourseType}','API\ScoreController@updateCourseType');
Route::put('updateBookletType/{BookletType}','API\ScoreController@updateBookletType');
Route::put('updateResearchActivityType/{ResearchActivityType}','API\ScoreController@updateResearchActivityType');

// Terms Update route
Route::post('termChange','API\TermsController@termChange');
Route::put('termActive/{Term}','API\TermsController@termActivate');

Route::get('findPaper','API\PapersController@search');
Route::put('profile','API\UserController@updateProfile');


// Reports
Route::post('journalReport','API\ReportController@journalReport');
Route::post('conferenceReport','API\ReportController@conferenceReport');
Route::post('bookReport','API\ReportController@bookReport');
Route::post('inventionReport','API\ReportController@inventionReport');
Route::post('projectReport','API\ReportController@projectReport');
Route::post('tedReport','API\ReportController@tedReport');
Route::post('thesesReport','API\ReportController@thesesReport');
Route::post('grantsReport','API\ReportController@grantsReport');
Route::post('researchActivityReport','API\ReportController@researchActivityReport');
Route::post('refereesReport','API\ReportController@refereesReport');
Route::post('rewardsReport','API\ReportController@rewardsReport');
Route::post('bookletsReport','API\ReportController@bookletsReport');
Route::post('coursesReport','API\ReportController@coursesReport');
Route::post('researchActivityReport','API\ReportController@researchActivityReport');

// stats report
Route::post('termsList','API\ReportController@termsList');
Route::post('termStats','API\ReportController@termStats');
Route::post('facultyStats','API\ReportController@facultyStats');
Route::post('positionStats','API\ReportController@positionStats');
Route::post('typesStats','API\ReportController@typesStats');
Route::post('personalStats','API\ReportController@personalStats');
Route::post('personalChart','API\ReportController@personalChart');
Route::post('personalReport','API\ReportController@personalReport');
Route::post('dashboardReport','API\ReportController@dashboardReport');
Route::post('dashboardStats','API\ReportController@dashboardStats');

// User Reports
Route::post('userStats','API\ReportController@personalStats');
Route::post('userChart','API\ReportController@personalChart');
Route::post('userReport','API\ReportController@personalReport');
Route::post('presonalExportPdf','API\UserController@presonalExportPdf');
Route::post('userExportPdf','API\UserController@presonalExportPdf');
Route::post('jurResearchClubPaperPdf/{paper}','API\PapersController@jurResearchClub');
Route::post('confResearchClubPaperPdf/{paper}','API\PapersController@confResearchClub');
Route::post('jurResearchPrizePaperPdf/{paper}','API\PapersController@jurResearchPrize');
Route::post('confResearchPrizePaperPdf/{paper}','API\PapersController@confResearchPrize');

// Regulations Route
Route::get('regulationDetail/{regulation}','API\RegulationController@show');
Route::put('regulationDetail/{regulation}','API\RegulationController@update');


// helper routes to get Report relations collections
Route::get('paperReportRelation','API\PapersController@paperRelation');
Route::get('bookReportRelation','API\BookController@bookRelation');
Route::get('thesisReportRelation','API\ThesisController@thesisRelation');
Route::get('projectReportRelation','API\ProjectController@projectRelation');
Route::get('tedChairReportRelation','API\TEDChairController@tedChairRelation');
Route::get('refereeReportRelation','API\RefereeController@refereeRelation');
Route::get('bookletReportRelation','API\BookletController@bookletRelation');
Route::get('inventionReportRelation','API\InventionController@inventionRelation');
Route::get('rewardReportRelation','API\RewardController@rewardRelation');
Route::get('courseReportRelation','API\CourseController@courseRelation');
Route::get('grantReportRelation','API\GrantController@grantRelation');
Route::get('researchActivityReportRelation','API\ResearchActivityController@researchActivityRelation');


