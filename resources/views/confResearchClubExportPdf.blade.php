<html>
<header>

    @include('layouts.pdfStyle')
    <style>
        .table th,
        .table td {
            border-top: 0 solid #dee2e6 !important;
        }
    </style>
</header>
<body>
<div >
    <table class="m-0 p-0 table  w-100">
        <tr >
            <td class="w-15" style="text-align: right">
                <img class="img-thumbnail border-0"  src="{{  '.'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'club_logo.jpg' }}" alt="" width="80" height="80">
            </td>
            <td class="w-70 text-center  pt-5" style="vertical-align: bottom" >
                <p class="font-11" style="font-weight: bold; border:  5px double black;">  &nbsp;&nbsp;&nbsp;&nbsp;
                    فرم درخواست پاداش تشویق پژوهشگران جوان برای چاپ مقاله در مجلات علمی
                    &nbsp;&nbsp;&nbsp;&nbsp; </p>
            </td>
            <td class="15" style="text-align: left">
                <img class="img-thumbnail  border-0" src="{{  '.'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'club_logo.jpg' }}" alt="" width="80" height="80">
            </td>
        </tr>
        <tr>
            <td colspan="3" class="persian-num">
                <b>
                    نام و نام خانوادگی:
                </b>&nbsp;
                <span class="dottedUnderline">{{$paper->profile->Fname.' '.$paper->profile->Lname }}</span>
                &nbsp;
                <b>
                    شماره سیبا:
                </b>&nbsp;
                <span class="dottedUnderline">{{$paper->profile->siba}}</span>
                &nbsp;
                <b>
                نوع عضویت:
                </b>

                <span class="dottedUnderline">{{$paper->profile->member->name}}</span>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="persian-num">
                <b>
                    عنوان مقاله:
                </b>&nbsp;
                {{$paper->title}}
            </td>
        </tr>
        <tr>
            <td colspan="3" class="persian-num">
                <b>
                    عنوان همایش:
                </b>&nbsp;
                <span class="dottedUnderline">{{$paper->paperable->name}}</span>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="persian-num">
                <b>
                    زبان مقاله :
                </b>&nbsp;
                    @if($paper->lang == 0)
                    <span class="dottedUnderline">فارسی</span>
                    @else
                    <span class="dottedUnderline"> لاتین</span>
                    @endif
                <br>
                <b>
                    تاریخ و محل برگزاری:&nbsp;&nbsp;
                </b>
                <span class="dottedUnderline persian-num">{{$paper->paperable->organizer}}-{{$paper->paperable->city}}-{{\Morilog\Jalali\Jalalian::forge($paper->publish_date)->format('Y/m/d')}}</span>
                <br>
                <b>
                    نوع ارائه:&nbsp;&nbsp;
                </b>
                <span class="dottedUnderline persian-num">{{$paper->paperable->presentation_type}}</span>

            </td>
        </tr>


        <tr >
            <td colspan="3"  class="persian-num " style="border-top: 3px solid #000000;">

                <span class="font-10 persian-num">
                    سقف پرداخت هزینه ها  بر اساس ماده  <i class="dottedUnderline">&nbsp;8&nbsp;</i>
                    بخشنامه شماره
                    <i class="dottedUnderline">&nbsp;881110 &nbsp;</i>
                    تاریخ
                    <i class="dottedUnderline">&nbsp;1388/6/17&nbsp;</i>
                    :حداکثر
                    <span>&nbsp;&nbsp;
                        <img src="{{  '.'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'checkbox.png' }}" alt="" width="10" height="10">
                         چهار روز ماموریت استادیار
                    </span>
                    <span>&nbsp;&nbsp;
                        <img src="{{  '.'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'checkbox.png' }}" alt="" width="10" height="10">
                         دو روز ماموریت استادیار
                    </span>

                </span>


            </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">
                <p class="font-11" style="font-weight: bold; border:  5px double black; width: 100%">  &nbsp;&nbsp;&nbsp;&nbsp;
                    کل مبلغ تخصیص یافته:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                </p>
                <br>
                <p class="font-11" style="font-weight: bold; border:  5px double black; width: 100%">  &nbsp;&nbsp;&nbsp;&nbsp;
                    سقف پرداخت حداکثر:
                    &nbsp;&nbsp;&nbsp;

                    □ چهار روز ماموریت استادیار
                    &nbsp;&nbsp;&nbsp;


                    □ دو روز ماموریت استادیار

                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                </p>
            </td>

        </tr>
        <tr>
            <td></td>
            <td class="font-11">
               رئیس باشگاه پژوهشگران جوان و نخبگان
            </td>
            <td class="font-11">
                تاریخ
            </td>
        </tr>
        <tr>
            <td colspan="3"  style="border-top: 3px solid #000000;">

                <span ><b> مدیر محترم پژوهشی دانشگاه  </b></span>
                <br>
                <span class="persian-num font-11">
                    مبلغ فوق در ردیف<i class="dottedUnderline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>

                    <i class="dottedUnderline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>
                    بند
                    <i class="dottedUnderline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>

                    <i class="dottedUnderline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>
                    از دستورالعمل نحوه تخصیص اعتبار بودجه پژوهشی، سال
                    <i class="dottedUnderline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>
                    ثبت و اقدام گردید.

                </span>
            </td>

        </tr>
        <tr>
            <td ></td>
            <td colspan="2" class="font-11 text-left">
                طرح و برنامه و بودجه دانشگاه
                &nbsp;&nbsp;&nbsp;&nbsp;
                تاریخ و امضاء
            </td>

        </tr>
        <tr>
            <td colspan="3"  style="border-top: 3px solid #000000;">

                <span><b> معاون محترم پژوهشی دانشگاه   </b></span>
                <br>
                <span class="persian-num font-11">موارد فوق مورد تائید است، خواهشمند است دستور پرداخت صادر فرمایند.
                </span>
            </td>

        </tr>
        <tr>
            <td ></td>
            <td colspan="2" class="font-11 text-left">مدیر پژوهشی دانشگاه

            </td>

        </tr>
        <tr>
            <td colspan="3"  style="border-top: 3px solid #000000;">

                <span><b> معاون محترم اداری ومالی دانشگاه    </b></span>
                <br>
                <span class="persian-num font-11">با احترام خواهشمند است نسبت به پرداخت مبلغ فوق دستور فرمایند.
                </span>
            </td>

        </tr>
        <tr>
            <td ></td>
            <td colspan="2" class="font-11 text-left">معاون پژوهشی دانشگاه

            </td>

        </tr>
    </table>


</div>
</body>
</html>
