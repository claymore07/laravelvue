<template>
    <div class="container mt-5 pt-5">
        <div class="row justify-content-center text-right text-rtl">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">ثبت نام</div>

                    <div class="card-body">
                        <form @submit.prevent="signup()">
                           <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label text-md-right">نام کاربری</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control"
                                           :class="{ 'is-invalid': form.errors.has('name') } "
                                           name="name"
                                           v-model="form.name"
                                           @change="removeError('name')"
                                           required autofocus>
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-2 col-form-label text-md-right">رایان نامه</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control"
                                           name="email"
                                           v-model="form.email"
                                           @change="removeError('email')"
                                           :class="{ 'is-invalid': form.errors.has('email') } "
                                           required>
                                    <has-error :form="form" field="email"></has-error>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-2 col-form-label text-md-right">کلمه عبور</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control"
                                           name="password"
                                           v-model="form.password"
                                           @change="removeError('password')"
                                           :class="{ 'is-invalid': form.errors.has('password') } "
                                           required>
                                    <has-error :form="form" field="password"></has-error>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-2 col-form-label text-md-right">تایید کلمه عبور</label>

                                <div class="col-md-6">
                                    <input v-model="form.password_confirmation" id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        ثبت نام
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Signup",
        data(){
          return{
              form: new Form({
                  name:'',
                  email:'',
                  password:'',
                  password_confirmation:''
              })
          }
        },
        created(){
            if(User.loggedIn()){
                this.$router.push('/home')
            }
        },
        methods:{
            signup(){
                this.errors ={};
                this.form.post('/api/auth/signup')
                    .then(res => {
                        User.responseAfterLogin(res);
                        this.$router.push('/home');
                    })
                    .catch(error => this.errors = error.response.data.errors)
            },
            removeError(field){
                this.form.errors.clear(field)
            }
        }
    }
</script>

<style scoped>

</style>
