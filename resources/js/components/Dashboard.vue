<template>
    <div class="container">
        <div class="row justify-content-center text-right text-rtl">
            <div class="col-md-8">
                <div class="card card-default card-4">
                    <div class="card-header">داشبورد پژوهشی</div>

                    <div class="card-body">
                        <u>{{name}}</u><br>
                        <br>
                        به سامانه پژوهشی دانشگاه خوش آمدید.
                        <br>
                        شما آخرین بار در تاریخ
                        <u>{{lastSeen}}</u>
                        به سامانه مراجعه نموده اید.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Dashboard",
        computed:{
            name(){
                return User.name();
            },
            lastSeen(){
                return User.lastSeen();
            }
        },
        created() {
            User.forceLogOut();
        }
    }
</script>
