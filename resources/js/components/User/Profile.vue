<template>
    <div class="container">
        <div class="row ">
            <div class="col-md-12 mt-3">
                <div class="card card-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header text-white text-right" style="height: 250px;background: url('/img/photo1.png') center center;">
                        <h3 class="widget-user-username">پروفایل: <span v-if="form.hasProfile">{{form.Fname + ' ' + form.Lname}}</span> <span v-else>{{form.name}} پروفایل ناقص</span></h3>
                        <h5 v-if="this.form.type == 'admin'" class="widget-user-desc">مسئول سیستم</h5>
                        <h5 v-else-if="this.form.type == 'author'" class="widget-user-desc">کارشناس</h5>
                        <h5 v-else class="widget-user-desc">گاربر</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" :src="getProfilePhoto()" alt="User Avatar">
                    </div>
                    <div class="card-footer">
                         <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{3 | faDigit}}</h5>
                                    <span class="description-text">تعداد مقالات</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{0 | faDigit}}</h5>
                                    <span class="description-text">تایید شده</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">{{1 | faDigit}}</h5>
                                    <span class="description-text">دوره ها</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->



                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </div>

            <!-- tab -->

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills text-right" style="direction: rtl!important;">
                            <li class="nav-item order-1"><a class="nav-link" href="#timeline" data-toggle="tab">فعالیت ها</a></li>
                            <li class="nav-item order-0"><a class="nav-link active show" href="#settings" data-toggle="tab">تنظیمات</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Activity Tab -->
                            <div class="tab-pane text-right text-rtl" id="timeline">
                                <!-- The timeline -->
                                <ul class="timeline timeline-inverse">
                                    <!-- timeline time label -->
                                    <li class="time-label">
                                    <span class="bg-danger">
                                     10 بهمن 97
                                    </span>
                                    </li>
                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->
                                    <li>
                                        <i class="fa fa-envelope bg-primary"></i>

                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-clock-o"></i>  27 دقیقه پیش</span>

                                            <h3 class="timeline-header">مقاله شما توسط کارشناس پژوهشی بررسی شد.
                                            </h3>


                                        </div>
                                    </li>
                                    <!-- END timeline item -->
                                    <!-- timeline item -->
                                    <li>
                                        <i class="fa fa-user bg-info"></i>

                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-clock-o"></i>یک روز پیش</span>

                                            <h3 class="timeline-header no-border">شما مقاله خود با عنوان الگوریتم های رمزنگاری ... اصلاح کردید.
                                            </h3>
                                        </div>
                                    </li>
                                    <!-- END timeline item -->
                                    <!-- timeline item -->
                                    <li>
                                        <i class="fa fa-comments bg-warning"></i>

                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-clock-o"></i> دو روز پیش</span>

                                            <h3 class="timeline-header">شما مقاله خود را در سامانه ثبت کردید.
                                            </h3>


                                        </div>
                                    </li>
                                    <!-- END timeline item -->
                                    <!-- timeline time label -->

                                    <li>
                                        <i class="fa fa-clock-o bg-gray"></i>
                                    </li>
                                </ul>
                            </div><!-- /END timeline tab -->
                            <!-- Setting Tab -->
                            <div class="tab-pane active show" id="settings">
                                <form class="form-horizontal" @submit.prevent="updateInfo" @keydown="form.onKeydown($event)" id="Form">
                                    <div class="form-group mt-4 text-right">
                                        <label class="blue">نام:</label>
                                        <input  type="text"  name="Fname" placeholder="نام"
                                               class="form-control" v-model="form.Fname"
                                               pattern="[^A-Za-z0-9.-_+*/×-]{1,30}"
                                               data-error-pattern-mismatch="نام باید فارسی باشد!"

                                               :class="{ 'is-invalid': form.errors.has('Fname') } " @input="() => {}">
                                        <has-error :form="form" field="Fname"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">نام خانوادگی:</label>
                                        <input  v-model="form.Lname"
                                               placeholder="نام خانوادگی"
                                               pattern="[^A-Za-z0-9.-_+*/×-]{1,30}"
                                               data-error-pattern-mismatch="نام خانوادگی باید فارسی باشد!"
                                               required
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('Lname') }">
                                        <has-error :form="form" field="Lname"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">نام کاربری:</label>
                                        <input v-model="form.name" type="text" name="name" placeholder="نام کاربری"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('name') }"
                                               pattern="[A-Za-z]{6,}"
                                               data-error-pattern-mismatch="نام کاربری باید به زبان انگلیسی به طول بیش از 6 کاراکتر باشد!"
                                               data-error-generic="این فیلد باید تکمیل شود."
                                               required>
                                        <has-error :form="form" field="name"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">رایان نامه:</label>
                                        <input v-model="form.email" type="email" name="email" placeholder="example@gmail.com"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('email') }"
                                               required >
                                        <has-error :form="form" field="email"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">کلمه عبور:</label>

                                        <input  v-model="form.password" type="password" name="password" placeholder="کلمه عبور ( حداقل 6 کاراکتر)"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('password') }"
                                        >
                                        <has-error :form="form" field="password"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">شماره سیبا:</label>
                                        <input v-model="form.siba" type="text" maxlength="13" name="siba"id="siba" placeholder="0000000000000"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('siba') }"
                                               pattern="[0-9]{13}"
                                               data-error-pattern-mismatch="شماره حساب سیبا باید عدد و بطول 13 باشد!"
                                               required>
                                        <has-error :form="form" field="siba"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">نشماره موبایل:</label>
                                        <input v-model="form.phone" type="tel" maxlength="11" name="phone"id="phone" placeholder="09111111111"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }"
                                               pattern="[0-9]{11}"
                                               data-error-pattern-mismatch="شماره موبایل باید عدد و بطول 11 باشد!"
                                               required>
                                        <has-error :form="form" field="phone"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">شماره پرسنلی:</label>
                                        <input  v-model="form.personal_id" type="text" name="personal_id" placeholder="111"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('personal_id') }"
                                               pattern="[0-9]{3,12}"
                                               data-error-pattern-mismatch="شماره پرسنلی باید عدد و حداقل به طول 3  باشد!"
                                               required>
                                        <has-error :form="form" field="personal_id"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">خلاصه بیوگرافی:</label>
                                        <textarea v-model="form.bio" name="bio" id="bio"
                                                  placeholder="خلاصه بیوگرافی:"
                                                  class="form-control"
                                                  :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                                        <has-error :form="form" field="bio"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right d-none">
                                        <label class="blue">نوع دسترسی به سامانه:</label>
                                        <select name="type" v-model="form.type" id="type" class="form-control test1"
                                                :class="{ 'is-invalid': form.errors.has('type') }">
                                            <option selected disabled value="">نوع دسترسی به سامانه</option>
                                            <option value="admin">Admin</option>
                                            <option value="user">Standard User</option>
                                            <option value="author">Author</option>
                                        </select>
                                        <has-error :form="form" field="type"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">آخرین مدرک تحصیلی:</label>
                                        <Select2 class="form-control select2-form-control"
                                                 :class="{ 'is-invalid': form.errors.has('degree_id') }" v-model="form.degree_id"
                                                 :options="degrees"
                                                 @change="removeError('degree_id')"
                                                 :settings="{theme: 'bootstrap4', placeholder: 'آخرین مدرک تحصیلی', width: '100%' }">
                                        </Select2>
                                        <has-error :form="form" field="degree_id"></has-error>
                                    </div>
                                    <div class="form-group my-5  text-right">
                                        <label class="blue">مرتبه علمی:</label>
                                        <Select2 class="form-control select2-form-control"
                                                 :class="{ 'is-invalid': form.errors.has('rank_id') }" v-model="form.rank_id"
                                                 :options="ranks"
                                                 @change="removeError('rank_id')"
                                                 :settings="{theme: 'bootstrap4', placeholder: 'مرتبه علمی', width: '100%' }">
                                        </Select2>
                                        <has-error :form="form" field="rank_id"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">نوع عضویت در باشگاه پژوهشگران:</label>
                                        <Select2 class="form-control select2-form-control" id="member_id"
                                                 :class="{ 'is-invalid': form.errors.has('member_id') }" v-model="form.member_id"
                                                 :options="members"
                                                 @change="removeError('member_id')"
                                                 :settings="{theme: 'bootstrap4', placeholder: 'نوع عضویت در باشگاه پژوهشگران', width: '100%' }">
                                        </Select2>
                                        <has-error :form="form" field="member_id"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">گروه آموزشی:</label>
                                        <Select2 class="form-control select2-form-control" id="department_id"
                                                 :class="{ 'is-invalid': form.errors.has('department_id') }"
                                                 v-model="form.department_id"
                                                 :options="departments"
                                                 @change="removeError('department_id')"
                                                 :settings="{theme: 'bootstrap4', placeholder: 'گروه آموزشی', width: '100%' }">
                                        </Select2>
                                        <has-error :form="form" field="department_id"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">نام دانشکده:</label>
                                        <Select2 class="form-control select2-form-control" id="faculty_id"
                                                 :class="{ 'is-invalid': form.errors.has('faculty_id') }" v-model="form.faculty_id"
                                                 :options="faculties"
                                                 @change="removeError('faculty_id')"
                                                 :settings="{theme: 'bootstrap4', placeholder: 'نام دانشکده', width: '100%' }">
                                        </Select2>
                                        <has-error :form="form" field="faculty_id"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">نوع همکاری با دانشگاه:</label>
                                        <Select2 @change="baseToggle(), removeError('position_id')" class="form-control select2-form-control" id="position_id"
                                                 :class="{ 'is-invalid': form.errors.has('position_id') }" v-model="form.position_id"
                                                 :options="positions"
                                                 :settings="{theme: 'bootstrap4', placeholder: 'نوع همکاری با دانشگاه', width: '100%' }">
                                        </Select2>
                                        <has-error :form="form" field="position_id"></has-error>
                                    </div>
                                    <div v-if="baseMode" class="form-group my-5 text-right">
                                        <label class="blue">پایه:</label>
                                        <input v-model="form.base" :class="{ 'is-invalid': form.errors.has('base') }"
                                               style="direction: rtl; text-align: right !important;"
                                               class="form-control text-ltr text-left addon" id="base1" placeholder="1"
                                               pattern="[0-9]{1,2}"
                                               data-error-pattern-mismatch="شماره پرسنلی باید عدد و حداقل به طول 3  باشد!"
                                                min="1"
                                               required name="base" type="number">
                                        <has-error :form="form" field="base"></has-error>
                                    </div>


                                    <div class="custom-file">
                                        <input @change="updateProfile" name="photo" type="file" class="custom-file-input" id="customFile" data-browse="Bestand kiezen">
                                        <label v-if="photoName === ''" class="custom-file-label"  for="customFile">انتخاب فایل تصویر</label>
                                        <label v-else class="custom-file-label"  for="customFile">{{photoName}}</label>
                                    </div>

                                    <div class="form-group mt-5">

                                            <button :disabled="form.busy" type="submit" class="btn  ripple btn-lg btn-block btn-success">برروزرسانی</button>

                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- end tabs -->
        </div>
    </div>
