<template>
    <div>

        <div class="container-fluid">
            <div class="col-md-12 mt-3" v-if="$gate.isAdminOrAuthor()">
                <div class="card card-4">
                    <div class="card-header  " style="direction: rtl">
                        <div class="row justify-content-between  text-right">
                            <div class="col-xl-4 m-3">
                                <h4 class=" text-right"><i class="fal fa-file-chart-line fa-fw"></i>گزارش مقالات</h4>
                            </div>
                        </div><!-- /card-tools -->

                    </div><!-- /.card-header -->
                    <div class="card-body  p-4">
                        <div class="row  ">

                            <button  @click="changePaperType(0)" type="button" class="btn btn-lg btn-success mr-3 mt-2"><i v-if="paperType === 0" class="fal fa-check text-white ml-3"></i>گزارش مقالات ژورنالی</button>
                            <button  @click="changePaperType(1)" type="button" class="btn btn-lg btn-success mr-3 mt-2"><i v-if="paperType === 1" class="fal fa-check text-white ml-3"></i>گزارش مقالات کنفرانسی</button>

                        </div>
                        <div class="row  justify-content-start  mt-3">

                            <div class="col-lg-4  mt-3" >
                                <div class="form-group mb-3 text-right">
                                    <label class="blue text-right  text-rtl">ترم :</label>
                                    <!-- @change="searchit" -->
                                    <Select2  class="form-control select2-form-control non-modal-select2" id="term_id"
                                              v-model="term_id"
                                              :options="terms"

                                              :settings="{theme: 'bootstrap4', placeholder: 'انتخاب ترم', width: '100%' ,multiple: true}">
                                    </Select2>
                                </div>
                            </div>
                            <div class="col-lg-4  mt-3" >
                                <div class="form-group mb-3 text-right">
                                    <label class="blue text-right  text-rtl">وضعیت بررسی :</label>
                                    <!-- @change="searchit" -->
                                    <Select2  class="form-control select2-form-control non-modal-select2" id="status"
                                              v-model="status"
                                              :options="statuses"

                                              :settings="{theme: 'bootstrap4', placeholder: 'انتخاب وضعیت بررسی', width: '100%' ,multiple: true}">
                                    </Select2>

                                </div>
                            </div>
                            <div class="col-lg-4  mt-3" >
                                <div class="form-group mb-3 text-right">
                                    <label class="blue text-right  text-rtl">وضعیت پاداش :</label>
                                    <!-- @change="searchit" -->
                                    <Select2  class="form-control select2-form-control non-modal-select2" id="reward"
                                              v-model="reward"
                                              :options="rewards"

                                              :settings="{theme: 'bootstrap4', placeholder: 'انتخاب وضعیت بررسی', width: '100%' ,multiple: true}">
                                    </Select2>

                                </div>
                            </div>
                            <div v-if="paperType == 0" class="col-lg-4  mt-3 " >
                                <div class="form-group mb-3 text-right">
                                    <label class="blue text-right  text-rtl">نوع مجله :</label>
                                    <!-- @change="searchit" -->
                                    <Select2  class="form-control select2-form-control non-modal-select2" id="jtype_id"
                                              v-model="jtype_id"
                                              :options="jtypes"

                                              :settings="{theme: 'bootstrap4', placeholder: 'انتخاب نوع مجله', width: '100%' ,multiple: true}">
                                    </Select2>
                                </div>
                            </div>

                            <div v-if="paperType == 1" class="col-lg-4  mt-3 " >
                                <div class="form-group mb-3 text-right">
                                    <label class="blue text-right  text-rtl">نوع کنفرانس :</label>
                                    <!-- @change="searchit" -->
                                    <Select2  class="form-control select2-form-control non-modal-select2" id="conftype_id"
                                              v-model="conftype_id"
                                              :options="conftypes"

                                              :settings="{theme: 'bootstrap4', placeholder: 'انتخاب نوع کنفرانس', width: '100%' ,multiple: true}">
                                    </Select2>
                                </div>
                            </div>
                            <div  class="col-lg-4  mt-3  text-right" >
                                <label class="blue">نام دانشکده:</label>
                                <Select2  class="form-control select2-form-control non-modal-select2" id="faculty_id"
                                         v-model="faculty_id"
                                         :options="faculties"
                                         :settings="{theme: 'bootstrap4', placeholder: 'نام دانشکده', width: '100%',multiple: true}">
                                    <!-- ,multiple: true  --->
                                </Select2>
                            </div>
                            <div  class="col-lg-4  mt-3  text-right" >
                                <label class="blue">گروه آموزشی:</label>
                                <Select2 class="form-control select2-form-control non-modal-select2" id="department_id"
                                         v-model="department_id"
                                         :options="departments"
                                         :settings="{theme: 'bootstrap4', placeholder: 'گروه آموزشی', width: '100%' ,multiple: true}">
                                </Select2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 mt-3  ">
                                <div class="form-group my-3 py-3 text-right">
                                    <label class="blue text-right">گزارش براساس:<i class="red mx-1">*</i>:</label>

                                    <p-radio v-model="dateType" name="license_to" value="0" class="p-icon p-curve p-bigger p-pulse text-ltr"  color="info-o">
                                        <i slot="extra" class="icon far fa-check"></i>
                                        تاریخ ثبت
                                    </p-radio>
                                    <p-radio v-validate="'required'" v-model="dateType"
                                             name="license_to" value="1" type="radio" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                        <i slot="extra" class="icon far fa-check"></i>
                                        تاریخ چاپ
                                    </p-radio>
                                </div>
                            </div>
                            <div class="col-lg-4 mt-3  ">
                                <div  style="direction: ltr; text-align: right" >
                                    <label class="blue text-right  text-rtl">از تاریخ :</label>

                                    <span class="float-left font-16 "> {{start_date | myDate}}</span>
                                    <date-picker format="YYYY-MM-DD" v-model="start_date" name="start_date" locale="fa,en"></date-picker>
                                </div>
                            </div>
                            <div class="col-lg-4 mt-3  ">
                                <div  style="direction: ltr; text-align: right" >
                                    <label class="blue text-right  text-rtl">تا تاریخ :</label>

                                    <span class="float-left font-16 "> {{end_date | myDate}}</span>
                                    <date-picker format="YYYY-MM-DD" name="end_date" locale="fa,en" v-model="end_date"></date-picker>

                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center  mt-2">

                            <button @click="getResults()"  type="button" class="btn btn-info mr-3 mt-2 btn-lg"><i  class="fal fa-eye text-white ml-3"></i>مشاهده گزارش</button>
                            <download-excel v-if="paperType === 0"
                                class   = "btn btn-secondary mr-3 mt-2 btn-lg"
                                :fetch="getExcel"
                                :meta="json_meta"
                                :exportFields="journal_fields"

                                worksheet = "My Worksheet"
                                name    = "journals.xls">
                                <i  class="fal fa-file-excel text-white ml-3"></i>دریافت فایل
                            </download-excel>
                            <download-excel v-if="paperType === 1 "
                                class   = "btn btn-secondary mr-3 mt-2 btn-lg"
                                :fetch="getExcel"
                                :meta="json_meta"
                                :exportFields="conf_fields"

                                worksheet = "My Worksheet"
                                name    = "conference.xls">
                                <i  class="fal fa-file-excel text-white ml-3"></i>دریافت فایل
                            </download-excel>
                            <button @click="resetForm()"  type="button" class="btn btn-warning mr-3 mt-2 btn-lg"><i  class="fal fa-retweet text-white ml-3"></i>بازنشانی فرم گزارش</button>

                        </div>

                        <div v-if="showReport" class="card-body table-responsive p-0 table-sm my-5">

                            <table v-if="paperType === 0" class="table table-sm  table-striped table-hover text-right">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>شماره</th>
                                        <th>نام مقاله</th>
                                        <th>نام نویسندگان</th>
                                        <th>نام ثبت کننده</th>
                                        <th>نام دانشکده</th>
                                        <th>نام گروه</th>
                                        <th>زبان مقاله</th>
                                        <th>نوع مقاله</th>
                                        <th>عنوان ژورنال</th>
                                        <th>نام ناشر</th>
                                        <th>نوع ژورنال</th>
                                        <th>نوع مستخرج بودن</th>
                                        <th>توضیحات مجوز</th>
                                        <th>نوع موظفی</th>
                                        <th>تاریخ پذیرش</th>
                                        <th>تاریخ چاپ</th>
                                        <th>Doi</th>
                                        <th>ISSN</th>
                                        <th>IF</th>
                                        <th>ترم</th>
                                        <th>وضعیت بررسی</th>
                                        <th>وضعیت پاداش</th>
                                        <th @click="toggle()" :class="['sort-control', sortType]">تاریخ ثبت</th>
                                        <th><select  class="persian-num" v-model="perPage" @change="getResults()">
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="50">50</option>
                                        </select></th>
                                    </tr>
                                </thead>
                                <tbody>

                                <tr v-if="papers.length <= 0">
                                    <td colspan="24"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                                </tr>
                                <tr v-for="(paper, index) in papers" :key="paper.id">
                                    <td class="persian-num">{{counter(index) }}</td>
                                    <td>{{ paper.title | truncate(40) }}</td>
                                    <td>{{ paper.Authors }}</td>
                                    <td>{{ paper.Author_name }}</td>
                                    <td>{{ paper.faculty }}</td>
                                    <td>{{ paper.department }}</td>
                                    <td>{{ paper.lang }}</td>
                                    <td>{{ paper.paper_type }}</td>
                                    <td >{{paper.journal_name | truncate(50)}} </td>
                                    <td >{{paper.publisher_name | truncate(50)}} </td>
                                    <td >{{paper.jtype_name}} </td>
                                    <td >{{paper.excerpt_name}} </td>
                                    <td  class="persian-num">{{paper.license}} </td>
                                    <td >{{paper.license_to}} </td>
                                    <td >{{paper.accept_date | myDate}} </td>
                                    <td >{{paper.publish_date | myDate}} </td>

                                    <td >{{paper.doi}} </td>
                                    <td >{{paper.issn}} </td>
                                    <td >{{paper.IFactor}} </td>
                                    <td  class="persian-num">{{paper.term_name}} </td>
                                    <td v-if="paper.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                    <td v-else-if="paper.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                    <td v-else-if="paper.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                    <td v-else-if="paper.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                    <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                    <td v-if="paper.reward == '0'"  class="red"><i class="fal fa-times"></i>  خیر</td>
                                    <td v-else-if="paper.reward == '1'"  class="green"><i class="fal fa-check"></i>  بله</td>
                                    <td colspan="2">{{ paper.created_at | myDate  }}</td>

                                </tr>
                                </tbody>
                            </table>
                            <table v-if="paperType === 1" class="table table-sm  table-striped table-hover text-right">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>شماره</th>
                                        <th>نام مقاله</th>
                                        <th>نام نویسندگان</th>
                                        <th>نام ثبت کننده</th>
                                        <th>نام دانشکده</th>
                                        <th>نام گروه</th>
                                        <th>زبان مقاله</th>
                                        <th>نوع مقاله</th>
                                        <th>عنوان کنفرانس</th>
                                        <th>نام برگزارکننده</th>
                                        <th>نوع کنفرانس</th>
                                        <th>دوره برگزاری</th>
                                        <th>نوع مستخرج بودن</th>
                                        <th>توضیحات مجوز</th>
                                        <th>نوع موظفی</th>
                                        <th>تاریخ پذیرش</th>
                                        <th>تاریخ چاپ</th>
                                        <th>ترم</th>
                                        <th>وضعیت بررسی</th>
                                        <th>وضعیت پاداش</th>
                                        <th @click="toggle()" :class="['sort-control', sortType]">تاریخ ثبت</th>
                                        <th><select  class="persian-num" v-model="perPage" @change="getResults()">
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="50">50</option>
                                        </select></th>
                                    </tr>
                                </thead>
                                <tbody>

                                <tr v-if="papers.length <= 0">
                                    <td colspan="22"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                                </tr>
                                <tr v-for="(paper, index) in papers" :key="paper.id">
                                    <td  class="persian-num">{{counter(index) }}</td>
                                    <td>{{ paper.title | truncate(40) }}</td>
                                    <td>{{ paper.Authors }}</td>
                                    <td>{{ paper.Author_name }}</td>
                                    <td>{{ paper.faculty }}</td>
                                    <td>{{ paper.department }}</td>
                                    <td>{{ paper.lang }}</td>
                                    <td>{{ paper.paper_type }}</td>
                                    <td >{{paper.conf_name | truncate(50)}} </td>
                                    <td >{{paper.organizer | truncate(50)}} </td>
                                    <td >{{paper.conftype_name}} </td>
                                    <td  class="persian-num">{{paper.period}} </td>
                                    <td >{{paper.excerpt_name}} </td>
                                    <td >{{paper.license}} </td>
                                    <td >{{paper.license_to}} </td>
                                    <td >{{paper.accept_date | myDate}} </td>
                                    <td >{{paper.publish_date | myDate}} </td>

                                    <td  class="persian-num">{{paper.term_name}} </td>
                                    <td v-if="paper.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                    <td v-else-if="paper.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                    <td v-else-if="paper.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                    <td v-else-if="paper.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                    <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                    <td v-if="paper.reward == '0'"  class="red"><i class="fal fa-times"></i>  خیر</td>
                                    <td v-else-if="paper.reward == '1'"  class="green"><i class="fal fa-check"></i>  بله</td>

                                    <td colspan="2">{{ paper.created_at | myDate  }}</td>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- /.card-body -->
                    <div v-if="showReport" class="card-footer d-flex flex-row justify-content-md-center" style="min-height: 60px">
                        <pagination v-if="" :data="allData" @pagination-change-page="getResults" :limit="1"
                                    :show-disabled="true">
                            <span slot="prev-nav"><i class="fa fa-angle-double-right"></i></span>
                            <span slot="next-nav"><i class="fa fa-fw fa-angle-double-left"></i></span>
                        </pagination>
                        <span class="table-detail persian-num">
                        تعداد
                        {{(this.numTo - this.numStart + 1)   }}
                        از
 {{this.total }}                   </span>
                    </div><!-- /card-footer --->
                </div>
            </div><!-- /col-md-12 --->
            <div v-if="!$gate.isAdminOrAuthor()">
                <not-found></not-found>
            </div><!-- /404 page -->
        </div>
    </div>
