<template>
    <div>

        <div class="container-fluid">
            <div class="col-md-12 mt-3" >
                <div class="card card-4">
                    <div class="card-header  " style="direction: rtl">
                        <div class="row justify-content-between  text-right">
                            <div class="col-xl-4 m-3">
                                <h4 class=" text-right"><i class="fal fa-project-diagram fa-fw"></i> طرح‌های پژوهشی و فناوری</h4>
                            </div>
                            <div class="col-xl-4  " >
                                <button class="btn btn-block-only btn-success ripple mt-3 mx-xl-2 float-left" @click="newModal"> <i style="font-size: 16px" class="fal fa-file-plus"></i> افزودن طرح پژوهشی</button>
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
                                <th>عنوان طرح پژوهشی</th>
                                <th>نوع طرح</th>
                                <th>نام مجری</th>
                                <th>وضعیت بررسی</th>
                                <th @click="toggle()" :class="['sort-control', sortType]">تاریخ ثبت</th>
                                <th>ابزارهای ویرایشی</th>
                            </tr>
                            <tr v-if="projects.length <= 0">
                                <td colspan="7"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                            </tr>
                            <tr v-for="(project, index) in projects" :key="project.id">
                                <td>{{counter(index) | faDigit}}</td>
                                <td>{{ project.title | truncate(40) }}</td>
                                <td>{{ project.project_type  }}</td>


                                <td>{{ project.Author_name  }}</td>
                                <td v-if="project.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                <td v-else-if="project.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                <td v-else-if="project.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                <td v-else-if="project.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                <td>{{ project.created_at | myDate  }}</td>
                                <td>
                                    <router-link :to="{ name: 'projectEdit', params: { id: project.id }}">
                                        <i class="fa fa-edit blue"></i>
                                    </router-link>
                                    /
                                    <a href="#" @click="deleteProject(project.id)">
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
            <div   class="modal  fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><i
                                class="fas fa-project-diagram fa-fw"></i> ثبت طرح‌ پژوهشی و فناوری جدید </h5>

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
                            <h2 slot="title">تکمیل طرح‌ پژوهشی و فناوری</h2>
                            <!--  -->
                            <tab-content title="طرح‌ پژوهشی" :before-change="projectValidation"  icon="far fa-project-diagram">
                                <form @submit.prevent="createCourse()" @keydown="form.onKeydown($event)" @change="form.onKeydown($event)" data-vv-scope="form" id="Form">

                                    <div class="modal-body">
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">عنوان طرح پژوهشی و فناوری<i class="red mx-1">*</i>:</label>
                                            <input  type="text"  name="title" placeholder="عنوان طرح پژوهشی و فناوری"
                                                    class="form-control" v-model="form.title"
                                                    v-validate="'required'"
                                                    autofocus
                                                    :class="{ 'is-invalid': form.errors.has('title') || errors.has('form.title') } " >
                                            <i v-show="errors.has('form.title') || form.errors.has('title')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.title')" class="red d-inline-block">{{ errors.first('form.title') }}</span>
                                            <span v-show="form.errors.has('title')" class="red d-inline-block">{{ form.errors.get('title') }}</span>
                                        </div>
                                        <div class="form-group my-4 text-right">
                                            <label class="blue">نوع طرح پژوهشی<i class="red mx-1">*</i>:</label>
                                            <Select2 v-validate="'required'" data-vv-name="project_types_id"
                                                     class="form-control select2-form-control" id="project_types_id"
                                                     :class="[( errors.has('form.project_types_id') || form.errors.has('project_types_id') ? 'is-invalid': ''  )]"
                                                     v-model="form.project_types_id"
                                                     :options="project_types"
                                                     @change="removeError('project_types_id')"
                                                     :settings="{theme: 'bootstrap4', placeholder: 'نوع طرح پژوهشی', width: '100%' }">
                                            </Select2>

                                            <i v-show="errors.has('form.project_types_id') || form.errors.has('project_types_id')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.project_types_id')" class="red d-inline-block">{{ errors.first('form.project_types_id') }}</span>
                                            <span v-show="form.errors.has('project_types_id')" class="red d-inline-block">{{ form.errors.get('project_types_id') }}</span>
                                        </div>
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">سازمان طرف قرارداد<i class="red mx-1">*</i>:</label>
                                            <input  type="text"  name="organization" placeholder="سازمان طرف قرارداد"
                                                    class="form-control" v-model="form.organization"
                                                    v-validate="'required'"
                                                    :class="{ 'is-invalid': form.errors.has('organization') || errors.has('form.organization')} " @input="() => {}">
                                            <i v-show="errors.has('form.organization') || form.errors.has('organization')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.organization')" class="red d-inline-block">{{ errors.first('form.organization') }}</span>
                                            <span v-show="form.errors.has('organization')" class="red d-inline-block">{{ form.errors.get('organization') }}</span>
                                        </div>
                                        <div  class="form-group my-3 text-right">
                                            <label class="blue ">بودجه طرح پژوهشی<i class="red mx-1">*</i>:{{ form.budget | currency}}<span >ریال</span></label>
                                            <input  type="number" name="budget" step="1" min="1"
                                                    placeholder="1"
                                                    v-validate="'required|integer'"
                                                    class="form-control" v-model="form.budget"
                                                    :class="[( errors.has('form.budget') || form.errors.has('budget') ? 'is-invalid': ''  ) ]"
                                            >
                                            <i v-show="errors.has('form.budget') || form.errors.has('budget')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.budget')" class="red d-inline-block">{{ errors.first('form.budget') }}</span>
                                            <span v-show="form.errors.has('budget')" class="red d-inline-block">{{ form.errors.get('budget') }}</span>
                                        </div>
                                        <div class=" my-3" style="direction: ltr; text-align: right" >
                                            <label class="blue text-right  text-rtl">تاریخ تصویب در شورای پژوهشی<i class="red mx-1">*</i>:</label>
                                            <br> <span class="float-left font-16 "> {{form.council_aprovedate | myDate}}</span>
                                            <date-picker @change="removeError('council_aprovedate')" format="YYYY-MM-DD"
                                                         v-validate="'required'"
                                                         :class="[ errors.has('form.council_aprovedate') || form.errors.has('council_aprovedate') ? 'is-invalid': ''  ] "
                                                         name="council_aprovedate" v-model="form.council_aprovedate" locale="fa,en"></date-picker>
                                            <div class="text-rtl">
                                                <i v-show="errors.has('form.council_aprovedate') || form.errors.has('council_aprovedate')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form.council_aprovedate')" class="red d-inline-block">{{ errors.first('form.council_aprovedate') }}</span>
                                                <span v-show="form.errors.has('council_aprovedate')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('council_aprovedate') }}</span>
                                            </div>
                                        </div>
                                        <div class=" my-3" style="direction: ltr; text-align: right" >
                                            <label class="blue text-right  text-rtl">تاریخ دفاع<i class="red mx-1">*</i>:</label>
                                            <br> <span class="float-left font-16 "> {{form.defense_date | myDate}}</span>
                                            <date-picker @change="removeError('defense_date')" format="YYYY-MM-DD"
                                                         v-validate="'required'"
                                                         :class="[ errors.has('form.defense_date') || form.errors.has('defense_date') ? 'is-invalid': ''  ] "
                                                         name="defense_date" v-model="form.defense_date" locale="fa,en"></date-picker>
                                            <div class="text-rtl">
                                                <i v-show="errors.has('form.defense_date') || form.errors.has('defense_date')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form.defense_date')" class="red d-inline-block">{{ errors.first('form.defense_date') }}</span>
                                                <span v-show="form.errors.has('defense_date')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('defense_date') }}</span>
                                            </div>
                                        </div>

                                        <div class="form-group my-3 text-right">
                                            <label class="blue text-right">فایل های ضمیمه:<i class="red mx-1">*</i>:</label>
                                            <span class="red"><br/>
                                                اسکن قرارداد بصورت pdf<br>
                                                اسکن مجوز شورای بصورت pdf در صورت وجود<br>
                                                اسکن صورت جلسه دفاع بصورت pdf در صورت وجود<br>
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
                            <tab-content title="اطلاعات نویسندگان"  icon="fa fa-user-plus" :before-change="authorValidation"   >
                                <form @submit.prevent="addAuthor"
                                      @keydown="form.onKeydown($event)" @change="form.onKeydown($event)"  data-vv-scope="form-4" id="Form4">
                                    <div class="text-right ">
                                        <span>لیست نویسندگان:</span><br>
                                        <i v-show="errors.has('form-4.isresponsible')||form.errors.has('isresponsible')||form.errors.has('authors')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show="errors.has('form-4.isresponsible')" class="red d-inline-block">{{ errors.first('form-4.isresponsible') }}</span>
                                        <span v-show="form.errors.has('isresponsible')" class="red d-inline-block">{{ form.errors.get('isresponsible') }}</span>
                                        <span v-show="form.errors.has('authors')" class="red d-inline-block">{{ form.errors.get('authors') }}</span>

                                    </div>
                                    <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">نام و نام خانوادگی</th>
                                            <th scope="col">آدرس</th>
                                            <th scope="col"> نویسنده مسئول<i class="red mx-1">*</i></th>
                                            <th scope="col"> حذف</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(author, index) of form.authors">
                                            <th scope="row">{{index+1 | faDigit}}</th>
                                            <td>{{author}}</td>
                                            <td>{{form.affiliations[index]}}</td>
                                            <td><label class="radio"> </label>
                                                <p-radio v-validate="'required'" v-model="form.isresponsible"
                                                         name="isresponsible" :value="index" type="radio" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                                    <i slot="extra" class="icon far fa-check"></i>
                                                </p-radio>

                                            </td>
                                            <td>
                                                <a class="" @click="removeAuthor(index)"><i class=" red far fa-user-times fa-fw"></i> </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div id="authorsContainer">
                                        <div class="form-group mb-3 mt-5  text-right">
                                            <label class="blue ">نام و نام خانواگی نویسنده<i class="red mx-1">*</i>:</label>
                                            <input  type="text" name="author"
                                                    :placeholder="'نام و نام خانواگی نویسنده'"
                                                    class="form-control" v-model="author" >
                                        </div>
                                        <div class="form-group mt-1 mb-3 text-right">
                                            <label class="blue ">آدرس یا Affiliation نویسنده<i class="red mx-1">*</i>:</label>
                                            <input  type="text" name="author"
                                                    :placeholder="'آدرس یا Affiliation نویسنده'"
                                                    class="form-control" v-model="affiliation"  >
                                        </div>
                                        <button @click="addAuthor" class="btn btn-block btn-info mb-5"><i class="fas fa-user-plus fa-fw"></i> افزودن نویسنده</button>
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
                                <thead>
                                <td class="align-middle text-center">شماره بند</td>
                                <td class="align-middle text-center" colspan="1">موضوعات</td>
                                <td class="align-middle text-center" colspan="1">حداکثرامتیاز در واحد کار یا نیم سال</td>
                                <td class="align-middle text-center" colspan="1">حداکثر امتیاز در هر موضوع</td>
                                <td class="align-middle text-center" colspan="1">حداقل امتیاز لازم در هر دوره ارتقاء</td>
                                </thead>
                                <tr>
                                    <td class="align-middle text-center"  rowspan="2">بند 16</td>
                                    <td width="40%" class="align-middle" rowspan="1">1. گزارش های علمی طرح های پژوهشی و فناوری خاتمه یافته در داخل موسسه با تایید معاون پژوهشی
                                    </td>
                                    <td class="align-middle  text-center">تا 2</td>
                                    <td class="align-middle  text-center" rowspan="1"> 6 </td>
                                    <td class="align-middle  text-center" rowspan="1"> - </td>
                                </tr>
                                <tr>
                                    <td width="40%" class="align-middle" rowspan="1">2. گزارش های علمی طرح های پژوهشی و فناوری با طرف قرارداد خارج از موسسه تایید شده نهاد سفارش دهنده، که تا حدامکان نکات زیر در نظر گرفته شود: <br>
                                        - استانی، منطقه ای، ملی یا بین المللی بودن موضوع طرح
                                        <br>
                                        - گزارش طرح های تحقیقاتی مشترک با دانشگاه ها و موسسه های علمی خارج از کشور تا 1/2 برار.
                                    </td>
                                    <td class="align-middle  text-center">تا 15</td>
                                    <td class="align-middle  text-center" rowspan="1"> - </td>
                                    <td class="align-middle  text-center" rowspan="1"> - </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        تبصره 1. ویژه اعضای هیات علمی موسسه های تحت نظارت وزارت علوم<br/>
                                        تبصره 2. طرح های که نتیجه مسئولیت اجرایی یا حقوقی باشد امتیازی تعلق نمی گیرد.
                                    </td>
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
        name: "projects",
        data(){
            return{
                filter:5,
                projects:{},
                project_types:[],
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
                author:'',
                affiliation:'',
                f:new FormData, // creates the new FormData object to store selected files data
                // form data of VForm data object witch will be used to fill and submit the form
                form: new Form({
                    title:'',
                    organization: '',
                    project_types_id: '',
                    council_aprovedate: '',
                    defense_date: '',
                    isresponsible:'',
                    budget:'',
                    authors:[],
                    affiliations:[],
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
            // push or add the author detail to form.authors array
            addAuthor () {
                if(this.author.trim() && this.affiliation.trim()){
                    this.form.authors.push(this.author);
                    this.form.affiliations.push(this.affiliation);
                    this.author = '';
                    this.affiliation = '';
                }
            },
            // validate the authors detail in last step
            authorValidation(){
                return this.$validator.validateAll('form-4').then(result => {
                    if (!result) {
                        this.errorSwal('باید مسئول طرح پژوهشی انتخاب شود!');
                        return false;
                    }
                    return true;
                });
            },
            projectValidation(){
                return this.$validator.validateAll('form').then(result => {
                    if (!result) {
                        this.errorSwal('اطلاعات طرح پژوهشی دارای خطا می باشد!');
                        return false;
                    }
                    return true;
                });
            },
            onComplete(){
                this.$Progress.start();
                let loader1 = Vue.$loading.show();
                this.form.busy;

                this.form.submit('post', '/api/project', {
                    // Transform form data to FormData
                    transformRequest: [function (data, headers) {
                        return objectToFormData(data)
                    }]
                }).then((response) => {
                    loader1.hide();
                    this.projects.unshift(response.data.data);
                    $('#addNew').modal('hide');
                    this.successToast('اطلاعات طرح پژوهشی جدید با موفقیت ثبت شد.');
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
            deleteProject(id){
                swal({
                    title: 'آیا از حذف طرح پژوهشی مورد نظر مطمئن هستید؟',
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
                        this.form.delete(`/api/project/${id}`).then(() => {
                            this.successSwal('طرح پژوهشی مورد نظر با موفقیت حذف شد.');
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
                    axios.get('/api/findProject?order=' + sortOrder + '&q=' + que +'&filter='+this.filter +'&page=' + page)
                        .then(response => {
                            loader1.hide();
                            this.allData = response.data;
                            this.projects = response.data.data;
                            this.total = response.data.meta.total;
                            this.numToShow = response.data.meta.per_page;
                            this.numStart = response.data.meta.from;
                            this.numTo = response.data.meta.to;
                        }).catch(error =>{
                        loader1.hide();
                    });
                } else {
                    axios.get('/api/project?order=' + sortOrder + '&page=' + page +'&filter='+this.filter)
                        .then(response => {
                            loader1.hide();
                            this.allData = response.data;
                            this.projects = response.data.data;
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
            getProjectRelation(){
                axios.get('/api/projectRelation')
                    .then(response => {
                        this.project_types = response.data.project_types;
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
            this.$parent.pageName = 'آرشیو طرح‌های پژوهشی و فناوری';
            this.$validator.localize('farsi', {
                messages: farsi.messages,
                attributes: {
                    title: 'عنوان طرح‌های پژوهشی',
                    organization: 'سازمان طرف قرارداد',
                    budget: 'بودجه طرح پژوهشی',
                    isresponsible: 'مسئول طرح پژوهشی',
                    project_types_id: 'نوع طرح پژوهشی و فناوری',
                    council_aprovedate: 'تاریخ تصویب شورای پژوهشی',
                    defense_date: 'تاریخ دفاع طرح پژوهشی',
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
            this.getProjectRelation();
            this.form.reset();
        },
        components: {
            Select2,
        }
    }
</script>

<style scoped>

</style>
