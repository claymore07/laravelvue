<template>
    <div>

        <div class="container-fluid">
            <div class="col-md-12 mt-3" v-if="$gate.isAdminOrUser">
                <div class="card card-4">
                    <div class="card-header  " style="direction: rtl">
                        <div class="row justify-content-between  text-right">
                            <div class="col-xl-4 m-3">
                                <h4 class=" text-right"><i class="fal  fa-shield-check fa-fw"></i> آرشیو مجلات بلک لیست</h4>
                            </div>
                            <div class="col-xl-4  " >
                                <button class="btn btn-block-only btn-success ripple mt-3 mx-xl-2 float-left" @click="newModal"> <i style="font-size: 16px" class="fal fa-file-plus"></i> افزودن مجله</button>
                            </div>

                        </div><!-- /card-tools -->


                    </div><!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <div class="row justify-content-center no-gutters">
                            <div class="col-lg-7 mt-3  mr-2 mb-5">

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
                        </div>

                        <table class="table table-hover text-right">
                            <tbody>
                            <tr>
                                <th>شماره</th>
                                <th>عنوان مجله</th>
                                <th>ISSN</th>
                                <th>نمایه</th>
                                <th>آدرس اصلی</th>
                                <th>آدرس جعلی</th>
                                <th @click="toggle()" :class="['sort-control', sortType]">تاریخ ثبت</th>
                                <th>ابزارهای ویرایشی</th>
                            </tr>
                            <tr v-if="blacklists.length <= 0">
                                <td colspan="7"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                            </tr>
                            <tr v-for="(blacklist, index) in blacklists" :key="blacklist.id">
                                <td>{{counter(index) | faDigit}}</td>
                                <td>{{ blacklist.title | truncate(40) }}</td>
                                <td>{{ blacklist.issn }}</td>


                                <td>{{ blacklist.indexing  }}</td>
                                <td><a :href="blacklist.url" target="_blank" class="btn btn-sm btn-success">مشاهده</a></td>
                                <td><a :href="blacklist.fake" target="_blank" class="btn btn-sm btn-warning">مشاهده</a></td>

                                <td>{{ blacklist.created_at | myDate  }}</td>
                                <td>

                                    <a href="#" @click="deleteBlacklist(blacklist.id)">
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
                                class="fas fa-shield-check fa-fw"></i>ورود اطلاعات مجلات بلک لیست</h5>

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
                            <h2 slot="title">تکمیل اطلاعات مجلات بلک لیست</h2>
                            <!--  -->
                            <tab-content title="اطلاعات جزوه یا اسلاید" :before-change="blacklistValidation"  icon="far fa-shield-check">
                                <form @submit.prevent="createBlackList()" @keydown="form.onKeydown($event)"  data-vv-scope="form" @change="form.onKeydown($event)" id="Form">

                                    <div class="modal-body">

                                        <div class="form-group my-3 text-right">
                                            <label class="blue text-right">فایل های ضمیمه:<i class="red mx-1">*</i>:</label>
                                            <span class="red"><br/>
                                                       فایل مجلات بلک لیست باید بصورت xls یا xlsx باشد.
                                                    </span>
                                        </div>

                                        <div class="custom-file text-ltr text-right mb-5">
                                            <input @change="fieldChange"  v-validate="'required|ext:xls,xlsx|size:7000'" name="file"  type="file" class="custom-file-input" id="customFile" >
                                            <label  class="custom-file-label"   for="customFile">انتخاب فایل های ضمیمه</label>
                                            <span class="badge badge-info my-2 mx-2" style="font-size: 14px; color: #ffffff; background-color: #17a2b8;"
                                                  v-for="item in fileName">{{item}}</span>
                                            <has-error :form="form" field="file"></has-error>
                                            <div class="text-rtl">
                                                <i v-show="errors.has('form.file')|| form.errors.has('file')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form.file') " class="red d-inline-block">{{ errors.first('form.file') }}</span>
                                                <span v-show="form.errors.has('file')" class="red d-inline-block">{{ form.errors.get('file') }}</span>
                                            </div>
                                        </div>


                                    </div>

                                </form>
                            </tab-content>
                        </form-wizard>
                    </div>
                </div>
            </div><!-- /modal -->

        </div><!-- /container-fluid -->
    </div>
</template>

