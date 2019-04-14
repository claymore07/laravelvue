<template>
    <div>

        <div class="container-fluid">
            <div class="col-md-12 mt-3" v-if="$gate.isAdminOrUser">
                <div class="card card-4">
                    <div class="card-header  " style="direction: rtl">
                        <div class="justify-content-around d-lg-flex text-right">
                            <div class="col-lg-2 m-3">
                                <h4 class=" text-right"><i class="fal  fa-microscope fa-fw"></i> آرشیو اختراعات</h4>
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
                                        <i style="font-size: 16px" class="fal fa-file-plus"></i> افزودن اختراع، اکتشاف</button>
                                </div>
                            </div>
                        </div><!-- /card-tools -->


                    </div><!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-right">
                            <tbody>
                            <tr>
                                <th>شماره</th>
                                <th>عنوان اختراع، اکتشاف یا تولید علمی</th>
                                <th>نوع اختراع</th>
                                <th>نام مخترع</th>
                                <th>وضعیت بررسی</th>
                                <th @click="toggle()" :class="['sort-control', sortType]">تاریخ ثبت</th>
                                <th>ابزارهای ویرایشی</th>
                            </tr>
                            <tr v-for="(invention, index) in inventions" :key="invention.id">
                                <td>{{counter(index) | faDigit}}</td>
                                <td>{{ invention.title | truncate(40) }}</td>
                                <td>{{ invention.invention_type | truncate(40) }}</td>


                                <td>{{ invention.Author_name  }}</td>
                                <td v-if="invention.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                <td v-else-if="invention.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                <td v-else-if="invention.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                <td v-else-if="invention.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                <td>{{ invention.created_at | myDate  }}</td>
                                <td>
                                    <router-link :to="{ name: 'inventionEdit', params: { id: invention.id }}">
                                        <i class="fa fa-edit blue"></i>
                                    </router-link>
                                    /
                                    <a href="#" @click="deleteInvention(invention.id)">
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
            <div  v-if="$gate.isAdmin()||$gate.isAuthor()" class="modal  fade" id="addNew" tabindex="-1" post="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl  modal-dialog-centered" post="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><i
                                class="fas fa-microscope fa-fw"></i> ثبت اختراع، اکتشاف یا تولید علمی جدید </h5>

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
                            <h2 slot="title">تکمیل اطلاعات اختراع، اکتشاف یا تولید علمی</h2>
                            <!--  -->
                            <tab-content title="اطلاعات اختراع" :before-change="inventionValidation"  icon="far fa-microscope">
                                <form @submit.prevent="createCourse()" @keydown="form.onKeydown($event)" @change="form.onKeydown($event)" data-vv-scope="form" id="Form">

                                    <div class="modal-body">
                                        <div class="form-group mt-4 text-right">
                                            <label class="blue">عنوان اختراع، اکتشاف یا تولید علمی<i class="red mx-1">*</i>:</label>
                                            <input  type="text"  name="title" placeholder="عنوان اختراع، اکتشاف یا تولید علمی"
                                                    class="form-control" v-model="form.title"
                                                    v-validate="'required'"
                                                    autofocus
                                                    :class="{ 'is-invalid': form.errors.has('title') || errors.has('form.title') } " >
                                            <i v-show="errors.has('form.title') || form.errors.has('title')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.form.title')" class="red d-inline-block">{{ errors.first('form.title') }}</span>
                                            <span v-show="form.errors.has('title')" class="red d-inline-block">{{ form.errors.get('title') }}</span>
                                        </div>
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">نوع عنوان اختراع، اکتشاف یا تولید علمی<i class="red mx-1">*</i>:</label>
                                            <Select2 v-validate="'required'" data-vv-name="invention_types_id"
                                                     class="form-control select2-form-control" id="invention_types_id"
                                                     :class="[( errors.has('form.invention_types_id') || form.errors.has('invention_types_id') ? 'is-invalid': ''  )]"
                                                     v-model="form.invention_types_id"
                                                     :options="invention_types"
                                                     @change="resetErrors()"
                                                     :settings="{theme: 'bootstrap4', placeholder: 'نوع عنوان اختراع، اکتشاف یا تولید علمی', width: '100%' }">
                                            </Select2>

                                            <i v-show="errors.has('form.invention_types_id') || form.errors.has('invention_types_id')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.invention_types_id')" class="red d-inline-block">{{ errors.first('form.invention_types_id') }}</span>
                                            <span v-show="form.errors.has('invention_types_id')" class="red d-inline-block">{{ form.errors.get('invention_types_id') }}</span>
                                        </div>
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">نقش در اختراع، اکتشاف یا تولید علمی:</label>
                                            <select v-model="form.post"
                                                    data-vv-name="post"
                                                    :class="{ 'is-invalid': form.errors.has('post')|| errors.has('form.post') }"
                                                    v-validate="'required'"
                                                    class="form-control">
                                                <option selected disabled  value="">انتخاب گزینه ...</option>
                                                <option value="مسئول">مسئول</option>
                                                <option value="عضو تیم">عضو تیم</option>
                                            </select>
                                            <i v-show="errors.has('form.post') || form.errors.has('post')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.post')" class="red d-inline-block">{{ errors.first('form.post') }}</span>
                                            <has-error :form="form" field="post"></has-error>
                                        </div>
                                        <div  class="form-group my-3 text-right">
                                            <label   class="blue ">نام مرجع تایید کننده<i class="red mx-1">*</i>:</label>
                                            <input   type="text" name="authorities"
                                                     placeholder="نام مرجع تایید کننده"
                                                     v-validate="'required'"
                                                     class="form-control" v-model="form.authorities"
                                                     :class="[( errors.has('form.authorities') || form.errors.has('authorities') ? 'is-invalid': ''  ) ]"
                                            >
                                            <i v-show="errors.has('form.authorities') || form.errors.has('authorities')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.authorities')" class="red d-inline-block">{{ errors.first('form.authorities') }}</span>
                                            <span v-show="form.errors.has('authorities')" class="red d-inline-block">{{ form.errors.get('authorities') }}</span>
                                        </div>


                                        <div class=" mt-4" style="direction: ltr; text-align: right" >
                                            <label class="blue text-right  text-rtl">تاریخ ثبت اختراع یا صدور تاییدیه<i class="red mx-1">*</i>:</label>
                                            <br> <span class="float-left font-16 "> {{form.submit_date | myDate}}</span>
                                            <date-picker @change="removeError('submit_date')" format="YYYY-MM-DD"
                                                         v-validate="'required'"
                                                         :class="[ errors.has('form.submit_date') || form.errors.has('submit_date') ? 'is-invalid': ''  ] "
                                                         name="submit_date" v-model="form.submit_date" locale="fa,en"></date-picker>
                                            <div class="text-rtl">
                                                <i v-show="errors.has('form.submit_date') || form.errors.has('submit_date')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form.submit_date')" class="red d-inline-block">{{ errors.first('form.submit_date') }}</span>
                                                <span v-show="form.errors.has('submit_date')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('submit_date') }}</span>
                                            </div>
                                        </div>
                                        <div v-if="form.invention_types_id == 9" class="form-group my-3 text-right ">
                                            <label class="blue text-right  text-rtl">آیا پتنت ثبت شده به فروش رسیده یا بصورت لیسانس از آن استفاده شده است؟<i class="red mx-1">*</i></label>
                                            <p-radio v-model="form.license" name="license" value="1" class="p-icon p-curve p-bigger p-pulse text-ltr"  color="info-o">
                                                <i slot="extra" class="icon far fa-check"></i>
                                                بله
                                            </p-radio>
                                            <p-radio v-validate="'required'" v-model="form.license"
                                                     name="license" value="0" type="radio" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                                <i slot="extra" class="icon far fa-check"></i>
                                                خیر
                                            </p-radio>

                                            <br>
                                            <i v-show="errors.has('form.license') || form.errors.has('license')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.license')" class="red d-inline-block">{{ errors.first('form.license') }}</span>
                                            <span v-show="form.errors.has('license')" class="red d-inline-block">{{ form.errors.get('license') }}</span>
                                        </div>

                                        <div  v-if="form.invention_types_id == 9"  class="form-group my-3 text-right">
                                            <label   class="blue ">نام موسسه وابسته یا Affiliation ثبت شده در پتنت<i class="red mx-1">*</i>:</label>
                                            <input   type="text" name="affiliation"
                                                     placeholder="نام موسسه وابسته"
                                                     v-validate="'required'"
                                                     class="form-control" v-model="form.affiliation"
                                                     :class="[( errors.has('form.affiliation') || form.errors.has('affiliation') ? 'is-invalid': ''  ) ]"
                                            >
                                            <i v-show="errors.has('form.affiliation') || form.errors.has('affiliation')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.affiliation')" class="red d-inline-block">{{ errors.first('form.affiliation') }}</span>
                                            <span v-show="form.errors.has('affiliation')" class="red d-inline-block">{{ form.errors.get('affiliation') }}</span>
                                        </div>
                                        <div v-if="form.invention_types_id == 9"  class="form-group my-3 text-right">
                                            <label   class="blue ">شماره ثبت پتنت<i class="red mx-1">*</i>:</label>
                                            <input   type="text" name="license_number"
                                                     placeholder="شماره ثبت پتنت"
                                                     v-validate="'required'"
                                                     class="form-control" v-model="form.license_number"
                                                     :class="[( errors.has('form.license_number') || form.errors.has('license_number') ? 'is-invalid': ''  ) ]"
                                            >
                                            <i v-show="errors.has('form.license_number') || form.errors.has('license_number')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.license_number')" class="red d-inline-block">{{ errors.first('form.license_number') }}</span>
                                            <span v-show="form.errors.has('license_number')" class="red d-inline-block">{{ form.errors.get('license_number') }}</span>
                                        </div>
                                        <div v-if="form.invention_types_id == 8" class="form-group my-3 text-right">
                                            <label   class="blue ">نام شرکت<i class="red mx-1">*</i>:</label>
                                            <input   type="text" name="company_name"
                                                     placeholder="نام شرکت"
                                                     v-validate="'required'"
                                                     class="form-control" v-model="form.company_name"
                                                     :class="[( errors.has('form.company_name') || form.errors.has('company_name') ? 'is-invalid': ''  ) ]"
                                            >
                                            <i v-show="errors.has('form.company_name') || form.errors.has('company_name')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.company_name')" class="red d-inline-block">{{ errors.first('form.company_name') }}</span>
                                            <span v-show="form.errors.has('company_name')" class="red d-inline-block">{{ form.errors.get('company_name') }}</span>
                                        </div>
                                        <div  v-if="form.invention_types_id == 8" class="form-group my-3 text-right">
                                            <label   class="blue ">نوع شرکت ثبت شده<i class="red mx-1">*</i>:</label>
                                            <input   type="text" name="company_type"
                                                     placeholder="نوع شرکت ثبت شده( سهامی عام و...)"
                                                     v-validate="'required'"
                                                     class="form-control" v-model="form.company_type"
                                                     :class="[( errors.has('form.company_type') || form.errors.has('company_type') ? 'is-invalid': ''  ) ]"
                                            >
                                            <i v-show="errors.has('form.company_type') || form.errors.has('company_type')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.company_type')" class="red d-inline-block">{{ errors.first('form.company_type') }}</span>
                                            <span v-show="form.errors.has('company_type')" class="red d-inline-block">{{ form.errors.get('company_type') }}</span>
                                        </div>
                                        <div  v-if="form.invention_types_id == 8" class="form-group my-3 text-right">
                                            <label   class="blue ">آدرس شرکت ثبت شده<i class="red mx-1">*</i>:</label>
                                            <input   type="text" name="company_address"
                                                     placeholder="آدرس شرکت ثبت شده"
                                                     v-validate="'required'"
                                                     class="form-control" v-model="form.company_address"
                                                     :class="[( errors.has('form.company_address') || form.errors.has('company_address') ? 'is-invalid': ''  ) ]"
                                            >
                                            <i v-show="errors.has('form.company_address') || form.errors.has('company_address')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.company_address')" class="red d-inline-block">{{ errors.first('form.company_address') }}</span>
                                            <span v-show="form.errors.has('company_address')" class="red d-inline-block">{{ form.errors.get('company_address') }}</span>
                                        </div>
                                        <div  v-if="form.invention_types_id == 8" class="form-group my-3 text-right">
                                            <label   class="blue ">شماره ثبت شرکت<i class="red mx-1">*</i>:</label>
                                            <input   type="text" name="registration_number"
                                                     placeholder="شماره ثبت شرکت"
                                                     v-validate="'required'"
                                                     class="form-control" v-model="form.registration_number"
                                                     :class="[( errors.has('form.registration_number') || form.errors.has('registration_number') ? 'is-invalid': ''  ) ]"
                                            >
                                            <i v-show="errors.has('form.registration_number') || form.errors.has('registration_number')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.registration_number')" class="red d-inline-block">{{ errors.first('form.registration_number') }}</span>
                                            <span v-show="form.errors.has('registration_number')" class="red d-inline-block">{{ form.errors.get('registration_number') }}</span>
                                        </div>

                                        <div class="form-group mt-4 text-right">
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
            <div v-if="!$gate.isAdmin()">
                <not-found></not-found>
            </div><!-- /404 page -->
        </div><!-- /container-fluid -->
    </div>
    </div>