</template>


<script>
    import Select2 from 'v-select2-component';
    export default {
        name: "Profile",
        data() {
            return {
                baseMode: true,         // checks if پایه or base required for use based on their position
                degrees: [],            // degrees array
                ranks: [],              // array of ranks or رتبه علمی
                members: [],            // array of نوع عضویت در باشگاه پژوهشگران
                departments: [],        // array of گروه های آموزشی
                faculties: [],          // array of دانشکده ها
                positions: [],          // array of نوع همکاری با دانشگاه
                photoName:'',           // user profile photo name
                form: new Form({
                    hasProfile: true,
                    id: '',
                    name: '',
                    Fname: '',
                    Lname: '',
                    email: '',
                    type: '',
                    bio: '',
                    photo: '',
                    password: '',
                    siba: '',
                    phone: '',
                    personal_id: '',
                    degree_id: '',
                    rank_id: '',
                    member_id: '',
                    position_id: '',
                    faculty_id: '',
                    department_id: '',
                    base: ''
                }),
            }
        },
        mounted() {
            $('#Form').html5cvm({
                generic: 'این گزینه باید تکمیل شود!',
                typeMismatch: "نوع داده ورودی همخوانی ندارد."
            });
        },
        methods:{
            // remove field error from form.errors bag onChange
            removeError(field){
                this.form.errors.clear(field)
            },
            // shows or hides the پایه or base input based on the user position
            baseToggle() {
                if (this.form.position_id == 1 || this.form.position_id == 2 || this.form.position_id == 3) {
                    this.baseMode = true;
                } else {
                    this.baseMode = false;
                    this.form.base = 0;
                }
              //  console.log(this.baseMode);
            },
            farsiTypeInputSetter(e, field) {
                switch (field) {
                    case 'Fname':
                        this.form.Fname = e;
                        break;
                    case 'Lname':
                        this.form.Lname = e;
                        break;
                }
            },
            // loads the user profile photo if there is any or default photo
            getProfilePhoto(){
                let photo = (this.form.photo.length > 200) ? this.form.photo : "img/profile/"+ this.form.photo ;
                return photo;
            },
            // gets the necessary data to initialize user forms
            getProfileRation(){
                axios.get('/api/profileRelation')
                    .then(response => {
                        this.degrees = response.data.degrees;
                        this.ranks = response.data.ranks;
                        this.members = response.data.members;
                        this.departments = response.data.departments;
                        this.faculties = response.data.faculties;
                        this.positions = response.data.positions;
                    })
                    .catch((e)=>{
                           // console.log(e);
                        }
                    );
            },
            // handles the user form when submited
            updateInfo(){
                this.$Progress.start();
                if(this.form.password == ''){
                    this.form.password = undefined;
                }
                this.form.put('/api/profile/')
                    .then(()=>{
                        Fire.$emit('AfterCreate');
                        this.successToast('پروفایل شما با موفقیت بروزرسانی شد.')
                        this.$Progress.finish();
                    })
                    .catch(()=>{
                        this.$Progress.fail();
                    });
            },
            // handles the user profile upload form when submited
            updateProfile(e){

                let file = e.target.files[0];
                this.photoName = file.name;
                let reader = new FileReader();
                let limit = 1024 * 1024 * 2;
                if(file['size'] > limit){
                    this.errorSwal('حداکثر حجم مجاز 2Mb  می باشد.')
                    return false;
                }
                reader.onloadend = (file) => {
                    this.form.photo = reader.result;
                };

                reader.readAsDataURL(file);
            },
            // perpare user edit form // the @param user data
            fillForm(user) {
                this.baseMode = true;
                this.form.reset();
                if (user.profile) {
                    user.base = user.profile.base;
                    user.degree_id = user.profile.degree_id;
                    user.rank_id = user.profile.rank_id;
                    user.member_id = user.profile.member_id;
                    user.department_id = user.profile.department_id;
                    user.faculty_id = user.profile.faculty_id;
                    user.position_id = user.profile.position_id;
                    user.Fname = user.profile.Fname;
                    user.Lname = user.profile.Lname;
                    user.siba = user.profile.siba;
                    user.phone = user.profile.phone;
                    user.personal_id = user.profile.personal_id;
                    user.hasProfile = true;
                    if (user.position_id == 1 || user.position_id == 2 || user.position_id == 3) {
                        this.baseMode = true;
                    } else {
                        this.baseMode = false;
                        this.form.base = 0;
                    }
                } else {
                    user.hasProfile = false;
                }
                this.form.fill(user);
            },
        },
        created(){
            this.$parent.pageName = 'پروفایل شما';
            this.getProfileRation();
            axios.get("/api/profile")
                .then((response)=>{
                    this.fillForm(response.data.user)
                });
            Fire.$on('AfterCreate',() => {
                axios.get("/api/profile").then((response)=>{
                    this.fillForm(response.data.user)
                });
            });
        },
        components: {
            Select2,
        }
    }
</script>

<style scoped>

</style>
