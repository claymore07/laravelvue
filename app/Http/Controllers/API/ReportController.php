<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\BookReportResource;
use App\Http\Resources\conferenceReportResource;
use App\Http\Resources\GrantReportResource;
use App\Http\Resources\InventionReportResource;
use App\Http\Resources\JournalReportResource;
use App\Http\Resources\ProjectReportResource;
use App\Http\Resources\RefereeReportResource;
use App\Http\Resources\TEDReportResource;
use App\Http\Resources\ThesesReportResource;
use App\Models\Book;
use App\Models\Conference;
use App\Models\Grant;
use App\Models\Invention;
use App\Models\Journal;
use App\Models\Paper;
use App\Models\Project;
use App\Models\Referee;
use App\Models\TEDChair;
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

    public function journalReport(){

        $this->perPage = \Request::get('perPage');
        $jtype_id = \Request::get('jtype_id');
        $status = \Request::get('status');
        $term = \Request::get('term_id');
        $faculty_id = \Request::get('faculty_id');
        $start_date = \Request::get('start_date');
        $end_date = \Request::get('end_date');
        $journalQuery = Journal::with(['papers.profile','papers.profile.faculty','papers.authors','papers.excerpt','papers.term','jtype'])
            ->whereHas('papers',function ($query) use($status, $term, $start_date,$end_date) {
                if ( $term != 0) {
                     $query->where('term_id','=',$term);
                 }
                 if ( $start_date != '' &&  $end_date != '') {
                     $query->whereBetween('created_at',[$start_date, $end_date]);
                 }

                if($status != 5){
                    $query->where('status', '=' , $status);
                }

            })->whereHas('jtype', function ($query) use ($jtype_id){
                if ($jtype_id != 0) {
                     $query->where('id', $jtype_id)   ;
                }
            })->whereHas('papers.profile', function ($query) use ($faculty_id){
                if ($faculty_id != 0) {
                    $query->where('faculty_id', $faculty_id)   ;
                }})
             ->orderBy('created_at', 'desc');

             if(\Request::get('excelReport') !=0){
                 $journalPapers =  $journalQuery->get();
             }else{
                 $journalPapers =  $journalQuery->paginate($this->perPage);
             }

       return JournalReportResource::collection($journalPapers);

   }

    public function conferenceReport(){

        $this->perPage = \Request::get('perPage');
        $conftype_id = \Request::get('conftype_id');
        $status = \Request::get('status');
        $term = \Request::get('term_id');
        $faculty_id = \Request::get('faculty_id');
        $start_date = \Request::get('start_date');
        $end_date = \Request::get('end_date');
        //
        //\DB::enableQueryLog();
        $conferenceQuery = Conference::with(['papers.profile','papers.authors','papers.excerpt','papers.term','conftype'])
            ->whereHas('papers',function ($query) use ($term, $status, $start_date,$end_date) {
                if ( $term != 0) {
                    $query->where('term_id','=',$term);
                }
                if ( $start_date != '' &&  $end_date != '') {
                    $query->whereBetween('created_at',[$start_date, $end_date]);
                }

                if($status != 5){
                    $query->where('status', '=' , $status);
                }
        })->whereHas('conftype', function ($query) use ($conftype_id){
            if ($conftype_id != 0) {
                 $query->where('id', $conftype_id)   ;
            }
        })->whereHas('papers.profile', function ($query) use ($faculty_id){
                if ($faculty_id != 0) {
                    $query->where('faculty_id', $faculty_id)   ;
                }
        })
        ->orderBy('created_at', 'desc');
        if(\Request::get('excelReport') !=0){
            $conferencePapers =  $conferenceQuery->get();
        }else{
            $conferencePapers =  $conferenceQuery->paginate($this->perPage);
        }
      //  dd(\DB::getQueryLog());
        // return \Response::json(['papers'=>$journalPapers]);
        return conferenceReportResource::collection($conferencePapers);

    }
    public function bookReport(){

        $this->perPage = \Request::get('perPage');
        $bookType_id = \Request::get('bookType_id');
        $status = \Request::get('status');
        $term = \Request::get('term_id');
        $start_date = \Request::get('start_date');
        $end_date = \Request::get('end_date');
        $bookQuery = Book::with(['profile','authors','excerpt','term','booktype'])
           ->where(function ($query) use($status, $term, $start_date,$end_date) {
                if ( $term != 0) {
                    $query->where('term_id','=',$term);
                }
                if ( $start_date != '' &&  $end_date != '') {
                    $query->whereBetween('created_at',[$start_date, $end_date]);
                }

                if($status != 5){
                    $query->where('status', '=' , $status);
                }

            })->whereHas('booktype', function ($query) use ($bookType_id){
                if ($bookType_id != 0) {
                    $query->where('id', $bookType_id)   ;
                }
            })
            ->orderBy('created_at', 'desc');

        if(\Request::get('excelReport') !=0){
            $books =  $bookQuery->get();
        }else{
            $books =  $bookQuery->paginate($this->perPage);
        }
        //return \Response::json(['books'=>$books]);
        return BookReportResource::collection($books);

    }
    public function inventionReport(){

        $this->perPage = \Request::get('perPage');
        $inventionType_id = \Request::get('inventionType_id');
        $status = \Request::get('status');
        $term = \Request::get('term_id');
        $start_date = \Request::get('start_date');
        $end_date = \Request::get('end_date');
        $inventionQuery = Invention::with(['profile','term','inventionType'])
           ->where(function ($query) use($status, $term, $start_date,$end_date) {
                if ( $term != 0) {
                    $query->where('term_id','=',$term);
                }
                if ( $start_date != '' &&  $end_date != '') {
                    $query->whereBetween('created_at',[$start_date, $end_date]);
                }

                if($status != 5){
                    $query->where('status', '=' , $status);
                }

            })->whereHas('inventionType', function ($query) use ($inventionType_id){
                if ($inventionType_id != 0) {
                    $query->where('id', $inventionType_id)   ;
                }
            })
            ->orderBy('created_at', 'desc');

        if(\Request::get('excelReport') !=0){
            $inventions =  $inventionQuery->get();
        }else{
            $inventions =  $inventionQuery->paginate($this->perPage);
        }
        //return \Response::json(['books'=>$inventions]);
        return InventionReportResource::collection($inventions);

    }
    public function projectReport(){

        $this->perPage = \Request::get('perPage');
        $projectType_id = \Request::get('project_type_id');
        $status = \Request::get('status');
        $term = \Request::get('term_id');
        $start_date = \Request::get('start_date');
        $end_date = \Request::get('end_date');
        $projectQuery = Project::with(['profile','term','authors','projectType'])
           ->where(function ($query) use($status, $term, $start_date,$end_date) {
                if ( $term != 0) {
                    $query->where('term_id','=',$term);
                }
                if ( $start_date != '' &&  $end_date != '') {
                    $query->whereBetween('created_at',[$start_date, $end_date]);
                }

                if($status != 5){
                    $query->where('status', '=' , $status);
                }

            })->whereHas('projectType', function ($query) use ($projectType_id){
                if ($projectType_id != 0) {
                    $query->where('id', $projectType_id)   ;
                }
            })
            ->orderBy('created_at', 'desc');

        if(\Request::get('excelReport') !=0){
            $projects =  $projectQuery->get();
        }else{
            $projects =  $projectQuery->paginate($this->perPage);
        }
       // return \Response::json(['books'=>$projects]);
        return ProjectReportResource::collection($projects);

    }

    public function tedReport(){

        $this->perPage = \Request::get('perPage');
        $tedType_id = \Request::get('ted_type_id');
        $status = \Request::get('status');
        $term = \Request::get('term_id');
        $start_date = \Request::get('start_date');
        $end_date = \Request::get('end_date');
        $tedQuery = TEDChair::with(['profile','term','TEDType'])
           ->where(function ($query) use($status, $term, $start_date,$end_date) {
                if ( $term != 0) {
                    $query->where('term_id','=',$term);
                }
                if ( $start_date != '' &&  $end_date != '') {
                    $query->whereBetween('created_at',[$start_date, $end_date]);
                }

                if($status != 5){
                    $query->where('status', '=' , $status);
                }

            })->whereHas('TEDType', function ($query) use ($tedType_id){
                if ($tedType_id != 0) {
                    $query->where('id', $tedType_id)   ;
                }
            })
            ->orderBy('created_at', 'desc');

        if(\Request::get('excelReport') !=0){
            $teds =  $tedQuery->get();
        }else{
            $teds =  $tedQuery->paginate($this->perPage);
        }
      //  return \Response::json(['books'=>$teds]);
        return TEDReportResource::collection($teds);

    }


    public function thesesReport(){

        $this->perPage = \Request::get('perPage');
        $thesis_type_id = \Request::get('thesis_type_id');
        $status = \Request::get('status');
        $term = \Request::get('term_id');
        $start_date = \Request::get('start_date');
        $end_date = \Request::get('end_date');
        $thesesQuery = Thesis::with(['profile','term','thesisType'])
           ->where(function ($query) use($status, $term, $start_date,$end_date) {
                if ( $term != 0) {
                    $query->where('term_id','=',$term);
                }
                if ( $start_date != '' &&  $end_date != '') {
                    $query->whereBetween('created_at',[$start_date, $end_date]);
                }

                if($status != 5){
                    $query->where('status', '=' , $status);
                }

            })->whereHas('thesisType', function ($query) use ($thesis_type_id){
                if ($thesis_type_id != 0) {
                    $query->where('id', $thesis_type_id)   ;
                }
            })
            ->orderBy('created_at', 'desc');

        if(\Request::get('excelReport') !=0){
            $theses =  $thesesQuery->get();
        }else{
            $theses =  $thesesQuery->paginate($this->perPage);
        }
        //return \Response::json(['books'=>$theses]);
        return ThesesReportResource::collection($theses);

    }
    public function refereesReport(){

        $this->perPage = \Request::get('perPage');
        $referee_types_id = \Request::get('referee_type_id');
        $status = \Request::get('status');
        $term = \Request::get('term_id');
        $start_date = \Request::get('start_date');
        $end_date = \Request::get('end_date');
        $refereeQuery = Referee::with(['profile','term','refereeType'])
           ->where(function ($query) use($status, $term, $start_date,$end_date) {
                if ( $term != 0) {
                    $query->where('term_id','=',$term);
                }
                if ( $start_date != '' &&  $end_date != '') {
                    $query->whereBetween('created_at',[$start_date, $end_date]);
                }

                if($status != 5){
                    $query->where('status', '=' , $status);
                }

            })->whereHas('refereeType', function ($query) use ($referee_types_id){
                if ($referee_types_id != 0) {
                    $query->where('id', $referee_types_id)   ;
                }
            })
            ->orderBy('created_at', 'desc');

        if(\Request::get('excelReport') !=0){
            $referees =  $refereeQuery->get();
        }else{
            $referees =  $refereeQuery->paginate($this->perPage);
        }
        //return \Response::json(['books'=>$referees]);
        return RefereeReportResource::collection($referees);

    }

    public function grantsReport(){

        $this->perPage = \Request::get('perPage');
        $status = \Request::get('status');
        $term = \Request::get('term_id');
        $start_date = \Request::get('start_date');
        $end_date = \Request::get('end_date');
        $grantsQuery = Grant::with(['profile','term'])
           ->where(function ($query) use($status, $term, $start_date,$end_date) {
                if ( $term != 0) {
                    $query->where('term_id','=',$term);
                }
                if ( $start_date != '' &&  $end_date != '') {
                    $query->whereBetween('created_at',[$start_date, $end_date]);
                }

                if($status != 5){
                    $query->where('status', '=' , $status);
                }

            })
            ->orderBy('created_at', 'desc');

        if(\Request::get('excelReport') !=0){
            $grants =  $grantsQuery->get();
        }else{
            $grants =  $grantsQuery->paginate($this->perPage);
        }
       // return \Response::json(['books'=>$grants]);
        return GrantReportResource::collection($grants);

    }

}
