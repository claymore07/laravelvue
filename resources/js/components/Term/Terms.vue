<template>
    <div class="container-fluid">
        <div class="col-md-12 mt-3" v-if="$gate.isAdmin()">
            <div class="card card-4">
                <div class="card-header  " style="direction: rtl">
                    <div class="justify-content-around d-md-flex text-right">
                        <div class="col-md-5 m-3">
                            <h4 class=" text-right"> <i class="fal fa-calendar-edit ml-2"></i>فهرست ترم ها</h4>
                        </div>
                        <div class="col-md-3 mt-3">
                        </div>
                        <div class="col-md-3 mt-3">
                            <div class="d-md-inline-block float-md-left">
                                <button class="btn btn-success  ripple" @click="newModal"><i style="font-size: 16px" class="fal  fa-plus-square"></i> تعریف ترم</button>
                            </div>
                        </div>
                    </div><!-- /card-tools -->
                </div><!-- /.card-header -->
                <div class="card-body table-responsive p-0">

                    <table class="table table-hover text-right">
                        <tbody>
                        <tr>
                            <th>شماره</th>
                            <th @click="toggle()" :class="['sort-control', sortType]">شناسه</th>
                            <th>عنوان ترم</th>
                            <th >وضعیت</th>
                            <th >فعال سازی</th>
                            <th  >تاریخ شروع</th>
                            <th >تاریخ پایان</th>
                            <th>ابزارهای ویرایشی</th>
                        </tr>
                        <tr v-for="(term, index) in terms.data" :key="term.id">
                            <td>{{counter(index) | faDigit}}</td>
                            <td>{{counter(term.id) | faDigit}}</td>
                            <td>{{ term.name  }}</td>
                            <td v-if="term.status == '1'"><span class="green"><i class="fal fa-check ml-2"></i>فعال</span></td>
                            <td v-else><span class="red"><i class="fal fa-times ml-2"></i>غیر فعال</span></td>
                            <td>
                                <a class="btn   ripple " :class="[term.status == '1'?'disabled btn-secondary':'btn-success']"  href="#" @click="termActivate(term.id)" title="فعالسازی ترم">
                                    <i class="fa fa-check "></i>
                                </a>
                            </td>
                            <td>{{ term.starts_at | myDate  }}</td>
                            <td>{{ term.ends_at | myDate  }}</td>
                            <td>
                                <a href="#" @click="editModal(term)">
                                    <i class="fa fa-edit blue"></i>
                                </a>
                                <!--/
                                <a href="#" @click="deleteFaculty(term.id)">
                                    <i class="fa fa-trash red"></i>
                                </a>-->
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div><!-- card-body -->

                <div class="card-footer d-flex flex-row justify-content-md-center" style="min-height: 60px">
                    <pagination v-if="" :data="terms" @pagination-change-page="getTerms" :limit="1"
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
        </div><!-- /col-md-12 -->


        <div class="modal  fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="!editMode" id="exampleModalLabel"><i
                            class="fal fa-calendar-edit fa-fw"></i> تعریف ترم جدید</h5>
                        <h5 class="modal-title" v-else="editMode" id="exampleModalLabel"><i
                            class="fal fa-calendar-edit fa-fw"></i> ویرایش ترم  </h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? updateTerm():createTerm()" @keydown="form.onKeydown($event)" @change="form.onKeydown($event)" id="Form">
                        <div class="modal-body" >
                            <div class="form-row align-items-center">
                                <div class="col-auto my-1">
                                    <label class="blue" for="inlineFormCustomSelect">عنوان ترم:</label>
                                </div>
                                <div class="col-auto my-1">
                                    <select v-model="termTitle" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                        <option disabled selected>انتخاب عنوان</option>
                                        <option value="ترم اول">ترم اول</option>
                                        <option value="ترم دوم">ترم دوم</option>
                                        <option value="ترم تابستان">ترم تابستان</option>
                                        <option value="ترم ویژه">ترم ویژه</option>
                                    </select>
                                </div>
                                <div class="col-auto my-1">
                                    <input v-model="termName"  type="text"  name="name" placeholder="98-97"
                                            class="form-control"
                                            pattern="[^A-Za-z._+*/×]{1,30}"
                                            data-error-pattern-mismatch="عنوان ترم باید شامل سال شروع و پایان باشد!"
                                            required
                                            :class="{ 'is-invalid': form.errors.has('name') } " @input="() => {}">
                                </div>
                            </div>

                            <div class=" mt-4" style="direction: ltr; text-align: right"  >
                                <label class="blue text-right text-rtl">تاریخ شروع<i class="red mx-1">*</i>:</label>
                               <br> <span class="float-left font-16 "> {{form.starts_at | myDate}}</span>
                                <date-picker @change="removeError('starts_at')"  format="YYYY-MM-DD" :class="[(  form.errors.has('starts_at') ? 'is-invalid': ''  )]"  v-validate="'required'" name="starts_at" v-model="form.starts_at" locale="fa,en"></date-picker>
                                <div class="text-rtl">
                                    <i v-show=" form.errors.has('starts_at')" class="red far fa-exclamation-triangle"></i>
                                    <span v-show="form.errors.has('starts_at')" class="red d-inline-block text-rtl">{{ form.errors.get('starts_at') }}</span>
                                </div>
                            </div>
                            <div class=" mt-4" style="direction: ltr; text-align: right"  >
                                <label class="blue text-right text-rtl">تاریخ پایان<i class="red mx-1">*</i>:{{form.ends_at | myDate}}</label>
                                <br> <span class="float-left font-16 "> {{form.ends_at | myDate}}</span>
                                <date-picker @change="removeError('ends_at')"  format="YYYY-MM-DD" :class="[(  form.errors.has('ends_at') ? 'is-invalid': ''  )]"  v-validate="'required'" name="ends_at" v-model="form.ends_at" locale="fa,en"></date-picker>
                                <div class="text-rtl">
                                    <i v-show=" form.errors.has('ends_at')" class="red far fa-exclamation-triangle"></i>
                                    <span v-show="form.errors.has('ends_at')" class="red d-inline-block text-rtl">{{ form.errors.get('ends_at') }}</span>
                                </div>
                            </div>
                        </div><!-- modal-body -->
                        <div class="modal-footer">
                            <button :disabled="form.busy" v-if="!editMode" type="submit"   class="btn ripple  btn-lg btn-block btn-primary mx-3">ثبت اطلاعات</button>
                            <button :disabled="form.busy" v-else="editMode" type="submit"  class="btn ripple  btn-lg btn-block btn-success mx-3">بروزرسانی اطلاعات</button>
                            <button type="button" class="btn ripple  btn-danger btn-lg btn-block mt-0" data-dismiss="modal">لغو عملیات</button>
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
        name: "Terms",
        data(){
            return{
                terms:{},
                order: 1,       // order 1 for desc and 0  for asc
                total: 0,       // total number of papers
                numToShow: 0,   // number of papers shown in this page
                numStart: 0,    // starting row number
                numTo: 0,       // ending number
                editMode: false,        // checks if we want to edit or not
                termTitle:'',
                termName:'',
                activeForm: new Form({
                   id:'',
                }),
                form: new Form({
                    id:'',
                    name:'',
                    starts_at:'',
                    ends_at:'',
                })
            }
        },
        computed:{
            sortType() {
                return this.order === 1 ? 'ascending' : 'descending';
            },
        },
        methods:{
            termActivate(id){
                swal({
                    title: 'آیا از فعال سازی ترم مورد نظر مطمئن هستید؟',
                    text: "در هر دوره فقط یک ترم قعال خواهد بود",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله فعال می کنم',
                    cancelButtonText: 'لغو عملیات'
                }).then((result) => {
                    // send ajax request to server
                    if (result.value) {
                        this.activeForm.id =id;
                        this.activeForm.put('api/termActive/'+id)
                            .then(()=>{
                                Fire.$emit('AfterCreate');
                            }).catch(() => {
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                            this.$Progress.fail();
                        })
                    } else {
                        this.warningSwal('شما این عملیات را لغو کردید.');
                    }
                })
            },
            checkTermForm(){
                if(this.termName != "" && this.termTitle != "") {
                    if (this.form.starts_at != "" && this.form.ends_at != "") {
                        if (moment(this.form.starts_at).isBefore(this.form.ends_at)) {
                                return true;
                        } else {
                            this.errorSwal('تاریخ شروع باید از تاریخ پایان قبل تر باشد!');
                            return false;
                        }
                    } else {
                        this.errorSwal('تاریخ شروع و پایان باید مشخص باشد!');
                        return false;
                    }
                }else{
                    this.errorSwal('عنوان ترم و دوره آن الزامی است!');
                    return false;
                }
            },
            createTerm(){
                if (this.checkTermForm()){
                    this.form.name = this.termTitle+' '+ this.termName;
                        this.$Progress.start();
                        this.form.post('api/term')
                            .then(() => {
                            Fire.$emit('AfterCreate');
                            $('#addNew').modal('hide');
                            this.successToast('اطلاعات ترم با موفقیت ثبت شد.');
                            this.$Progress.finish();
                            this.form.reset();
                            this.termName='';
                            this.termTitle='';
                             })
                            .catch(() => {
                                this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                                this.$Progress.fail();
                            })
                    }

            },
            updateTerm(){
                if (this.checkTermForm()) {
                    this.form.name = this.termTitle + ' ' + this.termName;
                    this.$Progress.start();
                    this.form.put('api/term/'+this.form.id)
                        .then(() => {
                            Fire.$emit('AfterCreate');
                            $('#addNew').modal('hide');
                            this.successToast('اطلاعات ترم با موفقیت بروزرسانی شد.');
                            this.$Progress.finish();
                            this.form.reset();
                            this.termName='';
                            this.termTitle='';
                        })
                        .catch(() => {
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                            this.$Progress.fail();
                        })

                }
            },
            editModal(term){
                let title = term.name.split(' ');
                this.termTitle = title[0] +' '+ title[1] ;
                this.termName = title[2];
                this.form.fill(term);
                this.editMode = true;
                $('#addNew').modal('show');
            },
            newModal() {
                this.form.reset();
                this.editMode = false;
                $('#addNew').modal('show');
            },
            getTerms(page = 1) {
                let loader1 = Vue.$loading.show();
                let sortOrder = this.order === 1 ? 'asc' : 'desc';
                axios.get('api/term?order=' + sortOrder + '&page=' + page)
                    .then(response => {
                           loader1.hide();
                           this.terms = response.data.terms;
                           this.total = response.data.terms.total;
                           this.numToShow = response.data.terms.per_page;
                           this.numStart = response.data.terms.from;
                           this.numTo = response.data.terms.to;
                    }).catch(error =>{
                        loader1.hide() ;
                    });
            },
            counter(i) {
                return this.numStart + i;
            },
            toggle() {
                this.order *= -1;
                this.getTerms();
            },
            // remove field error from form.errors bag onChange
            removeError(field){
                this.form.errors.clear(field)
            },
        },
        created(){
            this.$parent.pageName = 'مدیریت ترم ها'
            Fire.$on('AfterCreate', () => {
                this.getTerms();
            });
            this.getTerms();
        },
        mounted(){

        },
        component:{

        }

    }
</script>

<style scoped>

</style>
