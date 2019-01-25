<template>
<div>

    <div class="container-fluid">
        <div class="col-md-12 mt-3" v-if="$gate.isAdmin()||$gate.isAuthor()">
            <div class="card">
                <div class="card-header justify-content-around d-flex " style="direction: rtl">
                    <div class="col">
                        <h3 class=" text-right">جدول کاربران</h3>
                    </div>
                    <div class="col w-50">
                        <div class="input-group input-group-sm">
                            <input class="w-75"   type="search" placeholder="جستجو..." aria-label="جستجو">
                            <!-- v-model="search" @keyup="searchit()" -->
                            <div class="input-group-append">
                                <button class="btn btn-navbar"  type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <button class="btn btn-success" @click="newModal"><i class="fas fa-user-plus fa-fw" ></i> افزودن کاربر جدید</button>
                    </div><!-- /card-tools -->
                </div><!-- /.card-header -->
                <div class="card-body">
                </div>
            </div>
        </div><!-- /col-md-12 --->

        <div  v-if="$gate.isAdmin()||$gate.isAuthor()" class="modal  fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i
                            class="fas fa-user-plus fa-fw"></i> ایجاد کاربر جدید</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                        <div class="modal-body" >
                            <form-wizard
                                back-button-text="مرحله قبل"
                                next-button-text="مرحله بعد"
                                finish-button-text="ثبت نهایی">
                                <h2 slot="title">تکمیل اطلاعات مقاله</h2>
                                <!--  -->
                                <tab-content title="انتخاب نوع مقاله" :before-change="chooseType">
                                    <div class="btns my-5" style="direction: ltr; text-align: left">
                                        <label class="order-0">
                                            <input v-model="paperType"  type="radio" name="papertype" value="enconf">
                                            <span class="btn"> کنفرانس لاتین</span>
                                            </input>
                                        </label>
                                        <label class="order-1">
                                            <input v-model="paperType"  type="radio" name="papertype" value="faconf">
                                            <span class="btn"> کنفرانس فارسی</span>
                                            </input>
                                        </label>
                                        <label class="order-2">
                                            <input v-model="paperType"  type="radio" name="papertype" value="enjur">
                                            <span class="btn">ژورنال لاتین</span>
                                            </input>
                                        </label>
                                        <label class="order-3">
                                            <input v-model="paperType" type="radio" name="papertype" checked value="fajur" required>
                                            <span class="btn">ژونال فارسی</span>
                                            </input>
                                        </label>
                                    </div>

                                    <label class="label" for="email">Email</label>
                                    <p :class="{ 'control': true }">
                                        <input v-validate="'required|email'" :class="{'input': true, 'is-danger': errors.has('email') }" name="email" type="text" placeholder="Email">
                                        <span v-show="errors.has('email')" class="help is-danger">{{ errors.first('email') }}</span>
                                    </p>
                                </tab-content>
                                <tab-content title="اطلاعات مقاله" :before-change="createPaper">
                                    <!--<keep-alive>
                                        <component :is="currentTabComponent" v-bind="{ 'form': form, 'excerpts': excerpts }"></component>
                                    </keep-alive>-->
                                    <form @submit.prevent="createPaper()" @keyup.enter="checkFunc"
                                          @keydown="form.onKeydown($event)" id="Form">

                                        <div class="form-group my-5 text-right">
                                            <label class="blue ">عنوان مقاله:</label>
                                            <input type="text" name="title"
                                                   placeholder="عنوان مقاله"
                                                   v-validate="'required'"
                                                   class="form-control" v-model="form.title"
                                                   :class="[( errors.has('title') || form.errors.has('title') ? 'is-invalid': ''  ), ((paperType === 'fajur' || paperType === 'faconf')?'text-right':'text-left') ]"
                                            >
                                            <i v-show="errors.has('title')" class="fa fa-warning"></i>
                                            <span v-show="errors.has('title')" class="invalid-feedback">{{ errors.first('title') }}</span>
                                            <has-error :form="form" field="title"></has-error>
                                        </div>
                                        <div class="form-group my-5 text-right">
                                            <label class="blue">شماره Doi:</label>
                                            <input type="text" name="doi" placeholder="Doi مقاله"
                                                   class="form-control" v-model="form.doi"
                                                   :class="[( errors.has('doi') || form.errors.has('doi') ? 'is-invalid': ''  )] "
                                            >
                                            <has-error :form="form" field="doi"></has-error>
                                        </div>
                                        <div class="form-group my-5 text-right">
                                            <label class="blue ">لینک مقاله:</label>
                                            <input type="text" name="link"
                                                   placeholder="لینک با در نظر گرفتن http://"
                                                   v-validate="'required'"
                                                   class="form-control text-ltr text-left" v-model="form.link"
                                                   :class="[( errors.has('link') || form.errors.has('link') ? 'is-invalid': ''  ) ]">
                                            <i v-show="errors.has('link')" class="fa fa-warning"></i>
                                            <span v-show="errors.has('link')" class="invalid-feedback">{{ errors.first('link') }}</span>
                                            <has-error :form="form" field="link"></has-error>
                                        </div>
                                        <div class="form-group my-5 text-right">
                                            <label class="blue">مستخرج از:</label>
                                            <Select2 v-validate="'required'" data-vv-name="excerpt_id"
                                                     class="form-control select2-form-control" id="excerpt_id"
                                                     :class="[( errors.has('excerpt_id') || form.errors.has('excerpt_id') ? 'is-invalid': ''  )]"
                                                     v-model="form.excerpt_id"
                                                     :options="excerpts"
                                                     :settings="{theme: 'bootstrap4', placeholder: 'نوع مستخرج از:', width: '100%' }">
                                            </Select2>

                                            <i v-show="errors.has('excerpt_id')" class="fa fa-warning"></i>
                                            <span v-show="errors.has('excerpt_id')" class="red d-block">{{ errors.first('excerpt_id') }}</span>
                                            <has-error :form="form" field="excerpt_id"></has-error>
                                        </div>
                                        <div v-if="form.excerpt_id === '3'">
                                            <div class="form-group mt-5 text-right">
                                                <label class="blue text-right">نوع مجوز</label>
                                            </div>
                                            <div class="form-group mb-5 text-right">
                                                <label class="radio">موظفی طرح: </label>
                                                <input v-model="form.license_to" name="license_to" value="0'"
                                                       type="radio">
                                                <label class="radio">مازاد موظفی:</label>
                                                <input v-validate="'required'" v-model="form.license_to"
                                                       name="license_to" value="1'" type="radio">
                                                <i v-show="errors.has('license_to')" class="fa fa-warning"></i>
                                                <span v-show="errors.has('license_to')" class="red d-block">{{ errors.first('license_to') }}</span>
                                            </div>
                                            <div class="form-group my-5 text-right">
                                                <label class="blue">توضیحات و شماره مجوز*</label>
                                                <label for="license" class="blue"></label>
                                                <input id="license" name="license" type="text"
                                                       v-model="form.license"
                                                       v-validate="'required'"
                                                       class="form-control  text-right text-rtl"
                                                       :class="[( errors.has('license') || form.errors.has('license') ? 'is-invalid': ''  )] ">
                                                <i v-show="errors.has('license')" class="fa fa-warning"></i>
                                                <span v-show="errors.has('license')" class="invalid-feedback">{{ errors.first('license') }}</span>
                                            </div>
                                        </div>
                                        <div class=" mt-5" style="direction: ltr; text-align: right"  >
                                             <label class="blue text-right">تاریخ چاپ</label>
                                            <date-picker  format="YYYY-M-D" :class="[( errors.has('publish_date') || form.errors.has('publish_date') ? 'is-invalid': ''  )]"  v-validate="'required'" name="publish_date" v-model="form.publish_date" locale="fa,en"></date-picker>
                                            <i v-show="errors.has('publish_date')" class="fa fa-warning"></i>
                                            <span v-show="errors.has('publish_date')"class="red d-block">{{ errors.first('publish_date') }}</span>
                                        </div>
                                        <div class=" mt-5" style="direction: ltr; text-align: right" >
                                            <label class="blue text-right">تاریخ پذیرش</label>
                                            <date-picker format="YYYY-M-D"  :class="[( errors.has('accept_date') || form.errors.has('accept_date') ? 'is-invalid': ''  )] " v-validate="'required'" name="accept_date" v-model="form.accept_date" locale="fa,en"></date-picker>
                                            <i v-show="errors.has('accept_date')" class="fa fa-warning"></i>
                                            <span v-show="errors.has('accept_date')" class="red d-block">{{ errors.first('accept_date') }}</span>
                                        </div>
                                        <div class="text-ltr text-right mt-5" >
                                            <label class="blue text-right">چکیده</label>
                                            <i v-show="errors.has('abstract')" class="fa fa-warning"></i>
                                            <span v-show="errors.has('abstract')" class="red d-block">{{ errors.first('abstract') }}</span>
                                        <tinymce :other_options="options" v-validate="'required'" name="abstract" v-model="form.abstract" id="d1"></tinymce>

                                        </div>
                                    </form>
                                </tab-content>
                                <tab-content title="ااطلاعات مجله"  icon="fa fa-user-plus">
                                    Yuhuuu! This seems pretty damn simple
                                </tab-content>
                                <tab-content title="اطلاعات نویسندگان"  icon="fa fa-user-plus">
                                    Yuhuuu! This seems pretty damn simple
                                </tab-content>
                            </form-wizard>

                        </div>

                </div>
            </div>
        </div>

    </div>
