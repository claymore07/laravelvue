<template>
    <div>

        <div class="container-fluid">
            <div class="col-md-12 mt-3" >
                <div class="card card-4">
                    <div class="card-header  " style="direction: rtl">
                        <div class="row justify-content-between  text-right">
                            <div class="col-xl-4 m-3">
                                <h4 class=" text-right"><i class="fal fa-gavel fa-fw"></i> آرشیو داوری‌ها</h4>
                            </div>
                            <div class="col-xl-4  " >
                                <button class="btn btn-block-only btn-success ripple mt-3 mx-xl-2 float-left" @click="newModal"><i style="font-size: 16px" class="fal fa-file-plus"></i> افزودن داوری</button>
                                <button class="btn btn-block-only btn-info ripple mt-3 mx-xl-2 float-left" @click="infoModal"><i style="font-size: 16px" class="far fa-info-circle"></i> راهنمای بخشنامه</button>
                            </div>
                        </div><!-- /card-tools -->


                    </div><!-- /.card-header -->
                    <div class="card-body table-responsive p-0">

                        <div class="row justify-content-center no-gutters">
                            <div class="col-lg-7 mt-3  mr-2">

                                <div class="input-group  ">
                                    <input class="form-control"  type="search" placeholder="جستجو..." aria-label="جستجو"
                                           v-model="search" @keyup="searchit()"><!--    -->
                                    <div class="input-group-append">
                                        <button class="btn btn-navbar"  type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3  mt-3 mr-2" >
                                <div class="input-group mb-3 ">
                                    <select v-model="filter" @change="searchit" class="custom-select">
                                        <option selected disabled>پالایش بر اساس:</option>
                                        <option value="5">همه</option>
                                        <option value="0">بررسی نشده</option>
                                        <option value="4">اصلاح شده</option>
                                        <option value="1">تایید شده</option>
                                        <option value="2">عدم تایید موقت</option>
                                        <option value="3">عدم تایید قطعی</option>
                                    </select>
                                    <div class="input-group-append " >
                                        <span class="input-group-text" style="border: none!important; background: none"  title="پالایش براساس"><i class="fal  blue fa-filter"></i> </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-hover text-right">
                            <tbody>
                            <tr>
                                <th>شماره</th>
                                <th>عنوان اثر داوری شده</th>
                                <th>نوع اثر</th>
                                <th>نام داوری</th>
                                <th>وضعیت بررسی</th>
                                <th @click="toggle()" :class="['sort-control', sortType]">تاریخ ثبت</th>
                                <th>ابزارهای ویرایشی</th>
                                <th>
                                    <select class="persian-num" v-model="perPage" @change="getResults()">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </th>
                            </tr>

                            <tr v-if="referees.length <= 0">
                                <td colspan="7"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                            </tr>
                            <tr v-for="(referee, index) in referees" :key="referee.id">
                                <td class="persian-num">{{counter(index) }}</td>
                                <td>{{ referee.title | truncate(40) }}</td>
                                <td>{{ referee.referee_type  }}</td>


                                <td>{{ referee.Author_name  }}</td>
                                <td v-if="referee.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                <td v-else-if="referee.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                <td v-else-if="referee.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                <td v-else-if="referee.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                <td>{{ referee.created_at | myDate  }}</td>
                                <td colspan="2">
                                    <router-link :to="{ name: 'refereeEdit', params: { id: referee.id }}">
                                        <i class="fa fa-edit blue"></i>
                                    </router-link>
                                    /
                                    <a href="#" @click="deleteReferee(referee.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div> <!-- /.card-body -->
                    <div class="card-footer d-flex flex-row justify-content-md-center" style="min-height: 60px">
                        <pagination v-if="" :data="allData" @pagination-change-page="getResults" :limit="1"
                                    :show-disabled="true">
                            <span slot="prev-nav"><i class="fa fa-angle-double-right"></i></span>
                            <span slot="next-nav"><i class="fa fa-fw fa-angle-double-left"></i></span>
                        </pagination>
                        <span class="table-detail persian-num">
                        تعداد
                        {{(this.numTo - this.numStart + 1) }}
                        از
 {{this.total }}                   </span>
                    </div><!-- /card-footer --->
                </div>
            </div><!-- /col-md-12 --->
            <div  class="modal  fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><i
                                class="fas fa-gavel fa-fw"></i> ثبت داوری جدید </h5>

                            <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form-wizard
                            back-button-text="مرحله قبل"
                            next-button-text="مرحله بعد"
                            finish-button-text="ثبت نهایی"
                            :start-index="0"
                            @on-complete="onComplete"
                            ref="wizard">
                            <h2 slot="title">تکمیل اطلاعات داوری</h2>
                            <!--  -->
                            <tab-content title="اطلاعات داوری"   icon="far fa-gavel">
                                <form @submit.prevent="createCourse()" @keydown="form.onKeydown($event)" @change="form.onKeydown($event)" data-vv-scope="form" id="Form">

                                    <div class="modal-body">
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">عنوان اثر داوری شده<i class="red mx-1">*</i>:</label>
                                            <input  type="text"  name="title" placeholder="عنوان اثر داوری شده"
                                                    class="form-control" v-model="form.title"
                                                    v-validate="'required'"
                                                    autofocus
                                                    :class="{ 'is-invalid': form.errors.has('title') || errors.has('form.title') } " >
                                            <i v-show="errors.has('form.title') || form.errors.has('title')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.form.title')" class="red d-inline-block">{{ errors.first('form.title') }}</span>
                                            <span v-show="form.errors.has('title')" class="red d-inline-block">{{ form.errors.get('title') }}</span>
                                        </div>
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">نوع اثر داوری شده<i class="red mx-1">*</i>:</label>
                                            <Select2 v-validate="'required'" data-vv-name="referee_types_id"
                                                     class="form-control select2-form-control" id="referee_types_id"
                                                     :class="[( errors.has('form.referee_types_id') || form.errors.has('referee_types_id') ? 'is-invalid': ''  )]"
                                                     v-model="form.referee_types_id"
                                                     :options="referee_types"
                                                     @change="removeError('referee_types_id')"
                                                     :settings="{theme: 'bootstrap4', placeholder: 'نوع اثر داوری شده', width: '100%' }">
                                            </Select2>

                                            <i v-show="errors.has('form.referee_types_id') || form.errors.has('referee_types_id')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.referee_types_id')" class="red d-inline-block">{{ errors.first('form.referee_types_id') }}</span>
                                            <span v-show="form.errors.has('referee_types_id')" class="red d-inline-block">{{ form.errors.get('referee_types_id') }}</span>
                                        </div>
                                        <div v-if="journalFields" class="form-group my-3 text-right">
                                            <label   class="blue ">نام مجله<i class="red mx-1">*</i>:</label>
                                            <input   type="text" name="journal_name"
                                                     placeholder=" نام مجله"
                                                     v-validate="'required'"
                                                     class="form-control" v-model="form.journal_name"
                                                     :class="[( errors.has('form.journal_name') || form.errors.has('journal_name') ? 'is-invalid': ''  ) ]"
                                            >
                                            <i v-show="errors.has('form.journal_name') || form.errors.has('journal_name')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.journal_name')" class="red d-inline-block">{{ errors.first('form.journal_name') }}</span>
                                            <span v-show="form.errors.has('journal_name')" class="red d-inline-block">{{ form.errors.get('journal_name') }}</span>
                                        </div>
                                        <div v-if="journalFields" class="form-group my-3 text-right">
                                            <label class="blue ">ISSN<i class="red mx-1">*</i>:</label>
                                            <input    type="text" name="journal_issn"
                                                      placeholder="1111-1111"
                                                      v-mask="'####-###X'"
                                                      v-validate="'required'"
                                                      class="form-control" v-model="form.journal_issn"
                                                      :class="[( errors.has('form.journal_issn') || form.errors.has('journal_issn') ? 'is-invalid': ''  ) ]"
                                            >
                                            <i v-show="errors.has('form.journal_issn') || form.errors.has('journal_issn')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.journal_issn')" class="red d-inline-block">{{ errors.first('form.journal_issn') }}</span>
                                            <span v-show="form.errors.has('journal_issn')" class="red d-inline-block">{{ form.errors.get('journal_issn') }}</span>
                                        </div>

                                        <div class=" my-3" style="direction: ltr; text-align: right" >
                                            <label class="blue text-right  text-rtl">تاریخ داوری<i class="red mx-1">*</i>:</label>
                                            <br> <span class="float-left font-16 "> {{form.referee_date | myDate}}</span>
                                            <date-picker @change="removeError('referee_date')" format="YYYY-MM-DD"
                                                         v-validate="'required'"
                                                         :class="[ errors.has('form.referee_date') || form.errors.has('referee_date') ? 'is-invalid': ''  ] "
                                                         name="referee_date" v-model="form.referee_date" locale="fa,en"></date-picker>
                                            <div class="text-rtl">
                                                <i v-show="errors.has('form.referee_date') || form.errors.has('referee_date')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form.referee_date')" class="red d-inline-block">{{ errors.first('form.referee_date') }}</span>
                                                <span v-show="form.errors.has('referee_date')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('referee_date') }}</span>
                                            </div>
                                        </div>

                                        <div class="form-group my-3 text-right">
                                            <label class="blue text-right">فایل های ضمیمه:<i class="red mx-1">*</i>:</label>
                                            <span class="red"><br/>
                                                اسکن گواهی داوری درصورت وجود بصورت pdf<br>
                                                اسکن گواهی نظارت در صورت وجود بصورت pdf<br>
                                                سایر فایل های مربوطه بصورت یک فایل فشرده با پسونده zip
                                            </span>
                                        </div>

                                        <div class="custom-file text-ltr text-right mb-5">
                                            <input @change="fieldChange" multiple v-validate="'required|ext:rar,zip,pdf|size:5000'" name="files" type="file" class="custom-file-input" id="customFile" >
                                            <label  class="custom-file-label"   for="customFile">انتخاب فایل های ضمیمه</label>
                                            <span class="badge badge-info my-2 mx-2" style="font-size: 14px; color: #ffffff; background-color: #17a2b8;"
                                                  v-for="item in fileName">{{item}}</span>
                                            <has-error :form="form" field="files"></has-error>
                                            <div class="text-rtl">
                                                <i v-show="errors.has('form.files')|| form.errors.has('files')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form.files') " class="red d-inline-block">{{ errors.first('form.files') }}</span>
                                                <span v-show="form.errors.has('files')" class="red d-inline-block">{{ form.errors.get('files') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </tab-content>
                        </form-wizard>
                    </div>
                </div>
            </div><!-- /modal -->
            <!-- Info Modal -->
            <div class="modal  fade" id="InfoModal" tabindex="-1" role="dialog" aria-labelledby="InfoModal" aria-hidden="true">
                <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="InfoModal2"><i
                                class="fal fa-info-circle fa-fw"></i>مشاهد آیین نامه</h5>
                            <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-right text-rtl" style="height: 600px; overflow-y: scroll" >
                            <div v-html="regulation"></div>
                        </div><!-- modal-body -->
                    </div><!-- /modal-content -->
                </div><!-- /modal-dialog -->
            </div><!-- / Info show modal  -->

        </div><!-- /container-fluid -->
    </div>
</template>

<script>
    import Select2 from 'v-select2-component';
    import farsi from 'vee-validate/dist/locale/fa';
    export default {
        name: "Referees",
        data(){
            return{
                filter:5,
                perPage:5,
                regulation:'',
                referees:{},
                referee_types:[],
                allData :{},
                search: '',     // search term
                order: -1,       // order 1 for desc and 0  for asc
                total: 0,       // total number of papers
                numToShow: 0,   // number of papers shown in this page
                numStart: 0,    // starting row number
                numTo: 0,       // ending number
                searchResult: false,
                fileName:[],    // For UI rendering and displaying the choosen file Names
                attachments:[],
                f:new FormData, // creates the new FormData object to store selected files data
                // form data of VForm data object witch will be used to fill and submit the form
                form: new Form({
                    title:'',
                    referee_types_id: '',
                    journal_name: '',
                    journal_issn: '',
                    referee_date: '',
                    files:[],
                }),
            }
        },
        methods:{
            removeError(field){
                this.form.errors.clear(field)
            },
            counter(i) {
                return this.numStart + i;
            },
            toggle() {
                this.order *= -1;
                this.getResults();
            },
            searchit(){
                this.$parent.searchit();
            },
            newModal() {
                $('#addNew').modal('show');
                $('#addNew').on('shown.bs.modal', function() {
                    $(this).find('[autofocus]').focus();
                });
            },
            infoModal() {
                $('#InfoModal').modal('show');
            },
            fieldChange(e){
                let selectedFiles=e.target.files;
                if(!selectedFiles.length){
                    return false;
                }
                this.form.files = [];
                this.fileName = [];
                for(let i=0;i<selectedFiles.length;i++){
                    this.fileName.push(selectedFiles[i].name);
                    this.form.files.push(selectedFiles[i]);
                }
            },
            refereeValidation(){
                return this.$validator.validateAll('form').then(result => {
                    if (!result) {
                        this.errorSwal('اطلاعات داوری دارای خطا می باشد!');
                        return false;
                    }
                    return true;
                });
            },
            onComplete(){
                this.$Progress.start();
                let loader1 = Vue.$loading.show();
                this.form.busy;

                this.form.submit('post', '/api/referee', {
                    // Transform form data to FormData
                    transformRequest: [function (data, headers) {
                        return objectToFormData(data)
                    }]
                }).then((response) => {
                    loader1.hide();
                    this.referees.unshift(response.data.data);
                    $('#addNew').modal('hide');
                    this.successToast('اطلاعات داوری جدید با موفقیت ثبت شد.');
                    this.$Progress.finish();
                    this.resetFormWizard();
                })
                    .catch((e) => {
                        loader1.hide();
                        let t = Object.keys(this.form.errors.all()).filter(function (key) {
                            return /^files./.test(key);
                        });

                        if (!t.length) {
                        } else {
                            this.form.errors.set('files', 'نوع فایل باید یکی از انواع pdf و rar یا zip باشد.')
                        }
                        if(e.response.status == 405){
                            let starts = this.$options.filters.myDate(window.term.starts_at);
                            let ends = this.$options.filters.myDate(window.term.ends_at);
                            this.errorSwal(`تاریخ ثبت اطلاعات در ترم جاری از بازه ${starts} تا بازه ${ends} می باشد. امکان ثبت در تاریخ کنون وجود ندارد.`);
                        }else{
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        }
                        this.$Progress.fail();
                    })

            },
            resetFormWizard() {
                this.fileName=[];
                this.attachments = [];
                this.form.reset();
                this.$refs.wizard.reset();
                this.$validator.reset();
            },
            deleteReferee(id){
                swal({
                    title: 'آیا از حذف داوری مورد نظر مطمئن هستید؟',
                    text: "این تغییر قابل بازگشت نخواهد بود",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله حذف می کنم',
                    cancelButtonText: 'لغو عملیات'
                }).then((result) => {
                    // send ajax request to server
                    if (result.value) {
                        this.form.delete(`/api/referee/${id}`).then(() => {
                            this.successSwal('داوری مورد نظر با موفقیت حذف شد.');
                            Fire.$emit('AfterCreate');
                        }).catch((e) => {
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        });
                    } else {
                        this.warningSwal('شما این عملیات را لغو کردید.');
                    }
                })
            },
            getResults(page = 1, que = '') {
                let loader1 = Vue.$loading.show();

                let sortOrder = this.order === 1 ? 'asc' : 'desc';
                if (this.searchResult) {
                    que = this.search;
                    axios.get('/api/findReferee?order=' + sortOrder + '&q=' + que +'&filter='+this.filter
                        +'&page=' + page +'&perPage=' + this.perPage)
                        .then(response => {
                            loader1.hide();
                            this.allData = response.data;
                            this.referees = response.data.data;
                            this.total = response.data.meta.total;
                            this.numToShow = response.data.meta.per_page;
                            this.numStart = response.data.meta.from;
                            this.numTo = response.data.meta.to;
                        }).catch(error =>{
                        loader1.hide();
                    });
                } else {
                    axios.get('/api/referee?order=' + sortOrder + '&page=' + page
                        +'&filter='+this.filter +'&perPage=' + this.perPage)
                        .then(response => {
                            loader1.hide();
                            this.allData = response.data;
                            this.referees = response.data.data;
                            this.total = response.data.meta.total;
                            this.numToShow = response.data.meta.per_page;
                            this.numStart = response.data.meta.from;
                            this.numTo = response.data.meta.to;
                        }).catch(error =>{
                        loader1.hide();
                    });
                }
            },
            // gets necessary data for form like
            getRefereeRelation(){
                axios.get('/api/refereeRelation')
                    .then(response => {
                        this.referee_types = response.data.referee_types;
                    })
                    .catch((e)=>{
                            //  console.log(e);
                        }
                    );
            },
            prepareRegulation() {
                axios.get(`/api/regulationDetail/5`).then((response)=>{
                    this.regulation = response.data.data.detail;
                }).catch(()=>{
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },

        },
        computed:{
            sortType() {
                return this.order === 1 ? 'ascending' : 'descending';
            },
            journalFields(){
                if(this.form.referee_types_id){
                    return this.form.referee_types_id == 1 || this.form.referee_types_id == 2;
                }else {
                    return false;
                }
            }
        },
        created(){
            this.$parent.pageName = 'آرشیو داوری‌ها';
            this.$validator.localize('farsi', {
                messages: farsi.messages,
                attributes: {
                    title: 'عنوان اثر داوری شده',
                    referee_types_id: 'نوع اثر داوری شده',
                    journal_name: 'نام مجله',
                    journal_issn: 'شماره ISSN مجله',
                    referee_date: 'تاربخ داوری',
                    files: 'فایل های ضمیمه',
                }
            });
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
            this.prepareRegulation();
            this.getResults();
            this.getRefereeRelation();
            this.form.reset();
        },
        components: {
            Select2,
        }
    }
</script>

<style scoped>

</style>
