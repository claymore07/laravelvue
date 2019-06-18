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
                    عنوان مجله:
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
                    نوع مجله:&nbsp;&nbsp;
                </b>
                <span class="dottedUnderline">{{$paper->paperable->jtype->name}}</span>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="persian-num text-center text-ltr">
                <b>
                    ISSN :
                </b>
                <span class="dottedUnderline">{{$paper->paperable->issn}}</span>


                <b>
                    Impact Factor:&nbsp;&nbsp;
                </b>
                <span class="dottedUnderline">{{$paper->paperable->IFactor}}</span>
                <b>
                    JCR:&nbsp;&nbsp;
                </b>
                <span class="dottedUnderline">{{$paper->paperable->JCR}}</span>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="persian-num ">
                <b>
                    تعداد نویسندگان :
                </b>&nbsp;&nbsp;
                <u><b>{{$paper->author_count}}</b></u>
                &nbsp;&nbsp;
                <b>
                    جایگاه درخواست کننده:&nbsp;&nbsp;
                </b>&nbsp;
                @if($paper->isresponsible == 1)
                   <span class="dottedUnderline">نویسنده مسئول </span>
                @else
                    <span class="dottedUnderline">سایر نویسندگان</span>
                @endif
                &nbsp;&nbsp;

                        نفر&nbsp;&nbsp;<u><b>{{$paper->author_place}}</b></u>&nbsp;&nbsp; در لیست نویسندگان می باشد. &nbsp;&nbsp;


            </td>
        </tr>
        <tr >
            <td colspan="3"  class="persian-num " style="border-top: 3px solid #000000;">

                <span class="font-12 persian-num">
                    میزان پاداش برای غیر اعضا بر اساس ماده <i class="dottedUnderline">&nbsp;7&nbsp;</i>
                    بخشنامه شماره
                    <i class="dottedUnderline">&nbsp;87/352626&nbsp;</i>
                    تاریخ
                    <i class="dottedUnderline">&nbsp;92/10/22&nbsp;</i>
                    :
                    <i class="dottedUnderline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>
                    ریال

                </span>
                <br>
                <br>
                <span class="font-10">
                ضریب افزایشی براساس رتبه مجله ماده
                    <i class="dottedUnderline">&nbsp;10&nbsp;</i>
                بخشنامه شماره
                <i class="dottedUnderline text-ltr">&nbsp;87/352626&nbsp;</i>
                تاریخ
                <i class="dottedUnderline">&nbsp;92/10/22&nbsp;</i>
                :
                <span>&nbsp;&nbsp;
                    <img src="{{  '.'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'checkbox.png' }}" alt="" width="10" height="10">
                    2
                </span>
                <span>&nbsp;&nbsp;
                    <img src="{{  '.'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'checkbox.png' }}" alt="" width="10" height="10">
                    1.8
                </span>
                <span>&nbsp;&nbsp;
                    <img src="{{  '.'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'checkbox.png' }}" alt="" width="10" height="10">
                    1.5
                </span>
                <span>&nbsp;&nbsp;
                    <img src="{{  '.'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'checkbox.png' }}" alt="" width="10" height="10">
                    1.2
                </span>
                <span>&nbsp;&nbsp;
                    <img src="{{  '.'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'checkbox.png' }}" alt="" width="10" height="10">
                    ندارد
                </span>

            </span>
                <br>
                <br>
                <span class="font-10">
                ضریب افزایش پاداش به دلیل عضویت در باشگاه ماده
                    <i class="dottedUnderline">&nbsp;8&nbsp;</i>
                بخشنامه شماره
                <i class="dottedUnderline text-ltr">&nbsp;881110 &nbsp;</i>
                تاریخ
                <i class="dottedUnderline">&nbsp;88/06/17&nbsp;</i>
                :
                <span>&nbsp;&nbsp;
                    <img src="{{  '.'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'checkbox.png' }}" alt="" width="10" height="10">
                    1.2
                </span>
                <span>&nbsp;&nbsp;
                    <img src="{{  '.'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'checkbox.png' }}" alt="" width="10" height="10">
                    1.15
                </span>
                <span>&nbsp;&nbsp;
                    <img src="{{  '.'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'checkbox.png' }}" alt="" width="10" height="10">
                    1.1
                </span>

            </span>
                <br>
                <br>
                <span class="font-10">
                ضریب افزایش پاداش به دلیل استعداد درخشان ماده
                    <i class="dottedUnderline">&nbsp;8&nbsp;</i>
                بخشنامه شماره
                <i class="dottedUnderline text-ltr">&nbsp;881110 &nbsp;</i>
                تاریخ
                <i class="dottedUnderline">&nbsp;88/06/17&nbsp;</i>
                :
                <span>&nbsp;&nbsp;
                    <img src="{{  '.'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'checkbox.png' }}" alt="" width="10" height="10">
                    1.5
                </span>
                <span>&nbsp;&nbsp;
                    <img src="{{  '.'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'checkbox.png' }}" alt="" width="10" height="10">
                    1.2
                </span>
                <span>&nbsp;&nbsp;
                    <img src="{{  '.'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'checkbox.png' }}" alt="" width="10" height="10">
                    ندارد
                </span>

            </span>
                <br>

            </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">
                <p class="font-11" style="font-weight: bold; border:  5px double black; width: 100%">  &nbsp;&nbsp;&nbsp;&nbsp;
                    پاداش قابل پرداخت:
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
                    5
                    <i class="dottedUnderline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>
                    بند
                    <i class="dottedUnderline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>
                    1
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
