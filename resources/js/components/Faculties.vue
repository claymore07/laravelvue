<template>
    <div class="container-fluid">
        <div class="col-md-12 mt-3" v-if="$gate.isAdmin()">
            <div class="card">
                <div class="card-header  " style="direction: rtl">
                    <div class="justify-content-around d-lg-flex text-right">
                        <div class="col-lg-4 m-3">
                            <h4 class=" text-right"> <i class="fal fa-university ml-2"></i>فهرست دانشکده ها</h4>
                        </div>
                        <div class="col-lg-5 mt-3">

                            <div class="input-group  ">
                              <input class="form-control"  type="search" placeholder="جستجو..." aria-label="جستجو"
                                     v-model="search" @keyup="searchit()" >
                                <div class="input-group-append">
                                    <button class="btn btn-navbar"  type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3  mt-3" >
                            <div class="d-xl-inline-block float-xl-left">
                                <button class="btn btn-success" @click="newModal"><i style="font-size: 16px" class="fal  fa-plus-square"></i> افزودن دانشکده</button>
                            </div>
                        </div>
                    </div><!-- /card-tools -->


                </div><!-- /.card-header -->
                <div class="card-body table-responsive p-0">

                    <table class="table table-hover text-right">
                        <tbody>
                        <tr>
                            <th>شماره</th>
                            <th>نام دانشکده</th>
                            <th @click="toggle()" :class="['sort-control', sortType]">تاریخ ثبت</th>
                            <th>ابزارهای ویرایشی</th>
                        </tr>
                        <tr v-for="(faculty, index) in faculties.data" :key="faculty.id">
                            <td>{{counter(index) | faDigit}}</td>
                            <td>{{ faculty.name  }}</td>
                            <td>{{ faculty.created_at | myDate  }}</td>
                            <td>
                                <a href="#" @click="editModal(faculty)">
                                    <i class="fa fa-edit blue"></i>
                                </a>
                                /
                                <a href="#" @click="deleteFaculty(faculty.id)">
                                    <i class="fa fa-trash red"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div><!-- card-body -->
                <div class="card-footer d-flex flex-row justify-content-md-center" style="min-height: 60px">
                    <pagination v-if="" :data="faculties" @pagination-change-page="getFacutlites" :limit="1"
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
        </div>
        <div class="modal  fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="!editMode" id="exampleModalLabel"><i
                            class="fas fa-university fa-fw"></i> ایجاد دانشکده جدید</h5>
                        <h5 class="modal-title" v-else="editMode" id="exampleModalLabel"><i
                            class="fas fa-university fa-fw"></i> بروزرسانی دانشکده  </h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? updateFaculty():createFaculty()" @keydown="form.onKeydown($event)" @change="form.onKeydown($event)" id="Form">
                        <div class="modal-body" >
                            <div class="form-group mt-4 text-right">
                                <label class="blue">نام دانشکده:</label>
                                <input  type="text"  name="name" placeholder="نام دانشکده"
                                        class="form-control" v-model="form.name"

                                        pattern="[^A-Za-z0-9.-_+*/×-]{1,30}"
                                        data-error-pattern-mismatch="نام دانشکده باید فارسی باشد!"
                                        required
                                        :class="{ 'is-invalid': form.errors.has('name') } " @input="() => {}">
                                <i v-show=" form.errors.has('name')" class="red far fa-exclamation-triangle"></i>
                                <span v-show="form.errors.has('name')" class="red d-inline-block">{{ form.errors.get('name') }}</span>
                            </div>
                        </div><!-- modal-body -->
                        <div class="modal-footer">
                            <button :disabled="form.busy" v-if="!editMode" type="submit"   class="btn btn-lg btn-block btn-primary mx-3">ثبت اطلاعات</button>
                            <button :disabled="form.busy" v-else="editMode" type="submit"  class="btn btn-lg btn-block btn-success mx-3">بروزرسانی اطلاعات</button>
                            <button type="button" class="btn btn-danger btn-lg btn-block" data-dismiss="modal">لغو عملیات</button>
                        </div>
                    </form>
                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->
        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div><!-- /404 page -->
    </div>
