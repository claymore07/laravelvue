<template>
    <div class="container-fluid">
        <div class="col-md-12 mt-3" v-if="$gate.isAdmin()||$gate.isAuthor()">
            <div class="card">
                <div class="card-header  " style="direction: rtl">
                    <div class="justify-content-around d-lg-flex text-right">
                        <div class="col-lg-7 m-3">
                            <h4 class=" text-right"> <i class="fal fa-star ml-2"></i>فهرست عناوین شامل امتیاز</h4>
                        </div>
                        <div class="col-lg-5 mt-3">


                        </div>


                    </div><!-- /card-tools -->


                </div><!-- /.card-header -->
                <div class="card-body table-responsive p-0">

                    <table class="table table-hover text-right">
                        <tbody>
                        <tr>
                            <th>شماره</th>
                            <th>عنوان</th>

                            <th>ابزارهای ویرایشی</th>
                        </tr>
                        <tr>
                            <td> {{1|faDigit}}</td>
                            <td>  فهرست عناوین کنفرانسی</td>
                            <td>
                                <a class="mr-2" href="#"  @click="perpareConfTypeList">
                                    <i class="fa fa-edit blue"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{2|faDigit}}</td>
                            <td>  فهرست عناوین ژونالی</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="perpareJournalTypeList"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{3|faDigit}}</td>
                            <td>  فهرست عناوین کتب</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{4|faDigit}}</td>
                            <td>  فهرست عناوین جوایز و افتخارات</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue"></i>
                                </a>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div><!-- card-body -->
                <div class="card-footer d-flex flex-row justify-content-md-center" style="min-height: 60px">


                </div><!-- /card-footer --->
            </div>
        </div>
        <div class="modal  fade" id="confTypeListModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i
                            class="fas fa-building fa-fw"></i> فهرست عناوین کنفرانسی</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                        <div class="modal-body" >
                            <div class="text-right text-rtl">
                                <i v-show=" confTypeForm.errors.has('minscore')" class="red far fa-exclamation-triangle "></i>
                                <span v-show="confTypeForm.errors.has('minscore')" class="red d-inline-block ">{{ confTypeForm.errors.get('minscore') }}</span>
                            </div>
                            <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"> نوع کنفرانس</th>
                                    <th scope="col">کف امتیاز</th>
                                    <th scope="col">سقف امتیاز</th>
                                    <th></th>
                                    <th scope="col"> ویرایش</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(confType, index) of confTypeList">
                                    <th scope="row">{{index+1 | faDigit}}</th>
                                    <td><span>{{confType.name}}</span> </td>
                                    <td ><label  v-show="editOffset != index">{{confType.minscore | faDigits }}</label>
                                        <input :id = "'item-conftype-'+index" v-show="editOffset == index"  type="number" name="minscore"
                                               :placeholder="'کف امتیاز'"
                                               min="0"
                                               step="0.01"
                                               class="form-control"
                                               @keyup="removeError('minscore', 'conftype')"
                                               @keydown.enter.pervent=""
                                               :class="{ 'is-invalid': confTypeForm.errors.has('minscore') }"
                                               v-model.number="confTypeForm.minscore"
                                               >
                                    </td>
                                    <td>
                                        <label  v-show="editOffset != index">{{confType.maxscore | faDigits  }}</label>
                                        <input  v-show="editOffset == index"  type="number" name="maxscore"
                                               :placeholder="'سقف امتیاز'"
                                                min="0" step="0.01"
                                               class="form-control"
                                                @keyup="removeError('maxscore', 'conftype')"
                                                @keydown.enter.pervent=""
                                                :class="{ 'is-invalid': confTypeForm.errors.has('maxscore') }"
                                               v-model.number="confTypeForm.maxscore"

                                        >
                                    </td>
                                    <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateConfType(index)">ثبت تغییرات</button></td>
                                    <td>
                                        <a class="" @click="startEditing(index, confType.id, 'conftype')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div><!-- modal-body -->
                        <div class="modal-footer">

                        </div>

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->
        <div class="modal  fade" id="journalTypeListModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2"><i
                            class="fas fa-building fa-fw"></i> فهرست عناوین ژونالی</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                        <div class="modal-body" >
                            <div class="text-right text-rtl">
                                <i v-show=" jTypeForm.errors.has('minscore')" class="red far fa-exclamation-triangle "></i>
                                <span v-show="jTypeForm.errors.has('minscore')" class="red d-inline-block ">{{ jTypeForm.errors.get('minscore') }}</span>
                            </div>
                            <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"> نوع ژونال</th>
                                    <th scope="col">کف امتیاز</th>
                                    <th scope="col">سقف امتیاز</th>
                                    <th></th>
                                    <th scope="col"> ویرایش</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(jType, index) of journalTypeList">
                                    <th scope="row">{{index+1 | faDigit}}</th>
                                    <td><span>{{jType.name}}</span> </td>
                                    <td ><label  v-show="editOffset != index">{{jType.minscore | faDigits }}</label>
                                        <input :id = "'item-jType-'+index" v-show="editOffset == index"  type="number" name="minscore"
                                               :placeholder="'کف امتیاز'"
                                               min="0"
                                               step="0.01"
                                               class="form-control"
                                               @keyup="removeError('minscore', 'jType')"
                                               @keydown.enter.pervent=""
                                               :class="{ 'is-invalid': jTypeForm.errors.has('minscore') }"
                                               v-model.number="jTypeForm.minscore"
                                               >
                                    </td>
                                    <td>
                                        <label  v-show="editOffset != index">{{jType.maxscore | faDigits  }}</label>
                                        <input  v-show="editOffset == index"  type="number" name="maxscore"
                                               :placeholder="'سقف امتیاز'"
                                                min="0" step="0.01"
                                               class="form-control"
                                                @keyup="removeError('maxscore', 'jType')"
                                                @keydown.enter.pervent=""
                                                :class="{ 'is-invalid': jTypeForm.errors.has('maxscore') }"
                                               v-model.number="jTypeForm.maxscore"

                                        >
                                    </td>
                                    <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateJType(index)">ثبت تغییرات</button></td>
                                    <td>
                                        <a class="" @click="startEditing(index, jType.id, 'jType')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div><!-- modal-body -->
                        <div class="modal-footer">

                        </div>

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->
    </div>
