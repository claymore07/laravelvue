<template>
    <div>

        <div class="container-fluid">
            <div class="col-md-12 mt-3" v-if="$gate.isAdminOrUser">
                <div class="card card-4">
                    <div class="card-header  " style="direction: rtl">
                        <div class="row justify-content-between  text-right">
                            <div class="col-xl-4 m-3">
                                <h4 class=" text-right"><i class="fal fa-file-chart-line fa-fw"></i>گزارش کتب</h4>
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
                                    <label class="blue text-right  text-rtl">نوع کتاب :</label>
                                    <!-- @change="searchit" -->
                                    <select  v-model="bookType_id" class="custom-select">
                                        <option selected value="0">تمام کتاب ها</option>
                                        <option v-for="bookType in bookTypes" :value="bookType.id" :key="bookType.id">{{bookType.text}}</option>
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
                                            :fields="book_fields"

                                            worksheet = "My Worksheet"
                                            name    = "Books.xls">
                                <i  class="fal fa-file-excel text-white ml-3"></i>دریافت فایل
                            </download-excel>

                            <button @click="resetForm()"  type="button" class="btn btn-warning mr-3 mt-2 btn-lg"><i  class="fal fa-retweet text-white ml-3"></i>بازنشانی فرم گزارش</button>

                        </div>

                        <div v-if="showReport" class="card-body table-responsive p-0 table-sm my-5">

                            <table class="table  table-striped table-hover text-right">
                                <thead class="thead-dark">
                                <tr>
                                    <th>شماره</th>
                                    <th>نام کتاب</th>
                                    <th>نام نویسندگان</th>
                                    <th>نام ثبت کننده</th>
                                    <th>نام ناشر</th>
                                    <th>موضوع کتاب</th>
                                    <th>نوع کتاب</th>
                                    <th>نوع مستخرج بودن</th>
                                    <th>تاریخ چاپ</th>
                                    <th>شابک</th>
                                    <th>وضعیت ویرایش</th>
                                    <th>شماره ویرایش</th>
                                    <th>شماره چاپ</th>
                                    <th>تیراژ</th>
                                    <th>تعداد صفحات</th>
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

                                <tr v-if="books.length <= 0">
                                    <td colspan="19"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                                </tr>
                                <tr v-for="(book, index) in books" :key="book.id">
                                    <td>{{counter(index) | faDigit}}</td>
                                    <td>{{ book.title | truncate(40) }}</td>
                                    <td>{{ book.Authors }}</td>
                                    <td>{{ book.Author_name }}</td>
                                    <td >{{book.publisher_name | truncate(50)}} </td>
                                    <td>{{ book.subject }}</td>
                                    <td>{{ book.booktype_name }}</td>
                                    <td >{{book.excerpt_name}} </td>
                                    <td >{{book.publish_year | myDate}} </td>

                                    <td >{{book.isbn}} </td>
                                    <td >{{book.edited}} </td>
                                    <td >{{book.edited_number}} </td>
                                    <td >{{book.publish_number}} </td>
                                    <td >{{book.copy_number}} </td>
                                    <td >{{book.pages}} </td>
                                    <td >{{book.term_name}} </td>
                                    <td v-if="book.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                    <td v-else-if="book.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                    <td v-else-if="book.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                    <td v-else-if="book.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                    <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                    <td colspan="2">{{ book.created_at | myDate  }}</td>

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
        name: "BookReport",
        data(){
            return{
                status:5,
                allData :{},
                books:[],
                bookTypes:{},
                terms:{},

                order: 1,       // order 1 for desc and 0  for asc
                total: 0,       // total number of books
                numToShow: 0,   // number of books shown in this page
                numStart: 0,    // starting row number
                numTo: 0,       // ending number

                showReport: false,
                excelReport:0,
                term_id: 0,
                start_date:'',
                end_date:'',
                bookType_id:0,
                perPage:5,
                loader : Vue.$loading,

                book_fields:{
                    'عنوان کتاب' : 'title',
                    'نام نویسندگان' : 'Authors',
                    'نام ثبت کننده' : 'Author_name',
                    'نام ناشر' : 'publisher_name',
                    'موضوع کتاب' : 'subject',
                    'نوع کتاب' : 'booktype_name',
                    'نوع مستخرج بودن' : 'excerpt_name',
                    'تاریخ چاپ' : {
                        field: 'publish_year',
                        callback: (value) => {
                            return `${this.$options.filters.myDate(value)}`;
                        }
                    },
                    'شابک' : 'isbn',
                    'وضعیت ویرایش' : 'edited',
                    'شماره ویرایش' : 'edited_number',
                    'شماره چاپ' : 'publish_number',
                    'تیراژ' : 'copy_number',
                    'تعداد صفحات' : 'pages',
                    'کدملی' : 'national_code',
                    'شماره کنگره' : 'congress_code',
                    'شماره دویویی' : 'dewey_code',
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
                this.bookType_id=0;
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
                const response = await axios.post('/api/bookReport?order=' + sortOrder + '&term_id=' + this.term_id + '&bookType_id=' + this.bookType_id +
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
                axios.post('/api/bookReport?order=' + sortOrder + '&term_id=' + this.term_id + '&bookType_id=' + this.bookType_id  +
                    '&start_date=' + this.start_date + '&end_date=' + this.end_date + '&status=' + this.status + '&page=' + page + '&perPage=' + this.perPage)
                    .then(response => {
                        loader1.hide();
                        this.allData = response.data;
                        this.books = response.data.data;
                        this.total = response.data.meta.total;
                        this.numToShow = response.data.meta.per_page;
                        this.numStart = response.data.meta.from;
                        this.numTo = response.data.meta.to;
                        this.showReport = true;
                    }).catch(error => {
                    loader1.hide();
                });

            },

            // gets necessary data for form like excerpts and conference types and journal types
            // gets necessary data for form like excerpts and conference types and journal types
            getBookRelation(){
                axios.get('/api/bookRelation')
                    .then(response => {
                        //this.excerpts = response.data.excerpts;
                        this.bookTypes = response.data.bookTypes;
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
            this.$parent.pageName = 'گزارش کتب';
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

            this.getBookRelation();
            //this.getResults();
        }
    }
</script>

<style scoped>

</style>
