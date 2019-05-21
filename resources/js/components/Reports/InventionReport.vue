<template>
    <div>

        <div class="container-fluid">
            <div class="col-md-12 mt-3" v-if="$gate.isAdminOrUser">
                <div class="card card-4">
                    <div class="card-header  " style="direction: rtl">
                        <div class="row justify-content-between  text-right">
                            <div class="col-xl-4 m-3">
                                <h4 class=" text-right"><i class="fal fa-file-chart-line fa-fw"></i>گزارش اختراعات</h4>
                            </div>
                        </div><!-- /card-tools -->

                    </div><!-- /.card-header -->
                    <div class="card-body  p-4">

                        <div class="row justify-content-start no-gutters mt-3">

                            <div class="col-lg-3  mt-3 mr-2" >
                                <div class="form-group mb-3 text-right">
                                    <label class="blue text-right  text-rtl">ترم :</label>
                                    <!-- @change="searchit" -->
                                    <select  v-model="term_id" class="custom-select">
                                        <option selected value="0">تمام ترم ها</option>
                                        <option v-for="term in terms" :value="term.id" :key="term.id">{{term.text}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3  mt-3 mr-2" >
                                <div class="form-group mb-3 text-right">
                                    <label class="blue text-right  text-rtl">وضعیت بررسی :</label>
                                    <!-- @change="searchit" -->
                                    <select  v-model="status" class="custom-select">
                                        <option value="5">همه</option>
                                        <option value="0">بررسی نشده</option>
                                        <option value="4">اصلاح شده</option>
                                        <option value="1">تایید شده</option>
                                        <option value="2">عدم تایید موقت</option>
                                        <option value="3">عدم تایید قطعی</option>
                                    </select>
                                </div>
                            </div>
                            <div  class="col-lg-3  mt-3 mr-2" >
                                <div class="form-group mb-3 text-right">
                                    <label class="blue text-right  text-rtl">نوع اختراع :</label>
                                    <!-- @change="searchit" -->
                                    <select  v-model="inventionType_id" class="custom-select">
                                        <option selected value="0">تمام اختراعات</option>
                                        <option v-for="invention_type in invention_types" :value="invention_type.id" :key="invention_type.id">{{invention_type.text}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 mt-3  mr-2">
                                <div  style="direction: ltr; text-align: right" >
                                    <label class="blue text-right  text-rtl">از تاریخ :</label>

                                    <span class="float-left font-16 "> {{start_date | myDate}}</span>
                                    <date-picker format="YYYY-MM-DD" v-model="start_date" name="start_date" locale="fa,en"></date-picker>
                                </div>
                            </div>
                            <div class="col-lg-3 mt-3  mr-2">
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
                                :fields="inventions_fields"

                                worksheet = "My Worksheet"
                                name    = "Inventions.xls">
                                <i  class="fal fa-file-excel text-white ml-3"></i>دریافت فایل
                            </download-excel>

                            <button @click="resetForm()"  type="button" class="btn btn-warning mr-3 mt-2 btn-lg"><i  class="fal fa-retweet text-white ml-3"></i>بازنشانی فرم گزارش</button>

                        </div>

                        <div v-if="showReport" class="card-body table-responsive p-0 table-sm my-5">

                            <table class="table  table-striped table-hover text-right">
                                <thead class="thead-dark">
                                <tr>
                                    <th>شماره</th>
                                    <th>عنوان اختراع</th>
                                    <th>نام ثبت کننده</th>
                                    <th>نوع اختراع</th>
                                    <th>سمت در تیم</th>
                                    <th>مرحع تایید کننده</th>
                                    <th>پتنت بفروش رسیده یا لایسنس شده</th>
                                    <th>affiliation پتنت</th>
                                    <th>شماره پتنت</th>

                                    <th>نام شرکت ثبت شده</th>
                                    <th>نوع شرکت ثبت شده</th>
                                    <th>آدرس شرکت</th>
                                    <th>تاریخ ثبت یا صدور تاییدیه</th>
                                    <th>ترم</th>
                                    <th>وضعیت بررسی</th>
                                    <th @click="toggle()" :class="['sort-control', sortType]">تاریخ ثبت</th>
                                    <th><select v-model="perPage" @change="getResults()">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select></th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr v-if="inventions.length <= 0">
                                    <td colspan="17"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                                </tr>
                                <tr v-for="(invention, index) in inventions" :key="invention.id">
                                    <td>{{counter(index) | faDigit}}</td>
                                    <td>{{ invention.title | truncate(40) }}</td>
                                    <td>{{ invention.Author_name }}</td>
                                    <td>{{ invention.inventiontype_name }}</td>
                                    <td >{{invention.post}} </td>
                                    <td>{{ invention.authorities }}</td>
                                    <td>{{ invention.license }}</td>
                                    <td >{{invention.affiliation}} </td>
                                    <td >{{invention.license_number }} </td>
                                    <td >{{invention.company_name }} </td>
                                    <td >{{invention.company_type }} </td>
                                    <td >{{invention.company_address }} </td>
                                    <td >{{invention.submit_date | myDate}} </td>

                                    <td >{{invention.term_name}} </td>
                                    <td v-if="invention.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                    <td v-else-if="invention.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                    <td v-else-if="invention.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                    <td v-else-if="invention.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                    <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                    <td colspan="2">{{ invention.created_at | myDate  }}</td>

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
                        <span class="table-detail">
                        تعداد
                        {{(this.numTo - this.numStart + 1) | faDigit  }}
                        از
 {{this.total | faDigit}}                   </span>
                    </div><!-- /card-footer --->
                </div>
            </div><!-- /col-md-12 --->
        </div>
    </div>
</template>

<script>
    export default {
        name: "InventionReport",
        data(){
            return{
                status:5,
                allData :{},
                inventions:[],
                invention_types:{},
                terms:{},

                order: 1,       // order 1 for desc and 0  for asc
                total: 0,       // total number of inventions
                numToShow: 0,   // number of inventions shown in this page
                numStart: 0,    // starting row number
                numTo: 0,       // ending number

                showReport: false,
                excelReport:0,
                term_id: 0,
                start_date:'',
                end_date:'',
                inventionType_id:0,
                perPage:5,
                loader : Vue.$loading,

                inventions_fields:{
                    'عنوان اختراع' : 'title',
                    'نام ثبت کننده' : 'Author_name',
                    'نوع اختراع' : 'inventiontype_name',
                    'سمت در تیم' : 'post',
                    'مرحع تایید کننده' : 'authorities',
                    'پتنت بفروش رسیده یا لایسنس شده' : 'license',
                    'affiliation پتنت' : 'affiliation',
                    'شماره پتنت' : 'license_number',

                    'نام شرکت ثبت شده' : 'company_name',
                    'نوع شرکت ثبت شده' : 'company_type',
                    'آدرس شرکت' : 'company_address',
                    'تاریخ ثبت یا صدور تاییدیه' : {
                        field: 'submit_date',
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
                this.term_id= 0;
                this.start_date='';
                this.end_date='';
                this.inventionType_id=0;
                this.status=5;
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
                const response = await axios.post('/api/inventionReport?order=' + sortOrder + '&term_id=' + this.term_id + '&inventionType_id=' + this.inventionType_id +
                    '&start_date=' + this.start_date+ '&end_date=' + this.end_date +'&status='+this.status +'&excelReport=' + this.excelReport);
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
                axios.post('/api/inventionReport?order=' + sortOrder + '&term_id=' + this.term_id + '&inventionType_id=' + this.inventionType_id  +
                    '&start_date=' + this.start_date + '&end_date=' + this.end_date + '&status=' + this.status + '&page=' + page + '&perPage=' + this.perPage)
                    .then(response => {
                        loader1.hide();
                        this.allData = response.data;
                        this.inventions = response.data.data;
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
            getInventionRelation(){
                axios.get('/api/inventionRelation')
                    .then(response => {
                        this.invention_types = response.data.invention_types;
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
            this.$parent.pageName = 'گزارش اختراعات';
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

            this.getInventionRelation();
            //this.getResults();
        }
    }
</script>

<style scoped>

</style>