<script>
    import farsi from 'vee-validate/dist/locale/fa';
    export default {
        name: "BlackLists",
        data(){
            return{
                allData :{},
                blacklists :{},
                search: '',     // search term
                order: 1,       // order 1 for desc and 0  for asc
                total: 0,       // total number of papers
                numToShow: 0,   // number of papers shown in this page
                numStart: 0,    // starting row number
                numTo: 0,       // ending number
                searchResult: false,
                fileName:[],    // For UI rendering and displaying the choosen file Names

                f:new FormData, // creates the new FormData object to store selected files data
                // form data of VForm data object witch will be used to fill and submit the form
                form: new Form({

                    file:'',
                }),
            }
        },
        methods: {
            removeError(field) {
                this.form.errors.clear(field)
            },
            counter(i) {
                return this.numStart + i;
            },
            toggle() {
                this.order *= -1;
                this.getResults();
            },
            searchit() {
                this.$parent.searchit();
            },
            newModal() {
                $('#addNew').modal('show');
                $('#addNew').on('shown.bs.modal', function () {
                    $(this).find('[autofocus]').focus();
                });
            },
            blacklistValidation(){

                return this.$validator.validateAll('form').then(result => {
                    if (!result) {
                        this.errorSwal('اطلاعات جزوه یا اسلاید دارای خطا می باشد!');
                        return false;
                    }
                    return true;
                });
            },
            onComplete() {
                this.$Progress.start();
                let loader1 = Vue.$loading.show();
                this.form.busy;

                this.form.submit('post', '/api/blacklistimport', {
                    // Transform form data to FormData
                    transformRequest: [function (data, headers) {
                        return objectToFormData(data)
                    }]
                }).then((response) => {
                    loader1.hide();
                    this.getResults();
                    $('#addNew').modal('hide');
                    this.successToast('اطلاعات مجلات بلک لیست جدید با موفقیت ثبت شد.');
                    this.$Progress.finish();
                    this.resetFormWizard();
                })
                    .catch((e) => {
                        loader1.hide();
                        /*let t = Object.keys(this.form.errors.all()).filter(function (key) {
                            return /^files./.test(key);
                        });

                        if (!t.length) {
                        } else {
                            this.form.errors.set('file', 'نوع فایل باید یکی از انواع xls  یا xlsx باشد.')
                        }
*/

                        this.$Progress.fail();
                    })

            },
            fieldChange(e){
                let selectedFiles=e.target.files;
                this.form.file = [];
                this.fileName = [];
                this.form.file = selectedFiles[0];
                this.fileName.push(selectedFiles[0].name);

            },
            resetErrors() {
                this.$validator.reset();
            },
            resetFormWizard() {
                this.fileName = [];
                this.form.reset();
                this.$refs.wizard.reset();
            },
            deleteBlacklist(id) {
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
                        this.form.delete(`/api/blacklist/${id}`).then(() => {
                            this.successSwal('مجله مورد نظر با موفقیت حذف شد.');
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
                    axios.get('/api/findBlackList?order=' + sortOrder + '&q=' + que + '&page=' + page)
                        .then(response => {
                            loader1.hide();
                            this.allData = response.data;
                            this.blacklists = response.data.data;
                            this.total = response.data.meta.total;
                            this.numToShow = response.data.meta.per_page;
                            this.numStart = response.data.meta.from;
                            this.numTo = response.data.meta.to;
                        }).catch(error => {
                        loader1.hide();
                    });
                } else {
                    axios.get('/api/blacklist?order=' + sortOrder + '&page=' + page)
                        .then(response => {
                            loader1.hide();
                            this.allData = response.data;
                            this.blacklists = response.data.data;
                            this.total = response.data.meta.total;
                            this.numToShow = response.data.meta.per_page;
                            this.numStart = response.data.meta.from;
                            this.numTo = response.data.meta.to;
                        }).catch(error => {
                        loader1.hide();
                    });
                }
            },
            createBlackList(){}
        },
            computed:{
                sortType() {
                    return this.order === 1 ? 'ascending' : 'descending';
                }
            },
            created(){
                this.$parent.pageName = 'آرشیو مجلات بلک لیست';
                this.$validator.localize('farsi', {
                    messages: farsi.messages,
                    attributes: {

                        file: 'فایل ضمیمه',

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
                this.form.reset();
            },

    }
</script>

<style scoped>

</style>
