<template>
    <div>

        <div class="container-fluid">
            <div class="col-md-12 mt-3" v-if="$gate.isAdminOrAuthor()">
                <div class="card card-4">
                    <div class="card-header  " style="direction: rtl">
                        <div class="row justify-content-between  text-right">
                            <div class="col-xl-4 m-3">
                                <h4 class=" text-right"><i class="fal fa-file-chart-line fa-fw"></i>گزارش پروپوزال های پژوهشی</h4>
                            </div>
                        </div><!-- /card-tools -->

                    </div><!-- /.card-header -->
                    <div class="card-body  p-4">

                        <div class="row justify-content-start  mt-3">


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
                            <div  class="col-lg-4  mt-3" >
                                <div class="form-group mb-3 text-right">
                                    <label class="blue text-right  text-rtl">نوع طرح پروپوزال :</label>
                                    <!-- @change="searchit" -->
                                    <Select2  class="form-control select2-form-control non-modal-select2" id="proposal_type_id"
                                              v-model="proposal_type_id"
                                              :options="proposal_types"
                                              :settings="{theme: 'bootstrap4', placeholder: 'انتخاب نوع طرح پژوهشی', width: '100%' ,multiple: true}">
                                    </Select2>

                                </div>
                            </div>
                            <div  class="col-lg-4  mt-3" >
                                <div class="form-group mb-3 text-right">
                                    <label class="blue text-right  text-rtl">نوع کاربرد پروپوزال :</label>
                                    <!-- @change="searchit" -->
                                    <Select2  class="form-control select2-form-control non-modal-select2" id="proposal_usage_id"
                                              v-model="proposal_usage_id"
                                              :options="proposal_usages"
                                              :settings="{theme: 'bootstrap4', placeholder: 'انتخاب نوع کاربرد پروپوزال', width: '100%' ,multiple: true}">
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

                            <div class="col-lg-4 mt-3 ">
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
                            <download-excel
                                class   = "btn btn-secondary mr-3 mt-2 btn-lg"
                                :fetch="getExcel"
                                :meta="json_meta"
                                :exportFields="proposal_fields"

                                worksheet = "My Worksheet"
                                name    = "Proposals.xls">
                                <i  class="fal fa-file-excel text-white ml-3"></i>دریافت فایل
                            </download-excel>

                            <button @click="resetForm()"  type="button" class="btn btn-warning mr-3 mt-2 btn-lg"><i  class="fal fa-retweet text-white ml-3"></i>بازنشانی فرم گزارش</button>

                        </div>

                        <div v-if="showReport" class="card-body table-responsive p-0 table-sm my-5">

                            <table class="table  table-striped table-hover text-right">
                                <thead class="thead-dark">
                                <tr>
                                    <th>شماره</th>
                                    <th>عنوان فارسی</th>
                                    <th>نام نویسندگان</th>
                                    <th>نام ثبت کننده</th>
                                    <th>نام دانشکده</th>
                                    <th>نام گروه</th>
                                    <th>نوع پروپوزال پژوهشی</th>
                                    <th>نوع کاربرد پروپوزال</th>
                                    <th>ارزش تخمینی(ریال)</th>
                                    <th>بودجه طرح پژوهشی(ریال)</th>
                                    <th>محل اجرا</th>
                                    <th>مدت زمان اجرا</th>

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

                                <tr v-if="proposals.length <= 0">
                                    <td colspan="15"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                                </tr>
                                <tr v-for="(proposal, index) in proposals" :key="proposal.id">
                                    <td  class="persian-num">{{counter(index)}}</td>
                                    <td>{{ proposal.title | truncate(40) }}</td>
                                    <td>{{ proposal.Authors }}</td>
                                    <td>{{ proposal.Author_name }}</td>
                                    <td>{{ proposal.faculty }}</td>
                                    <td>{{ proposal.department }}</td>
                                    <td>{{ proposal.proposal_type }}</td>
                                    <td>{{ proposal.proposal_usage }}</td>
                                    <td  class="persian-num">{{ proposal.value | currency }}</td>
                                    <td  class="persian-num">{{ proposal.budget | currency }}</td>
                                    <td >{{proposal.project_location}} </td>
                                    <td >{{proposal.duration}} </td>

                                    <td v-if="proposal.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                    <td v-else-if="proposal.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                    <td v-else-if="proposal.status == '5'"  class="green"><i class="fal fa-search"></i>  {{'تحت داوری' }}</td>
                                    <td v-else-if="proposal.status == '6'"  class="green"><i class="fal fa-search"></i>  {{'تایید و ارسال برای داوری' }}</td>
                                    <td v-else-if="proposal.status == '7'"  class="green"><i class="fal fa-search"></i>  {{'تایید شده با اصلاحات' }}</td>
                                    <td v-else-if="proposal.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                    <td v-else-if="proposal.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                    <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                    <td colspan="2">{{ proposal.created_at | myDate  }}</td>

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
        name: "ResearchProposalReport",
        data(){
            return{
                status:[],
                allData :{},
                proposals:[],
                proposal_types:[],
                proposal_usages:[],
                faculties:[],
                departments:[],

                order: -1,       // order 1 for desc and 0  for asc
                total: 0,       // total number of proposals
                numToShow: 0,   // number of proposals shown in this page
                numStart: 0,    // starting row number
                numTo: 0,       // ending number

                showReport: false,
                excelReport:0,
                start_date:'',
                end_date:'',
                proposal_type_id:[],
                proposal_usage_id:[],
                faculty_id:[],
                department_id:[],
                dateType:"0",
                perPage:5,
                loader : Vue.$loading,
                statuses:[
                    {id:0, text:'بررسی نشده'},
                    {id:4, text:'اصلاح شده'},
                    {id:1, text:'تایید شده'},
                    {id:5, text:'تحت داوری'},
                    {id:6, text:'تایید و ارسال برای داوری'},
                    {id:7, text:'تایید با اصلاحات'},
                    {id:2, text:'عدم تایید موقت'},
                    {id:3, text:'عدم تایید قطعی'},
                ],
                proposal_fields:{
                    'عنوان فارسی' : 'title',
                    'عنوان انگلیسی' : 'en_title',
                    'نام نویسندگان' : 'Authors',
                    'نام ثبت کننده' : 'Author_name',
                    'نام دانشکده' : 'faculty',
                    'نام گروه' : 'department',
                    'نوع پروپوزال پژوهشی' : 'proposal_type',
                    'نوع کاربرد پروپوزال' : 'proposal_usage',
                    'ارزش تخمینی (ریال)' :  {
                        field: 'value',
                        callback: (value) => {
                            return `${this.$options.filters.currency(value)}`;
                        }
                    },'بودجه پیشنهادی(ریال)' :  {
                        field: 'budget',
                        callback: (value) => {
                            return `${this.$options.filters.currency(value)}`;
                        }
                    },
                    'محل اجرای طرح' : 'project_location',
                    'مدت زمان اجرا' : 'duration',

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
                            }else if(value === 5){
                                return 'تحت داوری'
                            }else if(value === 6){
                                return 'تایید و ارسال برای داوری'
                            }else if(value === 7){
                                return 'تایید با اصلاحات'
                            }
                        }
                    },
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
                this.start_date='';
                this.end_date='';
                this.proposal_type_id=[];
                this.proposal_usage_id=[];
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
                const response = await axios.post('/api/researchProposalReport?order=' + sortOrder +  '&proposal_type_id=' + this.proposal_type_id +'&proposal_usage_id=' + this.proposal_usage_id +
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
                axios.post('/api/researchProposalReport?order=' + sortOrder + '&proposal_type_id=' + this.proposal_type_id +'&proposal_usage_id=' + this.proposal_usage_id +
                    '&start_date=' + this.start_date + '&end_date=' + this.end_date + '&status=' + this.status  +'&faculty_id=' + this.faculty_id
                    +'&department_id=' + this.department_id + '&page=' + page + '&perPage=' + this.perPage
                    +'&dateType=' + this.dateType)
                    .then(response => {
                        loader1.hide();
                        this.allData = response.data;
                        this.proposals = response.data.data;
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
            getResearchProposalRelation(){
                axios.get('/api/researchProposalReportRelation')
                    .then(response => {
                        this.proposal_types = response.data.proposal_types;
                        this.proposal_usages = response.data.proposal_usages;
                        this.faculties = response.data.faculties;
                        this.departments = response.data.departments;
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
            this.$parent.pageName = 'گزارش پروپوزال های پژوهشی';
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

            this.getResearchProposalRelation();
            //this.getResults();
        },
        components: {
            Select2,
        }
    }
</script>

<style scoped>

</style>


