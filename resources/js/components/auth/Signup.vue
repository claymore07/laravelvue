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
                                <label for="email" class="col-md-2 col-form-label text-md-right">رایانامه</label>

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
                            <div class="form-group row mb-0 mt-4">
                                <div class="col-md-8 offset-md-4">
                                    <div class="d-md-inline-block ml-5 ">ربات نیستم:</div>
                                    <div class="mr-5 text-ltr text-left d-md-inline-block">
                                        <p-check v-model="form.captcha"  style="font-size: 40px" class="captcha p-switch p-fill p-bigger "></p-check>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-0 mt-4">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary" :disabled='isDisabled'>
                                        ثبت نام
                                    </button>
                                    <button @click="goToLogin" class="btn btn-success mr-2"  >
                                        ورود
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
                  captcha:false,
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
        computed: {
            isDisabled: function(){
                return !this.form.captcha;
            }
        },
        methods:{
            goToLogin(){
                this.$router.push('/login');
            },
            signup(){

                this.form.post('/api/auth/signup')
                    .then(res => {
                        User.responseAfterLogin(res);
                        this.$router.push('/home');
                    })
                    .catch(error => {})
            },
            removeError(field){
                this.form.errors.clear(field)
            }
        }
    }
</script>

<style scoped>

</style>
