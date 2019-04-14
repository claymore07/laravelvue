<template>
    <div>

        <div class="container-fluid">
            <div class="col-md-12 mt-3" v-if="$gate.isAdminOrUser">
                <div class="card card-4">
                    <div class="card-header  " style="direction: rtl">
                        <div class="justify-content-around d-lg-flex text-right">
                            <div class="col-lg-2 m-3">
                                <h4 class=" text-right"><i class="fal  fa-presentation fa-fw"></i> آرشیو جزوات</h4>
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
                                    <button class="btn btn-success ripple " @click="newModal">
                                        <i style="font-size: 16px" class="fal fa-file-plus"></i> افزودن جزوه</button>
                                </div>
                            </div>
                        </div><!-- /card-tools -->


                    </div><!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-right">
                            <tbody>
                            <tr>
                                <th>شماره</th>
                                <th>عنوان جزوه</th>
                                <th>نام درس</th>
                                <th>نام استاد</th>
                                <th>وضعیت بررسی</th>
                                <th @click="toggle()" :class="['sort-control', sortType]">تاریخ ثبت</th>
                                <th>ابزارهای ویرایشی</th>
                            </tr>

                            <tr v-for="(booklet, index) in booklets" :key="booklet.id">
                                <td>{{counter(index) | faDigit}}</td>
                                <td>{{ booklet.title | truncate(40) }}</td>
                                <td>{{ booklet.name | truncate(40) }}</td>


                                <td>{{ booklet.Author_name  }}</td>
                                <td v-if="booklet.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                <td v-else-if="booklet.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                <td v-else-if="booklet.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                <td v-else-if="booklet.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                <td>{{ booklet.created_at | myDate  }}</td>
                                <td>
                                    <router-link :to="{ name: 'bookletEdit', params: { id: booklet.id }}">
                                        <i class="fa fa-edit blue"></i>
                                    </router-link>
                                    /
                                    <a href="#" @click="deleteBooklet(booklet.id)">
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
                                class="fas fa-presentation fa-fw"></i> ثبت جزوه یا اسلاید جدید</h5>

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
                            <h2 slot="title">تکمیل اطلاعات جزوه یا اسلاید</h2>
                            <!--  -->
                            <tab-content title="اطلاعات جزوه یا اسلاید" :before-change="bookletsValidation"  icon="far fa-presentation">
                                <form @submit.prevent="createThesis()" @keydown="form.onKeydown($event)" @change="form.onKeydown($event)" id="Form">

                                    <div class="modal-body">
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">نقش در دوره:</label>
                                            <select v-model="form.booklet_type"
                                                    data-vv-name="booklet_type"
                                                    :class="{ 'is-invalid': form.errors.has('booklet_type')|| errors.has('form.booklet_type') }"
                                                    v-validate="'required'"
                                                    autofocus
                                                    class="form-control">
                                                <option selected disabled  value="">انتخاب گزینه ...</option>
                                                <option value="جزوه">جزوه</option>
                                                <option value="اسلاید">اسلاید</option>
                                            </select>
                                            <i v-show="errors.has('form.booklet_type') || form.errors.has('booklet_type')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.booklet_type')" class="red d-inline-block">{{ errors.first('form.booklet_type') }}</span>
                                            <span v-show="form.errors.has('booklet_type')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('booklet_type') }}</span>
                                        </div>
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">مقطع تحصیلی:</label>
                                            <Select2 class="form-control select2-form-control"
                                                     :class="{ 'is-invalid': form.errors.has('degree_id') || errors.has('form.degree_id')  }" v-model="form.degree_id"
                                                     :options="degrees"
                                                     @change="removeError('degree_id')"
                                                     :settings="{theme: 'bootstrap4', placeholder: 'مقطع تحصیلی', width: '100%' }">
                                            </Select2>
                                            <div class="text-rtl">
                                                <i v-show="errors.has('form.degree_id') || form.errors.has('degree_id')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form.degree_id')" class="red d-inline-block">{{ errors.first('form.degree_id') }}</span>
                                                <span v-show="form.errors.has('degree_id')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('degree_id') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">عنوان جزوه یا اسلاید:</label>
                                            <input  type="text"  name="title" placeholder="عنوان جزوه یا اسلاید"
                                                    class="form-control" v-model="form.title"
                                                    required

                                                    :class="{ 'is-invalid': form.errors.has('title') || errors.has('form.title') } " @input="() => {}">
                                            <div class="text-rtl">
                                                <i v-show="errors.has('form.title') || form.errors.has('title')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form.title')" class="red d-inline-block">{{ errors.first('form.title') }}</span>
                                                <span v-show="form.errors.has('title')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('title') }}</span>
                                            </div>
                                        </div>



                                        <div class="form-group my-3 text-right">
                                            <label class="blue">نام درس:</label>
                                            <input  type="text"  name="name" placeholder="نام درس"
                                                    class="form-control" v-model="form.name"
                                                    required
                                                    :class="{ 'is-invalid': form.errors.has('name') || errors.has('form.name')} " @input="() => {}">
                                            <div class="text-rtl">
                                                <i v-show="errors.has('form.name') || form.errors.has('title')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form.name')" class="red d-inline-block">{{ errors.first('form.name') }}</span>
                                                <span v-show="form.errors.has('name')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('title') }}</span>
                                            </div>
                                        </div>

                                        <div class=" my-3" style="direction: ltr; text-align: right" >
                                            <label class="blue text-right  text-rtl">تاریخ تالیف<i class="red mx-1">*</i>:</label>
                                            <br> <span class="float-left font-16 "> {{form.compilation_date | myDate}}</span>
                                            <date-picker @change="removeError('compilation_date')" format="YYYY-MM-DD"  :class="[ form.errors.has('compilation_date') ? 'is-invalid': ''  ] "
                                                         name="accept_date" v-model="form.compilation_date" locale="fa,en"></date-picker>
                                            <div class="text-rtl">
                                                <i v-show="errors.has('form.compilation_date') || form.errors.has('compilation_date')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form.compilation_date')" class="red d-inline-block">{{ errors.first('form.compilation_date') }}</span>
                                                <span v-show="form.errors.has('compilation_date')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('compilation_date') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group my-3 text-right">
                                            <label class="blue text-right">فایل های ضمیمه:<i class="red mx-1">*</i>:</label>
                                            <span class="red"><br/>
                                                       فایل جزوه یا اسلاید بصورت pdf یا درصورت پاورپوینت بودن بصورت فشرده و در قالب zip یا rar
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
        name: "Booklets",
        data(){
            return{
                filter:5,
                booklets:{},
                degrees:[],
                allData :{},
                search: '',     // search term
                order: 1,       // order 1 for desc and 0  for asc
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
                    name: '',
                    booklet_type: '',
                    degree_id: '',
                    compilation_date: '',
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
            bookletsValidation(){
                return this.$validator.validateAll('form').then(result => {
                    if (!result) {
                        this.errorSwal('اطلاعات جزوه یا اسلاید دارای خطا می باشد!');
                        return false;
                    }
                    return true;
                });
            },
            onComplete(){
                this.$Progress.start();
                let loader1 = Vue.$loading.show();
                this.form.busy;

                this.form.submit('post', '/api/booklet', {
                    // Transform form data to FormData
                    transformRequest: [function (data, headers) {
                        return objectToFormData(data)
                    }]
                }).then((response) => {
                    loader1.hide();
                    this.booklets.unshift(response.data.data);
                    $('#addNew').modal('hide');
                    this.successToast('اطلاعات جزوه یا اسلاید جدید با موفقیت ثبت شد.');
                    this.$Progress.finish();
                    this.resetFormWizard();
                })
                    .catch(() => {
                        loader1.hide();
                        let t = Object.keys(this.form.errors.all()).filter(function (key) {
                            return /^files./.test(key);
                        });

                       if (!t.length) {
                        } else {
                            this.form.errors.set('files', 'نوع فایل باید یکی از انواع pdf و rar یا zip باشد.')
                        }
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        this.$Progress.fail();
                    })

            },
            resetErrors(){
                this.$validator.reset();
            },
            resetFormWizard() {
                this.fileName=[];
                this.attachments = [];
                this.form.reset();
                this.$refs.wizard.reset();
                this.$validator.reset();
            },
            deleteBooklet(id){
                swal({
                    title: 'آیا از حذف جزوه یا اسلاید مورد نظر مطمئن هستید؟',
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
                        this.form.delete(`/api/booklet/${id}`).then(() => {
                            this.successSwal('جزوه یا اسلاید مورد نظر با موفقیت حذف شد.');
                            Fire.$emit('AfterCreate');
                        }).catch((e) => {
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        });
                    } else {
                        this.warningSwal('شما این عملیات را لغو کردید.');
                    }
                })
            },
            getResults: function (page = 1, que = '') {
                let loader1 = Vue.$loading.show();

                let sortOrder = this.order === 1 ? 'asc' : 'desc';
                if (this.searchResult) {
                    que = this.search;
                    axios.get('/api/findBooklet?order=' + sortOrder + '&q=' + que + '&filter=' + this.filter + '&page=' + page)
                        .then(response => {
                            loader1.hide();
                            this.allData = response.data;
                            this.booklets = response.data.data;
                            this.total = response.data.meta.total;
                            this.numToShow = response.data.meta.per_page;
                            this.numStart = response.data.meta.from;
                            this.numTo = response.data.meta.to;
                        }).catch(error => {
                        loader1.hide();
                    });
                } else {
                    axios.get('/api/booklet?order=' + sortOrder + '&page=' + page + '&filter=' + this.filter)
                        .then(response => {
                            loader1.hide();
                            this.allData = response.data;
                            this.booklets = response.data.data;
                            this.total = response.data.meta.total;
                            this.numToShow = response.data.meta.per_page;
                            this.numStart = response.data.meta.from;
                            this.numTo = response.data.meta.to;
                        }).catch(error => {
                        loader1.hide();
                    });
                }
            },
            // gets necessary data for form like
            getBookletRelation(){
                axios.get('/api/bookletRelation')
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
            }
        },
        created(){
            this.$parent.pageName = 'آرشیو جزوات';
            this.$validator.localize('farsi', {
                messages: farsi.messages,
                attributes: {
                    title: 'عنوان جزوه',
                    name: 'نام درس',
                    booklet_type: 'نوع جزوه',
                    degree_id: 'مقظع تدریس',
                    compilation_date: 'تاریخ تالیف',
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
            this.getResults();
            this.getBookletRelation();
            this.form.reset();
        },
        components: {
            Select2,
        }
    }
</script>

<style scoped>

</style>
