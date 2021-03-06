<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\BookletReportResource;
use App\Http\Resources\BookReportResource;
use App\Http\Resources\conferenceReportResource;
use App\Http\Resources\CourseReportResource;
use App\Http\Resources\GrantReportResource;
use App\Http\Resources\InventionReportResource;
use App\Http\Resources\JournalReportResource;
use App\Http\Resources\ProjectReportResource;
use App\Http\Resources\ProposalReviewResource;
use App\Http\Resources\RefereeReportResource;
use App\Http\Resources\ResearchActivityReportResource;
use App\Http\Resources\ResearchActivityResource;
use App\Http\Resources\ResearchProposalForReviewResource;
use App\Http\Resources\ResearchProposalReportResource;
use App\Http\Resources\RewardReportResource;
use App\Http\Resources\TEDReportResource;
use App\Http\Resources\ThesesReportResource;
use App\Models\Book;
use App\Models\Booklet;
use App\Models\BookType;
use App\Models\Conference;
use App\Models\ConfType;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Grant;
use App\Models\Invention;
use App\Models\InventionType;
use App\Models\Journal;
use App\Models\Jtype;
use App\Models\Paper;
use App\Models\Position;
use App\Models\Profile;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\ProposalReview;
use App\Models\Referee;
use App\Models\RefereeType;
use App\Models\ResearchActivity;
use App\Models\ResearchProposal;
use App\Models\Reward;
use App\Models\TEDChair;
use App\Models\TEDType;
use App\Models\Term;
use App\Models\ThesesType;
use App\Models\Thesis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
/*use App\Exports\JournalExport;
use Maatwebsite\Excel\Facades\Excel;*/


