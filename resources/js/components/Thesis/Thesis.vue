<template>
    <div>

        <div class="container-fluid">
            <div class="col-md-12 mt-3" v-if="$gate.isAdminOrUser">
                <div class="card card-4">
                    <div class="card-header  " style="direction: rtl">
                        <div class="justify-content-around d-lg-flex text-right">
                            <div class="col-lg-2 m-3">
                                <h4 class=" text-right"><i class="fal fa-book-reader fa-fw"></i> آرشیو پایان نامه ها</h4>
                            </div>
                            <div class="col-lg-5 mt-3">

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

                            <div class="col-lg-5  mt-3" >
                                <div class="d-xl-inline-block  ">
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
                                            <span class="ml-3 input-group-text" style="border: none!important; background: none"  title="پالایش براساس"><i class="fal  blue fa-filter"></i> </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-xl-inline-block float-xl-left">
                                    <button class="btn btn-success ripple " @click="newModal"><i style="font-size: 16px" class="fal fa-file-plus"></i> افزودن پایان نامه</button>
                                </div>
                            </div>
                        </div><!-- /card-tools -->


                    </div><!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
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
                                class="fas fa-book-open fa-fw"></i> ثبت پایان نامه جدید</h5>

                            <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="createThesis()" @keydown="form.onKeydown($event)" @change="form.onKeydown($event)" id="Form">

                            <div class="modal-body">
                                <div class="form-group my-3 text-right">
                                    <label class="blue">عنوان پایان نامه:</label>
                                    <input  type="text"  name="title" placeholder="عنوان پایان نامه"
                                            class="form-control" v-model="form.title"
                                            data-error-pattern-mismatch="نام باید فارسی باشد!"
                                            required
                                            autofocus
                                            :class="{ 'is-invalid': form.errors.has('title') || errors.has('form.title') } " @input="() => {}">
                                    <i v-show="errors.has('form.title') || form.errors.has('location')" class="red far fa-exclamation-triangle"></i>
                                    <span v-show="errors.has('form.title')" class="red d-inline-block">{{ errors.first('form.title') }}</span>
                                    <span v-show="form.errors.has('title')" class="red d-inline-block">{{ form.errors.get('title') }}</span>

                                </div>

                                <div class="form-group my-3 text-right">
                                    <label class="blue">مقطع تحصیلی:</label>
                                    <Select2 class="form-control select2-form-control"
                                             :class="{ 'is-invalid': form.errors.has('degree_id') || errors.has('form.degree_id')}" v-model="form.degree_id"
                                             :options="degrees"
                                             @change="removeError('degree_id')"
                                             :settings="{theme: 'bootstrap4', placeholder: 'مقطع تحصیلی', width: '100%' }">
                                    </Select2>
                                    <i v-show="errors.has('form.degree_id') || form.errors.has('degree_id')" class="red far fa-exclamation-triangle"></i>
                                    <span v-show="errors.has('form.degree_id')" class="red d-inline-block">{{ errors.first('form.degree_id') }}</span>
                                    <span v-show="form.errors.has('degree_id')" class="red d-inline-block">{{ form.errors.get('degree_id') }}</span>
                                </div>
                                <div class="form-group my-3 text-right">
                                    <label class="blue">مسئولیت استاد در پایان نامه:</label>
                                    <select name="type" v-model="form.responsible" id="type" class="form-control test1"
                                            :class="{ 'is-invalid': form.errors.has('responsible') || errors.has('form.responsible')}">
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
                                    <date-picker @change="removeError('group_aprovedate')" format="YYYY-MM-DD"  :class="[ form.errors.has('group_aprovedate') ? 'is-invalid': ''  ] "
                                                 name="accept_date" v-model="form.group_aprovedate" locale="fa,en"></date-picker>
                                    <div class="text-rtl">
                                        <i v-show="errors.has('form.group_aprovedate') || form.errors.has('group_aprovedate')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show="errors.has('form.group_aprovedate')" class="red d-inline-block">{{ errors.first('form.group_aprovedate') }}</span>
                                        <span v-show="form.errors.has('group_aprovedate')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('group_aprovedate') }}</span>
                                    </div>
                                </div>
                                <div class=" my-3" style="direction: ltr; text-align: right" >
                                    <label class="blue text-right  text-rtl">تاریخ تصویب در شورای پژوهشی<i class="red mx-1">*</i>:</label>
                                    <br> <span class="float-left font-16 "> {{form.council_aprovedate | myDate}}</span>
                                    <date-picker @change="removeError('council_aprovedate')" format="YYYY-MM-DD"  :class="[ form.errors.has('council_aprovedate') ? 'is-invalid': ''  ] "
                                                 name="accept_date" v-model="form.council_aprovedate" locale="fa,en"></date-picker>
                                    <div class="text-rtl">
                                        <i v-show="errors.has('form.council_aprovedate') || form.errors.has('council_aprovedate')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show="errors.has('form.council_aprovedate')" class="red d-inline-block">{{ errors.first('form.council_aprovedate') }}</span>
                                        <span v-show="form.errors.has('council_aprovedate')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('council_aprovedate') }}</span>
                                    </div>
                                </div>
                                <div class=" my-3" style="direction: ltr; text-align: right" >
                                    <label class="blue text-right  text-rtl">تاریخ دریافت کد<i class="red mx-1">*</i>:</label>
                                    <br> <span class="float-left font-16 "> {{form.code_date | myDate}}</span>
                                    <date-picker @change="removeError('code_date')" format="YYYY-MM-DD"  :class="[ form.errors.has('code_date') ? 'is-invalid': ''  ] "
                                                 name="accept_date" v-model="form.code_date" locale="fa,en"></date-picker>
                                    <div class="text-rtl">
                                        <i v-show="errors.has('form.code_date') || form.errors.has('code_date')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show="errors.has('form.code_date')" class="red d-inline-block">{{ errors.first('form.code_date') }}</span>
                                        <span v-show="form.errors.has('code_date')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('code_date') }}</span>
                                    </div>
                                </div>
                                <div class=" my-3" style="direction: ltr; text-align: right" >
                                    <label class="blue text-right  text-rtl">تاریخ تصویب دفاع<i class="red mx-1">*</i>:</label>
                                    <br> <span class="float-left font-16 "> {{form.defense_date | myDate}}</span>
                                    <date-picker @change="removeError('defense_date')" format="YYYY-MM-DD"  :class="[ form.errors.has('defense_date') ? 'is-invalid': ''  ] "
                                                 name="accept_date" v-model="form.defense_date" locale="fa,en"></date-picker>
                                    <div class="text-rtl">
                                        <i v-show="errors.has('form.defense_date') || form.errors.has('defense_date')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show="errors.has('form.defense_date')" class="red d-inline-block">{{ errors.first('form.defense_date') }}</span>
                                        <span v-show="form.errors.has('defense_date')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('defense_date') }}</span>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button :disabled="form.busy"  type="submit"   class="btn ripple btn-lg btn-block btn-primary mx-3">ثبت اطلاعات</button>
                                <button type="button" class="btn ripple  btn-lg btn-block btn-danger mx-3 mt-0" data-dismiss="modal">لغو عملیات</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div><!-- /modal -->
            <div v-if="!$gate.isAdmin()">
                <not-found></not-found>
            </div><!-- /404 page -->
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
            createThesis(){
                this.$Progress.start();
                let loader1 = Vue.$loading.show();
                this.form.busy;
                this.form.post('/api/thesis')
                    .then((response) => {
                        loader1.hide();
                        this.theses.unshift(response.data.data);
                        $('#addNew').modal('hide');
                        this.successToast('اطلاعات کاربر جدید با موفقیت ثبت شد.');
                        this.$Progress.finish();
                        this.form.reset();
                    })
                    .catch(() => {
                        loader1.hide();
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        this.$Progress.fail();
                    })
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
                        this.degrees = response.data.data;
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
        created(){
            this.$parent.pageName = 'آرشیو پایان نامه ها';
            //this.getThesisRelation();

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
