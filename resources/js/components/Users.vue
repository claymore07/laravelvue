<template>
    <div class="container-fluid">
        <div class="col-md-12 mt-3" v-if="$gate.isAdmin()||$gate.isAuthor()">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Users Table</h3>

                    <div class="card-tools">
                        <button class="btn btn-success" @click="newModal"><i class="fas fa-user-plus fa-fw" ></i> Add New User</button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>شماره</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th @click="toggle()" :class="['sort-control', sortType]">Register At</th>
                            <th>Modify</th>
                        </tr>
                        <tr v-for="(user, index) in users.data" :key="user.id">
                            <td>{{counter(index)}}</td>
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.type | upText }}</td>
                            <td >{{ user.created_at | myDate  }}</td>
                            <td>
                                <a href="#" @click="editModal(user)">
                                    <i class="fa fa-edit blue"></i>
                                </a>
                                /
                                <button href="#" @click="deleteUser(user.id)">
                                    <i class="fa fa-trash red"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer d-flex flex-row justify-content-md-center" style="min-height: 60px">
                    <pagination  v-if="" :data="users" @pagination-change-page="getResults" :limit="1" :show-disabled="true">
                        <span slot="prev-nav"><i class="fa fa-angle-double-right"></i></span>
                        <span slot="next-nav"><i class="fa fa-fw fa-angle-double-left"></i></span>
                    </pagination>
                    <span class="table-detail">
                        تعداد {{this.numToShow}} از
 {{this.total}}                   </span>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- Modal -->
        <div  v-if="$gate.isAdmin()||$gate.isAuthor()" class="modal  fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="!editMode" id="exampleModalLabel"><i class="fas fa-user-plus fa-fw"></i> ایجاد کاربر جدید</h5>
                        <h5 class="modal-title" v-else="editMode" id="exampleModalLabel"><i class="fas fa-user-cog fa-fw"></i> بروزرسانی کاربر: {{form.name}}</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? updateUser():createUser()" @keydown="form.onKeydown($event)" id="Form">

                   <div class="modal-body">
                            <div class="form-group mt-4">
                                <float-label fixed>
                                    <input  lang="fa-IR" type="text" name="Fname" placeholder="نام"
                                           class="form-control"  v-model.lazy="form.Fname" @keyup="farsiTypeInputSetter($event.target.value, 'Fname')"  :class="{ 'is-invalid': form.errors.has('Fname') } " @input="() => {}">
                                </float-label>
                                <has-error :form="form" field="Fname"></has-error>
                            </div>
                            <div class="form-group my-5">
                                <float-label fixed>
                                    <input lang="fa-IR" v-model.lazy="form.Lname" @keyup="farsiTypeInputSetter($event.target.value, 'Lname')" type="text" name="Lname" placeholder="نام خانوادگی"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('Lname') }">
                                </float-label>
                                <has-error :form="form" field="Lname"></has-error>
                            </div>
                            <div class="form-group my-5">
                                <float-label fixed>
                                    <input v-model="form.name" type="text" name="name" placeholder="نام کاربری"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('name') }"  pattern="[A-Za-z]{6,}" data-error-pattern-mismatch="نام کاربری باید به زبان انگلیسی به طول بیش از 6 کاراکتر باشد!" required>
                                </float-label >
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group my-5">
                                <float-label fixed>
                                    <input v-model="form.email" type="email" name="email" placeholder="رایان نامه"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                </float-label>
                                <has-error :form="form" field="email"></has-error>
                            </div>

                        <div class="form-group my-5">
                            <float-label fixed>
                                <input v-model="form.password" type="password" name="password" placeholder="کلمه عبور"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                            </float-label>
                            <has-error :form="form" field="password"></has-error>
                        </div>
                        <div class="form-group my-5">
                            <float-label fixed>
                                <input v-model="form.siba" type="text" name="siba" placeholder="شماره سیبا"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('siba') }">
                            </float-label>
                            <has-error :form="form" field="siba"></has-error>
                        </div>
                        <div class="form-group my-5">
                            <float-label fixed>
                                <input v-model="form.phone" type="tel" name="phone" placeholder="شماره موبایل"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
                            </float-label>
                            <has-error :form="form" field="phone"></has-error>
                        </div>
                        <div class="form-group my-5">
                            <float-label fixed>
                                <input v-model="form.personal_id" type="text" name="personal_id" placeholder="شماره پرسنلی"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('personal_id') }">
                            </float-label>
                            <has-error :form="form" field="personal_id"></has-error>
                        </div>
                        <div class="form-group my-5">
                            <float-label fixed>
                                <textarea v-model="form.bio" name="bio" id="bio"
                                          placeholder="خلاصه بیوگرافی:"
                                          class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                            </float-label >
                            <has-error :form="form" field="bio"></has-error>
                        </div>
                           <div class="form-group my-5">
                              <float-label :dispatch="false" fixed>
                                  <select name="type" v-model="form.type"  id="type" class="form-control test1"  :class="{ 'is-invalid': form.errors.has('type') }">
                                      <option selected disabled value="">نوع دسترسی به سامانه</option>
                                      <option value="admin">Admin</option>
                                      <option value="user">Standard User</option>
                                      <option value="author">Author</option>
                                  </select>
                              </float-label>
                              <has-error :form="form" field="type"></has-error>
                          </div>
                         <div class="form-group my-5">
                              <float-label :dispatch="false" fixed>
                                  <select name="degree_id" v-model="form.degree_id" id="degree_id" class="form-control" :class="{ 'is-invalid': form.errors.has('degree_id') }">
                                      <option selected disabled value="">آخرین مدرک دانشگاهی</option>
                                      <option v-for="(degree, id) of this.degrees" v-bind:value=id >{{ degree}}</option>
                                  </select>
                              </float-label>
                              <has-error :form="form" field="degree_id"></has-error>
                          </div>
                           <div class="form-group my-5">
                               <float-label :dispatch="false" fixed>
                                   <select name="rank_id" v-model="form.rank_id" id="rank_id" class="form-control" :class="{ 'is-invalid': form.errors.has('rank_id') }">
                                       <option selected disabled value="">مرتبه علمی</option>
                                       <option v-for="(rank, id) of this.ranks" v-bind:value=id >{{ rank}}</option>
                                   </select>
                               </float-label>
                               <has-error :form="form" field="rank_id"></has-error>
                           </div>
                           <div class="form-group my-5">
                               <float-label :dispatch="false" fixed>
                                   <select name="member_id" v-model="form.member_id" id="member_id" class="form-control" :class="{ 'is-invalid': form.errors.has('member_id') }">
                                       <option selected disabled  value="">نوع عضویت در باشگاه پژوهشگران</option>
                                       <option v-for="(member, id) of this.members" v-bind:value=id >{{ member}}</option>
                                   </select>
                               </float-label>
                               <has-error :form="form" field="member_id"></has-error>
                           </div>
                          <div class="form-group my-5">
                              <float-label :dispatch="false" fixed>
                                  <select name="department_id" v-model="form.department_id" id="department_id" class="form-control" :class="{ 'is-invalid': form.errors.has('department_id') }">
                                      <option selected disabled  value="">گروه آموزشی</option>
                                      <option v-for="(department, id) of this.departments" v-bind:value=id >{{ department}}</option>
                                  </select>
                              </float-label>
                              <has-error :form="form" field="department_id"></has-error>
                          </div>
                          <div class="form-group my-5">
                              <float-label :dispatch="false" fixed>
                                  <select name="faculty_id" v-model="form.faculty_id" id="faculty_id" class="form-control" :class="{ 'is-invalid': form.errors.has('faculty_id') }">
                                      <option selected disabled  value="">نام دانشکده</option>
                                      <option v-for="(facutlty, id) of this.faculties" v-bind:value=id >{{ facutlty}}</option>
                                  </select>
                              </float-label>
                              <has-error :form="form" field="faculty_id"></has-error>
                          </div>
                          <div class="form-group my-5">
                              <float-label :dispatch="false" fixed>
                                  <select @change="baseToggle" name="position_id" v-model="form.position_id" id="position_id" class="form-control" :class="{ 'is-invalid': form.errors.has('position_id') }">
                                      <option selected disabled value="">نوع همکاری با دانشگاه</option>
                                      <option v-for="(position, id) of this.positions" v-bind:value=id >{{ position}}</option>
                                  </select>
                              </float-label>
                              <has-error :form="form" field="position_id"></has-error>
                          </div>
                       <div v-if="baseMode" class="form-group my-5">
                           <float-label fixed>
                               <input v-model="form.base" :class="{ 'is-invalid': form.errors.has('base') }" style="direction: rtl; text-align: right !important;"    class="form-control text-ltr text-left addon" id="base1" placeholder="پایه" required name="base" type="number">
                               </float-label >
                           <has-error :form="form" field="base"></has-error>
                       </div>
                  </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button :disabled="form.busy" v-if="!editMode" type="submit"   class="btn btn-primary">Create User</button>
                        <button :disabled="form.busy" v-else="editMode" type="submit"   class="btn btn-success">Update User</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div v-if="!$gate.isAdmin()&&!$gate.isAuthor()">
            <not-found></not-found>
        </div>

    </div>



