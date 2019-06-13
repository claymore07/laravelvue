<template>
    <div>

        <div class="container-fluid">
            <div class="col-md-12 mt-3" v-if="$gate.isAdminOrAuthor()">
                <div class="card card-4">
                    <div class="card-header  " style="direction: rtl">
                        <div class="row justify-content-between  text-right">
                            <div class="col-xl-4 m-3">
                                <h4 class=" text-right"><i class="fal fa-file-chart-line fa-fw"></i>گزارش کرسی های نظریه پردازی</h4>
                            </div>
                        </div><!-- /card-tools -->

                    </div><!-- /.card-header -->
                    <div class="card-body  p-4">

                        <div class="row justify-content-start no-gutters mt-3">

                            <div class="col-lg-4  mt-3" >
                                <div class="form-group mb-3 text-right">
                                    <label class="blue text-right  text-rtl">ترم :</label>
                                    <!-- @change="searchit" -->
                                    <Select2  class="form-control select2-form-control" id="term_id"
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
                                    <Select2  class="form-control select2-form-control" id="status"
                                              v-model="status"
                                              :options="statuses"
                                              :settings="{theme: 'bootstrap4', placeholder: 'انتخاب وضعیت بررسی', width: '100%' ,multiple: true}">
                                    </Select2>

                                </div>
                            </div>
                            <div  class="col-lg-4  mt-3" >
                                <div class="form-group mb-3 text-right">
                                    <label class="blue text-right  text-rtl">نوع کرسی :</label>
                                    <!-- @change="searchit" -->
                                    <Select2  class="form-control select2-form-control" id="ted_type_id"
                                              v-model="ted_type_id"
                                              :options="ted_types"
                                              :settings="{theme: 'bootstrap4', placeholder: 'انتخاب نوع اختراع', width: '100%' ,multiple: true}">
                                    </Select2>

                                </div>
                            </div>

                            <div  class="col-lg-4  mt-3  text-right" >
                                <label class="blue">نام دانشکده:</label>
                                <Select2  class="form-control select2-form-control" id="faculty_id"
                                          v-model="faculty_id"
                                          :options="faculties"
                                          :settings="{theme: 'bootstrap4', placeholder: 'نام دانشکده', width: '100%',multiple: true}">
                                    <!-- ,multiple: true  --->
                                </Select2>
                            </div>
                            <div  class="col-lg-4  mt-3  text-right" >
                                <label class="blue">گروه آموزشی:</label>
                                <Select2 class="form-control select2-form-control" id="department_id"
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
                                        تاریخ ارائه کرسی
                                    </p-radio>
                                </div>
                            </div>
                            <div class="col-lg-4 mt-3">
                                <div  style="direction: ltr; text-align: right" >
                                    <label class="blue text-right  text-rtl">از تاریخ :</label>

                                    <span class="float-left font-16 "> {{start_date | myDate}}</span>
                                    <date-picker format="YYYY-MM-DD" v-model="start_date" name="start_date" locale="fa,en"></date-picker>
                                </div>
                            </div>
                            <div class="col-lg-4 mt-3">
                                <div  style="direction: ltr; text-align: right" >
                                    <label class="blue text-right  text-rtl">تا تاریخ :</label>

                                    <span class="float-left font-16 "> {{end_date | myDate}}</span>
                                    <date-picker format="YYYY-MM-DD" name="end_date" locale="fa,en" v-model="end_date"></date-picker>

                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center  mt-2">

                            <button @click="getResults()"  type="button" class="btn btn-info mr-3 mt-2 btn-lg"><i  class="fal fa-eye text-white ml-3"></i>مشاهده گزارش</button>
                            <download-excel
                                class   = "btn btn-secondary mr-3 mt-2 btn-lg"
                                :fetch="getExcel"
                                :meta="json_meta"
                                :exportFields="ted_fields"

                                worksheet = "My Worksheet"
                                name    = "TEDs.xls">
                                <i  class="fal fa-file-excel text-white ml-3"></i>دریافت فایل
                            </download-excel>

                            <button @click="resetForm()"  type="button" class="btn btn-warning mr-3 mt-2 btn-lg"><i  class="fal fa-retweet text-white ml-3"></i>بازنشانی فرم گزارش</button>

                        </div>

                        <div v-if="showReport" class="card-body table-responsive p-0 table-sm my-5">

                            <table class="table  table-striped table-hover text-right">
                                <thead class="thead-dark">
                                <tr>
                                    <th>شماره</th>
                                    <th>عنوان کرسی نظریه پزداری</th>
                                    <th>نام ثبت کننده</th>
                                    <th>نام دانشکده</th>
                                    <th>نام گروه</th>
                                    <th>نوع کرسی</th>
                                    <th>محل برگزاری</th>
                                    <th>تاریخ تصویب شورای</th>
                                    <th>تاریخ ارائه</th>

                                    <th>ترم</th>
                                    <th>امتیاز کسب شده</th>
                                    <th>وضعیت بررسی</th>
                                    <th @click="toggle()" :class="['sort-control', sortType]">تاریخ ثبت</th>
                                    <th><select class="persian-num" v-model="perPage" @change="getResults()">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select></th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr v-if="teds.length <= 0">
                                    <td colspan="14"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                                </tr>
                                <tr v-for="(ted, index) in teds" :key="ted.id">
                                    <td class="persian-num">{{counter(index)}}</td>
                                    <td>{{ ted.title | truncate(40) }}</td>
                                    <td>{{ ted.Author_name }}</td>
                                    <td>{{ ted.faculty }}</td>
                                    <td>{{ ted.department }}</td>
                                    <td>{{ ted.ted_type_name }}</td>
                                    <td>{{ ted.location  }}</td>
                                    <td>{{ ted.council_aprovedate  | myDate  }}</td>
                                    <td>{{ ted.presentation_date  | myDate  }}</td>

                                    <td  class="persian-num">{{ted.term_name}} </td>
                                    <td  class="persian-num">{{ted.score}} </td>
                                    <td v-if="ted.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                    <td v-else-if="ted.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                    <td v-else-if="ted.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                    <td v-else-if="ted.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                    <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                    <td colspan="2">{{ ted.created_at | myDate  }}</td>

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
                        {{(this.numTo - this.numStart + 1)  }}
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
        name: "TEDReport",
        data(){
            return{
                status:[],
                allData :{},
                teds:[],
                ted_types:[],
                faculties:[],
                departments:[],
                terms:[],

                order: 1,       // order 1 for desc and 0  for asc
                total: 0,       // total number of teds
                numToShow: 0,   // number of teds shown in this page
                numStart: 0,    // starting row number
                numTo: 0,       // ending number

                showReport: false,
                excelReport:0,
                term_id: [],
                start_date:'',
                end_date:'',
                ted_type_id:[],
                faculty_id:[],
                department_id:[],
                dateType:"0",
                perPage:5,
                loader : Vue.$loading,
                statuses:[
                    {id:0, text:'بررسی نشده'},
                    {id:4, text:'اصلاح شده'},
                    {id:1, text:'تایید شده'},
                    {id:2, text:'عدم تایید موقت'},
                    {id:3, text:'عدم تایید قطعی'},
                ],
                ted_fields:{
                    'عنوان کرسی نظریه پزداری' : 'title',
                    'نام ثبت کننده' : 'Author_name',
                    'نام دانشکده' : 'faculty',
                    'نام گروه' : 'department',
                    'نوع کرسی' : 'ted_type_name',
                    'محل برگزاری' : 'location',

                    'تاریخ تصویب شورای' : {
                        field: 'council_aprovedate',
                        callback: (value) => {
                            return `${this.$options.filters.myDate(value)}`;
                        }
                    },
                    'تاریخ ارائه' : {
                        field: 'presentation_date',
                        callback: (value) => {
                            return `${this.$options.filters.myDate(value)}`;
                        }
                    },
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
                this.ted_type_id=[];
                this.faculty_id=[];
                this.department_id=[];
                this.status=[];
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
                const response = await axios.post('/api/tedReport?order=' + sortOrder + '&term_id=' + this.term_id + '&ted_type_id=' + this.ted_type_id +
                    '&start_date=' + this.start_date+ '&end_date=' + this.end_date +'&status='+this.status  +'&faculty_id=' + this.faculty_id
                    +'&department_id=' + this.department_id +'&excelReport=' + this.excelReport
                    +'&dateType=' + this.dateType);
                this.excelReport = 0;
                return response.data.data;

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
                axios.post('/api/tedReport?order=' + sortOrder + '&term_id=' + this.term_id + '&ted_type_id=' + this.ted_type_id +
                    '&start_date=' + this.start_date + '&end_date=' + this.end_date + '&status=' + this.status  +'&faculty_id=' + this.faculty_id
                    +'&department_id=' + this.department_id + '&page=' + page + '&perPage=' + this.perPage
                    +'&dateType=' + this.dateType)
                    .then(response => {
                        loader1.hide();
                        this.allData = response.data;
                        this.teds = response.data.data;
                        this.total = response.data.meta.total;
                        this.numToShow = response.data.meta.per_page;
                        this.numStart = response.data.meta.from;
                        this.numTo = response.data.meta.to;
                        this.showReport = true;
                    }).catch(error => {
                    loader1.hide();
                });

            },
            // gets necessary data for form like
            getTEDRelation(){
                axios.get('/api/tedChairReportRelation')
                    .then(response => {
                        this.ted_types = response.data.ted_types;
                        this.faculties = response.data.faculties;
                        this.departments = response.data.departments;
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
            this.$parent.pageName = 'گزارش کرسی های نظریه پردازی';
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

            this.getTEDRelation();
            //this.getResults();
        },
        components: {
            Select2,
        }
    }
</script>

<style scoped>

</style>