</template>

<script>
    export default {
        name: "Faculties",
        data(){
            return{
                faculties:{},
                order: 1,       // order 1 for desc and 0  for asc
                total: 0,       // total number of papers
                numToShow: 0,   // number of papers shown in this page
                numStart: 0,    // starting row number
                numTo: 0,       // ending number
                editMode: false,        // checks if we want to edit or not
                searchResult: false,    // if there is search going on or not
                search:'',
                form: new Form({
                    id: '',
                    name:''
                }),
            }
        },
        computed:{
            sortType() {
                return this.order === 1 ? 'ascending' : 'descending';
            },
        },
        methods:{
            searchit(){
                this.$parent.searchit();
            },
            editModal(faculty) {
                this.editMode = true;
                this.form.reset();
                this.form.fill(faculty);
                $('#addNew').modal('show');
            },
            createFaculty(){
                this.$Progress.start();
                this.form.post('api/faculty')
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        this.successToast('اطلاعات دانشکده جدید با موفقیت ثبت شد.');
                        this.$Progress.finish();
                        this.form.reset();
                    })
                    .catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        this.$Progress.fail();
                    })
            },
            updateFaculty(){
                this.$Progress.start();
                this.form.put('api/faculty/' + this.form.id)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        this.successToast('برزوزسانی اطلاعات دانشکده با موفقیت انجام شد.');
                        this.$Progress.finish();
                    })
                    .catch((e) => {
                        this.$Progress.fail();
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                    })
            },
            deleteFaculty(id){
                swal({
                    title: 'آیا از حذف دانشکده مورد نظر مطمئن هستید؟',
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
                        this.form.delete('api/faculty/' + id).then(() => {
                            this.successSwal('دانشکده مورد نظر با موفقیت حذف شد.');
                            Fire.$emit('AfterCreate');
                        }).catch((e) => {
                            this.errorSwal('در لیست کاربران افرادی هستند که عضو این دانشکده می باشند. از این رو امکان حذف دانشکده مربوطه وجود ندارد!');
                        });
                    } else {
                        this.warningSwal('شما این عملیات را لغو کردید.');
                    }
                })
            },
            // loads bootstrap modal on click
            newModal() {
                this.form.reset();
                this.editMode = false;
                $('#addNew').modal('show');
            },
            getFacutlites(page = 1, que = '') {
                let sortOrder = this.order === 1 ? 'asc' : 'desc';
                if (this.searchResult) {        // if there is search going on this part will executed
                    que = this.search;
                    axios.get('api/findFaculty?order=' + sortOrder + '&q=' + que + '&page=' + page)
                        .then(response => {
                            this.faculties = response.data.faculties;
                            this.total = response.data.faculties.total;
                            this.numToShow = response.data.faculties.per_page;
                            this.numStart = response.data.faculties.from;
                            this.numTo = response.data.faculties.to;
                        });
                } else {
                    axios.get('api/faculty?order=' + sortOrder + '&page=' + page)
                        .then(response => {
                            this.faculties = response.data.faculties;
                            this.total = response.data.faculties.total;
                            this.numToShow = response.data.faculties.per_page;
                            this.numStart = response.data.faculties.from;
                            this.numTo = response.data.faculties.to;
                        });
                }
            },
            counter(i) {
                return this.numStart + i;
            },
            toggle() {
                this.order *= -1;
                this.getFacutlites();
            },
        },
        created(){
            this.$parent.pageName = 'فهرست دانشکده ها';
            Fire.$on('AfterCreate', () => {
                this.form.reset();
                this.getFacutlites();
            });
            Fire.$on('searching', () => {
                let page = 1;
                let query = this.search;
                this.searchResult = true;
                this.getFacutlites(page, query);
            });
            this.getFacutlites();
        },
        mounted() {
            $('#Form').html5cvm({
                generic: 'این گزینه باید تکمیل شود!',
                typeMismatch: "نوع داده ورودی همخوانی ندارد."
            });
        },
        component:{

        }

    }
</script>

<style scoped>

</style>
