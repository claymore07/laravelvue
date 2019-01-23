<template>
    <div class="container-fluid">
        <div class="col-md-12 mt-3" v-if="$gate.isAdmin()||$gate.isAuthor()">
            <div class="card">
                <div class="card-header justify-content-around d-flex " style="direction: rtl">
                    <div class="col">
                        <h3 class=" text-right">جدول کاربران</h3>
                    </div>
                    <div class="col w-50">
                        <div class="input-group input-group-sm">
                            <input v-model="search" @keyup="searchit()" class="w-75"   type="search" placeholder="جستجو..." aria-label="جستجو">
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
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-right">
                        <tbody>
                        <tr>
                            <th>شماره</th>
                            <th>شناسه</th>
                            <th>نام</th>
                            <th>رایان نامه</th>
                            <th>نوع دسترسی</th>
                            <th @click="toggle()" :class="['sort-control', sortType]">تاریخ ثبت نام</th>
                            <th>ابزارهای ویرایشی</th>
                        </tr>

                        <tr v-for="(user, index) in users.data" :key="user.id">
                            <td>{{counter(index) | faDigit}}</td>
                            <td>{{ user.id | faDigit}}</td>
                            <td v-if="user.profile" :class="{'blue': user.profile}">{{user.profile.Fname +' ' +
                                user.profile.Lname }}
                            </td>
                            <td v-else :class="{'red': !user.profile}">{{'پروفایل ناقص' }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.type | upText }}</td>
                            <td>{{ user.created_at | myDate }}</td>
                            <td>
                                <a href="#" @click="editModal(user)">
                                    <i class="fa fa-edit blue"></i>
                                </a>
                                /
                                <a href="#" @click="deleteUser(user.id)">
                                    <i class="fa fa-trash red"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div><!--- /card-body -->
                <!-- /.card-body -->
                <div class="card-footer d-flex flex-row justify-content-md-center" style="min-height: 60px">
                    <pagination v-if="" :data="users" @pagination-change-page="getResults" :limit="1"
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
            </div> <!-- /.card -->
        </div><!--- col-md-12 --->



        <!-- Modal -->
        <div  v-if="$gate.isAdmin()||$gate.isAuthor()" class="modal  fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="!editMode" id="exampleModalLabel"><i class="fas fa-user-plus fa-fw"></i> ایجاد کاربر جدید</h5>
                        <h5 class="modal-title" v-else="editMode" id="exampleModalLabel"><i  class="fas fa-user-cog fa-fw"></i> بروزرسانی کاربر: <span v-if="form.hasProfile">{{form.Fname + ' ' + form.Lname}}</span> <span v-else>{{form.name}} پروفایل ناقص</span> </h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? updateUser():createUser()" @keydown="form.onKeydown($event)" id="Form">

                   <div class="modal-body">
                       <div class="form-group mt-4 text-right">
                           <label class="blue">نام:</label>
                           <input lang="fa-IR" type="text"  name="Fname" placeholder="نام"
                                  class="form-control" v-model.lazy="form.Fname"
                                  @keyup="farsiTypeInputSetter($event.target.value, 'Fname')"
                                  pattern="[^A-Za-z0-9.-_+*/×-]{1,30}"
                                  data-error-pattern-mismatch="نام باید فارسی باشد!"

                                  :class="{ 'is-invalid': form.errors.has('Fname') } " @input="() => {}">
                           <has-error :form="form" field="Fname"></has-error>
                       </div>
                       <div class="form-group my-5 text-right">
                           <label class="blue">نام خانوادگی:</label>
                           <input lang="fa-IR" v-model.lazy="form.Lname"
                                  @keyup="farsiTypeInputSetter($event.target.value, 'Lname')" type="text" name="Lname"
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
                           <input v-if="!editMode" v-model="form.password" type="password" name="password" placeholder="کلمه عبور ( حداقل 6 کاراکتر)"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('password') }"
                                  required>
                           <input v-if="editMode" v-model="form.password" type="password" name="password" placeholder="کلمه عبور ( حداقل 6 کاراکتر)"
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
                           <input @change="farsi()"  v-model.lazy="form.personal_id" type="text" name="personal_id" placeholder="111"
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
                       <div class="form-group my-5 text-right">
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
                                    :settings="{theme: 'bootstrap4', placeholder: 'آخرین مدرک تحصیلی', width: '100%' }">
                           </Select2>
                           <has-error :form="form" field="degree_id"></has-error>
                       </div>
                       <div class="form-group my-5  text-right">
                           <label class="blue">مرتبه علمی:</label>
                           <Select2 class="form-control select2-form-control"
                                    :class="{ 'is-invalid': form.errors.has('rank_id') }" v-model="form.rank_id"
                                    :options="ranks"
                                    :settings="{theme: 'bootstrap4', placeholder: 'مرتبه علمی', width: '100%' }">
                           </Select2>
                           <has-error :form="form" field="rank_id"></has-error>
                       </div>
                       <div class="form-group my-5 text-right">
                           <label class="blue">نوع عضویت در باشگاه پژوهشگران:</label>
                           <Select2 class="form-control select2-form-control" id="member_id"
                                    :class="{ 'is-invalid': form.errors.has('member_id') }" v-model="form.member_id"
                                    :options="members"
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
                                    :settings="{theme: 'bootstrap4', placeholder: 'گروه آموزشی', width: '100%' }">
                           </Select2>
                           <has-error :form="form" field="department_id"></has-error>
                       </div>
                       <div class="form-group my-5 text-right">
                           <label class="blue">نام دانشکده:</label>
                           <Select2 class="form-control select2-form-control" id="faculty_id"
                                    :class="{ 'is-invalid': form.errors.has('faculty_id') }" v-model="form.faculty_id"
                                    :options="faculties"
                                    :settings="{theme: 'bootstrap4', placeholder: 'نام دانشکده', width: '100%' }">
                           </Select2>
                           <has-error :form="form" field="faculty_id"></has-error>
                       </div>
                       <div class="form-group my-5 text-right">
                           <label class="blue">نوع همکاری با دانشگاه:</label>
                           <Select2 @change="baseToggle" class="form-control select2-form-control" id="position_id"
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

                                  required name="base" type="text">
                           <has-error :form="form" field="base"></has-error>
                       </div>
                  </div>
                    <div class="modal-footer">
                        <button :disabled="form.busy" v-if="!editMode" type="submit"   class="btn btn-lg btn-block btn-primary mx-3">ثبت اطلاعات</button>
                        <button :disabled="form.busy" v-else="editMode" type="submit"  class="btn btn-lg btn-block btn-success mx-3">بروزرسانی اطلاعات</button>
                        <button type="button" class="btn btn-danger btn-lg btn-block" data-dismiss="modal">لغو عملیات</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div v-if="!$gate.isAdmin()&&!$gate.isAuthor()">
            <not-found></not-found>
        </div><!-- /404 page -->
    </div><!-- /container-fluid -->

