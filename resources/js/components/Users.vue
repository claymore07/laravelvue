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
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Register At</th>
                            <th>Modify</th>
                        </tr>
                        <tr v-for="user in users" :key="user.id">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.type | upText }}</td>
                            <td>{{ user.created_at | myDate  }}</td>
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
            </div>
            <!-- /.card -->
        </div>
        <!-- Modal -->
        <div  v-if="$gate.isAdmin()||$gate.isAuthor()" class="modal  fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="!editMode" id="exampleModalLabel"><i class="fas fa-user-plus fa-fw"></i> Add New User</h5>
                        <h5 class="modal-title" v-else="editMode" id="exampleModalLabel"><i class="fas fa-user-cog fa-fw"></i> Update User: {{form.name}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? updateUser():createUser()" @keydown="form.onKeydown($event)">
                    <div class="modal-body">

                            <div class="form-group">
                                <label>Name</label>
                                <input v-model="form.name" type="text" name="name" placeholder="Name"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input v-model="form.email" type="email" name="email" placeholder="Email"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                            <div class="form-group">
                            <textarea v-model="form.bio" name="bio" id="bio"
                                      placeholder="Short bio for user (Optional)"
                                      class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                                <has-error :form="form" field="bio"></has-error>
                            </div>
                            <div class="form-group">
                                <select name="type" v-model="form.type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                    <option value="">Select User Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">Standard User</option>
                                    <option value="author">Author</option>
                                </select>
                                <has-error :form="form" field="type"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input v-model="form.password" type="password" name="password"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
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
                editMode: false,
                users: {},
                form: new Form({
                    id:'',
                    name:'',
                    email:'',
                    type:'',
                    bio:'',
                    photo:'',
                    password:'',
                })
            }
        },
        methods:{
            newModal(){
                this.form.reset();
                this.editMode = false;
                $('#addNew').modal('show');
            },
            editModal(user){
                this.editMode = true;
                this.form.reset();
                this.form.fill(user);
                $('#addNew').modal('show');
            },
            loadUsers(){
                axios.get('api/user').then(({data})=>(this.users  = data.data));
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
                        $('#addNew').modal('hide');
                        toast({
                            type: 'success',
                            title: 'User Created in successfully'
                        });
                        this.$Progress.finish();
                        this.form.reset();
                    })
                    .catch(()=>{
                        this.$Progress.fail();
                    })
            }
        },
        created() {
           if( this.$gate.isAdmin()||this.$gate.isAuthor()){
               this.loadUsers();
               Fire.$on('AfterCreate',() => {
                   this.loadUsers();
               });
               //    setInterval(() => this.loadUsers(), 3000);
           }

        }
    }
</script>

<style scoped>

</style>

