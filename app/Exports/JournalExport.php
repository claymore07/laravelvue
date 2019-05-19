<?php
namespace App\Exports;

use App\Models\Journal;
use App\Models\Role;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class JournalExport implements FromCollection
{
    public function collection()
    {
         //$jtype_id = \Request::get('jtype_id');
        //
        //\DB::enableQueryLog();
        $journalPapers = User::all()/* with(['papers.profile','papers.authors','papers.excerpt','papers.term','jtype'])
           ->whereHas('papers',function ($query) {
                if ( \Request::has('term_id')) {
                    $term = \Request::get('term_id');

                    $query->where('term_id','=',$term);
                }
                if ( \Request::has('start_date') &&  \Request::has('end_date')) {
                    $start_date = \Request::get('start_date');
                    $end_date = \Request::get('end_date');
                    $query->whereBetween('created_at',[$start_date, $end_date]);
                }
                if(\Request::has('status')){
                    $status = \Request::get('status');
                    //dd($status);
                    $query->where('status', '=' , $status);
                }
            })->whereHas('jtype', function ($query) use ($jtype_id){
                if ($jtype_id != 0) {
                    $query->where('id', $jtype_id)   ;
                }
            })
            ->orderBy('created_at', 'desc')->take(5)*/;
        return $journalPapers;
    }
}