class ReportController extends Controller
{
    //
    protected $perPage;
    public function __construct()
    {

        $this->middleware('jwt');
        $this->perPage=5;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function journalReport(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        $this->perPage = $request->get('perPage');
        $jtype_id = $request->get('jtype_id');
        $status = $request->get('status');
        $reward = $request->get('reward');
        $term = $request->get('term_id');
        $faculty_id = $request->get('faculty_id');
        $department_id = $request->get('department_id');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $order = $request->get('order');
        $dateType = $request->get('dateType');

        $journalQuery = Journal::with(['papers.profile','papers.profile.faculty','papers.authors','papers.excerpt','papers.term','jtype'])
            ->whereHas('papers',function ($query) use($reward, $status, $term, $start_date,$end_date, $dateType) {
                if (isset($term)) {
                    $query->whereIn('term_id',  explode(',',$term));
                }
                 if ( $start_date != '' &&  $end_date != '' ) {
                    if( $dateType == 0){
                        $query->whereBetween('created_at',[$start_date, $end_date]);
                    }elseif ( $dateType == 1){
                        $query->whereBetween('publish_date',[$start_date, $end_date]);
                    }
                 }
                if (isset($status)) {
                    $query->whereIn('status',  explode(',',$status));
                }
                if (isset($reward)) {
                    $query->whereIn('reward',  explode(',',$reward));
                }
            })->whereHas('jtype', function ($query) use ($jtype_id){
                if (isset($jtype_id)) {
                    $query->whereIn('id',  explode(',',$jtype_id));
                }
            })->whereHas('papers.profile', function ($query) use ($faculty_id){
                if (isset($faculty_id)) {
                    $query->whereIn('faculty_id',  explode(',',$faculty_id));
                }
            })->whereHas('papers.profile', function ($query) use ($department_id){
                if (isset($department_id)) {
                    $query->whereIn('department_id',  explode(',',$department_id));
                }
            })->orderBy('created_at', $order);

             if(\Request::get('excelReport') !=0){
                 $journalPapers =  $journalQuery->get();
             }else{
                 $journalPapers =  $journalQuery->paginate($this->perPage);
             }

       return JournalReportResource::collection($journalPapers);

   }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function conferenceReport(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        $this->perPage = $request->get('perPage');
        $conftype_id = $request->get('conftype_id');
        $status = $request->get('status');
        $reward = $request->get('reward');
        $term = $request->get('term_id');
        $faculty_id = $request->get('faculty_id');
        $department_id = $request->get('department_id');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $order = $request->get('order');
        $dateType = $request->get('dateType');
        //
        //\DB::enableQueryLog();
        $conferenceQuery = Conference::with(['papers.profile','papers.authors','papers.excerpt','papers.term','conftype'])
            ->whereHas('papers',function ($query) use ($reward,$term, $status, $start_date,$end_date, $dateType) {
                if (isset($term)) {
                    $query->whereIn('term_id',  explode(',',$term));
                }
                if ( $start_date != '' &&  $end_date != '' ) {
                    if( $dateType == 0){
                        $query->whereBetween('created_at',[$start_date, $end_date]);
                    }elseif ( $dateType == 1){
                        $query->whereBetween('publish_date',[$start_date, $end_date]);
                    }
                }
                if (isset($status)) {
                    $query->whereIn('status',  explode(',',$status));
                }

                if (isset($reward)) {
                    $query->whereIn('reward',  explode(',',$reward));
                }
        })->whereHas('conftype', function ($query) use ($conftype_id){
                if (isset($conftype_id)) {
                    $query->whereIn('id',  explode(',',$conftype_id));
                }
        })->whereHas('papers.profile', function ($query) use ($faculty_id){
                if (isset($faculty_id)) {
                    $query->whereIn('faculty_id',  explode(',',$faculty_id));
                }
        })->whereHas('papers.profile', function ($query) use ($department_id){
                if (isset($department_id)) {
                    $query->whereIn('department_id',  explode(',',$department_id));
                }
            })->orderBy('created_at', $order);
        if(\Request::get('excelReport') !=0){
            $conferencePapers =  $conferenceQuery->get();
        }else{
            $conferencePapers =  $conferenceQuery->paginate($this->perPage);
        }
      //  dd(\DB::getQueryLog());
        // return \Response::json(['papers'=>$journalPapers]);
        return conferenceReportResource::collection($conferencePapers);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function bookReport(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        $this->perPage = $request->get('perPage');
        $bookType_id = $request->get('bookType_id');
        $status = $request->get('status');
        $term = $request->get('term_id');
        $faculty_id = $request->get('faculty_id');
        $department_id = $request->get('department_id');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $order = $request->get('order');
        $dateType = $request->get('dateType');

        $bookQuery = Book::with(['profile','authors','excerpt','term','booktype'])
           ->where(function ($query) use($status, $term, $start_date,$end_date, $dateType) {
               if (isset($term)) {
                   $query->whereIn('term_id',  explode(',',$term));
               }
               if ( $start_date != '' &&  $end_date != '' ) {
                   if( $dateType == 0){
                       $query->whereBetween('created_at',[$start_date, $end_date]);
                   }elseif ( $dateType == 1){
                       $query->whereBetween('publish_year',[$start_date, $end_date]);
                   }
               }
               if (isset($status)) {
                   $query->whereIn('status',  explode(',',$status));
               }

            })->whereHas('booktype', function ($query) use ($bookType_id){
                if (isset($bookType_id)) {
                    $query->whereIn('id',  explode(',',$bookType_id));
                }
            })->whereHas('profile', function ($query) use ($faculty_id){
                if (isset($faculty_id)) {
                    $query->whereIn('faculty_id',  explode(',',$faculty_id));
                }
            })->whereHas('profile', function ($query) use ($department_id){
                if (isset($department_id)) {
                    $query->whereIn('department_id',  explode(',',$department_id));
                }
            })
            ->orderBy('created_at', $order);

        if(\Request::get('excelReport') !=0){
            $books =  $bookQuery->get();
        }else{
            $books =  $bookQuery->paginate($this->perPage);
        }
        //return \Response::json(['books'=>$books]);
        return BookReportResource::collection($books);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function inventionReport(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        $this->perPage = $request->get('perPage');
        $inventionType_id = $request->get('inventionType_id');
        $faculty_id = $request->get('faculty_id');
        $department_id = $request->get('department_id');
        $status = $request->get('status');
        $term = $request->get('term_id');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $order = $request->get('order');
        $dateType = $request->get('dateType');

        $inventionQuery = Invention::with(['profile','term','inventionType'])
           ->where(function ($query) use($status, $term, $start_date,$end_date,$dateType) {
               if (isset($term)) {
                   $query->whereIn('term_id',  explode(',',$term));
               }
               if ( $start_date != '' &&  $end_date != '' ) {
                   if( $dateType == 0){
                       $query->whereBetween('created_at',[$start_date, $end_date]);
                   }elseif ( $dateType == 1){
                       $query->whereBetween('submit_date',[$start_date, $end_date]);
                   }
               }
               if (isset($status)) {
                   $query->whereIn('status',  explode(',',$status));
               }

            })->whereHas('inventionType', function ($query) use ($inventionType_id){
                if (isset($inventionType_id)) {
                    $query->whereIn('id',  explode(',',$inventionType_id));
                }
            })->whereHas('profile', function ($query) use ($faculty_id){
                if (isset($faculty_id)) {
                    $query->whereIn('faculty_id',  explode(',',$faculty_id));
                }
            })->whereHas('profile', function ($query) use ($department_id){
                if (isset($department_id)) {
                    $query->whereIn('department_id',  explode(',',$department_id));
                }
            })
            ->orderBy('created_at', $order);

        if(\Request::get('excelReport') !=0){
            $inventions =  $inventionQuery->get();
        }else{
            $inventions =  $inventionQuery->paginate($this->perPage);
        }
        //return \Response::json(['books'=>$inventions]);
        return InventionReportResource::collection($inventions);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function projectReport(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        $this->perPage = $request->get('perPage');
        $projectType_id = $request->get('project_type_id');
        $faculty_id = $request->get('faculty_id');
        $department_id = $request->get('department_id');
        $status = $request->get('status');
        $term = $request->get('term_id');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $order = $request->get('order');
        $dateType = $request->get('dateType');

        $projectQuery = Project::with(['profile','term','authors','projectType'])
           ->where(function ($query) use($status, $term, $start_date,$end_date, $dateType) {
               if (isset($term)) {
                   $query->whereIn('term_id',  explode(',',$term));
               }
               if ( $start_date != '' &&  $end_date != '' ) {
                   if( $dateType == 0){
                       $query->whereBetween('created_at',[$start_date, $end_date]);
                   }elseif ( $dateType == 1){
                       $query->whereBetween('defense_date',[$start_date, $end_date]);
                   }
               }
               if (isset($status)) {
                   $query->whereIn('status',  explode(',',$status));
               }

            })->whereHas('projectType', function ($query) use ($projectType_id){
                if (isset($projectType_id)) {
                    $query->whereIn('id',  explode(',',$projectType_id));
                }
            })->whereHas('profile', function ($query) use ($faculty_id){
                if (isset($faculty_id)) {
                    $query->whereIn('faculty_id',  explode(',',$faculty_id));
                }
            })->whereHas('profile', function ($query) use ($department_id){
                if (isset($department_id)) {
                    $query->whereIn('department_id',  explode(',',$department_id));
                }
            })
            ->orderBy('created_at', $order);

        if(\Request::get('excelReport') !=0){
            $projects =  $projectQuery->get();
        }else{
            $projects =  $projectQuery->paginate($this->perPage);
        }
       // return \Response::json(['books'=>$projects]);
        return ProjectReportResource::collection($projects);

    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function ResearchProposalReport(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        $this->perPage = $request->get('perPage');
        $proposalType_id = $request->get('proposal_type_id');
        $proposalUsage_id = $request->get('proposal_usage_id');
        $faculty_id = $request->get('faculty_id');
        $department_id = $request->get('department_id');
        $status = $request->get('status');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $order = $request->get('order');
        $dateType = $request->get('dateType');

        $researchProposalQuery = ResearchProposal::with(['profile','authors','proposalType','proposalUsage'])
           ->where(function ($query) use($status, $start_date,$end_date, $dateType) {
               if ( $start_date != '' &&  $end_date != '' ) {
                   $query->whereBetween('created_at',[$start_date, $end_date]);
               }
               if (isset($status)) {
                   $query->whereIn('status',  explode(',',$status));
               }

            })->whereHas('proposalType', function ($query) use ($proposalType_id){
                if (isset($proposalType_id)) {
                    $query->whereIn('id',  explode(',',$proposalType_id));
                }
            })->whereHas('proposalUsage', function ($query) use ($proposalUsage_id){
                if (isset($proposalUsage_id)) {
                    $query->whereIn('id',  explode(',',$proposalUsage_id));
                }
            })->whereHas('profile', function ($query) use ($faculty_id){
                if (isset($faculty_id)) {
                    $query->whereIn('faculty_id',  explode(',',$faculty_id));
                }
            })->whereHas('profile', function ($query) use ($department_id){
                if (isset($department_id)) {
                    $query->whereIn('department_id',  explode(',',$department_id));
                }
            })
            ->orderBy('created_at', $order);

        if(\Request::get('excelReport') !=0){
            $proposals =  $researchProposalQuery->get();
        }else{
            $proposals =  $researchProposalQuery->paginate($this->perPage);
        }
       // return \Response::json(['books'=>$projects]);
        return ResearchProposalReportResource::collection($proposals);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function tedReport(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        $this->perPage = $request->get('perPage');
        $tedType_id = $request->get('ted_type_id');
        $faculty_id = $request->get('faculty_id');
        $department_id = $request->get('department_id');
        $status = $request->get('status');
        $term = $request->get('term_id');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $order = $request->get('order');
        $dateType = $request->get('dateType');

        $tedQuery = TEDChair::with(['profile','term','TEDType'])
           ->where(function ($query) use($status, $term, $start_date,$end_date,$dateType) {
               if (isset($term)) {
                   $query->whereIn('term_id',  explode(',',$term));
               }
               if ( $start_date != '' &&  $end_date != '' ) {
                   if( $dateType == 0){
                       $query->whereBetween('created_at',[$start_date, $end_date]);
                   }elseif ( $dateType == 1){
                       $query->whereBetween('presentation_date',[$start_date, $end_date]);
                   }
               }
               if (isset($status)) {
                   $query->whereIn('status',  explode(',',$status));
               }
            })->whereHas('TEDType', function ($query) use ($tedType_id){
                if (isset($tedType_id)) {
                    $query->whereIn('id',  explode(',',$tedType_id));
                }
            })->whereHas('profile', function ($query) use ($faculty_id){
                if (isset($faculty_id)) {
                    $query->whereIn('faculty_id',  explode(',',$faculty_id));
                }
            })->whereHas('profile', function ($query) use ($department_id){
                if (isset($department_id)) {
                    $query->whereIn('department_id',  explode(',',$department_id));
                }
            })
            ->orderBy('created_at', $order);

        if(\Request::get('excelReport') !=0){
            $teds =  $tedQuery->get();
        }else{
            $teds =  $tedQuery->paginate($this->perPage);
        }
      //  return \Response::json(['books'=>$teds]);
        return TEDReportResource::collection($teds);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function thesesReport(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        $this->perPage = $request->get('perPage');
        $thesis_type_id = $request->get('thesis_type_id');
        $faculty_id = $request->get('faculty_id');
        $department_id = $request->get('department_id');
        $status = $request->get('status');
        $term = $request->get('term_id');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $order = $request->get('order');
        $dateType = $request->get('dateType');

        $thesesQuery = Thesis::with(['profile','term','thesisType'])
           ->where(function ($query) use($status, $term, $start_date,$end_date, $dateType) {
               if (isset($term)) {
                   $query->whereIn('term_id',  explode(',',$term));
               }
               if ( $start_date != '' &&  $end_date != '' ) {
                   if( $dateType == 0){
                       $query->whereBetween('created_at',[$start_date, $end_date]);
                   }elseif ( $dateType == 1){
                       $query->whereBetween('defense_date',[$start_date, $end_date]);
                   }
               }
               if (isset($status)) {
                   $query->whereIn('status',  explode(',',$status));
               }

            })->whereHas('thesisType', function ($query) use ($thesis_type_id){
                if (isset($thesis_type_id)) {
                    $query->whereIn('id',  explode(',',$thesis_type_id));
                }
            })->whereHas('profile', function ($query) use ($faculty_id){
                if (isset($faculty_id)) {
                    $query->whereIn('faculty_id',  explode(',',$faculty_id));
                }
            })->whereHas('profile', function ($query) use ($department_id){
                if (isset($department_id)) {
                    $query->whereIn('department_id',  explode(',',$department_id));
                }
            })
            ->orderBy('created_at', $order);

        if(\Request::get('excelReport') !=0){
            $theses =  $thesesQuery->get();
        }else{
            $theses =  $thesesQuery->paginate($this->perPage);
        }
        //return \Response::json(['books'=>$theses]);
        return ThesesReportResource::collection($theses);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function refereesReport(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        $this->perPage = $request->get('perPage');
        $referee_types_id = $request->get('referee_type_id');
        $faculty_id = $request->get('faculty_id');
        $department_id = $request->get('department_id');
        $status = $request->get('status');
        $term = $request->get('term_id');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $order = $request->get('order');
        $dateType = $request->get('dateType');

        $refereeQuery = Referee::with(['profile','term','refereeType'])
           ->where(function ($query) use($status, $term, $start_date,$end_date,$dateType) {
               if (isset($term)) {
                   $query->whereIn('term_id',  explode(',',$term));
               }
               if ( $start_date != '' &&  $end_date != '' ) {
                   if( $dateType == 0){
                       $query->whereBetween('created_at',[$start_date, $end_date]);
                   }elseif ( $dateType == 1){
                       $query->whereBetween('referee_date',[$start_date, $end_date]);
                   }
               }
               if (isset($status)) {
                   $query->whereIn('status',  explode(',',$status));
               }

            })->whereHas('refereeType', function ($query) use ($referee_types_id){
                if (isset($referee_types_id)) {
                    $query->whereIn('id',  explode(',',$referee_types_id));
                }
            })->whereHas('profile', function ($query) use ($faculty_id){
                if (isset($faculty_id)) {
                    $query->whereIn('faculty_id',  explode(',',$faculty_id));
                }
            })->whereHas('profile', function ($query) use ($department_id){
                if (isset($department_id)) {
                    $query->whereIn('department_id',  explode(',',$department_id));
                }
            })
            ->orderBy('created_at', $order);

        if(\Request::get('excelReport') !=0){
            $referees =  $refereeQuery->get();
        }else{
            $referees =  $refereeQuery->paginate($this->perPage);
        }
        //return \Response::json(['books'=>$referees]);
        return RefereeReportResource::collection($referees);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function grantsReport(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        $this->perPage = $request->get('perPage');
        $faculty_id = $request->get('faculty_id');
        $department_id = $request->get('department_id');
        $status = $request->get('status');
        $term = $request->get('term_id');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $order = $request->get('order');
        $dateType = $request->get('dateType');

        $grantsQuery = Grant::with(['profile','term'])
           ->where(function ($query) use($status, $term, $start_date,$end_date,$dateType) {
               if (isset($term)) {
                   $query->whereIn('term_id',  explode(',',$term));
               }
               if ( $start_date != '' &&  $end_date != '' ) {
                   if( $dateType == 0){
                       $query->whereBetween('created_at',[$start_date, $end_date]);
                   }elseif ( $dateType == 1){
                       $query->whereBetween('submit_date',[$start_date, $end_date]);
                   }
               }
               if (isset($status)) {
                   $query->whereIn('status',  explode(',',$status));
               }

           })->whereHas('profile', function ($query) use ($faculty_id){
                if (isset($faculty_id)) {
                    $query->whereIn('faculty_id',  explode(',',$faculty_id));
                }
            })->whereHas('profile', function ($query) use ($department_id){
                if (isset($department_id)) {
                    $query->whereIn('department_id',  explode(',',$department_id));
                }
            })
            ->orderBy('created_at', $order);

        if(\Request::get('excelReport') !=0){
            $grants =  $grantsQuery->get();
        }else{
            $grants =  $grantsQuery->paginate($this->perPage);
        }
       // return \Response::json(['books'=>$grants]);
        return GrantReportResource::collection($grants);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function rewardsReport(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        $this->perPage = $request->get('perPage');
        $faculty_id = $request->get('faculty_id');
        $department_id = $request->get('department_id');
        $status = $request->get('status');
        $term = $request->get('term_id');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $order = $request->get('order');
        $dateType = $request->get('dateType');

        $rewardsQuery = Reward::with(['profile','term'])
           ->where(function ($query) use($status, $term, $start_date,$end_date, $dateType) {
               if (isset($term)) {
                   $query->whereIn('term_id',  explode(',',$term));
               }
               if ( $start_date != '' &&  $end_date != '' ) {
                   if( $dateType == 0){
                       $query->whereBetween('created_at',[$start_date, $end_date]);
                   }elseif ( $dateType == 1){
                       $query->whereBetween('holding_date',[$start_date, $end_date]);
                   }
               }
               if (isset($status)) {
                   $query->whereIn('status',  explode(',',$status));
               }

           })->whereHas('profile', function ($query) use ($faculty_id){
                if (isset($faculty_id)) {
                    $query->whereIn('faculty_id',  explode(',',$faculty_id));
                }
            })->whereHas('profile', function ($query) use ($department_id){
                if (isset($department_id)) {
                    $query->whereIn('department_id',  explode(',',$department_id));
                }
            })
            ->orderBy('created_at', $order);

        if(\Request::get('excelReport') !=0){
            $rewards =  $rewardsQuery->get();
        }else{
            $rewards =  $rewardsQuery->paginate($this->perPage);
        }
        //return \Response::json(['books'=>$rewards]);
        return RewardReportResource::collection($rewards);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function researchActivityReport(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        $this->perPage = $request->get('perPage');
        $research_activity_Type_id = $request->get('research_activity_Type_id');
        $faculty_id = $request->get('faculty_id');
        $department_id = $request->get('department_id');
        $status = $request->get('status');
        $term = $request->get('term_id');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $order = $request->get('order');
        $dateType = $request->get('dateType');

        $researchAtivityQuery = ResearchActivity::with(['profile','term','ResearchActivityType'])
            ->where(function ($query) use($status, $term, $start_date,$end_date,$dateType) {
                if (isset($term)) {
                    $query->whereIn('term_id',  explode(',',$term));
                }
                if ( $start_date != '' &&  $end_date != '' ) {
                    if( $dateType == 0){
                        $query->whereBetween('created_at',[$start_date, $end_date]);
                    }elseif ( $dateType == 1){
                        $query->whereBetween('start_date',[$start_date, $end_date]);
                    }
                }
                if (isset($status)) {
                    $query->whereIn('status',  explode(',',$status));
                }

            })->whereHas('ResearchActivityType', function ($query) use ($research_activity_Type_id){
                if (isset($research_activity_Type_id)) {
                    $query->whereIn('id',  explode(',',$research_activity_Type_id));
                }
            })->whereHas('profile', function ($query) use ($faculty_id){
                if (isset($faculty_id)) {
                    $query->whereIn('faculty_id',  explode(',',$faculty_id));
                }
            })->whereHas('profile', function ($query) use ($department_id){
                if (isset($department_id)) {
                    $query->whereIn('department_id',  explode(',',$department_id));
                }
            })
            ->orderBy('created_at', $order);

        if(\Request::get('excelReport') !=0){
            $researchActivities =  $researchAtivityQuery->get();
        }else{
            $researchActivities =  $researchAtivityQuery->paginate($this->perPage);
        }

        //return \Response::json(['books'=>$inventions]);
        return ResearchActivityReportResource::collection($researchActivities);

    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function bookletsReport(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        $this->perPage = $request->get('perPage');
        $faculty_id = $request->get('faculty_id');
        $department_id = $request->get('department_id');
        $status = $request->get('status');
        $term = $request->get('term_id');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $order = $request->get('order');
        $dateType = $request->get('dateType');
        $bookletsQuery = Booklet::with(['profile','term'])
           ->where(function ($query) use($status, $term, $start_date,$end_date,$dateType) {
               if (isset($term)) {
                   $query->whereIn('term_id',  explode(',',$term));
               }
               if ( $start_date != '' &&  $end_date != '' ) {
                   if( $dateType == 0){
                       $query->whereBetween('created_at',[$start_date, $end_date]);
                   }elseif ( $dateType == 1){
                       $query->whereBetween('compilation_date',[$start_date, $end_date]);
                   }
               }
               if (isset($status)) {
                   $query->whereIn('status',  explode(',',$status));
               }

           })->whereHas('profile', function ($query) use ($faculty_id){
                if (isset($faculty_id)) {
                    $query->whereIn('faculty_id',  explode(',',$faculty_id));
                }
            })->whereHas('profile', function ($query) use ($department_id){
                if (isset($department_id)) {
                    $query->whereIn('department_id',  explode(',',$department_id));
                }
            })
            ->orderBy('created_at', $order);

        if(\Request::get('excelReport') !=0){
            $booklets =  $bookletsQuery->get();
        }else{
            $booklets =  $bookletsQuery->paginate($this->perPage);
        }
        //return \Response::json(['books'=>$booklets]);
        return BookletReportResource::collection($booklets);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function coursesReport(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        $this->perPage = $request->get('perPage');
        $faculty_id = $request->get('faculty_id');
        $department_id = $request->get('department_id');
        $status = $request->get('status');
        $term = $request->get('term_id');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $order = $request->get('order');
        $dateType = $request->get('dateType');

        $coursesQuery = Course::with(['profile','term'])
           ->where(function ($query) use($status, $term, $start_date,$end_date,$dateType) {
               if (isset($term)) {
                   $query->whereIn('term_id',  explode(',',$term));
               }
               if ( $start_date != '' &&  $end_date != '' ) {
                   if( $dateType == 0){
                       $query->whereBetween('created_at',[$start_date, $end_date]);
                   }elseif ( $dateType == 1){
                       $query->whereBetween('holding_date',[$start_date, $end_date]);
                   }
               }
               if (isset($status)) {
                   $query->whereIn('status',  explode(',',$status));
               }

           })->whereHas('profile', function ($query) use ($faculty_id){
                if (isset($faculty_id)) {
                    $query->whereIn('faculty_id',  explode(',',$faculty_id));
                }
            })->whereHas('profile', function ($query) use ($department_id){
                if (isset($department_id)) {
                    $query->whereIn('department_id',  explode(',',$department_id));
                }
            })
            ->orderBy('created_at', $order);

        if(\Request::get('excelReport') !=0){
            $courses =  $coursesQuery->get();
        }else{
            $courses =  $coursesQuery->paginate($this->perPage);
        }
        //return \Response::json(['books'=>$courses]);
        return CourseReportResource::collection($courses);

    }
    public function termStats(Request $request){
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $statuses = [0,1,2,3,4];
        $total =0;
        $failed = 0;
        $success = 0;
        $uncheck = 0;
        $failed_temporarily =0;
        $edited = 0 ;
        $term = Term::where('status',1)->first()->id;
       // dd($term);

        $papers = Paper::where(function ($query) use ($term, $start_date, $end_date) {
            if (isset($term)) {
                $query->whereIn('papers.term_id',  explode(',',$term));
            }
            if ($start_date != '' && $end_date != '') {
                $query->whereBetween('papers.created_at', [$start_date, $end_date]);
            }
        })->get();
        $failed += $papers->where('status' ,3)->count();
        $success += $papers->where('status' ,1)->count();
        $uncheck += $papers->where('status' ,0)->count();
        $failed_temporarily += $papers->where('status' ,2)->count();
        $edited += $papers->where('status' ,4)->count();

        $books = Book::where(function ($query) use ($term, $start_date, $end_date) {
            if (isset($term)) {
                $query->whereIn('books.term_id',  explode(',',$term));
            }
            if ($start_date != '' && $end_date != '') {
                $query->whereBetween('books.created_at', [$start_date, $end_date]);
            }
        })->get();
        $failed += $books->where('status' ,3)->count();
        $success += $books->where('status' ,1)->count();
        $uncheck += $books->where('status' ,0)->count();
        $failed_temporarily += $books->where('status' ,2)->count();
        $edited += $books->where('status' ,4)->count();

        $projects = Project::where(function ($query) use ($term, $start_date, $end_date) {
            if (isset($term)) {
                $query->whereIn('projects.term_id',  explode(',',$term));
            }
            if ($start_date != '' && $end_date != '') {
                $query->whereBetween('projects.created_at', [$start_date, $end_date]);
            }
        })->get();
        $failed += $projects->where('status' ,3)->count();
        $success += $projects->where('status' ,1)->count();
        $uncheck += $projects->where('status' ,0)->count();
        $failed_temporarily += $projects->where('status' ,2)->count();
        $edited += $projects->where('status' ,4)->count();

        $theses = Thesis::where(function ($query) use ($term, $start_date, $end_date) {
            if (isset($term)) {
                $query->whereIn('theses.term_id',  explode(',',$term));
            }
            if ($start_date != '' && $end_date != '') {
                $query->whereBetween('theses.created_at', [$start_date, $end_date]);
            }
        })->get();
        $failed += $theses->where('status' ,3)->count();
        $success += $theses->where('status' ,1)->count();
        $uncheck += $theses->where('status' ,0)->count();
        $failed_temporarily += $theses->where('status' ,2)->count();
        $edited += $theses->where('status' ,4)->count();

        $inventions = Invention::where(function ($query) use ($term, $start_date, $end_date) {
            if (isset($term)) {
                $query->whereIn('inventions.term_id',  explode(',',$term));
            }
            if ($start_date != '' && $end_date != '') {
                $query->whereBetween('inventions.created_at', [$start_date, $end_date]);
            }
        })->get();
        $failed += $inventions->where('status' ,3)->count();
        $success += $inventions->where('status' ,1)->count();
        $uncheck += $inventions->where('status' ,0)->count();
        $failed_temporarily += $inventions->where('status' ,2)->count();
        $edited += $inventions->where('status' ,4)->count();

        $referees = Referee::where(function ($query) use ($term, $start_date, $end_date) {
            if (isset($term)) {
                $query->whereIn('referees.term_id',  explode(',',$term));
            }
            if ($start_date != '' && $end_date != '') {
                $query->whereBetween('referees.created_at', [$start_date, $end_date]);
            }
        })->get();
        $failed += $referees->where('status' ,3)->count();
        $success += $referees->where('status' ,1)->count();
        $uncheck += $referees->where('status' ,0)->count();
        $failed_temporarily += $referees->where('status' ,2)->count();
        $edited += $referees->where('status' ,4)->count();

        $researchActivities = ResearchActivity::where(function ($query) use ($term, $start_date, $end_date) {
            if (isset($term)) {
                $query->whereIn('research_activities.term_id',  explode(',',$term));
            }
            if ($start_date != '' && $end_date != '') {
                $query->whereBetween('research_activities.created_at', [$start_date, $end_date]);
            }
        })->get();
        $failed += $researchActivities->where('status' ,3)->count();
        $success += $researchActivities->where('status' ,1)->count();
        $uncheck += $researchActivities->where('status' ,0)->count();
        $failed_temporarily += $researchActivities->where('status' ,2)->count();
        $edited += $researchActivities->where('status' ,4)->count();

        $teds = TEDChair::where(function ($query) use ($term, $start_date, $end_date) {
            if (isset($term)) {
                $query->whereIn('tedchairs.term_id',  explode(',',$term));
            }
            if ($start_date != '' && $end_date != '') {
                $query->whereBetween('tedchairs.created_at', [$start_date, $end_date]);
            }
        })->get();
        $failed += $teds->where('status' ,3)->count();
        $success += $teds->where('status' ,1)->count();
        $uncheck += $teds->where('status' ,0)->count();
        $failed_temporarily += $teds->where('status' ,2)->count();
        $edited += $teds->where('status' ,4)->count();

        $rewards = Reward::where(function ($query) use ($term, $start_date, $end_date) {
            if (isset($term)) {
                $query->whereIn('rewards.term_id',  explode(',',$term));
            }
            if ($start_date != '' && $end_date != '') {
                $query->whereBetween('rewards.created_at', [$start_date, $end_date]);
            }
        })->get();
        $failed += $rewards->where('status' ,3)->count();
        $success += $rewards->where('status' ,1)->count();
        $uncheck += $rewards->where('status' ,0)->count();
        $failed_temporarily += $rewards->where('status' ,2)->count();
        $edited += $rewards->where('status' ,4)->count();

        $grants = Grant::where(function ($query) use ($term, $start_date, $end_date) {
            if (isset($term)) {
                $query->whereIn('grants.term_id',  explode(',',$term));
            }
            if ($start_date != '' && $end_date != '') {
                $query->whereBetween('grants.created_at', [$start_date, $end_date]);
            }
        })->get();
        $failed += $grants->where('status' ,3)->count();
        $success += $grants->where('status' ,1)->count();
        $uncheck += $grants->where('status' ,0)->count();
        $failed_temporarily += $grants->where('status' ,2)->count();
        $edited += $grants->where('status' ,4)->count();

        $courses = Course::where(function ($query) use ($term, $start_date, $end_date) {
            if (isset($term)) {
                $query->whereIn('courses.term_id',  explode(',',$term));
            }
            if ($start_date != '' && $end_date != '') {
                $query->whereBetween('courses.created_at', [$start_date, $end_date]);
            }
        })->get();
        $failed += $courses->where('status' ,3)->count();
        $success += $courses->where('status' ,1)->count();
        $uncheck += $courses->where('status' ,0)->count();
        $failed_temporarily += $courses->where('status' ,2)->count();
        $edited += $courses->where('status' ,4)->count();

        $booklets = Booklet::where(function ($query) use ($term, $start_date, $end_date) {
            if (isset($term)) {
                $query->whereIn('booklets.term_id',  explode(',',$term));
            }
            if ($start_date != '' && $end_date != '') {
                $query->whereBetween('booklets.created_at', [$start_date, $end_date]);
            }
        })->get();
        $failed += $booklets->where('status' ,3)->count();
        $success += $booklets->where('status' ,1)->count();
        $uncheck += $booklets->where('status' ,0)->count();
        $failed_temporarily += $booklets->where('status' ,2)->count();
        $edited += $booklets->where('status' ,4)->count();

        $total = $failed + $failed_temporarily + $success + $uncheck + $edited;
        $result = [$success,$failed,$uncheck,$failed_temporarily,$edited];
        return  \Response::json(['total'=>$total,'result'=>$result]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function facultyStats(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        //$faculty_id = $request->get('faculty_id');
        $term = $request->get('term_id');
        $query_type = $request->get('query_type');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $query = '';
        $statuses = [0,1,3];
        $faild = array();
        $success = array();
        $uncheck = array();


        $faculties = Faculty::all();
        $faculties_name = $faculties->pluck('name')->toArray();
        if($query_type == 'Journal' || $query_type == 'Conference'){
            foreach ($faculties as $faculty){
                $query = Paper::join('profiles', 'papers.profile_id', '=', 'profiles.id')
                    ->where('paperable_type', 'LIKE', "%{$query_type}")
                    ->where(function ($query) use ($faculty,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('papers.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('papers.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.faculty_id', $faculty->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Book'){
            foreach ($faculties as $faculty){
                $query = Book::join('profiles', 'books.profile_id', '=', 'profiles.id')
                    ->where(function ($query) use ($faculty,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('books.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('books.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.faculty_id', $faculty->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Project'){
            foreach ($faculties as $faculty){
                $query = Project::join('profiles', 'projects.profile_id', '=', 'profiles.id')
                    ->where(function ($query) use ($faculty,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('projects.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('projects.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.faculty_id', $faculty->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Invention'){
            foreach ($faculties as $faculty){
                $query = Invention::join('profiles', 'inventions.profile_id', '=', 'profiles.id')
                    ->where(function ($query) use ($faculty,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('inventions.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('inventions.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.faculty_id', $faculty->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'ResearchActivity'){
            foreach ($faculties as $faculty){
                $query = ResearchActivity::join('profiles', 'research_activities.profile_id', '=', 'profiles.id')
                    ->where(function ($query) use ($faculty,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('research_activities.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('research_activities.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.faculty_id', $faculty->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'TEDChair'){
            foreach ($faculties as $faculty){
                $query = TEDChair::join('profiles', 'tedchairs.profile_id', '=', 'profiles.id')
                    ->where(function ($query) use ($faculty,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('tedchairs.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('tedchairs.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.faculty_id', $faculty->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Referee'){
            foreach ($faculties as $faculty){
                $query = Referee::join('profiles', 'referees.profile_id', '=', 'profiles.id')
                    ->where(function ($query) use ($faculty,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('referees.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('referees.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.faculty_id', $faculty->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }

        }elseif($query_type == 'Thesis'){
            foreach ($faculties as $faculty){
                $query = Thesis::join('profiles', 'theses.profile_id', '=', 'profiles.id')
                    ->where(function ($query) use ($faculty,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('theses.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('theses.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.faculty_id', $faculty->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Reward'){
            foreach ($faculties as $faculty){
                $query = Reward::join('profiles', 'rewards.profile_id', '=', 'profiles.id')
                    ->where(function ($query) use ($faculty,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('rewards.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('rewards.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.faculty_id', $faculty->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Grant'){
            foreach ($faculties as $faculty){
                $query = Grant::join('profiles', 'grants.profile_id', '=', 'profiles.id')
                    ->where(function ($query) use ($faculty,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('grants.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('grants.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.faculty_id', $faculty->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Course'){
            foreach ($faculties as $faculty){
                $query = Course::join('profiles', 'courses.profile_id', '=', 'profiles.id')
                    ->where(function ($query) use ($faculty,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('courses.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('courses.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.faculty_id', $faculty->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Booklet'){
            foreach ($faculties as $faculty){
                $query = Booklet::join('profiles', 'booklets.profile_id', '=', 'profiles.id')
                    ->where(function ($query) use ($faculty,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('booklets.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('booklets.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.faculty_id', $faculty->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }
        return \Response::json(['success'=>$success,'failed'=>$faild,'unchecked'=>$uncheck, 'titles'=>$faculties_name]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function positionStats(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        $term = $request->get('term_id');
        $query_type = $request->get('query_type');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $query = '';
        $statuses = [0,1,3];
        $faild = array();
        $success = array();
        $uncheck = array();


        $positions = Position::all();
        $positions_name = $positions->pluck('name')->toArray();
        if($query_type == 'Journal' || $query_type == 'Conference'){
            foreach ($positions as $position){
                $query = Paper::join('profiles', 'papers.profile_id', '=', 'profiles.id')
                    ->where('paperable_type', 'LIKE', "%{$query_type}")
                    ->where(function ($query) use ($position,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('papers.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('papers.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.position_id', $position->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Book'){
            foreach ($positions as $position){
                $query = Book::join('profiles', 'books.profile_id', '=', 'profiles.id')
                    ->where(function ($query) use ($position,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('books.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('books.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.position_id', $position->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Project'){
            foreach ($positions as $position){
                $query = Project::join('profiles', 'projects.profile_id', '=', 'profiles.id')
                    ->where(function ($query) use ($position,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('projects.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('projects.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.position_id', $position->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Invention'){
            foreach ($positions as $position){
                $query = Invention::join('profiles', 'inventions.profile_id', '=', 'profiles.id')
                    ->where(function ($query) use ($position,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('inventions.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('inventions.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.position_id', $position->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'ResearchActivity'){
            foreach ($positions as $position){
                $query = ResearchActivity::join('profiles', 'research_activities.profile_id', '=', 'profiles.id')
                    ->where(function ($query) use ($position,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('research_activities.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('research_activities.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.position_id', $position->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'TEDChair'){
            foreach ($positions as $position){
                $query = TEDChair::join('profiles', 'tedchairs.profile_id', '=', 'profiles.id')
                    ->where(function ($query) use ($position,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('tedchairs.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('tedchairs.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.position_id', $position->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Referee'){
            foreach ($positions as $position){
                $query = Referee::join('profiles', 'referees.profile_id', '=', 'profiles.id')
                    ->where(function ($query) use ($position,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('referees.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('referees.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.position_id', $position->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Thesis'){
            foreach ($positions as $position){
                $query = Thesis::join('profiles', 'theses.profile_id', '=', 'profiles.id')
                    ->where(function ($query) use ($position,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('theses.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('theses.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.position_id', $position->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Reward'){
            foreach ($positions as $position){
                $query = Reward::join('profiles', 'rewards.profile_id', '=', 'profiles.id')
                    ->where(function ($query) use ($position,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('rewards.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('rewards.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.position_id', $position->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Grant'){
            foreach ($positions as $position){
                $query = Grant::join('profiles', 'grants.profile_id', '=', 'profiles.id')
                    ->where(function ($query) use ($position,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('grants.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('grants.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.position_id', $position->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Course'){
            foreach ($positions as $position){
                $query = Course::join('profiles', 'courses.profile_id', '=', 'profiles.id')
                    ->where(function ($query) use ($position,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('courses.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('courses.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.position_id', $position->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Booklet'){
            foreach ($positions as $position){
                $query = Booklet::join('profiles', 'booklets.profile_id', '=', 'profiles.id')
                    ->where(function ($query) use ($position,$term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('booklets.term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('booklets.created_at', [$start_date, $end_date]);
                        }
                        $query->where('profiles.position_id', $position->id);
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }
        return \Response::json(['success'=>$success,'failed'=>$faild,'unchecked'=>$uncheck, 'titles'=>$positions_name]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function typesStats(Request $request){
        $this->authorize('IsAdminOrIsAuthor');

        $term = $request->get('term_id');
        $query_type = $request->get('query_type');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $query = [];
        $statuses = [0,1,3];
        $faild = array();
        $success = array();
        $uncheck = array();

       // $query_type = 'Booklet';

        if($query_type == 'Journal' ){
            $jtypes = Jtype::all();
            $titles = $jtypes->pluck('name')->toArray();
            foreach ($jtypes as $jtype){

                $query = Journal::select('journals.id','journals.jtype_id')->with(['paper:status,term_id,paperable_type,paperable_id'])
                   // ->join('jtypes', 'journals.jtype_id', '=', 'jtypes.id')
                    ->where('journals.jtype_id', '=', $jtype->id)
                    ->whereHas('paper',function ($query) use ($term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('created_at', [$start_date, $end_date]);
                        }
                    })->get();

                $faild[] = $query->where('paper.status' ,3)->count();
                $success[] = $query->where('paper.status' ,1)->count();
                $uncheck[] = $query->where('paper.status' ,0)->count();
            }
        }elseif($query_type == 'Conference' ){
            $conftypes = ConfType::all();
            $titles = $conftypes->pluck('name')->toArray();
            foreach ($conftypes as $conftype){

                $query = Conference::select('conferences.id','conferences.conftype_id')->with(['paper:status,term_id,paperable_type,paperable_id'])
                   // ->join('conftypes', 'conferences.conftype_id', '=', 'conftypes.id')
                    ->where('conferences.conftype_id', '=', $conftype->id)
                    ->whereHas('paper',function ($query) use ($term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('created_at', [$start_date, $end_date]);
                        }
                    })->get();

                $faild[] = $query->where('paper.status' ,3)->count();
                $success[] = $query->where('paper.status' ,1)->count();
                $uncheck[] = $query->where('paper.status' ,0)->count();
            }
        }elseif($query_type == 'Book' ){
            $booktypes = BookType::all();
            $titles = $booktypes->pluck('name')->toArray();
            foreach ($booktypes as $booktype){

                $query = Book::select('id','booktype_id','status')
                    ->where('booktype_id', '=', $booktype->id)
                    ->where(function ($query) use ($term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('created_at', [$start_date, $end_date]);
                        }
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Project' ){
            $projecttypes = ProjectType::all();
            $titles = $projecttypes->pluck('name')->toArray();
            foreach ($projecttypes as $projecttype){

                $query = Project::select('id','project_types_id','status')
                    ->where('project_types_id', '=', $projecttype->id)
                    ->where(function ($query) use ($term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('created_at', [$start_date, $end_date]);
                        }
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Invention' ){
            $inventionypes = InventionType::all();
            $titles = $inventionypes->pluck('name')->toArray();
            foreach ($inventionypes as $inventionype){

                $query = Invention::select('id','invention_types_id','status')
                    ->where('invention_types_id', '=', $inventionype->id)
                    ->where(function ($query) use ($term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('created_at', [$start_date, $end_date]);
                        }
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Referee' ){
            $refereeTypes = RefereeType::all();
            $titles = $refereeTypes->pluck('name')->toArray();
            foreach ($refereeTypes as $refereeType){

                $query = Referee::select('id','referee_types_id','status')
                    ->where('referee_types_id', '=', $refereeType->id)
                    ->where(function ($query) use ($term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('created_at', [$start_date, $end_date]);
                        }
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'TEDChair' ){
            $tedTypes = TEDType::all();
            $titles = $tedTypes->pluck('name')->toArray();
            foreach ($tedTypes as $tedType){

                $query = TEDChair::select('id','ted_types_id','status')
                    ->where('ted_types_id', '=', $tedType->id)
                    ->where(function ($query) use ($term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('created_at', [$start_date, $end_date]);
                        }
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Thesis' ){
            $thesesTypes = ThesesType::all();
            $titles = $thesesTypes->pluck('name')->toArray();
            foreach ($thesesTypes as $thesesType){

                $query = Thesis::select('id','theses_types_id','status')
                    ->where('theses_types_id', '=', $thesesType->id)
                    ->where(function ($query) use ($term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('created_at', [$start_date, $end_date]);
                        }
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Reward' ){
            $types = ['داخلی','بین المللی'];
            $titles = $types;
            foreach ($types as $type){

                $query = Reward::select('id','type','status')
                    ->where('type', 'LIKE', "$type")
                    ->where(function ($query) use ($term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('created_at', [$start_date, $end_date]);
                        }
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Grant' ){
            $types = [0,1];
            $titles = ['داخلی','بین المللی'];
            foreach ($types as $type){

                $query = Grant::select('id','type','status')
                    ->where('type', '=', "$type")
                    ->where(function ($query) use ($term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('created_at', [$start_date, $end_date]);
                        }
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }elseif($query_type == 'Booklet' ){
            $types = ['اسلاید','جزوه'];
            $titles = $types;
            foreach ($types as $type){

                $query = Booklet::select('id','booklet_type','status')
                    ->where('booklet_type', 'LIKE', "$type")
                    ->where(function ($query) use ($term, $start_date, $end_date) {
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('created_at', [$start_date, $end_date]);
                        }
                    })->get();
                $faild[] = $query->where('status' ,3)->count();
                $success[] = $query->where('status' ,1)->count();
                $uncheck[] = $query->where('status' ,0)->count();
            }
        }
        return \Response::json(['success'=>$success,'failed'=>$faild,'unchecked'=>$uncheck, 'titles'=>$titles]);
    }

    public function personalChart(Request $request){

        if($request->is('api/userChart')){
            $user_id = $request->get('user_id');
        }elseif('api/personalChart'){
            $user_id = \Auth::user()->id;
        }


        $query[] = Profile::where('user_id','=',$user_id)->join('papers','profiles.id','=','papers.profile_id')
            ->where('papers.status','=',1)->
            select(\DB::raw('count(papers.id) as `data`'),\DB::raw('SUM(papers.score) as `scores`'), 'term_id')->groupBy('term_id')->get();
        $query[] = Profile::where('user_id','=',$user_id)->join('books','profiles.id','=','books.profile_id')
            ->where('books.status','=',1)->
            select(\DB::raw('count(books.id) as `data`'),\DB::raw('SUM(books.score) as `scores`'), 'term_id')->groupBy('term_id')->get();
        $query[] = Profile::where('user_id','=',$user_id)->join('inventions','profiles.id','=','inventions.profile_id')
            ->where('inventions.status','=',1)->
            select(\DB::raw('count(inventions.id) as `data`'),\DB::raw('SUM(inventions.score) as `scores`'), 'term_id')->groupBy('term_id')->get();

        $query[]= Profile::where('user_id','=',$user_id)->join('projects','profiles.id','=','projects.profile_id')
            ->where('projects.status','=',1)->
            select(\DB::raw('count(projects.id) as `data`'),\DB::raw('SUM(projects.score) as `scores`'), 'term_id')->groupBy('term_id')->get();
        $query[] = Profile::where('user_id','=',$user_id)->join('tedchairs','profiles.id','=','tedchairs.profile_id')
            ->where('tedchairs.status','=',1)->
            select(\DB::raw('count(tedchairs.id) as `data`'),\DB::raw('SUM(tedchairs.score) as `scores`'), 'term_id')->groupBy('term_id')->get();
        $query[] = Profile::where('user_id','=',$user_id)->join('theses','profiles.id','=','theses.profile_id')
            ->where('theses.status','=',1)->
            select(\DB::raw('count(theses.id) as `data`'),\DB::raw('SUM(theses.score) as `scores`'), 'term_id')->groupBy('term_id')->get();
        $query[] = Profile::where('user_id','=',$user_id)->join('referees','profiles.id','=','referees.profile_id')
            ->where('referees.status','=',1)->
            select(\DB::raw('count(referees.id) as `data`'),\DB::raw('SUM(referees.score) as `scores`'), 'term_id')->groupBy('term_id')->get();
        $query[]= Profile::where('user_id','=',$user_id)->join('booklets','profiles.id','=','booklets.profile_id')
            ->where('booklets.status','=',1)->
            select(\DB::raw('count(booklets.id) as `data`'),\DB::raw('SUM(booklets.score) as `scores`'), 'term_id')->groupBy('term_id')->get();
        $query[] = Profile::where('user_id','=',$user_id)->join('courses','profiles.id','=','courses.profile_id')
            ->where('courses.status','=',1)->
            select(\DB::raw('count(courses.id) as `data`'),\DB::raw('SUM(courses.score) as `scores`'), 'term_id')->groupBy('term_id')->get();
        $query[] = Profile::where('user_id','=',$user_id)->join('grants','profiles.id','=','grants.profile_id')
            ->where('grants.status','=',1)->
            select(\DB::raw('count(grants.id) as `data`'),\DB::raw('SUM(grants.score) as `scores`'), 'term_id')->groupBy('term_id')->get();
        $query[] = Profile::where('user_id','=',$user_id)->join('rewards','profiles.id','=','rewards.profile_id')
            ->where('rewards.status','=',1)->
            select(\DB::raw('count(rewards.id) as `data`'),\DB::raw('SUM(rewards.score) as `scores`'), 'term_id')->groupBy('term_id')->get();
        $query[] = Profile::where('user_id','=',$user_id)->join('research_activities','profiles.id','=','research_activities.profile_id')
            ->where('research_activities.status','=',1)->
            select(\DB::raw('count(research_activities.id) as `data`'),\DB::raw('SUM(research_activities.score) as `scores`'), 'term_id')->groupBy('term_id')->get();

        $counts = [];
        $scores = [];
        $terms = Term::orderBy('id', 'desc')->take(10)->get()->reverse();

        foreach ($terms as $term){
            $count = 0 ;
            $score = 0 ;
            foreach ($query as $items){
                foreach ($items as $item){
                    if($item['term_id'] == $term->id){
                        $count += $item['data'];
                        $score += $item['scores'];
                    }
                }
            }
            $counts[] = $count;
           $scores[] = round($score,2);
        }

        return \Response::json(['counts' => $counts, 'scores'=>$scores, 'titles'=>$terms->pluck('name')]);


    }
    public function personalStats(Request $request){
        if($request->is('api/userStats')){
            $profile = Profile::where('user_id', '=',$request->get('user_id'))->first();
            $profile_id = $profile->id;
        }elseif('api/personalStats'){
            $profile_id = \Auth::user()->profile->id;
        }

        $role = \Auth::user()->type;
        $term = $request->get('term_id');
        $result['Journal'] = Journal::with(['paper'])
            ->whereHas('paper',function ($query) use ($role,$profile_id,$term) {
                $query->where('profile_id',$profile_id);
                if (isset($term)) {
                    $query->whereIn('term_id',  explode(',',$term));
                }
            })->count();
        $result['Conference']= Conference::with(['paper'])
            ->whereHas('paper',function ($query) use ($role,$profile_id,$term) {
                $query->where('profile_id',$profile_id);
                if (isset($term)) {
                    $query->whereIn('term_id',  explode(',',$term));
                }
            })->count();
        $result['Book']= Book::where(function ($query) use ($role,$profile_id,$term) {
            $query->where('profile_id',$profile_id);
            if (isset($term)) {
                $query->whereIn('term_id',  explode(',',$term));
            }
        })->count();
        $result['Project']= Project::where(function ($query) use ($role,$profile_id,$term) {
            $query->where('profile_id',$profile_id);
            if (isset($term)) {
                $query->whereIn('term_id',  explode(',',$term));
            }
        })->count();
        $result['Invention'] = Invention::where(function ($query) use ($role,$profile_id,$term) {
            $query->where('profile_id',$profile_id);
            if (isset($term)) {
                $query->whereIn('term_id',  explode(',',$term));
            }
        })->count();
        $result['ResearchActivity'] = ResearchActivity::where(function ($query) use ($role,$profile_id,$term) {
            $query->where('profile_id',$profile_id);
            if (isset($term)) {
                $query->whereIn('term_id',  explode(',',$term));
            }
        })->count();
        $result['Referee']= Referee::where(function ($query) use ($role,$profile_id,$term) {
            $query->where('profile_id',$profile_id);
            if (isset($term)) {
                $query->whereIn('term_id',  explode(',',$term));
            }
        })->count();
        $result['TEDChair']= TEDChair::where(function ($query) use ($role,$profile_id,$term) {
            $query->where('profile_id',$profile_id);
            if (isset($term)) {
                $query->whereIn('term_id',  explode(',',$term));
            }
        })->count();
        $result['Thesis']= Thesis::where(function ($query) use ($role,$profile_id,$term) {
            $query->where('profile_id',$profile_id);
            if (isset($term)) {
                $query->whereIn('term_id',  explode(',',$term));
            }
        })->count();
        $result['Reward']= Reward::where(function ($query) use ($role,$profile_id,$term) {
            $query->where('profile_id',$profile_id);
            if (isset($term)) {
                $query->whereIn('term_id',  explode(',',$term));
            }
        })->count();
        $result['Grant']= Grant::where(function ($query) use ($role,$profile_id,$term) {
            $query->where('profile_id',$profile_id);
            if (isset($term)) {
                $query->whereIn('term_id',  explode(',',$term));
            }
        })->count();
        $result['Course']= Course::where(function ($query) use ($role,$profile_id,$term) {
            $query->where('profile_id',$profile_id);
            if (isset($term)) {
                $query->whereIn('term_id',  explode(',',$term));
            }
        })->count();
        $result['Booklet']= Booklet::where(function ($query) use ($role,$profile_id,$term) {
            $query->where('profile_id',$profile_id);
            if (isset($term)) {
                $query->whereIn('term_id',  explode(',',$term));
            }
        })->count();
        $result['ResearchProposal']= ResearchProposal::where(function ($query) use ($role,$profile_id,$term) {
            $query->where('profile_id',$profile_id);
        })->count();
        return \Response::json(['data'=>$result]);

    }
    public function personalReport(Request $request){
        if($request->is('api/userReport')){
            $profile = Profile::where('user_id', '=',$request->get('user_id'))->first();
            $profile_id = $profile->id;
        }elseif('api/personalReport'){
            $profile_id = \Auth::user()->profile->id;
        }


        $term = $request->get('term_id');
       // dd(explode(',',$term));
        $query_type = $request->get('query_type');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $query = [];
        if($query_type == 'Journal' ){
            $query = Journal::with(['paper'])
                ->whereHas('paper',function ($query) use ($profile_id,$term, $start_date, $end_date) {
                    $query->where('profile_id',$profile_id);
                    if (isset($term)) {
                        $query->whereIn('term_id',  explode(',',$term));
                    }
                    if ($start_date != '' && $end_date != '') {
                        $query->whereBetween('created_at', [$start_date, $end_date]);
                    }
                })->get();
            return JournalReportResource::collection($query);
        }elseif($query_type == 'Conference' ){
                $query = Conference::with(['paper'])
                    ->whereHas('paper',function ($query) use ($profile_id,$term, $start_date, $end_date) {
                        $query->where('profile_id',$profile_id);
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('created_at', [$start_date, $end_date]);
                        }
                    })->get();
              return conferenceReportResource::collection($query);
        }elseif($query_type == 'Book' ){
                $query = Book::where(function ($query) use ($profile_id,$term, $start_date, $end_date) {
                        $query->where('profile_id',$profile_id);
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('created_at', [$start_date, $end_date]);
                        }
                    })->get();
              return BookReportResource::collection($query);
        }elseif($query_type == 'Project' ){
                $query = Project::where(function ($query) use ($profile_id,$term, $start_date, $end_date) {
                        $query->where('profile_id',$profile_id);
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('created_at', [$start_date, $end_date]);
                        }
                    })->get();
              return ProjectReportResource::collection($query);
        }elseif($query_type == 'ResearchProposal' ){
            $query = ResearchProposal::where(function ($query) use ($profile_id,$term) {
                    $query->where('profile_id',$profile_id);
            })->get();
            return ResearchProposalReportResource::collection($query);
        }elseif($query_type == 'Invention' ){
                $query = Invention::where(function ($query) use ($profile_id,$term, $start_date, $end_date) {
                        $query->where('profile_id',$profile_id);
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('created_at', [$start_date, $end_date]);
                        }
                    })->get();
              return InventionReportResource::collection($query);
        }elseif($query_type == 'ResearchActivity' ){
                $query = ResearchActivity::where(function ($query) use ($profile_id,$term, $start_date, $end_date) {
                        $query->where('profile_id',$profile_id);
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('created_at', [$start_date, $end_date]);
                        }
                    })->get();
              return ResearchActivityReportResource::collection($query);
        }elseif($query_type == 'Referee' ){
                $query = Referee::where(function ($query) use ($profile_id,$term, $start_date, $end_date) {
                        $query->where('profile_id',$profile_id);
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('created_at', [$start_date, $end_date]);
                        }
                    })->get();
              return RefereeReportResource::collection($query);
        }elseif($query_type == 'TEDChair' ){
                $query = TEDChair::where(function ($query) use ($profile_id,$term, $start_date, $end_date) {
                        $query->where('profile_id',$profile_id);
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('created_at', [$start_date, $end_date]);
                        }
                    })->get();
              return TEDReportResource::collection($query);
        }elseif($query_type == 'Thesis' ){
                $query = Thesis::where(function ($query) use ($profile_id,$term, $start_date, $end_date) {
                        $query->where('profile_id',$profile_id);
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('created_at', [$start_date, $end_date]);
                        }
                    })->get();
              return ThesesReportResource::collection($query);
        }elseif($query_type == 'Reward' ){
                $query = Reward::where(function ($query) use ($profile_id,$term, $start_date, $end_date) {
                        $query->where('profile_id',$profile_id);
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('created_at', [$start_date, $end_date]);
                        }
                    })->get();
              return RewardReportResource::collection($query);
        }elseif($query_type == 'Grant' ){
                $query = Grant::where(function ($query) use ($profile_id,$term, $start_date, $end_date) {
                        $query->where('profile_id',$profile_id);
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('created_at', [$start_date, $end_date]);
                        }
                    })->get();
              return GrantReportResource::collection($query);
        }elseif($query_type == 'Course' ){
                $query = Course::where(function ($query) use ($profile_id,$term, $start_date, $end_date) {
                        $query->where('profile_id',$profile_id);
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('created_at', [$start_date, $end_date]);
                        }
                    })->get();
              return CourseReportResource::collection($query);
        }elseif($query_type == 'Booklet' ){
                $query = Booklet::where(function ($query) use ($profile_id,$term, $start_date, $end_date) {
                        $query->where('profile_id',$profile_id);
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                        if ($start_date != '' && $end_date != '') {
                            $query->whereBetween('created_at', [$start_date, $end_date]);
                        }
                    })->get();
              return BookletReportResource::collection($query);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function dashboardReport(Request $request){

        $profile_id = \Auth::user()->profile->id;
        $role = \Auth::user()->type;
        $term = $request->get('term_id');
        $query_type = $request->get('query_type');
        //$start_date = $request->get('start_date');
        //$end_date = $request->get('end_date');
        $query = [];
        if($query_type == 'Journal' ){
            $query = Journal::with(['paper'])
                ->whereHas('paper',function ($query) use ($role,$profile_id,$term) {
                    if($role == 'user'){
                        $query->where('profile_id',$profile_id);
                        $query->whereIn('status',[1,2,3]);
                    }else{
                        $query->whereIn('status',[0,4]);
                    }
                    if (isset($term)) {
                        $query->whereIn('term_id',  explode(',',$term));
                    }
                })->get();

            return JournalReportResource::collection($query);
        }elseif($query_type == 'Conference' ){
                $query = Conference::with(['paper'])
                    ->whereHas('paper',function ($query) use ($role,$profile_id,$term) {
                        if($role == 'user'){
                            $query->where('profile_id',$profile_id);
                            $query->whereIn('status',[1,2,3]);
                        }else{
                            $query->whereIn('status',[0,4]);
                        }
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                    })->get();

              return conferenceReportResource::collection($query);
        }elseif($query_type == 'Book' ){
                $query = Book::where(function ($query) use ($role,$profile_id,$term) {
                        if($role == 'user'){
                            $query->where('profile_id',$profile_id);
                            $query->whereIn('status',[1,2,3]);
                        }else{
                            $query->whereIn('status',[0,4]);
                        }
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                    })->get();

              return BookReportResource::collection($query);
        }elseif($query_type == 'Project' ){
                $query = Project::where(function ($query) use ($role,$profile_id,$term) {
                        if($role == 'user'){
                            $query->where('profile_id',$profile_id);
                            $query->whereIn('status',[1,2,3]);
                        }else{
                            $query->whereIn('status',[0,4]);
                        }
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                    })->get();

              return ProjectReportResource::collection($query);
        }elseif($query_type == 'Invention' ){
                $query = Invention::where(function ($query) use ($role,$profile_id,$term) {
                        if($role == 'user'){
                            $query->where('profile_id',$profile_id);
                            $query->whereIn('status',[1,2,3]);
                        }else{
                            $query->whereIn('status',[0,4]);
                        }
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                    })->get();

              return InventionReportResource::collection($query);
        }elseif($query_type == 'ResearchActivity' ){
                $query = ResearchActivity::where(function ($query) use ($role,$profile_id,$term) {
                        if($role == 'user'){
                            $query->where('profile_id',$profile_id);
                            $query->whereIn('status',[1,2,3]);
                        }else{
                            $query->whereIn('status',[0,4]);
                        }
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                    })->get();

              return ResearchActivityReportResource::collection($query);
        }elseif($query_type == 'Referee' ){
                $query = Referee::where(function ($query) use ($role,$profile_id,$term) {
                        if($role == 'user'){
                            $query->where('profile_id',$profile_id);
                            $query->whereIn('status',[1,2,3]);
                        }else{
                            $query->whereIn('status',[0,4]);
                        }
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                    })->get();

              return RefereeReportResource::collection($query);
        }elseif($query_type == 'TEDChair' ){
                $query = TEDChair::where(function ($query) use ($role,$profile_id,$term) {
                        if($role == 'user'){
                            $query->where('profile_id',$profile_id);
                            $query->whereIn('status',[1,2,3]);
                        }else{
                            $query->whereIn('status',[0,4]);
                        }
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                    })->get();

              return TEDReportResource::collection($query);
        }elseif($query_type == 'Thesis' ){
                $query = Thesis::where(function ($query)  use ($role,$profile_id,$term) {
                        if($role == 'user'){
                            $query->where('profile_id',$profile_id);
                            $query->whereIn('status',[1,2,3]);
                        }else{
                            $query->whereIn('status',[0,4]);
                        }
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                    })->get();

              return ThesesReportResource::collection($query);
        }elseif($query_type == 'Reward' ){
                $query = Reward::where(function ($query) use ($role,$profile_id,$term) {
                        if($role == 'user'){
                            $query->where('profile_id',$profile_id);
                            $query->whereIn('status',[1,2,3]);
                        }else{
                            $query->whereIn('status',[0,4]);
                        }
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                    })->get();

              return RewardReportResource::collection($query);
        }elseif($query_type == 'Grant' ){
                $query = Grant::where(function ($query) use ($role,$profile_id,$term) {
                        if($role == 'user'){
                            $query->where('profile_id',$profile_id);
                            $query->whereIn('status',[1,2,3]);
                        }else{
                            $query->whereIn('status',[0,4]);
                        }
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                    })->get();

              return GrantReportResource::collection($query);
        }elseif($query_type == 'Course' ){
                $query = Course::where(function ($query)use ($role,$profile_id,$term) {
                        if($role == 'user'){
                            $query->where('profile_id',$profile_id);
                            $query->whereIn('status',[1,2,3]);
                        }else{
                            $query->whereIn('status',[0,4]);
                        }
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                    })->get();

              return CourseReportResource::collection($query);
        }elseif($query_type == 'Booklet' ){
                $query = Booklet::where(function ($query) use ($role,$profile_id,$term) {
                        if($role == 'user'){
                            $query->where('profile_id',$profile_id);
                            $query->whereIn('status',[1,2,3]);
                        }else{
                            $query->whereIn('status',[0,4]);
                        }
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                    })->get();
              return BookletReportResource::collection($query);
        }elseif($query_type == 'ResearchProposal' ){
                $query = ResearchProposal::where(function ($query) use ($role,$profile_id,$term) {
                        if($role == 'user'){
                            $query->where('profile_id',$profile_id);
                            $query->whereIn('status',[1,2,3,5,7]);
                        }else{
                            $query->whereIn('status',[0,4]);
                        }
                    })->get();
              return ResearchProposalReportResource::collection($query);
        }elseif($query_type == 'ProposalReview' ){
                $query = ProposalReview::where(function ($query) use ($role,$profile_id,$term) {
                        $query->where('profile_id',$profile_id);
                        $query->where('status',0);
                        if (isset($term)) {
                            $query->whereIn('term_id',  explode(',',$term));
                        }
                    })->get();
              return ProposalReviewResource::collection($query);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function dashboardStats(Request $request){

        $profile_id = \Auth::user()->profile->id;
        $role = \Auth::user()->type;
        $term = $request->get('term_id');
        $result['Journal'] = Journal::with(['paper'])
                ->whereHas('paper',function ($query) use ($role,$profile_id,$term) {
                    if($role == 'user'){
                        $query->where('profile_id',$profile_id);
                        $query->whereIn('status',[1,2,3]);
                    }else{
                        $query->whereIn('status',[0,4]);
                    }
                    if (isset($term)) {
                        $query->whereIn('term_id',  explode(',',$term));
                    }
                })->count();
        $result['Conference']= Conference::with(['paper'])
            ->whereHas('paper',function ($query) use ($role,$profile_id,$term) {
                if($role == 'user'){
                    $query->where('profile_id',$profile_id);
                    $query->whereIn('status',[1,2,3]);
                }else{
                    $query->whereIn('status',[0,4]);
                }
                if (isset($term)) {
                    $query->whereIn('term_id',  explode(',',$term));
                }
            })->count();
        $result['Book']= Book::where(function ($query) use ($role,$profile_id,$term) {
            if($role == 'user'){
                $query->where('profile_id',$profile_id);
                $query->whereIn('status',[1,2,3]);
            }else{
                $query->whereIn('status',[0,4]);
            }
            if (isset($term)) {
                $query->whereIn('term_id',  explode(',',$term));
            }
        })->count();
        $result['Project']= Project::where(function ($query) use ($role,$profile_id,$term) {
            if($role == 'user'){
                $query->where('profile_id',$profile_id);
                $query->whereIn('status',[1,2,3]);
            }else{
                $query->whereIn('status',[0,4]);
            }
            if (isset($term)) {
                $query->whereIn('term_id',  explode(',',$term));
            }
        })->count();
        $result['Invention'] = Invention::where(function ($query) use ($role,$profile_id,$term) {
            if($role == 'user'){
                $query->where('profile_id',$profile_id);
                $query->whereIn('status',[1,2,3]);
            }else{
                $query->whereIn('status',[0,4]);
            }
            if (isset($term)) {
                $query->whereIn('term_id',  explode(',',$term));
            }
        })->count();
        $result['ResearchActivity'] = ResearchActivity::where(function ($query) use ($role,$profile_id,$term) {
            if($role == 'user'){
                $query->where('profile_id',$profile_id);
                $query->whereIn('status',[1,2,3]);
            }else{
                $query->whereIn('status',[0,4]);
            }
            if (isset($term)) {
                $query->whereIn('term_id',  explode(',',$term));
            }
        })->count();
        $result['Referee']= Referee::where(function ($query) use ($role,$profile_id,$term) {
            if($role == 'user'){
                $query->where('profile_id',$profile_id);
                $query->whereIn('status',[1,2,3]);
            }else{
                $query->whereIn('status',[0,4]);
            }
            if (isset($term)) {
                $query->whereIn('term_id',  explode(',',$term));
            }
        })->count();
        $result['TEDChair']= TEDChair::where(function ($query) use ($role,$profile_id,$term) {
            if($role == 'user'){
                $query->where('profile_id',$profile_id);
                $query->whereIn('status',[1,2,3]);
            }else{
                $query->whereIn('status',[0,4]);
            }
            if (isset($term)) {
                $query->whereIn('term_id',  explode(',',$term));
            }
        })->count();
        $result['Thesis']= Thesis::where(function ($query) use ($role,$profile_id,$term) {
            if($role == 'user'){
                $query->where('profile_id',$profile_id);
                $query->whereIn('status',[1,2,3]);
            }else{
                $query->whereIn('status',[0,4]);
            }
            if (isset($term)) {
                $query->whereIn('term_id',  explode(',',$term));
            }
        })->count();
        $result['Reward']= Reward::where(function ($query) use ($role,$profile_id,$term) {
            if($role == 'user'){
                $query->where('profile_id',$profile_id);
                $query->whereIn('status',[1,2,3]);
            }else{
                $query->whereIn('status',[0,4]);
            }
            if (isset($term)) {
                $query->whereIn('term_id',  explode(',',$term));
            }
        })->count();
        $result['Grant']= Grant::where(function ($query) use ($role,$profile_id,$term) {
            if($role == 'user'){
                $query->where('profile_id',$profile_id);
                $query->whereIn('status',[1,2,3]);
            }else{
                $query->whereIn('status',[0,4]);
            }
            if (isset($term)) {
                $query->whereIn('term_id',  explode(',',$term));
            }
        })->count();
        $result['Course']= Course::where(function ($query) use ($role,$profile_id,$term) {
            if($role == 'user'){
                $query->where('profile_id',$profile_id);
                $query->whereIn('status',[1,2,3]);
            }else{
                $query->whereIn('status',[0,4]);
            }
            if (isset($term)) {
                $query->whereIn('term_id',  explode(',',$term));
            }
        })->count();
        $result['Booklet']= Booklet::where(function ($query) use ($role,$profile_id,$term) {
            if($role == 'user'){
                $query->where('profile_id',$profile_id);
                $query->whereIn('status',[1,2,3]);
            }else{
                $query->whereIn('status',[0,4]);
            }
            if (isset($term)) {
                $query->whereIn('term_id',  explode(',',$term));
            }
        })->count();
        $result['ResearchProposal']= ResearchProposal::where(function ($query) use ($role,$profile_id,$term) {
            if($role == 'user'){
                $query->where('profile_id',$profile_id);
                $query->whereIn('status',[1,2,3,5,7]);
            }else{
                $query->whereIn('status',[0,4]);
            }

        })->count();
        $result['ProposalReview']= ProposalReview::where(function ($query) use ($role,$profile_id,$term) {
            $query->where('profile_id',$profile_id);
            $query->where('status',0);

        })->count();
        $show_result = false;
        foreach ($result as $item){
            if($item > 0){
                $show_result = true;
                break;
            }
        }
        return \Response::json(['data'=>$result, 'show_result'=>$show_result], 200);

    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function termsList(){
        $termes = Term::all()->map(function ($item){
            return ['id'=> $item['id'], 'text'=>$item['name']];
        })->toArray();
        return \Response::json(['terms'=>$termes], 200);
    }
}
