<template>
    <div class="container-fluid">
        <div class="col-md-12 mt-3" v-if="$gate.isAdminOrAuthor()">
            <div class="card card-4">
                <div class="card-header  " style="direction: rtl">
                    <div class="justify-content-around d-lg-flex text-right">
                        <div class="col-lg-7 m-3">
                            <h4 class=" text-right"> <i class="fal fa-boxes ml-2"></i>مدیریت گزینه&zwnj;های کاربری</h4>
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
                            <td>  فهرست عناوین مرتبه اعضای هیات علمی</td>
                            <td>
                                <a class="mr-2" href="#"  @click="prepareRankList">
                                    <i class="fa fa-edit blue"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{2|faDigit}}</td>
                            <td>  فهرست عناوین مدرک تحصیلی</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="getDegrees"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{3|faDigit}}</td>
                            <td>  فهرست عناوین همکاری</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="getPositions"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{4|faDigit}}</td>
                            <td>  فهرست عناوین عضویت در باشگاه</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="getMembers"></i>
                                </a>
                            </td>
                        </tr>
                        <!--<tr>
                            <td> {{5|faDigit}}</td>
                            <td>  فهرست عناوین داوری</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareRefereeTypeList"></i>
                                </a>
                            </td>
                        </tr>-->


                        </tbody>
                    </table>
                </div><!-- card-body -->
                <div class="card-footer d-flex flex-row justify-content-md-center" style="min-height: 60px">


                </div><!-- /card-footer --->
            </div>
        </div>
        <div v-if="$gate.isAdminOrAuthor()" class="modal  fade" id="rankListModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i
                            class="fas fa-building fa-fw"></i> فهرست عناوین مرتبه</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" >
                        <div class="text-right text-rtl">
                            <i v-show=" rankForm.errors.has('name')" class="red far fa-exclamation-triangle "></i>
                            <span v-show="rankForm.errors.has('name')" class="red d-inline-block ">{{ rankForm.errors.get('name') }}</span>
                        </div>
                        <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"> عنوان رتبه</th>
                                <th scope="col">تعداد کاربران ثبت شده</th>
                                <th></th>
                                <th scope="col"> ویرایش</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(rank, index) of rankList">
                                <th scope="row">{{index+1 | faDigit}}</th>
                                <td class="w-50"><label  v-show="editOffset != index">{{rank.name}}</label>
                                    <input :id = "'item-rank-'+index" v-show="editOffset == index"  type="text" name="name"
                                           :placeholder="'عنوان مرتبه'"
                                           class="form-control"
                                           @keyup="removeError('name', 'rank')"
                                           @keydown.enter.pervent=""
                                           :class="{ 'is-invalid': rankForm.errors.has('name') }"
                                           v-model="rankForm.name"
                                    >
                                </td>

                                <td style="font-family: IRANSans2, Tahoma, sans-serif">
                                    <span>{{rank.count}}</span>
                                </td>
                                <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateRankTitle(index)">ثبت تغییرات</button></td>
                                <td>
                                    <a class="" @click="startEditing(index, rank.id, 'rank')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    /
                                    <a @click="deleteRankTitle(index,rank.id)" href="#" class="btn btn-link" :class="[rank.count == 0?'':'disabled']" >
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div id="rankTypeTitleContainer">
                            <div class="form-group mb-3 mt-5  text-right">
                                <label class="blue ">عنوان مرتبه<i class="red mx-1">*</i>:</label>
                                <input  type="text" name="name"
                                        :placeholder="'عنوان  مرتبه'"
                                        @keydown.enter.pervent=""
                                        class="form-control" v-model="addTitle.name" >
                            </div>
                            <button @click="addRankTitle" class="btn btn-block btn-info mb-5"><i class="fas fa-user-plus fa-fw"></i> افزودن عنوان مرتبه</button>
                        </div>
                    </div><!-- modal-body -->
                    <div class="modal-footer">

                    </div>

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->
        <div v-if="$gate.isAdminOrAuthor()" class="modal  fade" id="degreeListModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel3"><i
                            class="fas fa-building fa-fw"></i> فهرست عناوین مدرک تحصیلی</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" >
                        <div class="text-right text-rtl">
                            <i v-show="degreeTypeForm.errors.has('name')" class="red far fa-exclamation-triangle "></i>
                            <span v-show="degreeTypeForm.errors.has('name')" class="red d-inline-block ">{{ degreeTypeForm.errors.get('name') }}</span>
                        </div>
                        <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"> عنوان مدرک تحصیلی</th>
                                <th scope="col">تعداد کاربران ثبت شده</th>
                                <th></th>
                                <th scope="col"> ویرایش</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(degree, index) of degreeList">
                                <th scope="row">{{index+1 | faDigit}}</th>
                                <td class="w-50"><label  v-show="editOffset != index">{{degree.name}}</label>
                                    <input :id = "'item-bookType-'+index" v-show="editOffset == index"  type="text" name="name"
                                           :placeholder="'عنوان مدرک تحصیلی'"
                                           class="form-control"
                                           @keyup="removeError('name', 'degree')"
                                           @keydown.enter.pervent=""
                                           :class="{ 'is-invalid': degreeTypeForm.errors.has('name') }"
                                           v-model="degreeTypeForm.name"
                                    >
                                </td>

                                <td style="font-family: IRANSans2, Tahoma, sans-serif">
                                    <span>{{degree.count}}</span>
                                </td>
                                <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateDegreeTitle(index)">ثبت تغییرات</button></td>
                                <td>
                                    <a class="" @click="startEditing(index, degree.id, 'degree')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    /
                                    <a @click="deleteDegreeTitle(index,degree.id)" href="#" class="btn btn-link" :class="[degree.count == 0?'':'disabled']" >
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div id="degreeTitleContainer">
                            <div class="form-group mb-3 mt-5  text-right">
                                <label class="blue ">عنوان مدرک تحصیلی<i class="red mx-1">*</i>:</label>
                                <input  type="text" name="name"
                                        :placeholder="'عنوان مدرک تحصیلی'"
                                        @keydown.enter.pervent=""
                                        class="form-control" v-model="addTitle.name" >
                            </div>
                            <button @click="addDegreeTitle" class="btn btn-block btn-info mb-5"><i class="fas fa-user-plus fa-fw"></i> افزودن عنوان مدرک تحصیلی</button>
                        </div>
                    </div><!-- modal-body -->
                    <div class="modal-footer">

                    </div>

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->
        <div v-if="$gate.isAdminOrAuthor()" class="modal  fade" id="positionListModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel4"><i
                            class="fas fa-building fa-fw"></i> فهرست عناوین همکاری</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" >
                        <div class="text-right text-rtl">
                            <i v-show="positionForm.errors.has('name')" class="red far fa-exclamation-triangle "></i>
                            <span v-show="positionForm.errors.has('name')" class="red d-inline-block ">{{ positionForm.errors.get('name') }}</span>
                        </div>
                        <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"> نوع همکاری</th>
                                <th scope="col">تعداد کاربران ثبت شده</th>
                                <th></th>
                                <th scope="col"> ویرایش</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(position, index) of positionList">
                                <th scope="row">{{index+1 | faDigit}}</th>
                                <td class="w-50"><label  v-show="editOffset != index">{{position.name}}</label>
                                    <input :id = "'item-position-'+index" v-show="editOffset == index"  type="text" name="name"
                                           :placeholder="'عنوان همکاری'"
                                           class="form-control"
                                           @keyup="removeError('name', 'position')"
                                           @keydown.enter.pervent=""
                                           :class="{ 'is-invalid': positionForm.errors.has('name') }"
                                           v-model="positionForm.name"
                                    >
                                </td>

                                <td style="font-family: IRANSans2, Tahoma, sans-serif">
                                    <span>{{position.count}}</span>
                                </td>
                                <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updatePositionTitle(index)">ثبت تغییرات</button></td>
                                <td>
                                    <a class="" @click="startEditing(index, position.id, 'position')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    /
                                    <a @click="deletePositionTitle(index,position.id)" href="#" class="btn btn-link" :class="[position.count == 0?'':'disabled']" >
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div id="positionTitleContainer">
                            <div class="form-group mb-3 mt-5  text-right">
                                <label class="blue ">عنوان همکاری<i class="red mx-1">*</i>:</label>
                                <input  type="text" name="name"
                                        :placeholder="'عنوان همکاری'"
                                        @keydown.enter.pervent=""
                                        class="form-control" v-model="addTitle.name" >
                            </div>
                            <button @click="addPositionTitle" class="btn btn-block btn-info mb-5"><i class="fas fa-user-plus fa-fw"></i> افزودن عنوان همکاری</button>
                        </div>
                    </div><!-- modal-body -->
                    <div class="modal-footer">

                    </div>

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->
        <div v-if="$gate.isAdminOrAuthor()" class="modal  fade" id="memberListModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel5"><i
                            class="fas fa-building fa-fw"></i> فهرست عناوین عضویت در باشگاه</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" >
                        <div class="text-right text-rtl">
                            <i v-show="memberForm.errors.has('name')" class="red far fa-exclamation-triangle "></i>
                            <span v-show="memberForm.errors.has('name')" class="red d-inline-block ">{{ memberForm.errors.get('name') }}</span>
                        </div>
                        <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"> نوع عضویت</th>
                                <th scope="col">تعداد کاربران ثبت شده</th>
                                <th></th>
                                <th scope="col"> ویرایش</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(member, index) of memberList">
                                <th scope="row">{{index+1 | faDigit}}</th>
                                <td class="w-50"><label  v-show="editOffset != index">{{member.name}}</label>
                                    <input :id = "'item-member-'+index" v-show="editOffset == index"  type="text" name="name"
                                           :placeholder="'عنوان عضویت نوع'"
                                           class="form-control"
                                           @keyup="removeError('name', 'member')"
                                           @keydown.enter.pervent=""
                                           :class="{ 'is-invalid': memberForm.errors.has('name') }"
                                           v-model="memberForm.name"
                                    >
                                </td>

                                <td style="font-family: IRANSans2, Tahoma, sans-serif">
                                    <span>{{member.count}}</span>
                                </td>
                                <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateMemberTitle(index)">ثبت تغییرات</button></td>
                                <td>
                                    <a class="" @click="startEditing(index, member.id, 'member')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    /
                                    <a @click="deleteMemberTitle(index,member.id)" href="#" class="btn btn-link" :class="[member.count == 0?'':'disabled']" >
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div id="memberTitleContainer">
                            <div class="form-group mb-3 mt-5  text-right">
                                <label class="blue ">عنوان عضویت<i class="red mx-1">*</i>:</label>
                                <input  type="text" name="name"
                                        :placeholder="'عنوان عضویت'"
                                        @keydown.enter.pervent=""
                                        class="form-control" v-model="addTitle.name" >
                            </div>
                            <button @click="addMemberTitle" class="btn btn-block btn-info mb-5"><i class="fas fa-user-plus fa-fw"></i> افزودن عنوان عضویت</button>
                        </div>
                    </div><!-- modal-body -->
                    <div class="modal-footer">

                    </div>

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->
        <div v-if="$gate.isAdminOrAuthor()" class="modal  fade" id="RefereeTypeListModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel6"><i
                            class="fas fa-building fa-fw"></i>فهرست عناوین داوری</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" >
                        <div class="text-right text-rtl">
                            <i v-show="refereeTypeForm.errors.has('name')" class="red far fa-exclamation-triangle "></i>
                            <span v-show="refereeTypeForm.errors.has('name')" class="red d-inline-block ">{{ refereeTypeForm.errors.get('name') }}</span>
                        </div>
                        <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"> نوع داوری</th>
                                <th scope="col">تعداد آثار ثبت شده</th>
                                <th></th>
                                <th scope="col"> ویرایش</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(refereeType, index) of refereeTypeList">
                                <th scope="row">{{index+1 | faDigit}}</th>
                                <td class="w-50"><label  v-show="editOffset != index">{{refereeType.name}}</label>
                                    <input :id = "'item-refereeType-'+index" v-show="editOffset == index"  type="text" name="name"
                                           :placeholder="'عنوان زیر نوع'"
                                           class="form-control"
                                           @keyup="removeError('name', 'refereeType')"
                                           @keydown.enter.pervent=""
                                           :class="{ 'is-invalid': refereeTypeForm.errors.has('name') }"
                                           v-model="refereeTypeForm.name"
                                    >
                                </td>

                                <td style="font-family: IRANSans2, Tahoma, sans-serif">
                                    <span>{{refereeType.count}}</span>
                                </td>
                                <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateRefereeType(index)">ثبت تغییرات</button></td>
                                <td>
                                    <a class="" @click="startEditing(index, refereeType.id, 'refereeType')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    /
                                    <a @click="deleteRefereeType(index,refereeType.id)" href="#" class="btn btn-link" :class="[refereeType.count == 0?'':'disabled']" >
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div id="refereeTypeTitleContainer">
                            <div class="form-group mb-3 mt-5  text-right">
                                <label class="blue ">عنوان زیر نوع<i class="red mx-1">*</i>:</label>
                                <input  type="text" name="name"
                                        :placeholder="'عنوان زیر نوع'"
                                        @keydown.enter.pervent=""
                                        class="form-control" v-model="addTitle.name" >
                            </div>
                            <button @click="addRefereeType" class="btn btn-block btn-info mb-5"><i class="fas fa-user-plus fa-fw"></i> افزودن زیر عنوان</button>
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
        name: "UserRelations",
        data(){
            return{

                rankList:{},
                degreeList:{},
                positionList:{},
                memberList:{},
                refereeTypeList:{},

                editOffset: -1,     // for managing author editing form status used if -1 the form will be hide
                addTitle: new Form({
                    name:'',
                }),
                rankForm: new Form({
                    id:'',
                    name:'',
                }),
                degreeTypeForm: new Form({
                    id:'',
                    name:'',
                }),
                positionForm: new Form({
                    id:'',
                    name:'',
                }),
                memberForm: new Form({
                    id:'',
                    name:'',
                }),
                refereeTypeForm: new Form({
                    id:'',
                    name:'',
                }),
            }
        },
        methods:{
            nothing(){},

            prepareRankList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getRanks').then((response)=>{
                    loader.hide();
                    this.rankList = response.data.ranks;
                    this.editOffset = -1;
                    $('#rankListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            getDegrees(){
                let loader = Vue.$loading.show();
                axios.get('/api/getDegrees').then((response)=>{
                    loader.hide();
                    this.degreeList = response.data.degrees;
                    this.editOffset = -1;
                    $('#degreeListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            getPositions(){
                let loader = Vue.$loading.show();
                axios.get('/api/getPositions').then((response)=>{
                    loader.hide();
                    this.positionList = response.data.positions;
                    this.editOffset = -1;
                    $('#positionListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            getMembers(){
                let loader = Vue.$loading.show();
                axios.get('/api/getMembers').then((response)=>{
                    loader.hide();
                    this.memberList = response.data.members;
                    this.editOffset = -1;
                    $('#memberListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            prepareRefereeTypeList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getRefereeTypes').then((response)=>{
                    loader.hide();
                    this.refereeTypeList = response.data.refereeTypeList;
                    this.editOffset = -1;
                    $('#RefereeTypeListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },

            // enables author editing form
            startEditing(index, id, type){
                this.editOffset = index;
                if(type == "rank"){
                    this.rankForm.fill(this.rankList[index]);
                    this.$nextTick(function(){
                        document.getElementById('item-'+type+'-'+this.editOffset).focus()
                    }.bind(this));
                }else if(type == "degree"){
                    this.degreeTypeForm.fill(this.degreeList[index]);
                    this.$nextTick(function(){
                        document.getElementById('item-'+type+'-'+this.editOffset).focus()
                    }.bind(this));
                }else if(type == "position"){
                    this.positionForm.fill(this.positionList[index]);
                    this.$nextTick(function(){
                        document.getElementById('item-'+type+'-'+this.editOffset).focus()
                    }.bind(this));
                }else if(type == "member"){
                    this.memberForm.fill(this.memberList[index]);
                    this.$nextTick(function(){
                        document.getElementById('item-'+type+'-'+this.editOffset).focus()
                    }.bind(this));
                }else if(type == "refereeType"){
                    this.refereeTypeForm.fill(this.refereeTypeList[index]);
                    this.$nextTick(function(){
                        document.getElementById('item-'+type+'-'+this.editOffset).focus()
                    }.bind(this));
                }
            },

            isIntOrFloat(n){
                return (Number(n) === n && n % 1 === 0) || (Number(n) === n && n % 1 !== 0);
            },

            updateRankTitle(index) {
                this.rankForm.put('/api/updateRankTitle/' + this.rankForm.id)
                    .then((response) => {
                        this.rankList[index]['name'] = response.data.name;
                        this.successToast('اطلاعات زیر عنوان با موفقیت بروزرسانی شد.');
                        this.rankForm.reset();
                        this.editOffset = -1;
                    }).catch(() => {
                    this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                });
            },
            deleteRankTitle(index, id) {
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
                        this.rankForm.delete('/api/deleteRankTitle/' + id)
                            .then((response) => {
                                this.rankList.splice(index,1);
                                this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                            }).catch(() => {
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        });
                    } else {
                        this.warningSwal('شما این عملیات را لغو کردید.');
                    }
                })

            },
            addRankTitle() {
                if(this.addTitle.name.trim()) {
                    this.addTitle.post('/api/addRankTitle')
                        .then((response) => {
                            this.rankList.push(response.data);
                            this.addTitle.reset();
                            this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                    });
                }
            },


            updateDegreeTitle(index) {
                this.degreeTypeForm.put('/api/updateDegreeTitle/' + this.degreeTypeForm.id)
                    .then((response) => {
                        this.degreeList[index]['name'] = response.data.name;
                        this.successToast('اطلاعات زیر عنوان با موفقیت بروزرسانی شد.');
                        this.degreeTypeForm.reset();
                        this.editOffset = -1;
                    }).catch(() => {
                    this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                });
            },
            deleteDegreeTitle(index, id) {
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
                        this.degreeTypeForm.delete('/api/deleteDegreeTitle/' + id)
                            .then((response) => {
                                this.degreeList.splice(index,1);
                                this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                            }).catch(() => {
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        });
                    } else {
                        this.warningSwal('شما این عملیات را لغو کردید.');
                    }
                })
            },
            addDegreeTitle() {
                if(this.addTitle.name.trim()) {
                    this.addTitle.post('/api/addDegreeTitle')
                        .then((response) => {
                            this.degreeList.push(response.data);
                            this.addTitle.reset();
                            this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                    });
                }
            },

            updatePositionTitle(index) {
                this.positionForm.put('/api/updatePositionTitle/' + this.positionForm.id)
                    .then((response) => {
                        this.positionList[index]['name'] = response.data.name;
                        this.successToast('اطلاعات زیر عنوان با موفقیت بروزرسانی شد.');
                        this.positionForm.reset();
                        this.editOffset = -1;
                    }).catch(() => {
                    this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                });
            },
            deletePositionTitle(index, id) {
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
                        this.positionForm.delete('/api/deletePositionTitle/' + id)
                            .then((response) => {
                                this.positionList.splice(index,1);
                                this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                            }).catch(() => {
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        });
                    } else {
                        this.warningSwal('شما این عملیات را لغو کردید.');
                    }
                })
            },
            addPositionTitle() {
                if(this.addTitle.name.trim()) {
                    this.addTitle.post('/api/addPositionTitle')
                        .then((response) => {
                            this.positionList.push(response.data);
                            this.addTitle.reset();
                            this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                    });
                }
            },

            updateMemberTitle(index) {
                this.memberForm.put('/api/updateMemberTitle/' + this.memberForm.id)
                    .then((response) => {
                        this.memberList[index]['name'] = response.data.name;
                        this.successToast('اطلاعات زیر عنوان با موفقیت بروزرسانی شد.');
                        this.memberForm.reset();
                        this.editOffset = -1;
                    }).catch(() => {
                    this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                });
            },
            deleteMemberTitle(index, id) {
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
                        this.memberForm.delete('/api/deleteMemberTitle/' + id)
                            .then((response) => {
                                this.memberList.splice(index,1);
                                this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                            }).catch(() => {
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        });
                    } else {
                        this.warningSwal('شما این عملیات را لغو کردید.');
                    }
                })
            },
            addMemberTitle() {
                if(this.addTitle.name.trim()) {
                    this.addTitle.post('/api/addMemberTitle')
                        .then((response) => {
                            this.memberList.push(response.data);
                            this.addTitle.reset();
                            this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                    });
                }
            },

            updateRefereeType(index) {
                this.refereeTypeForm.put('/api/updateRefereeTypeTitle/' + this.refereeTypeForm.id)
                    .then((response) => {
                        this.refereeTypeList[index]['name'] = response.data.name;
                        this.successToast('اطلاعات زیر عنوان با موفقیت بروزرسانی شد.');
                        this.refereeTypeForm.reset();
                        this.editOffset = -1;
                    }).catch(() => {
                    this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                });
            },
            deleteRefereeType(index, id) {
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
                        this.refereeTypeForm.delete('/api/deleteRefereeTypeTitle/' + id)
                            .then((response) => {
                                this.refereeTypeList.splice(index,1);
                                this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                            }).catch(() => {
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        });
                    } else {
                        this.warningSwal('شما این عملیات را لغو کردید.');
                    }
                })
            },
            addRefereeType() {
                if(this.addTitle.name.trim()) {
                    this.addTitle.post('/api/addRefereeTypeTitle')
                        .then((response) => {
                            this.refereeTypeList.push(response.data);
                            this.addTitle.reset();
                            this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                    });
                }
            },



            removeError(field, type){
                if(type == "rank") {
                    this.rankForm.errors.clear(field)
                }else if(type == "degree"){
                    this.degreeTypeForm.errors.clear(field)
                }else if(type == "position"){
                    this.positionForm.errors.clear(field)
                }else if(type == "member"){
                    this.memberForm.errors.clear(field)
                }else if(type == "refereeType"){
                    this.refereeTypeForm.errors.clear(field)
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
            this.$parent.pageName = 'مدیریت گزینه های کاربری'
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