</template>

<script>
    export default {
        name: "Scores",
        data(){
            return{

                confTypeList:{},
                journalTypeList:{},
                editOffset: -1,     // for managing author editing form status used if -1 the form will be hide
                confTypeForm: new Form({
                    id:'',
                    minscore:'',
                    maxscore:'',
                }),
                jTypeForm: new Form({
                    id:'',
                    minscore:'',
                    maxscore:'',
                }),
            }
        },
        methods:{
            nothing(){},
            perpareJournalTypeList(){
                let loader1 = Vue.$loading.show();
                axios.get('api/getJournalType').then((response)=>{
                    loader1.hide();
                    this.journalTypeList = response.data.journalTypeList;
                    this.editOffset = -1;
                    $('#journalTypeListModal').modal('show');
                }).catch(()=>{
                    loader1.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            perpareConfTypeList(){
                let loader = Vue.$loading.show();
                axios.get('api/getConfType').then((response)=>{
                    loader.hide();
                    this.confTypeList = response.data.confTypeList;
                    this.editOffset = -1;
                    $('#confTypeListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            // enables author editing form
            startEditing(index, id, type){
                this.editOffset = index;
                if(type == "conftype"){
                    this.confTypeForm.fill(this.confTypeList[index]);
                    this.$nextTick(function(){
                        document.getElementById('item-'+type+'-'+this.editOffset).focus()
                    }.bind(this));
                }else if(type == "jType"){
                    this.jTypeForm.fill(this.journalTypeList[index]);
                    this.$nextTick(function(){
                        document.getElementById('item-'+type+'-'+this.editOffset).focus()
                    }.bind(this));
                }
            },
            // closes the author editing form
            updateConfType(index) {
                if(this.isIntOrFloat(this.confTypeForm.minscore) && this.isIntOrFloat(this.confTypeForm.maxscore) ){
                    this.confTypeForm.minscore = this.confTypeForm.minscore.toFixed(2);
                    this.confTypeForm.maxscore = this.confTypeForm.maxscore.toFixed(2);
                    this.confTypeForm.put('api/updateConfType/' + this.confTypeForm.id)
                        .then((response) => {
                            this.confTypeList[index]['minscore'] = response.data.minscore;
                            this.confTypeList[index]['maxscore'] = response.data.maxscore;
                            this.confTypeForm.reset();
                            this.editOffset = -1;
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        this.confTypeForm.minscore = Number(this.confTypeForm.minscore);
                        this.confTypeForm.maxscore = Number(this.confTypeForm.maxscore);
                    });
                }else {
                    this.errorSwal('کف یا سقف امتیاز نمی تواند خالی باشد!')
                }
            },
            // closes the author editing form
            isIntOrFloat(n){
                return (Number(n) === n && n % 1 === 0) || (Number(n) === n && n % 1 !== 0);
            },
            updateJType(index) {
                if(this.isIntOrFloat(this.jTypeForm.minscore) && this.isIntOrFloat(this.jTypeForm.maxscore) > 0 ){
                    this.jTypeForm.minscore = this.jTypeForm.minscore.toFixed(2);
                    this.jTypeForm.maxscore = this.jTypeForm.maxscore.toFixed(2);
                    this.jTypeForm.put('api/updateJType/' + this.jTypeForm.id)
                        .then((response) => {
                            this.journalTypeList[index]['minscore'] = response.data.minscore;
                            this.journalTypeList[index]['maxscore'] = response.data.maxscore;
                            this.jTypeForm.reset();
                            this.editOffset = -1;
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        this.jTypeForm.minscore = Number(this.jTypeForm.minscore);
                        this.jTypeForm.maxscore = Number(this.jTypeForm.maxscore);
                    });
                }else {
                    this.errorSwal('کف یا سقف امتیاز نمی تواند خالی باشد!');
                }
            },
            removeError(field, type){
                console.log(type == "jType" , field,type)
                if(type == "conftype") {
                    this.confTypeForm.errors.clear(field)
                }else if(type == "jType"){
                    console.log('sssss')
                    this.jTypeForm.errors.clear(field)
                }
            },
        },
        computed:{

        },

        mounted(){
            $('.Form').html5cvm({
                generic: 'این گزینه باید تکمیل شود!',
                typeMismatch: "نوع داده ورودی همخوانی ندارد."
            });
        },
        created(){
            this.$parent.pageName = 'مدیریت امتیازات'
        },
        component:{

        }
    }
</script>

<style scoped>

</style>