</template>

<script>
    import Select2 from 'v-select2-component';
    export default {
        name: "PaperReport",
        data(){
            return{
                status:[],
                reward:[],
                allData :{},
                papers:[],
                jtypes:[],
                conftypes:[],
                faculties:[],
                departments:[],
                terms:[],

                order: -1,       // order 1 for desc and 0  for asc
                total: 0,       // total number of papers
                numToShow: 0,   // number of papers shown in this page
                numStart: 0,    // starting row number
                numTo: 0,       // ending number

                paperType:0,
                showReport: false,
                excelReport:0,
                term_id: [],
                start_date:'',
                end_date:'',
                jtype_id:[],
                conftype_id:[],
                faculty_id:[],
                department_id:[],
                dateType:"0",
                perPage:5,
                loader : Vue.$loading,
                rewards:[
                    {id:1,text:'شامل پاداش می باشد'},
                    {id:0,text:'شامل پاداش نمی باشد'},
                ],
                statuses:[
                    {id:0, text:'بررسی نشده'},
                    {id:4, text:'اصلاح شده'},
                    {id:1, text:'تایید شده'},
                    {id:2, text:'عدم تایید موقت'},
                    {id:3, text:'عدم تایید قطعی'},
                ],
                journal_fields:{
                    'عنوان مقاله' : 'title',
                    'نام نویسندگان' : 'Authors',
                    'نام ثبت کننده' : 'Author_name',
                    'نام ثبت کننده' : 'Author_name',
                    'تعداد نویسندگان' : 'author_count',
                    'جایگاه ثبت کننده' : 'author_place',
                    'نویسنده مسئول بوده' : 'isresponsible',
                    'نام دانشکده' : 'faculty',
                    'نام گروه' : 'department',
                    'زبان مقاله' : 'lang',
                    'نوع مقاله' : 'paper_type',
                    'عنوان ژونال' : 'journal_name',
                    'نام ناشر' : 'publisher_name',
                    'نوع ژورنال' : 'jtype_name',
                    'نوع مستخرج بودن' : 'excerpt_name',
                    'توضیحات مجوز' : 'license',
                    'نوع موظفی' : 'license_to',
                    'تاریخ پذیرش' : {
                        field: 'accept_date',
                        callback: (value) => {
                            return `${this.$options.filters.myDate(value)}`;
                        }
                    },
                    'تاریخ تاریخ چاپ' : {
                        field: 'publish_date',
                        callback: (value) => {
                            return `${this.$options.filters.myDate(value)}`;
                        }
                    },
                    'Doi' : 'doi',
                    'لینک مقاله' : 'link',
                    'لیست سیاه' : 'blacklistFlag',
                    'شماره مجله Issue' : 'issue',
                    'شماره مجلد Volume' : 'volume',
                    'شماره صفحه Pages' : 'pages',
                    'ضریب تاثیر IF' : 'IFactor',
                    'میانگین پنچ ساله' : 'FIF',
                    'JRK' : 'JRK',
                    'رتبه Scopus' : 'scopus',
                    'JCR' : 'JCR',
                    'ISSN' : 'issn',
                    'pISSN' : 'pissn',
                    'وضعیت بررسی' : {
                        field: 'status',
                        callback: (value) => {
                            if (value === 0){
                                return 'بررسی نشده'
                            }else if(value === 1){
                                return 'تایید شده'
                            }else if(value === 2){
                                return 'عدم تایید موقت'
                            }else if(value === 3){
                                return 'عدم تایید قطعی'
                            }else if(value === 4){
                                return 'اصلاح شده'
                            }
                        }
                    },
                    'وضعیت پاداش' : {
                        field: 'reward',
                        callback: (value) => {
                            if (value === "0"){
                                return 'خیر'
                            }else if(value === "1"){
                                return 'بله'
                            }
                        }
                    },
                    'امتیاز' : 'score',
                    'ترم' : 'term_name',
                    'تاریخ ثبت' : {
                        field: 'created_at',
                        callback: (value) => {
                            return `${this.$options.filters.myDate(value)}`;
                        }
                    },
                },
                conf_fields:{
                    'عنوان مقاله' : 'title',
                    'نام نویسندگان' : 'Authors',
                    'نام ثبت کننده' : 'Author_name',
                    'تعداد نویسندگان' : 'author_count',
                    'جایگاه ثبت کننده' : 'author_place',
                    'نویسنده مسئول بوده' : 'isresponsible',
                    'نام دانشکده' : 'faculty',
                    'نام گروه' : 'department',
                    'زبان مقاله' : 'lang',
                    'نوع مقاله' : 'paper_type',
                    'عنوان کنفرانس' : 'conf_name',
                    'نوع ارائه' : 'presentation_type',
                    'نام برگزارکننده' : 'organizer',
                    'دوره برگزاری' : 'period',
                    'نوع کنفرانس' : 'conftype_name',
                    'نوع مستخرج بودن' : 'excerpt_name',
                    'توضیحات مجوز' : 'license',
                    'نوع موظفی' : 'license_to',
                    'تاریخ پذیرش' : {
                        field: 'accept_date',
                        callback: (value) => {
                            return `${this.$options.filters.myDate(value)}`;
                        }
                    },
                    'تاریخ تاریخ چاپ' : {
                        field: 'publish_date',
                        callback: (value) => {
                            return `${this.$options.filters.myDate(value)}`;
                        }
                    },
                    'Doi' : 'doi',
                    'لینک مقاله' : 'link',
                    'شهر برگزاری' : 'city',
                    'وضعیت بررسی' : {
                        field: 'status',
                        callback: (value) => {
                            if (value === 0){
                                return 'بررسی نشده'
                            }else if(value === 1){
                                return 'تایید شده'
                            }else if(value === 2){
                                return 'عدم تایید موقت'
                            }else if(value === 3){
                                return 'عدم تایید قطعی'
                            }else if(value === 4){
                                return 'اصلاح شده'
                            }
                        }
                    },
                    'وضعیت پاداش' : {
                        field: 'reward',
                        callback: (value) => {
                            if (value === "0"){
                                return 'خیر'
                            }else if(value === "1"){
                                return 'بله'
                            }
                        }
                    },
                    'امتیاز' : 'score',
                    'ترم' : 'term_name',
                    'تاریخ ثبت' : {
                        field: 'created_at',
                        callback: (value) => {
                            return `${this.$options.filters.myDate(value)}`;
                        }
                    },
                },
                json_meta:[
                    [
                        {
                            'key': 'charset',
                            'value': 'utf-8',
                            'direction': 'rtl'
                        }
                    ]
                ],
            }
        },
        methods:{
            //  changes the paper Type and sets form.lang and form.paperType
            changePaperType(Selected) {
                this.paperType = Selected;
                this.resetForm();
            },
            searchit(){
                this.$parent.searchit();
            },
            counter(i) {
                return this.numStart + i;
            },
            toggle() {
                this.order *= -1;
                this.getResults();
            },
            resetForm(){
                this.showReport =false;
                this.excelReport=0;
                this.term_id= [];
                this.start_date='';
                this.end_date='';
                this.jtype_id=[];
                this.conftype_id=[];
                this.faculty_id=[];
                this.department_id=[];
                this.status=[];
                this.reward=[];
                this.perPage=5;
            },
           /* startDownload(){
                this.loader.show();
            },
            finishDownload(){
                this.loader.hide();
            },*/
            async  getExcel(page = 1){
                this.excelReport = 1;
                if(this.start_date !== '' || this.end_date !== '') {
                    if (!moment(this.start_date).isBefore(this.end_date)) {
                        this.errorSwal('بازه شروع تاریخ گزارش باید از تاریخ اتمام آن قبل تر باشد!');
                        return false;
                    }
                }
                let sortOrder = this.order === 1 ? 'asc' : 'desc';
                if (this.paperType == 0) {
                    const response = await axios.post('/api/journalReport?order=' + sortOrder + '&term_id=' + this.term_id + '&jtype_id=' + this.jtype_id +
                        '&start_date=' + this.start_date+ '&end_date=' + this.end_date +'&status='+this.status+'&reward='+this.reward
                        +'&faculty_id=' + this.faculty_id +'&department_id=' + this.department_id +'&excelReport=' + this.excelReport
                        +'&dateType=' + this.dateType);
                    this.excelReport = 0;
                    return response.data.data;
                } else {
                    const response = await  axios.post('/api/conferenceReport?order=' + sortOrder + '&term_id=' + this.term_id + '&conftype_id=' + this.conftype_id +
                        '&start_date=' + this.start_date+ '&end_date=' + this.end_date +'&status='+this.status+'&reward='+this.reward
                        +'&faculty_id=' + this.faculty_id +'&department_id=' + this.department_id +'&excelReport=' + this.excelReport
                        +'&dateType=' + this.dateType);
                    this.excelReport = 0;

                    return response.data.data;
                }
            },

            getResults(page = 1) {
                if(this.start_date !== '' || this.end_date !== '') {
                    if (!moment(this.start_date).isBefore(this.end_date)) {
                        this.errorSwal('بازه شروع تاریخ گزارش باید از تاریخ اتمام آن قبل تر باشد!');
                        return false;
                    }
                }
                let sortOrder = this.order === 1 ? 'asc' : 'desc';
                let loader1 = Vue.$loading.show();
                if (this.paperType == 0) {

                    axios.post('/api/journalReport?order=' + sortOrder + '&term_id=' + this.term_id + '&jtype_id=' + this.jtype_id +
                        '&start_date=' + this.start_date + '&end_date=' + this.end_date + '&status=' + this.status+'&reward='+this.reward
                        +'&faculty_id=' + this.faculty_id +'&department_id=' + this.department_id + '&page=' + page + '&perPage=' + this.perPage
                        +'&dateType=' + this.dateType)
                        .then(response => {
                            loader1.hide();
                            this.allData = response.data;
                            this.papers = response.data.data;
                            this.total = response.data.meta.total;
                            this.numToShow = response.data.meta.per_page;
                            this.numStart = response.data.meta.from;
                            this.numTo = response.data.meta.to;
                            this.showReport = true;
                        }).catch(error => {
                        loader1.hide();
                    });
                } else {
                    axios.post('/api/conferenceReport?order=' + sortOrder + '&term_id=' + this.term_id + '&conftype_id=' + this.conftype_id +
                        '&start_date=' + this.start_date + '&end_date=' + this.end_date + '&status=' + this.status +'&reward='+this.reward
                        +'&faculty_id=' + this.faculty_id +'&department_id=' + this.department_id+ '&page=' + page + '&perPage=' + this.perPage
                        +'&dateType=' + this.dateType)
                        .then(response => {
                            loader1.hide();
                            this.allData = response.data;
                            this.papers = response.data.data;
                            this.total = response.data.meta.total;
                            this.numToShow = response.data.meta.per_page;
                            this.numStart = response.data.meta.from;
                            this.numTo = response.data.meta.to;
                            this.showReport = true;
                        }).catch(error => {
                        loader1.hide();
                    });
                }
            },

            // gets necessary data for form like excerpts and conference types and journal types
            getPaperRelation(){
                axios.get('/api/paperReportRelation')
                    .then(response => {
                        this.conftypes = response.data.conftypes;
                        this.jtypes = response.data.jtypes;
                        this.faculties = response.data.faculties;
                        this.departments = response.data.departments;
                        this.jtypes = response.data.jtypes;
                        this.terms = response.data.terms;
                    })
                    .catch((e)=>{
                            //  console.log(e);
                        }
                    );
            },

        },
        computed:{
            sortType() {
                return this.order === 1 ? 'ascending' : 'descending';
            },
        },
        created() {
            this.$parent.pageName = 'گزارش مقالات';
            Fire.$on('searching', () => {
                let page = 1;
                let query = this.search;
                this.searchResult = true;
                this.getResults(page, query);
            });
            Fire.$on('AfterCreate', () => {
                this.form.reset();
                this.getResults();
            });

            this.getPaperRelation();
            //this.getResults();
        },
        components: {
            Select2,
        }
    }
</script>

<style scoped>

</style>
