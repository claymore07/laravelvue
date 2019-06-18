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
<div class="persian-num">
<h1>مدارک لازم جهت پرداخت تسهیلات به شرکت کنندگان به کنفرانس داخل کشور</h1>
    <ol>
        <li>تکمیل فرم درخواست هزینه ثبت نام کنفرانس (سه نسخه)</li>
        <li>تکمیل فرم تعهدنامه انتشار مقاله علمی</li>
        <li>گواهش ارائه مقاله در کنفرانس</li>
        <li>اصل مقاله ارائه شده در کنفرانس بصورت کامل</li>
        <li>بلیط رفت و برگشت و کپی آن</li>
        <li>اصل و کپی فاکتور اسکان</li>
        <li>اصل و کپی رسید پرداخت هزینه ثبت نام</li>
    </ol>
</div>
<pagebreak></pagebreak>
<div >
    <table class="m-0 p-0 table  w-100">
        <tr >
            <td class="w-15" style="text-align: right">
            </td>
            <td class="w-70 text-center  pt-5" style="vertical-align: bottom" >
                <p class="font-11" style="font-weight: bold; border:  5px double black;">  &nbsp;&nbsp;&nbsp;&nbsp;
                    فرم درخواست پاداش  درخواست هزینه ثبت نام و شرکت در کنفرانس داخلی
                    &nbsp;&nbsp;&nbsp;&nbsp; </p>
            </td>
            <td class="15" style="text-align: left">
            </td>
        </tr>
        <tr>
            <td colspan="3" class="persian-num" style="text-align: justify">
                <b>مسئول محترم دفتر امور پژوهشی دانشگاه</b>
                <br><br>
                نظر به اینکه اینجانب
                &nbsp;
                <span class="dottedUnderline">{{$paper->profile->Fname.' '.$paper->profile->Lname }}</span>
                &nbsp;

                <span class="dottedUnderline">{{$paper->profile->position->name}}</span>
                &nbsp;،
                (مرتبه علمی
                <span class="dottedUnderline">{{$paper->profile->rank->name}}</span>
                )
                &nbsp;&nbsp;
                <b>
                    تحت عنوان
                </b>&nbsp;
                <span class="dottedUnderline">{{$paper->title}}</span>
                &nbsp;&nbsp;
                <b>
                    در همایش
                </b>&nbsp;
                <span class="dottedUnderline">{{$paper->paperable->name}}</span>


                <span>به نام دانشگاه آزاد اسلامی واحد اردبیل چاپ شده است، خواهشمد است دستور فرمایید نسبت به پرداخت هزینه های مربوطه طبق اسناد پیوستی اقدام لازم مبذول فرمایند.</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="persian-num">
                &nbsp;&nbsp;شماره حساب سیبا:
                <i class="dottedUnderline">{{$paper->profile->siba}}</i>
            </td>
            <td colspan="1" class="persian-num text-left font-11">
                تاریخ و امضاء
            </td>
        </tr>


        <tr>
            <td colspan="3"  style="border-top: 3px solid #000000; text-align: justify; line-height: 150% !important;">

                <span ><b> مدیر محترم پژوهشی دانشگاه  </b></span>
                <br><br>
                براساس بند
                <i class="dottedUnderline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>
                بخشنامه شماره
                <i class="dottedUnderline persian-num">&nbsp;73/477489&nbsp;</i>
                تاریخ
                <i class="dottedUnderline persian-num">&nbsp;89/12/01&nbsp;</i>
                و بخشنامه شماره
                <i class="dottedUnderline persian-num">&nbsp;70/75736&nbsp;</i>
                تاریخ
                <i class="dottedUnderline persian-num">&nbsp;95/10/18&nbsp;</i>
                پرداخت مبلغ
                <i class="dottedUnderline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>
ریال
                &nbsp; &nbsp;
                به حروف
                <i class="dottedUnderline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    </i>
ریال به آقا/خانم
                &nbsp;
                <span class="dottedUnderline">{{$paper->profile->Fname.' '.$paper->profile->Lname }}</span>
                &nbsp;
                &nbsp;
                قابل پرداخت می باشد.
            </td>

        </tr>

        <tr>
            <td ></td>
            <td colspan="2" class="font-11 text-left">
                امور پژوهشی دانشگاه
                &nbsp;&nbsp;&nbsp;&nbsp;
                تاریخ و امضاء
            </td>

        </tr>
        <tr>
            <td colspan="3"  style="border-top: 3px solid #000000;">

                <span ><b> معاونت محترم پژوهشی دانشگاه  </b></span>
                <br><br>
                <span class="persian-num font-11">
                    مبلغ فوق در ردیف<i class="dottedUnderline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>
                    3
                    <i class="dottedUnderline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>
                    بند
                    <i class="dottedUnderline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>
                   4
                    <i class="dottedUnderline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>
                    از دستورالعمل نحوه تخصیص اعتبار بودجه پژوهشی،
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

                <span><b> معاونت محترم پژوهشی دانشگاه   </b></span>
                <br>
                <br>
                <span class="persian-num font-11">موارد فوق مورد تائید است، خواهشمند است دستور پرداخت صادر فرمایند.
                </span>
            </td>

        </tr>
        <tr>
            <td ></td>
            <td colspan="2" class="font-11 text-left">مدیر پژوهشی دانشگاه
                &nbsp;&nbsp;&nbsp;&nbsp;
                تاریخ و امضاء
            </td>

        </tr>
        <tr>
            <td colspan="3"  style="border-top: 3px solid #000000;">

                <span><b> معاونت محترم اداری ومالی دانشگاه    </b></span>
                <br>
                <br>
                <span class="persian-num font-11">با احترام خواهشمند است نسبت به پرداخت مبلغ فوق از بودجه پژوهشی دستور فرمایند.
                </span>
            </td>

        </tr>
        <tr>
            <td ></td>
            <td colspan="2" class="font-11 text-left">معاونت پژوهشی دانشگاه
                &nbsp;&nbsp;&nbsp;&nbsp;
                تاریخ و امضاء
            </td>

        </tr>
    </table>

</div>
</body>
</html>