</template>


<script>

    export default {
        name: "Users",
        data(){
            return{
                order: 1,
                total:0,
                numToShow:0,
                numStart:0,
                editMode: false,
                searchResult: false,
                baseMode: true,
                users: {},
                degrees:{},
                ranks:{},
                members:{},
                departments:{},
                faculties:{},
                positions:{},
                form: new Form({
                    id:'',
                    name:'',
                    Fname:'',
                    Lname:'',
                    email:'',
                    type:'',
                    bio:'',
                    photo:'',
                    password:'',
                    siba:'',
                    phone:'',
                    personal_id:'',
                    degree_id:'',
                    rank_id:'',
                    member_id:'',
                    position_id:'',
                    faculty_id:'',
                    department_id:'',
                    base:0
                })
            }
        },
        methods:{
            toggle(){
                 this.order *= -1;
                 this.getResults();
            },
            baseToggle(){
                console.log(this.baseMode);
                 if(this.form.position_id == 1||this.form.position_id == 2 || this.form.position_id == 3){
                     this.baseMode = true;
                 }else {
                     this.baseMode = false;
                     this.form.base = 0;
                 }
                console.log(this.baseMode);
            },
            getResults( page = 1 ,que='') {

                let sortOrder = this.order === 1 ? 'asc' : 'desc';

                if(this.searchResult){
                    let query = this.$parent.search;
                    axios.get('api/findUser?order='+sortOrder+'&q='+query + '&page=' + page)
                        .then(response => {
                            this.users = response.data.users;
                            this.degrees = response.data.degrees;
                            this.ranks = response.data.ranks;
                            this.members = response.data.members;
                            this.departments = response.data.departments;
                            this.faculties = response.data.faculties;
                            this.positions = response.data.positions;
                            this.total = response.data.users.total;
                            this.numToShow = response.data.users.per_page;
                            this.numStart = response.data.users.from;

                        });
                }else{
                    axios.get('api/user?order='+sortOrder+'&page=' + page)
                        .then(response => {
                            this.users = response.data.users;
                            this.degrees = response.data.degrees;
                            this.ranks = response.data.ranks;
                            this.members = response.data.members;
                            this.departments = response.data.departments;
                            this.faculties = response.data.faculties;
                            this.positions = response.data.positions;
                            this.total = response.data.users.total;
                            this.numToShow = response.data.users.per_page;
                            this.numStart = response.data.users.from;

                        });
                }
            },
            newModal(){
                this.form.reset();
                this.editMode = false;
                $('#addNew').modal('show');
            },
            editModal(user){
                this.editMode = true;
                this.form.reset();
                //console.log(user.profile.degree_id);
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
                this.form.fill(user);
                $('#addNew').modal('show');
            },

            updateUser(){
                this.$Progress.start();
                this.form.put('api/user/'+this.form.id)
                    .then(()=>{
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast({
                            type: 'success',
                            title: 'User updated in successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(()=>{
                        this.$Progress.fail();
                    })
            },
            deleteUser(id){
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    // send ajax request to server
                    if (result.value) {
                        this.form.delete('api/user/'+id).then(()=>{

                                swal(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                );

                            Fire.$emit('AfterCreate');
                        }).catch((e)=>{
                          //  console.log(e.response.data['message']);
                            swal("Failed!", e.response.data['message'], "error");
                        });
                    }else{
                        swal("Canceled!", "You have canceled the action.", "warning");
                    }


                })
            },
            createUser(){


                this.$Progress.start();
                this.form.busy;
                this.form.post('api/user')
                    .then(()=>{
                        Fire.$emit('AfterCreate');
                       // $('#addNew').modal('hide');
                        toast({
                            type: 'success',
                            title: 'User Created in successfully'
                        });
                        this.$Progress.finish();
                  //      this.form.reset();
                    })
                    .catch(()=>{
                        this.$Progress.fail();
                    })
            },
            farsiTypeInputSetter(e,field){
                switch (field){
                    case 'Fname':
                        this.form.Fname = e;
                        break;
                    case 'Lname':
                        this.form.Lname = e;
                        break;
                }
            },
            counter(i){
                console.log(this.numStart);


                return   this.numStart + i;
            }
        },
        computed: {
            sortType(){
                return this.order === 1 ? 'ascending' : 'descending';
            },


        },
        watch:{

        },
        created() {
           if( this.$gate.isAdmin()||this.$gate.isAuthor()){
               Fire.$on('searching',()=>{
                   let page =1;
                   let query = this.$parent.search;
                   this.searchResult =true;
                   this.getResults(page ,query);
               });

               Fire.$on('AfterCreate',() => {
                   this.getResults();
               });
               this.getResults();
               //    setInterval(() => this.loadUsers(), 3000);
           }

        },

    }
</script>

<style scoped>

</style>