</div>
</template>

<script>
    import Select2 from 'v-select2-component';
    import farsi from 'vee-validate/dist/locale/fa';
    export default {
        name: "Papers",
        computed: {
            currentTabComponent: function () {
                return this.page
            }
        },
        data(){
            return{
                options: {
                    language_url: 'js/fa_IR.js', //This url points to location of persian language file.
                    toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat',
                    toolbar1: ' cut copy paste | ltr rtl | | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor',
                    plugins:['advlist autolink lists link image charmap print preview hr anchor pagebreak', 'searchreplace wordcount visualblocks visualchars code fullscreen', 'insertdatetime media nonbreaking save table contextmenu directionality','template paste textcolor colorpicker textpattern imagetools toc help emoticons hr codesample'],
                },
                excerpts:[],
                paperType:'',
                page:'',
                form: new Form({
                    lang:'',
                    title: '',
                    abstract: '',
                    doi:'',
                    link:'',
                    license:'',
                    license_to:'',
                    publish_date: '',
                    accept_date: '',
                    excerpt_id: '',

                })
            }
        },
        methods:{
            checkFunc(){
                this.$validator.localize('farsi', {
                    messages: farsi.messages,
                    attributes: {
                        title: 'عنوان',
                        license:'اطلاعات مجوز',
                        license_to:'نوع مجوز',
                        excerpt_id:'نوع مستخرج بودن '
                    }
                });
                this.$validator.validate();
                console.log(this.$validator.errors)

                console.log('sss');
            },
            newModal() {
                $('#addNew').modal('show');
            },
            getPaperRelation(){
                axios.get('api/paperRelation')
                    .then(response => {
                        this.excerpts = response.data.excerpts;
                    })
                    .catch((e)=>{
                            console.log(e);
                        }
                    );
            },
            chooseType(){

                  console.log('asd');
                  if(this.papertype === ''){
                      swal.fire({
                          title: 'خطا!',
                          text: 'باید نوع مقاله را انتخاب نمایید!',
                          type: 'error',
                          confirmButtonText:
                              'متوجه شدم!',
                      });
                      return false;
                  }else {
                      return true;
                  }

            },
            createPaper(){

               return this.form.post('api/user')
                    .then(() => {
                       // Fire.$emit('AfterCreate');
                        //$('#addNew').modal('hide');
                        toast({
                            type: 'success',
                            position: 'top-start',
                            title: 'User Created in successfully'
                        });
                       // this.$Progress.finish();
                        this.form.reset();

                        return true;
                    })
                    .catch(() => {
                       // this.$Progress.fail();
                        return true;
                    })
            },
            farsiTypeInputSetter(e) {
                console.log(e);
                this.form.fa_title = e;
            },
        },
        mounted() {

            $('#siba').simpleMask({'mask': '#############'});
            $('#phone').simpleMask({'mask': '###########'});
            // $('#personal_id1').simpleMask( { 'mask': '####'     } );
        },
        created(){
            this.$validator.localize('farsi', {
                messages: farsi.messages,
                attributes: {
                    title: 'عنوان',
                    license:'اطلاعات مجوز'
                }
            });
            this.getPaperRelation();
        },
        components: {
            Select2,
        }
    }
</script>

<style scoped>

</style>
