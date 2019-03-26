<template>
    <div class="flex-center position-ref full-height">


        <div class="content" >
            <div class="title m-b-md">
                سامانه جامع علمی پژوهشی
            </div>

            <div class="links">
                <router-link class="btn btn-lg btn-outline-dark" to="/login">ورود</router-link>
                <router-link class="btn btn-lg btn-outline-dark" to="/signup">ثبت نام</router-link>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "welcome",
        created(){
            console.log('loaded11111111111')
        }
    }
</script>

<style scoped>
    html, body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'IRANSans', sans-serif;
        font-weight: 200;
        height: 100vh;
        margin: 0;
    }

    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 84px;
    }

    .links > a {
        padding: 0 25px;
        font-weight: 600;
        text-decoration: none;
    }

    .m-b-md {
        margin-bottom: 30px;
    }
</style>
