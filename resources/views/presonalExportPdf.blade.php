<html>
<header>

   @include('layouts.pdfStyle')
</header>
<body style="border: black 10px solid">

<?php
function arabic_w2e($str) {
    $arabic_eastern = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    $arabic_western = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    return str_replace($arabic_western, $arabic_eastern, $str);
}
?>
<htmlpagefooter name="page-footer">
    <span class="persian-num">{nb}/{PAGENO}</span>
</htmlpagefooter>
<table class="table border table-sm">
    <tr>
        <td colspan="2" style="border: none; font-size: 12pt"><b>مشخصات فردی</b></td>.
        <td rowspan="8" style="border: none; vertical-align: middle; text-align: center">
            @if($user->photo == 'profile.png')
                <img class="img-thumbnail" src="{{  '.'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'profile.png' }}" alt="" width="100" height="100"> </td>
            @else
                <img class="img-thumbnail" src="{{ '.'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'profile'.DIRECTORY_SEPARATOR."$user->photo" }}" alt="" width="100" height="100"> </td>
            @endif
    </tr>
    <tr>
        <td >نام و نام خانوادگی:  {{$user->profile->Fname.' '.$user->profile->Lname}}         </td>
    </tr>
    <tr>
        <td >
            آخرین مدرک: {{$user->profile->degree->name}}
        </td>
    </tr>
    <tr>
        <td >
            دانشکده: {{$user->profile->faculty->name}} <br>
        </td>
    </tr>
    <tr>
        <td >
            گروه: {{$user->profile->department->name}} <br>
        </td>
    </tr>
    <tr>
        <td >
            نوع همکاری: {{$user->profile->position->name}} <br>
        </td>
    </tr>
    <tr>
        <td >
            رایانامه: {{$user->email}} <br>
        </td>
    </tr>
    <tr>
        <td class="persian-num">
            شماره تماس: {{$user->profile->phone}} <br>
        </td>
    </tr>