</template>

<script>
    import Select2 from 'v-select2-component';
    import farsi from 'vee-validate/dist/locale/fa';
    export default {
        name: "Inventions",
        data(){
            return{
                filter:5,
                inventions:{},
                invention_types:[],
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
                    invention_types_id: '',
                    post: '',
                    authorities: '',
                    license: '',
                    license_number: '',
                    affiliation: '',
                    registration_number: '',
                    company_name: '',
                    company_type: '',
                    company_address: '',
                    submit_date: '',
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
            inventionValidation(){
                return this.$validator.validateAll('form').then(result => {
                    if (!result) {
                        this.errorSwal('اطلاعات اختراع دارای خطا می باشد!');
                        return false;
                    }
                    return true;
                });
            },
            onComplete(){
                this.$Progress.start();
                let loader1 = Vue.$loading.show();
                this.form.busy;

                this.form.submit('post', '/api/invention', {
                    // Transform form data to FormData
                    transformRequest: [function (data, headers) {
                        return objectToFormData(data)
                    }]
                }).then((response) => {
                    loader1.hide();
                    this.inventions.unshift(response.data.data);
                    $('#addNew').modal('hide');
                    this.successToast('اطلاعات اختراع جدید با موفقیت ثبت شد.');
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
            deleteInvention(id){
                swal({
                    title: 'آیا از حذف اختراع مورد نظر مطمئن هستید؟',
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
                        this.form.delete(`/api/invention/${id}`).then(() => {
                            this.successSwal('اختراع مورد نظر با موفقیت حذف شد.');
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
                    axios.get('/api/findInvention?order=' + sortOrder + '&q=' + que +'&filter='+this.filter +'&page=' + page)
                        .then(response => {
                            loader1.hide();
                            this.allData = response.data;
                            this.inventions = response.data.data;
                            this.total = response.data.meta.total;
                            this.numToShow = response.data.meta.per_page;
                            this.numStart = response.data.meta.from;
                            this.numTo = response.data.meta.to;
                        }).catch(error =>{
                        loader1.hide();
                    });
                } else {
                    axios.get('/api/invention?order=' + sortOrder + '&page=' + page +'&filter='+this.filter)
                        .then(response => {
                            loader1.hide();
                            this.allData = response.data;
                            this.inventions = response.data.data;
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
            getInventionRelation(){
                axios.get('/api/inventionRelation')
                    .then(response => {
                        this.invention_types = response.data.invention_types;
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
            this.$parent.pageName = 'آرشیو اختراعات';
            this.$validator.localize('farsi', {
                messages: farsi.messages,
                attributes: {
                    title: 'عنوان اختراع یا اکتشاف یا تولید علمی',
                    invention_types_id: 'نوع اختراع یا اکتشاف',
                    post: 'نقش در ثبت اختراع یا اکتشاف',
                    authorities: 'نام مرجع تایید کننده',
                    license: 'پاسخ به نحوه استفاده از پتنت',
                    license_number: 'شماره پتنت',
                    affiliation: 'آدرس Affiliation ثبت شده در اختراع',
                    registration_number: 'شماره ثبت شرکت',
                    company_name: 'نام شرکت',
                    company_type: 'نوع شرکت ثبت شده',
                    company_address: 'آدرس شرکت',
                    submit_date: 'تاریخ ثبت یا صدور تاییدیه',
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
            this.getInventionRelation();
            this.form.reset();
        },
        components: {
            Select2,
        }
    }
</script>

<style scoped>

</style>
