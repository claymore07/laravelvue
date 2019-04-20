<template>
    <div>

        <div class="container-fluid">
            <div class="col-md-12 mt-3" v-if="$gate.isAdminOrUser">
                <div class="card card-4">
                    <div class="card-header  " style="direction: rtl">
                        <div class="row justify-content-between  text-right">
                            <div class="col-xl-3 m-3">
                                <h4 class=" text-right"><i class="fal fa-book fa-fw"></i> آرشیو پایان نامه‌ها</h4>
                            </div>


                            <div class="col-xl-4  " >
                                    <button class="btn btn-block-only btn-success ripple mt-3 mx-xl-2 float-left" @click="newModal"><i style="font-size: 16px" class="fal fa-file-plus"></i> افزودن پایان نامه</button>
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
                                <th>عنوان پایان نامه</th>

                                <th>نام مسئول</th>
                                <th>وضعیت بررسی</th>
                                <th @click="toggle()" :class="['sort-control', sortType]">تاریخ ثبت</th>
                                <th>ابزارهای ویرایشی</th>
                            </tr>
                            <tr v-if="theses.length <= 0">
                                <td colspan="6"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                            </tr>
                            <tr v-for="(thesis, index) in theses" :key="thesis.id">
                                <td>{{counter(index) | faDigit}}</td>
                                <td>{{ thesis.title | truncate(40) }}</td>


                                <td>{{ thesis.Author_name  }}</td>
                                <td v-if="thesis.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                <td v-else-if="thesis.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                <td v-else-if="thesis.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                <td v-else-if="thesis.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                <td>{{ thesis.created_at | myDate  }}</td>
                                <td>
                                    <router-link :to="{ name: 'thesisEdit', params: { id: thesis.id }}">
                                        <i class="fa fa-edit blue"></i>
                                    </router-link>
                                    /
                                    <a href="#" @click="deleteThesis(thesis.id)">
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
                        <span class="table-detail">
                        تعداد
                        {{(this.numTo - this.numStart + 1) | faDigit  }}
                        از
 {{this.total | faDigit}}                   </span>
                    </div><!-- /card-footer --->
                </div>
            </div><!-- /col-md-12 --->
            <!-- Modal -->
            <div  v-if="$gate.isAdmin()||$gate.isAuthor()" class="modal  fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><i
                                class="fas fa-book fa-fw"></i> ثبت پایان نامه جدید</h5>

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
                            <h2 slot="title">تکمیل اطلاعات پایان نامه</h2>
                            <!--  -->
                            <tab-content title="اطلاعات پایان نامه" :before-change="thesisValidation"  icon="far fa-book">
                                <form @submit.prevent="createThesis()" @keydown="form.onKeydown($event)" @change="form.onKeydown($event)" data-vv-scope="form" id="Form">

                                    <div class="modal-body">
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">عنوان پایان نامه<i class="red mx-1">*</i>:</label>
                                            <input  type="text"  name="title" placeholder="عنوان پایان نامه"
                                                    class="form-control" v-model="form.title"
                                                    v-validate="'required'"
                                                    autofocus
                                                    :class="{ 'is-invalid': form.errors.has('title') || errors.has('form.title') } " @input="() => {}">
                                            <i v-show="errors.has('form.title') || form.errors.has('location')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.title')" class="red d-inline-block">{{ errors.first('form.title') }}</span>
                                            <span v-show="form.errors.has('title')" class="red d-inline-block">{{ form.errors.get('title') }}</span>

                                        </div>

                                        <div class="form-group my-3 text-right">
                                            <label class="blue">مقطع تحصیلی<i class="red mx-1">*</i>:</label>
                                            <Select2 class="form-control select2-form-control"
                                                     :class="{ 'is-invalid': form.errors.has('degree_id') || errors.has('form.degree_id')}" v-model="form.degree_id"
                                                     :options="degrees"
                                                     data-vv-name="degree_id"
                                                     v-validate="'required'"
                                                     @change="removeError('degree_id')"
                                                     :settings="{theme: 'bootstrap4', placeholder: 'مقطع تحصیلی', width: '100%' }">
                                            </Select2>
                                            <i v-show="errors.has('form.degree_id') || form.errors.has('degree_id')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.degree_id')" class="red d-inline-block">{{ errors.first('form.degree_id') }}</span>
                                            <span v-show="form.errors.has('degree_id')" class="red d-inline-block">{{ form.errors.get('degree_id') }}</span>
                                        </div>
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">مسئولیت استاد در پایان نامه<i class="red mx-1">*</i>:</label>
                                            <select name="responsible"
                                                    v-model="form.responsible"
                                                    id="type" class="form-control test1"
                                                    :class="{ 'is-invalid': form.errors.has('responsible') || errors.has('form.responsible')}"
                                                    v-validate="'required'"
                                            >
                                                <option selected disabled value="">مسئولیت استاد در پایان نامه</option>
                                                <option value="0">استاد راهنما</option>
                                                <option value="1">استاد مشاور</option>

                                            </select>
                                            <i v-show="errors.has('form.responsible') || form.errors.has('responsible')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.responsible')" class="red d-inline-block">{{ errors.first('form.responsible') }}</span>
                                            <span v-show="form.errors.has('responsible')" class="red d-inline-block">{{ form.errors.get('responsible') }}</span>
                                        </div>
                                        <div class=" my-3" style="direction: ltr; text-align: right" >
                                            <label class="blue text-right  text-rtl">تاریخ تصویب در گروه<i class="red mx-1">*</i>:</label>
                                            <br> <span class="float-left font-16 "> {{form.group_aprovedate | myDate}}</span>
                                            <date-picker @change="removeError('group_aprovedate')" format="YYYY-MM-DD"
                                                         :class="[ form.errors.has('group_aprovedate') ? 'is-invalid': ''  ] "
                                                         v-validate="'required'"
                                                         name="group_aprovedate" v-model="form.group_aprovedate" locale="fa,en"></date-picker>
                                            <div class="text-rtl">
                                                <i v-show="errors.has('form.group_aprovedate') || form.errors.has('group_aprovedate')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form.group_aprovedate')" class="red d-inline-block">{{ errors.first('form.group_aprovedate') }}</span>
                                                <span v-show="form.errors.has('group_aprovedate')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('group_aprovedate') }}</span>
                                            </div>
                                        </div>
                                        <div class=" my-3" style="direction: ltr; text-align: right" >
                                            <label class="blue text-right  text-rtl">تاریخ تصویب در شورای پژوهشی<i class="red mx-1">*</i>:</label>
                                            <br> <span class="float-left font-16 "> {{form.council_aprovedate | myDate}}</span>
                                            <date-picker @change="removeError('council_aprovedate')" format="YYYY-MM-DD"
                                                         :class="[ form.errors.has('council_aprovedate') ? 'is-invalid': ''  ] "
                                                         v-validate="'required'"
                                                         name="council_aprovedate" v-model="form.council_aprovedate" locale="fa,en"></date-picker>
                                            <div class="text-rtl">
                                                <i v-show="errors.has('form.council_aprovedate') || form.errors.has('council_aprovedate')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form.council_aprovedate')" class="red d-inline-block">{{ errors.first('form.council_aprovedate') }}</span>
                                                <span v-show="form.errors.has('council_aprovedate')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('council_aprovedate') }}</span>
                                            </div>
                                        </div>
                                        <div class=" my-3" style="direction: ltr; text-align: right" >
                                            <label class="blue text-right  text-rtl">تاریخ دریافت کد<i class="red mx-1">*</i>:</label>
                                            <br> <span class="float-left font-16 "> {{form.code_date | myDate}}</span>
                                            <date-picker @change="removeError('code_date')" format="YYYY-MM-DD"
                                                         :class="[ form.errors.has('code_date') ? 'is-invalid': ''  ] "
                                                         v-validate="'required'"
                                                         name="code_date" v-model="form.code_date" locale="fa,en"></date-picker>
                                            <div class="text-rtl">
                                                <i v-show="errors.has('form.code_date') || form.errors.has('code_date')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form.code_date')" class="red d-inline-block">{{ errors.first('form.code_date') }}</span>
                                                <span v-show="form.errors.has('code_date')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('code_date') }}</span>
                                            </div>
                                        </div>
                                        <div class=" my-3" style="direction: ltr; text-align: right" >
                                            <label class="blue text-right  text-rtl">تاریخ تصویب دفاع<i class="red mx-1">*</i>:</label>
                                            <br> <span class="float-left font-16 "> {{form.defense_date | myDate}}</span>
                                            <date-picker @change="removeError('defense_date')" format="YYYY-MM-DD"
                                                         :class="[ form.errors.has('defense_date') ? 'is-invalid': ''  ] "
                                                         v-validate="'required'"
                                                         name="defense_date" v-model="form.defense_date" locale="fa,en"></date-picker>
                                            <div class="text-rtl">
                                                <i v-show="errors.has('form.defense_date') || form.errors.has('defense_date')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form.defense_date')" class="red d-inline-block">{{ errors.first('form.defense_date') }}</span>
                                                <span v-show="form.errors.has('defense_date')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('defense_date') }}</span>
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
                        <div class="modal-body" style="height: 600px; overflow-y: scroll" >
                            <table class="table table-bordered table-hover text-right">
                                    <tr>
                                        <td class="align-middle text-center"  rowspan="4">بند 13</td>
                                        <td width="40%" class="align-middle" rowspan="2">1. راهنمایی و مشاوره پایان نامه کارشناسی ارشد یا دکتری حرفه ای یا سطح 3 حوزه( سقف برای پایان نامه های کاربردی با ضریب 1.5 برابر)</td>
                                        <td class="align-middle  text-center">1. استاد راهنما</td>
                                        <td class="align-middle  text-center">2</td>
                                        <td class="align-middle  text-center" rowspan="4">25</td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle  text-center">2. استاد مشاور</td>
                                        <td class="align-middle  text-center">0.5</td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle  text-center" rowspan="2">2. راهنمایی و مشاوره پایان نامه دکتری تخصصی یا سطح 4 حوزه( سقف برای پایان نامه های کاربردی با ضریب 1.5 برابر)</td>
                                        <td width="40%" class="align-middle  text-center">1. استاد راهنما</td>
                                        <td class="align-middle  text-center">6</td>
                                    </tr>

                                    <tr>
                                        <td class="align-middle  text-center">2. استاد مشاور</td>
                                        <td class="align-middle  text-center">1.5</td>
                                    </tr>

                            </table>
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
        name: "Thesis",

        data(){
            return{
                filter:5,
                theses:{},
                allData :{},
                degrees:[],
                search: '',     // search term
                order: 1,       // order 1 for desc and 0  for asc
                total: 0,       // total number of papers
                numToShow: 0,   // number of papers shown in this page
                numStart: 0,    // starting row number
                numTo: 0,       // ending number
                searchResult: false,
                form: new Form({
                    title:'',
                    degree_id:'',
                    responsible:'',
                    group_aprovedate:'',
                    council_aprovedate:'',
                    code_date:'',
                    defense_date:''
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
            onComplete(){
                this.$Progress.start();
                let loader1 = Vue.$loading.show();
                this.form.busy;
                this.form.post('/api/thesis')
                    .then((response) => {
                        loader1.hide();
                        this.theses.unshift(response.data.data);
                        $('#addNew').modal('hide');
                        this.successToast('اطلاعات پایان نامه جدید با موفقیت ثبت شد.');
                        this.$Progress.finish();
                        this.resetFormWizard();
                    })
                    .catch((e) => {
                        loader1.hide();
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
            thesisValidation(){
                return this.$validator.validateAll('form').then(result => {
                    if (!result) {
                        this.errorSwal('اطلاعات پایان نامه دارای خطا می باشد!');
                        return false;
                    }
                    return true;
                });
            },
            resetFormWizard() {
                this.form.reset();
                this.$refs.wizard.reset();
                this.$validator.reset();
            },
            deleteThesis(id){
                swal({
                    title: 'آیا از حذف پایان نامه مورد نظر مطمئن هستید؟',
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
                        this.form.delete(`/api/thesis/${id}`).then(() => {
                            this.successSwal('پایان نامه مورد نظر با موفقیت حذف شد.');
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
                    axios.get('/api/findThesis?order=' + sortOrder + '&q=' + que +'&filter='+this.filter +'&page=' + page)
                        .then(response => {
                            loader1.hide();
                            this.allData = response.data;
                            this.theses = response.data.data;
                            this.total = response.data.meta.total;
                            this.numToShow = response.data.meta.per_page;
                            this.numStart = response.data.meta.from;
                            this.numTo = response.data.meta.to;
                        }).catch(error =>{
                        loader1.hide();
                    });
                } else {
                    axios.get('/api/thesis?order=' + sortOrder + '&page=' + page +'&filter='+this.filter)
                        .then(response => {
                            loader1.hide();
                            this.allData = response.data;
                            this.theses = response.data.data;
                            this.total = response.data.meta.total;
                            this.numToShow = response.data.meta.per_page;
                            this.numStart = response.data.meta.from;
                            this.numTo = response.data.meta.to;
                        }).catch(error =>{
                        loader1.hide();
                    });
                }
            },
            // gets necessary data for form like excerpts and conference types and journal types
            getThesisRelation(){
                axios.get('/api/thesisRelation')
                    .then(response => {
                        this.degrees = response.data.degrees;
                    })
                    .catch((e)=>{
                            //  console.log(e);
                        }
                    );
            },
            createThesis(){

            }
        },
        computed:{
            sortType() {
                return this.order === 1 ? 'ascending' : 'descending';
            },
        },
        created(){
            this.$parent.pageName = 'آرشیو پایان نامه ها';
            this.$validator.localize('farsi', {
                messages: farsi.messages,
                attributes: {
                    title: 'عنوان پایان نامه',
                    group_aprovedate: 'تاربخ تصویب در گروه',
                    council_aprovedate: 'تاربخ تصویب در شورای پژوهشی',
                    code_date: 'تاربخ دریافت کد',
                    defense_date: 'تاربخ دفاع',
                    responsible: 'نوع مسئولیت استاد',
                    degree_id : 'مقطع تحصیلی'

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
            this.getResults();
            this.getThesisRelation();
            this.form.reset();
        },
        components: {
            Select2,
        }

    }
</script>

<style scoped>

</style>