</table>
<table class="table table-bordered table-sm"  style=" border-collapse: collapse;" >
    <tr>
        <td colspan="12" style="border: none; font-size: 12pt" class="border-bottom"><b>مقالات ژورنالی</b></td>
    </tr>

    <tr >
        <td style="text-align: center; vertical-align: middle">ردیف</td>
        <td style="vertical-align: middle">نام مقاله</td>
        <td style="vertical-align: middle">نام نویسندگان</td>
        <td style="vertical-align: middle">عنوان ژورنال</td>
        <td style="vertical-align: middle">نام ناشر</td>
        <td style="vertical-align: middle">نوع ژورنال</td>
        <td style="vertical-align: middle">نوع مستخرج بودن</td>
        <td style="vertical-align: middle">تاریخ چاپ</td>
        <td style="vertical-align: middle">ISSN</td>
        <td style="vertical-align: middle">IF</td>
        <td style="vertical-align: middle">ترم</td>
    </tr>
    <tbody>
    @php
        $counter = 1;
        @endphp
    @foreach($journals as $item)
        <tr>
            <td class="persian-num" style="text-align: center; vertical-align: middle">{{$counter++}}  </td>
            <td style=" vertical-align: middle">{{$item->paper->title}}  </td>
            <td style=" vertical-align: middle">
                @foreach($item->paper->authors as $author)
                        {{$author->name}},
                @endforeach
            </td>
            <td style=" vertical-align: middle">{{$item->name}}</td>
            <td style=" vertical-align: middle">{{$item->publisher}}</td>
            <td style=" vertical-align: middle">{{$item->paper->excerpt->name}}</td>
            <td style=" vertical-align: middle">{{$item->jtype->name}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{\Morilog\Jalali\Jalalian::forge($item->paper->publish_date)->format('Y/m/d')}}</td>
            <td class="persian-num"  style=" vertical-align: middle">{{$item->issn}}</td>
            <td class="persian-num"  style=" vertical-align: middle">{{$item->IFactor}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{$item->paper->term->name}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<table class="table table-bordered table-sm"  style=" border-collapse: collapse;" >
    <tr>
        <td colspan="12" style="border: none; font-size: 12pt" class="border-bottom"><b>مقالات کنفرانسی</b></td>
    </tr>

    <tr >
        <td style="text-align: center; vertical-align: middle">ردیف</td>
        <td style="vertical-align: middle">نام مقاله</td>
        <td style="vertical-align: middle">نام نویسندگان</td>
        <td style="vertical-align: middle">عنوان کنفرانس</td>
        <td style="vertical-align: middle">نام برگزارکننده</td>
        <td style="vertical-align: middle">نوع کنفرانس</td>
        <td style="vertical-align: middle">دوره برگزاری</td>
        <td style="vertical-align: middle">نوع مستخرج بودن</td>
        <td style="vertical-align: middle">تاریخ چاپ</td>
        <td style="vertical-align: middle">ترم</td>
    </tr>
    <tbody>
    @php
        $counter = 1;
        @endphp
    @foreach($conferences as $item)
        <tr>
            <td class="persian-num" style="text-align: center; vertical-align: middle">{{$counter++}}  </td>
            <td style=" vertical-align: middle">{{$item->paper->title}}  </td>
            <td style=" vertical-align: middle">
                @foreach($item->paper->authors as $author)
                        {{$author->name}},
                @endforeach
            </td>
            <td style=" vertical-align: middle">{{$item->name}}</td>
            <td style=" vertical-align: middle">{{$item->organizer}}</td>
            <td style=" vertical-align: middle">{{$item->paper->excerpt->name}}</td>
            <td style=" vertical-align: middle">{{$item->conftype->name}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{$item->period}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{\Morilog\Jalali\Jalalian::forge($item->paper->publish_date)->format('Y/m/d')}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{$item->paper->term->name}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<table class="table table-bordered table-sm"  style=" border-collapse: collapse;" >
    <tr>
        <td colspan="12" style="border: none; font-size: 12pt" class="border-bottom"><b>کتاب ها</b></td>
    </tr>

    <tr >
        <td style="text-align: center; vertical-align: middle">ردیف</td>
        <td style=" vertical-align: middle">نام کتاب</td>
        <td style=" vertical-align: middle">نام نویسندگان</td>
        <td style=" vertical-align: middle">نوع کتاب</td>
        <td style=" vertical-align: middle">نام ناشر</td>
        <td style=" vertical-align: middle">موضوع کتاب</td>
        <td style=" vertical-align: middle">نوع مستخرج بودن</td>
        <td style=" vertical-align: middle">تاریخ چاپ</td>
        <td style=" vertical-align: middle">ردیف چاپ</td>
        <td style=" vertical-align: middle">تیراژ</td>
        <td style=" vertical-align: middle">تعداد صفحات</td>
        <td style=" vertical-align: middle">ترم</td>
    </tr>
    <tbody>
    @php
        $counter = 1;
        @endphp
    @foreach($books as $item)
        <tr>
            <td class="persian-num" style="text-align: center; vertical-align: middle">{{$counter++}}  </td>
            <td style=" vertical-align: middle">{{$item->title}}  </td>
            <td style=" vertical-align: middle">
                @foreach($item->authors as $author)
                        {{$author->name}},
                @endforeach
            </td>
            <td style=" vertical-align: middle">{{$item->booktype->name}}</td>
            <td style=" vertical-align: middle">{{$item->publisher}}</td>
            <td style=" vertical-align: middle">{{$item->subject}}</td>
            <td style=" vertical-align: middle">{{$item->excerpt->name}}</td>
            <td style=" vertical-align: middle">{{\Morilog\Jalali\Jalalian::forge($item->publish_year)->format('Y/m/d')}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{$item->publish_number}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{$item->copy_number}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{$item->pages}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{$item->term->name}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<table class="table table-bordered table-sm"  style=" border-collapse: collapse;" >
    <tr>
        <td colspan="8" style="border: none; font-size: 12pt" class="border-bottom"><b>طرح های پژوهشی و فناوری</b></td>
    </tr>

    <tr >
        <td style="text-align: center; vertical-align: middle">ردیف</td>
        <td style=" vertical-align: middle">عنوان طرح پژوهشی</td>
        <td style=" vertical-align: middle">نام نویسندگان</td>
        <td style=" vertical-align: middle">نوع طرح پژوهشی</td>
        <td style=" vertical-align: middle">بودجه طرح پژوهشی(ریال)</td>
        <td style=" vertical-align: middle">سازمان طرف قرارداد</td>
        <td style=" vertical-align: middle">تاریخ دفاع</td>
        <td style=" vertical-align: middle">ترم</td>
    </tr>
    <tbody>
    @php
        $counter = 1;
        @endphp
    @foreach($projects as $item)
        <tr>
            <td class="persian-num" style="text-align: center; vertical-align: middle">{{$counter++}}  </td>
            <td style=" vertical-align: middle">{{$item->title}}  </td>
            <td style=" vertical-align: middle">
                @foreach($item->authors as $author)
                        {{$author->name}},
                @endforeach
            </td>
            <td style=" vertical-align: middle">{{$item->projectType->name}}</td>
            <td  class="persian-num" style=" vertical-align: middle">{{$item->budget}}</td>
            <td style=" vertical-align: middle">{{$item->organization}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{\Morilog\Jalali\Jalalian::forge($item->defense_date)->format('Y/m/d')}}</td>
            <td  class="persian-num" style=" vertical-align: middle">{{ $item->term->name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<table class="table table-bordered table-sm"  style=" border-collapse: collapse;" >
    <tr>
        <td colspan="7" style="border: none; font-size: 12pt" class="border-bottom"><b>اختراعات و ابداعات و نوآوری ها</b></td>
    </tr>

    <tr >
        <td style="text-align: center; vertical-align: middle">ردیف</td>
        <td style=" vertical-align: middle">عنوان اختراع</td>
        <td style=" vertical-align: middle">نوع اختراع</td>
        <td style=" vertical-align: middle">سمت در تیم</td>
        <td style=" vertical-align: middle">مرحع تایید کننده</td>
        <td style=" vertical-align: middle">تاریخ ثبت یا صدور تاییدیه</td>
        <td style=" vertical-align: middle">ترم</td>
    </tr>
    <tbody>
    @php
        $counter = 1;
        @endphp
    @foreach($inventions as $item)
        <tr>
            <td class="persian-num" style="text-align: center; vertical-align: middle">{{$counter++}}  </td>
            <td style=" vertical-align: middle">{{$item->title}}  </td>
            <td style=" vertical-align: middle">{{$item->inventionType->name}}</td>
            <td style=" vertical-align: middle">{{$item->post}}</td>
            <td style=" vertical-align: middle">{{$item->authorities}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{\Morilog\Jalali\Jalalian::forge($item->submit_date)->format('Y/m/d')}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{$item->term->name}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<table class="table table-bordered table-sm"  style=" border-collapse: collapse;" >
    <tr>
        <td colspan="7" style="border: none; font-size: 12pt" class="border-bottom"><b>فعالیت های اجرایی پژوهشی</b></td>
    </tr>

    <tr >
        <td style="text-align: center; vertical-align: middle">ردیف</td>
        <td style=" vertical-align: middle">عنوان فعالیت</td>
        <td style=" vertical-align: middle">نوع فعالیت</td>
        <td style=" vertical-align: middle">مرحع تایید کننده</td>
        <td style=" vertical-align: middle">تاریخ شروع</td>
        <td style=" vertical-align: middle">تاریخ اتمام</td>
        <td style=" vertical-align: middle">ترم</td>
    </tr>
    <tbody>
    @php
        $counter = 1;
    @endphp
    @foreach($researchActivities as $item)
        <tr>
            <td class="persian-num" style="text-align: center; vertical-align: middle">{{$counter++}}  </td>
            <td style=" vertical-align: middle">{{$item->title}}  </td>
            <td style=" vertical-align: middle">{{$item->ResearchActivityType->name}}</td>
            <td style=" vertical-align: middle">{{$item->authorities}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{\Morilog\Jalali\Jalalian::forge($item->start_date)->format('Y/m/d')}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{\Morilog\Jalali\Jalalian::forge($item->end_date)->format('Y/m/d')}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{$item->term->name}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<table class="table table-bordered table-sm"  style=" border-collapse: collapse;" >
    <tr>
        <td colspan="7" style="border: none; font-size: 12pt" class="border-bottom"><b>داوری مجلات و نظارت بر طرح های پژوهشی</b></td>
    </tr>

    <tr >
        <td style="text-align: center; vertical-align: middle">ردیف</td>
        <td style=" vertical-align: middle">عنوان اثر داوری شده</td>
        <td style=" vertical-align: middle">نوع اثر داوری شده</td>
        <td style=" vertical-align: middle">نام مجله</td>
        <td style=" vertical-align: middle">ISSN</td>
        <td style=" vertical-align: middle">تاریخ داوری</td>
        <td style=" vertical-align: middle">ترم</td>
    </tr>
    <tbody>
    @php
        $counter = 1;
        @endphp
    @foreach($referes as $item)
        <tr>
            <td class="persian-num" style="text-align: center; vertical-align: middle">{{$counter++}}  </td>
            <td style=" vertical-align: middle">{{$item->title}}  </td>
            <td style=" vertical-align: middle">{{$item->refereeType->name}}</td>
            <td style=" vertical-align: middle">{{is_null($item->journal_name) ? '-' : $item->journal_name}}</td>
            <td style=" vertical-align: middle">{{is_null($item->journal_issn) ? '-' : $item->journal_name}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{\Morilog\Jalali\Jalalian::forge($item->referee_date)->format('Y/m/d')}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{$item->term->name}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<table class="table table-bordered table-sm"  style=" border-collapse: collapse;" >
    <tr>
        <td colspan="6" style="border: none; font-size: 12pt" class="border-bottom"><b>کرسی های نظریه پردازی</b></td>
    </tr>

    <tr >
        <td style="text-align: center; vertical-align: middle">ردیف</td>
        <td style=" vertical-align: middle">عنوان کرسی نظریه پزداری</td>
        <td style=" vertical-align: middle">نوع کرسی</td>
        <td style=" vertical-align: middle">محل برگزاری</td>
        <td style=" vertical-align: middle">تاریخ ارائه</td>
        <td style=" vertical-align: middle">ترم</td>
    </tr>
    <tbody>
    @php
        $counter = 1;
        @endphp
    @foreach($teds as $item)
        <tr>
            <td class="persian-num" style="text-align: center; vertical-align: middle">{{$counter++}}  </td>
            <td style=" vertical-align: middle">{{$item->title}}  </td>
            <td style=" vertical-align: middle">{{$item->TEDType->name}}</td>
            <td style=" vertical-align: middle">{{$item->location}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{\Morilog\Jalali\Jalalian::forge($item->presentation_date)->format('Y/m/d')}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{$item->term->name}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<table class="table table-bordered table-sm"  style=" border-collapse: collapse;" >
    <tr>
        <td colspan="5" style="border: none; font-size: 12pt" class="border-bottom"><b>پایان نامه ها</b></td>
    </tr>

    <tr >
        <td style="text-align: center; vertical-align: middle">ردیف</td>
        <td style=" vertical-align: middle">عنوان پایان نامه</td>
        <td style=" vertical-align: middle">نوع پایان نامه</td>
        <td style=" vertical-align: middle">تاریخ تصویب شورای</td>
        <td style=" vertical-align: middle">تاریخ دفاع</td>
        <td style=" vertical-align: middle">ترم</td>
    </tr>
    <tbody>
    @php
        $counter = 1;
        @endphp
    @foreach($theses as $item)
        <tr>
            <td class="persian-num" style="text-align: center; vertical-align: middle">{{$counter++}}  </td>
            <td style=" vertical-align: middle">{{$item->title}}  </td>
            <td style=" vertical-align: middle">{{$item->thesisType->name}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{is_null($item->council_aprovedate)? '-':\Morilog\Jalali\Jalalian::forge($item->council_aprovedate)->format('Y/m/d')}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{is_null($item->defense_date)? '-':\Morilog\Jalali\Jalalian::forge($item->defense_date)->format('Y/m/d')}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{$item->term->name}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<table class="table table-bordered table-sm"  style=" border-collapse: collapse;" >
    <tr>
        <td colspan="8" style="border: none; font-size: 12pt" class="border-bottom"><b>جوایز و افتخارات</b></td>
    </tr>

    <tr >
        <td style="text-align: center; vertical-align: middle">ردیف</td>
        <td style=" vertical-align: middle">عنوان جشنواره، رقابت و یا مراسم</td>
        <td style=" vertical-align: middle">عنوان جایزه</td>
        <td style=" vertical-align: middle">نوع جشنواره، رقابت یا مراسم</td>
        <td style=" vertical-align: middle">رتبه کسب شده</td>
        <td style=" vertical-align: middle">دوره برگزاری</td>
        <td style=" vertical-align: middle">تاریخ برگزاری</td>
        <td style=" vertical-align: middle">ترم</td>
    </tr>
    <tbody>
    @php
        $counter = 1;
        @endphp
    @foreach($rewards as $item)
        <tr>
            <td class="persian-num" style="text-align: center; vertical-align: middle">{{$counter++}}  </td>
            <td style=" vertical-align: middle">{{$item->title}}  </td>
            <td style=" vertical-align: middle">{{$item->name}}</td>
            <td style=" vertical-align: middle">{{$item->type}}</td>
            <td style=" vertical-align: middle">
                @if($item->place==1)
                    اول
                @elseif($item->place==2)
                    دوم
                @else
                    سوم
                @endif
            </td>
            <td class="persian-num" style=" vertical-align: middle">{{$item->period}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{\Morilog\Jalali\Jalalian::forge($item->holding_date)->format('Y/m/d')}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{$item->term->name}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<table class="table table-bordered table-sm"  style=" border-collapse: collapse;" >
    <tr>
        <td colspan="6" style="border: none; font-size: 12pt" class="border-bottom"><b>بودجه های تحقیقاتی جذب شده</b></td>
    </tr>

    <tr >
        <td style="text-align: center; vertical-align: middle">ردیف</td>
        <td style=" vertical-align: middle">عنوان بودجه جذب شده</td>
        <td style=" vertical-align: middle">میزان بودجه(دلار یا ریال)</td>
        <td style=" vertical-align: middle">نوع بودجه</td>
        <td style=" vertical-align: middle">تاریخ جذب</td>
        <td style=" vertical-align: middle">ترم</td>
    </tr>
    <tbody>
    @php
        $counter = 1;
        @endphp
    @foreach($grants as $item)
        <tr>
            <td class="persian-num" style="text-align: center; vertical-align: middle">{{$counter++}}  </td>
            <td style=" vertical-align: middle">{{$item->title}}  </td>
            <td class="persian-num"  style=" vertical-align: middle">{{$item->budget}}
                @if($item->type==0)
                    ریال
                @else
                    دلار
                @endif</td>
            <td style=" vertical-align: middle">
                @if($item->type==0)
                    داخلی
                @else
                    خارجی
                @endif
            </td>
            <td class="persian-num"  style=" vertical-align: middle">{{\Carbon\Carbon::parse($item->submit_date)->format('Y-m-d')}}</td>
            <td class="persian-num"  style=" vertical-align: middle">{{arabic_w2e($item->term->name)}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<table class="table table-bordered table-sm"  style=" border-collapse: collapse;" >
    <tr>
        <td colspan="7" style="border: none; font-size: 12pt" class="border-bottom"><b>دوره ها</b></td>
    </tr>

    <tr >
        <td style="text-align: center; vertical-align: middle">ردیف</td>
        <td style=" vertical-align: middle">عنوان دوره</td>
        <td style=" vertical-align: middle">نقش در دروه</td>
        <td style=" vertical-align: middle">سازمان برگزار کننده</td>
        <td style=" vertical-align: middle">مدت دوره</td>
        <td style=" vertical-align: middle">تاریخ برگزاری</td>
        <td style=" vertical-align: middle">ترم</td>
    </tr>
    <tbody>
    @php
        $counter = 1;
        @endphp
    @foreach($courses as $item)
        <tr>
            <td class="persian-num" style="text-align: center; vertical-align: middle">{{$counter++}}  </td>
            <td style=" vertical-align: middle">{{$item->title}}  </td>
            <td style=" vertical-align: middle">{{$item->role}}</td>
            <td style=" vertical-align: middle">{{$item->organization}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{$item->duration}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{\Morilog\Jalali\Jalalian::forge($item->holding_date)->format('Y/m/d')}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{$item->term->name}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<table class="table table-bordered table-sm"  style=" border-collapse: collapse;" >
    <tr>
        <td colspan="7" style="border: none; font-size: 12pt" class="border-bottom"><b>جزوات و اسلایدها</b></td>
    </tr>

    <tr >
        <td style="text-align: center; vertical-align: middle">ردیف</td>
        <th>عنوان جزوه یا اسلاید</th>
        <th>نام درس</th>
        <th>نوع جزوه یا اسلاید</th>
        <th>مقطع</th>
        <th>تاریخ تالیف</th>
        <td style=" vertical-align: middle">ترم</td>
    </tr>
    <tbody>
    @php
        $counter = 1;
        @endphp
    @foreach($booklets as $item)
        <tr>
            <td class="persian-num" style="text-align: center; vertical-align: middle">{{$counter++}}  </td>
            <td style=" vertical-align: middle">{{$item->title}}  </td>
            <td style=" vertical-align: middle">{{$item->name}}</td>
            <td style=" vertical-align: middle">{{$item->booklet_type}}</td>
            <td style=" vertical-align: middle">{{$item->degree->name}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{\Morilog\Jalali\Jalalian::forge($item->compilation_date)->format('Y/m/d')}}</td>
            <td class="persian-num" style=" vertical-align: middle">{{$item->term->name}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<br>
<br>
<br>
<br>
<p style="text-align: center">
    نام و نام خانوادگی:<br>
    تاریخ:<br>
    امضاء
</p>
</body>
</html>

