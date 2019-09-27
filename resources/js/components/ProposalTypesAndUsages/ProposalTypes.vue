<template>
    <div class="container-fluid">
        <div class="col-md-12 mt-3" v-if="$gate.isAdminOrAuthor()">
            <div class="card card-4">
                <div class="card-header  " style="direction: rtl">
                    <div class="justify-content-around d-lg-flex text-right">
                        <div class="col-lg-7 m-3">
                            <h4 class=" text-right"> <i class="fal fa-edit ml-2"></i>مدیریت انواع پروپوزال</h4>
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
                            <td>  فهرست انواع پروپوزال</td>
                            <td>
                                <a class="mr-2" href="#"  @click="prepareProposalTypeList">
                                    <i class="fa fa-edit blue"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{2|faDigit}}</td>
                            <td>  فهرست انواع کاربرد پروپوزال</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareProposalUsageList"></i>
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
        <div v-if="$gate.isAdminOrAuthor()" class="modal  fade" id="ProposalTypeList" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i
                            class="fas fa-building fa-fw"></i>  فهرست انواع پروپوزال</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" >
                        <div class="text-right text-rtl">
                            <i v-show="proposalTypeForm.errors.has('name')" class="red far fa-exclamation-triangle "></i>
                            <span v-show="proposalTypeForm.errors.has('name')" class="red d-inline-block ">{{ proposalTypeForm.errors.get('name') }}</span>
                        </div>
                        <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"> نوع پروپوزال</th>
                                <th scope="col">تعداد آثار ثبت شده</th>
                                <th></th>
                                <th scope="col"> ویرایش</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(proposalType, index) of proposalTypeList">
                                <th scope="row">{{index+1 | faDigit}}</th>
                                <td class="w-50"><label  v-show="editOffset != index">{{proposalType.name}}</label>
                                    <input :id = "'item-ProposalType-'+index" v-show="editOffset == index"  type="text" name="name"
                                           :placeholder="'عنوان زیر نوع'"
                                           class="form-control"
                                           @keyup="removeError('name', 'ProposalType')"
                                           @keydown.enter.pervent=""
                                           :class="{ 'is-invalid': proposalTypeForm.errors.has('name') }"
                                           v-model="proposalTypeForm.name"
                                    >
                                </td>

                                <td style="font-family: IRANSans2, Tahoma, sans-serif">
                                    <span>{{proposalType.count}}</span>
                                </td>
                                <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateProposalType(index)">ثبت تغییرات</button></td>
                                <td>
                                    <a class="" @click="startEditing(index, proposalType.id, 'ProposalType')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    /
                                    <a @click="deleteProposalType(index,proposalType.id)" href="#" class="btn btn-link" :class="[proposalType.count == 0?'':'disabled']" >
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div id="ConfTypeTitleContainer">
                            <div class="form-group mb-3 mt-5  text-right">
                                <label class="blue ">عنوان زیر نوع<i class="red mx-1">*</i>:</label>
                                <input  type="text" name="name"
                                        :placeholder="'عنوان زیر نوع'"
                                        @keydown.enter.pervent=""
                                        class="form-control" v-model="addTitle.name" >
                            </div>
                            <button @click="addProposalType" class="btn btn-block btn-info mb-5"><i class="fas fa-user-plus fa-fw"></i> افزودن زیر عنوان</button>
                        </div>
                    </div><!-- modal-body -->
                    <div class="modal-footer">

                    </div>

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->
        <div v-if="$gate.isAdminOrAuthor()" class="modal  fade" id="ProposalUsageList" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2"><i
                            class="fas fa-building fa-fw"></i> فهرست انواع کاربرد پروپوزال</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" >
                        <div class="text-right text-rtl">
                            <i v-show=" proposalUsageForm.errors.has('name')" class="red far fa-exclamation-triangle "></i>
                            <span v-show="proposalUsageForm.errors.has('name')" class="red d-inline-block ">{{ proposalUsageForm.errors.get('name') }}</span>
                        </div>
                        <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"> نوع کاربرد</th>
                                <th scope="col">تعداد آثار ثبت شده</th>
                                <th></th>
                                <th scope="col"> ویرایش</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(proposalUsage, index) of proposalUsageList">
                                <th scope="row">{{index+1 | faDigit}}</th>
                                <td class="w-50"><label  v-show="editOffset != index">{{proposalUsage.name}}</label>
                                    <input :id = "'item-ProposalUsage-'+index" v-show="editOffset == index"  type="text" name="name"
                                           :placeholder="'عنوان زیر نوع'"
                                           class="form-control"
                                           @keyup="removeError('name', 'ProposalUsage')"
                                           @keydown.enter.pervent=""
                                           :class="{ 'is-invalid': proposalUsageForm.errors.has('name') }"
                                           v-model="proposalUsageForm.name"
                                    >
                                </td>

                                <td style="font-family: IRANSans2, Tahoma, sans-serif">
                                    <span>{{proposalUsage.count}}</span>
                                </td>
                                <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateProposalUsage(index)">ثبت تغییرات</button></td>
                                <td>
                                    <a class="" @click="startEditing(index, proposalUsage.id, 'ProposalUsage')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    /
                                    <a @click="deleteProposalUsage(index,proposalUsage.id)" href="#" class="btn btn-link" :class="[proposalUsage.count == 0?'':'disabled']" >
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div id="jTypeTitleContainer">
                            <div class="form-group mb-3 mt-5  text-right">
                                <label class="blue ">عنوان زیر نوع<i class="red mx-1">*</i>:</label>
                                <input  type="text" name="name"
                                        :placeholder="'عنوان زیر نوع'"
                                        @keydown.enter.pervent=""
                                        class="form-control" v-model="addTitle.name" >
                            </div>
                            <button @click="addPropsalUsage" class="btn btn-block btn-info mb-5"><i class="fas fa-user-plus fa-fw"></i> افزودن زیر عنوان</button>
                        </div>
                    </div><!-- modal-body -->
                    <div class="modal-footer">

                    </div>

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->

        <div v-if="!$gate.isAdminOrAuthor()">
            <not-found></not-found>
        </div><!-- /404 page -->
    </div>
