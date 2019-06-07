<template>
    <div class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-right text-rtl">
                    <div class="card-header">ورود</div>

                    <div class="card-body">
                        <form @submit.prevent="login()">
                            <div class="form-group row">
                                <label for="email" class="col-md-2 col-form-label text-md-right">رایانامه</label>
                                <div class="col-md-6">
                                    <input id="email"
                                           type="email"
                                           class="form-control"
                                           v-model="form.email"
                                           :class="{ 'is-invalid': form.errors.has('email') } "
                                           name="email"
                                           required autofocus>
                                    <has-error :form="form" field="email"></has-error>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-2 col-form-label text-md-right">کلمه عبور</label>

                                <div class="col-md-6">
                                    <input id="password"
                                           type="password"
                                           class="form-control"
                                           name="password"
                                           :class="{ 'is-invalid': form.errors.has('password') } "
                                           v-model="form.password"
                                           >
                                    <has-error :form="form" field="password"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" >

                                        <label class="form-check-label mr-4" for="remember">
                                            بخاطر داشته باش
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-0 ">
                                <div class="col-md-8 offset-md-4">
                                    <div class="d-md-inline-block ml-5 ">ربات نیستم:</div>
                                    <div class="mr-5 text-ltr text-left d-md-inline-block">
                                    <p-check v-model="form.captcha"  style="font-size: 40px" class="captcha p-switch p-fill p-bigger "></p-check>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-5 row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <a class="btn btn-link" href="">
                                        آیا کلمه عبور خود را فراموش کرده اید؟
                                    </a>
                                    <button type="submit" class="btn btn-primary mr-2" :disabled='isDisabled' >
                                        ورود
                                    </button>
                                    <button @click="goToSignUp" class="btn btn-success mr-2"  >
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
        name: "Login",
        data(){
            return{

                form: new Form({
                    captcha:false,
                    email:'',
                    password:''
                })
            }
        },
        computed: {
            isDisabled: function(){
                return !this.form.captcha;
            }
        },
        methods:{
            goToSignUp(){
                this.$router.push('/signup');
            },
            login(){
                User.login(this.form);

            }
        },
        created() {
            if (User.loggedIn()) {
                this.$router.push('/home')
            }
        },

    }
</script>

<style scoped>

</style>
