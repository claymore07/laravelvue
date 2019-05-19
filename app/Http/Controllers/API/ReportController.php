<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\BookReportResource;
use App\Http\Resources\conferenceReportResource;
use App\Http\Resources\JournalReportResource;
use App\Models\Book;
use App\Models\Conference;
use App\Models\Journal;
use App\Models\Paper;
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
        $start_date = \Request::get('start_date');
        $end_date = \Request::get('end_date');
        $journalQuery = Journal::with(['papers.profile','papers.authors','papers.excerpt','papers.term','jtype'])
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
            })
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

}