</template>

<script>
    export default {
        name: "SubTypes",
        data(){
            return{

                proposalTypeList:{},
                proposalUsageList:{},

                editOffset: -1,     // for managing author editing form status used if -1 the form will be hide
                addTitle: new Form({
                    name:'',
                }),

                proposalTypeForm: new Form({
                    id:'',
                    name:'',
                }),

                proposalUsageForm: new Form({
                    id:'',
                    name:'',
                }),
            }
        },
        methods:{
            nothing(){},
            prepareProposalTypeList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getResearchProposalTypes').then((response)=>{
                    loader.hide();
                    this.proposalTypeList = response.data.proposalTypeList;
                    this.editOffset = -1;
                    $('#ProposalTypeList').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },

            prepareProposalUsageList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getProposalUsageTypes').then((response)=>{
                    loader.hide();
                    this.proposalUsageList = response.data.proposalUsageList;
                    this.editOffset = -1;
                    $('#ProposalUsageList').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            // enables author editing form
            startEditing(index, id, type){
                this.editOffset = index;
                if(type == "ProposalType"){
                    this.proposalTypeForm.fill(this.proposalTypeList[index]);
                    this.$nextTick(function(){
                        document.getElementById('item-'+type+'-'+this.editOffset).focus()
                    }.bind(this));
                }else if(type == "ProposalUsage"){
                    this.proposalUsageForm.fill(this.proposalUsageList[index]);
                    this.$nextTick(function(){
                        document.getElementById('item-'+type+'-'+this.editOffset).focus()
                    }.bind(this));
                }
            },

            isIntOrFloat(n){
                return (Number(n) === n && n % 1 === 0) || (Number(n) === n && n % 1 !== 0);
            },



            updateProposalType(index) {
                this.proposalTypeForm.put('/api/updateResearchProposalTypeTitle/' + this.proposalTypeForm.id)
                    .then((response) => {
                        this.proposalTypeList[index]['name'] = response.data.name;
                        this.successToast('اطلاعات زیر عنوان با موفقیت بروزرسانی شد.');
                        this.proposalTypeForm.reset();
                        this.editOffset = -1;
                    }).catch(() => {
                    this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                });
            },
            deleteProposalType(index, id) {
                swal({
                    title: 'آیا از حذف زیر نوع مورد نظر مطمئن هستید؟',
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
                        this.proposalTypeForm.delete('/api/deleteResearchProposalTypeTitle/' + id)
                            .then((response) => {
                                this.proposalTypeList.splice(index,1);
                                this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                            }).catch(() => {
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        });
                    } else {
                        this.warningSwal('شما این عملیات را لغو کردید.');
                    }
                })
            },
            addProposalType() {
                if(this.addTitle.name.trim()) {
                    this.addTitle.post('/api/addResearchProposalTypeTitle')
                        .then((response) => {
                            this.proposalTypeList.push(response.data);
                            this.addTitle.reset();
                            this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                    });
                }
            },


            updateProposalUsage(index) {
                this.proposalUsageForm.put('/api/updateResearchProposalUsageTitle/' + this.proposalUsageForm.id)
                    .then((response) => {
                        this.proposalUsageList[index]['name'] = response.data.name;
                        this.successToast('اطلاعات زیر عنوان با موفقیت بروزرسانی شد.');
                        this.proposalUsageForm.reset();
                        this.editOffset = -1;
                    }).catch(() => {
                    this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                });
            },
            deleteProposalUsage(index, id) {
                swal({
                    title: 'آیا از حذف زیر نوع مورد نظر مطمئن هستید؟',
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
                        this.proposalUsageForm.delete('/api/deleteResearchProposalUsageTitle/' + id)
                            .then((response) => {
                                this.proposalUsageList.splice(index,1);
                                this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                            }).catch(() => {
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        });
                    } else {
                        this.warningSwal('شما این عملیات را لغو کردید.');
                    }
                })
            },
            addPropsalUsage() {
                if(this.addTitle.name.trim()) {
                    this.addTitle.post('/api/addResearchProposalUsageTitle')
                        .then((response) => {
                            this.proposalUsageList.push(response.data);
                            this.addTitle.reset();
                            this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                    });
                }
            },

            removeError(field, type){
                if(type == "ProposalType") {
                    this.proposalTypeForm.errors.clear(field)
                }else if(type == "ProposalUsage"){
                    this.proposalUsageForm.errors.clear(field)
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
            this.$parent.pageName = 'مدیریت انواع پروپوزال'
            swal.fire({
                title: 'توجه!!',
                text: 'اطلاعات این بخش دارای حساسیت بالایی می باشد و در صورت عدم دقت می تواند صحت کل اطلاعات سامانه را از بین ببرد!',
                type: 'warning',
                focusConfirm: true,
                confirmButtonText: 'متوجه شدم!',
            });
        },
        component:{

        }
    }
</script>

<style scoped>

</style>