</template>


<script>

    import Select2 from 'v-select2-component';

    export default {
        name: "Users",
        data() {
            return {
                search: '',
                modalID: '',
                order: 1,
                total: 0,
                numToShow: 0,
                numStart: 0,
                numTo: 0,
                editMode: false,
                searchResult: false,
                baseMode: true,
                users: {},
                degrees: [],
                ranks: [],
                members: [],
                departments: [],
                faculties: [],
                positions: [],
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
                })
            }
        },
        methods: {
            searchit(){
                    this.$parent.searchit();
                },
            farsi(){
                this.form.personal_id = this.$options.filters.faDigit(this.form.personal_id)
            },
            toggle() {
                this.order *= -1;
                this.getResults();
            },
            baseToggle() {
                if (this.form.position_id == 1 || this.form.position_id == 2 || this.form.position_id == 3) {
                    this.baseMode = true;
                } else {
                    this.baseMode = false;
                    this.form.base = 0;
                }
                console.log(this.baseMode);
            },
            newModal() {
                this.form.reset();
                this.editMode = false;
                $('#addNew').modal('show');
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
            counter(i) {
                return this.numStart + i;
            },
            getProfileRation(){
                axios.get('api/profileRelation')
                    .then(response => {
                        this.degrees = response.data.degrees;
                        this.ranks = response.data.ranks;
                        this.members = response.data.members;
                        this.departments = response.data.departments;
                        this.faculties = response.data.faculties;
                        this.positions = response.data.positions;
                    })
                    .catch((e)=>{
                            console.log(e);
                        }
                    );
            },
            getResults(page = 1, que = '') {
                let sortOrder = this.order === 1 ? 'asc' : 'desc';
                if (this.searchResult) {
                    que = this.search;
                    axios.get('api/findUser?order=' + sortOrder + '&q=' + que + '&page=' + page)
                        .then(response => {
                            this.users = response.data.users;
                            this.total = response.data.users.total;
                            this.numToShow = response.data.users.per_page;
                            this.numStart = response.data.users.from;
                            this.numTo = response.data.users.to;
                        });
                } else {
                    axios.get('api/user?order=' + sortOrder + '&page=' + page)
                        .then(response => {
                            this.users = response.data.users;
                            this.total = response.data.users.total;
                            this.numToShow = response.data.users.per_page;
                            this.numStart = response.data.users.from;
                            this.numTo = response.data.users.to;
                        });
                }
            },
            editModal(user) {
                this.editMode = true;
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
                $('#addNew').modal('show');
            },
            updateUser() {
                this.$Progress.start();
                this.form.put('api/user/' + this.form.id)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast({
                            position: 'top-start',
                            type: 'success',
                            title: 'برزوزسانی کاربر با موفقیت انجام شد.'
                        });
                        this.$Progress.finish();
                    })
                    .catch((e) => {
                        this.$Progress.fail();
                        swal.fire({
                            title: 'خطا!',
                            text: 'خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!',
                            type: 'error',
                            focusConfirm: true,
                            confirmButtonText:
                                'متوجه شدم!',
                            confirmButtonAriaLabel: 'متوجه شدم!',
                        });
                    })
            },
            deleteUser(id) {
                swal({
                    title: 'آیا از حذف کاربر مورد نظر مطمئن هستید؟',
                    text: "این تغییر قابل بازگشت نخواهد بود",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله پاک می کنم',
                    cancelButtonText: 'لغو عملیات'
                }).then((result) => {
                    // send ajax request to server
                    if (result.value) {
                        this.form.delete('api/user/' + id).then(() => {
                            swal(
                                'Deleted!',
                                'کاربر مورد نظر با موفقیت حذف شد.',
                                'success'
                            );
                            Fire.$emit('AfterCreate');
                        }).catch((e) => {
                            swal.fire({
                                title: 'خطا!',
                                text: 'خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!',
                                type: 'error',
                                focusConfirm: true,
                                confirmButtonText:
                                    'متوجه شدم!',
                                confirmButtonAriaLabel: 'متوجه شدم!',
                            });
                        });
                    } else {
                        swal.fire({
                            title: 'لفو شد!',
                            text: 'شما این عملیات را لغو کردید.',
                            type: 'warning',
                            focusConfirm: true,
                            confirmButtonText:
                                'متوجه شدم!',
                            confirmButtonAriaLabel: 'متوجه شدم!',
                        });
                    }
                })
            },
            createUser() {
                this.$Progress.start();
                this.form.busy;
                this.form.post('api/user')
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast({
                            type: 'success',
                            position: 'top-start',
                            title: 'User Created in successfully'
                        });
                        this.$Progress.finish();
                        this.form.reset();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },
        },
        computed: {
            sortType() {
                return this.order === 1 ? 'ascending' : 'descending';
            },
        },
        mounted() {
            this.modalID = $('#addNew');
            $('#Form').html5cvm({
                generic: 'این گزینه باید تکمیل شود!',
                typeMismatch: "نوع داده ورودی همخوانی ندارد."
            });
            $('#siba').simpleMask({'mask': '#############'});
            $('#phone').simpleMask({'mask': '###########'});
            // $('#personal_id1').simpleMask( { 'mask': '####'     } );
        },
        created() {
            this.$parent.pageName = 'کاربران';
            if (this.$gate.isAdmin() || this.$gate.isAuthor()) {
                Fire.$on('searching', () => {
                    let page = 1;
                    let query = this.search;
                    this.searchResult = true;
                    this.getResults(page, query);
                });
                Fire.$on('AfterCreate', () => {
                    this.getResults();
                });
                this.getResults();
                this.getProfileRation();
            }
        },
        components: {
            Select2,
        }
    }
</script>

<style scoped>

</style>

