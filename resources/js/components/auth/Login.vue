<template>
    <div class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-right text-rtl">
                    <div class="card-header">ورود</div>

                    <div class="card-body">
                        <form @submit.prevent="login()">
                            <div class="form-group row">
                                <label for="email" class="col-md-2 col-form-label text-md-right">رایان نامه</label>
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
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <a class="btn btn-link" href="">
                                        آیا کلمه عبور خود را فراموش کرده اید؟
                                    </a>
                                    <button type="submit" class="btn btn-primary">
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
        name: "Login",
        data(){
            return{
                form: new Form({
                    email:'',
                    password:''
                })
            }
        },
        methods:{
            login(){
                User.login(this.form);

            }
        },
        created(){
            if(User.loggedIn()){
                this.$router.push('/home')
            }
        },
    }
</script>

<style scoped>

</style>
