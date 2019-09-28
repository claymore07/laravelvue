<template>
    <div>

        <div class="container-fluid">
            <div class="col-md-12 mt-3" >
                <div class="card card-4">
                    <div class="card-header  " style="direction: rtl">
                        <div class="row justify-content-between  text-right">
                            <div class="col-xl-4 m-3">
                                <h4 class=" text-right"><i class="fal fa-scroll-old fa-fw"></i>پروپوزال طرح‌های پژوهشی</h4>
                            </div>
                            <div class="col-xl-4  " >
                            </div>
                        </div><!-- /card-tools -->


                    </div><!-- /.card-header -->
                    <div class="card-body table-responsive p-0">

                        <table class="table table-hover text-right">
                            <tbody>
                            <tr>
                                <th>شماره</th>
                                <th>عنوان طرح پژوهشی</th>
                                <th>نام داور</th>
                                <th>وضعیت بررسی</th>
                                <th @click="toggle()" :class="['sort-control', sortType]">تاریخ دریافت</th>
                                <th >تاریخ داوری</th>
                                <th>ایزار بررسی طرح</th>
                                <th>
                                    <select class="persian-num" v-model="perPage" @change="getResults()">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </th>
                            </tr>
                            <tr v-if="reviewsList.length <= 0">
                                <td colspan="7"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                            </tr>
                            <tr v-for="(review, index) in reviewsList" :key="review.id">
                                <td class="persian-num">{{counter(index)}}</td>
                                <td>{{ review.title | truncate(40) }}</td>
                                <td>{{ review.reviewer_name  }}</td>

                                <td v-if="review.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                <td v-else-if="review.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                <td v-else-if="review.status == '2'"  class="green"><i class="fal fa-search"></i>  {{'تایید شده با اصلاحات' }}</td>
                                <td v-else-if="review.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید' }}</td>
                                <td v-else></td>
                                <td>{{ review.assigned_at | myDate  }}</td>
                                <td>{{ review.reviewed_at | myDate  }}</td>
                                <td colspan="2" >
                                    <router-link :to="{ name: 'ReviewItem', params: { id: review.id }}">
                                        <i class="fa fa-edit blue"></i>
                                    </router-link>
                                </td>

                            </tr>
                            </tbody>
                        </table>
                    </div> <!-- /.card-body -->
                    <div class="card-footer d-flex flex-row justify-content-md-center" style="min-height: 60px">
                        <pagination v-if="" :data="allData" @pagination-change-page="getResults" :limit="1"
                                    :show-disabled="true">
                            <span slot="prev-nav"><i class="fa fa-angle-double-right"></i></span>
                            <span slot="next-nav"><i class="fa fa-fw fa-angle-double-left"></i></span>
                        </pagination>
                        <span class="table-detail persian-num">
                        تعداد
                        {{(this.numTo - this.numStart + 1)    }}
                        از
 {{this.total  }}                   </span>
                    </div><!-- /card-footer --->
                </div>
            </div><!-- /col-md-12 --->


        </div><!-- /container-fluid -->
    </div>
</template>

<script>
    export default {
        name: "ReviewList",
        data(){
            return{

                perPage:5,
                allData:{},
                reviewsList:{},

                order: -1,       // order 1 for desc and 0  for asc
                total: 0,       // total number of papers
                numToShow: 0,   // number of papers shown in this page
                numStart: 0,    // starting row number
                numTo: 0,       // ending number

            }
        },
        methods:{

            counter(i) {
                return this.numStart + i;
            },
            toggle() {
                this.order *= -1;
                this.getResults();
            },

            getResults(page = 1, que = '') {
                let loader1 = Vue.$loading.show();
                let sortOrder = this.order === 1 ? 'asc' : 'desc';
                axios.get('/api/getUserReviewList?order=' + sortOrder + '&page=' + page+
                    '&perPage=' + this.perPage)
                    .then(response => {
                        loader1.hide();
                        this.allData = response.data;
                        this.reviewsList = response.data.data;
                        this.total = response.data.meta.total;
                        this.numToShow = response.data.meta.per_page;
                        this.numStart = response.data.meta.from;
                        this.numTo = response.data.meta.to;
                    }).catch(error =>{
                    loader1.hide();
                });
            },

        },
        computed:{
            sortType() {
                return this.order === 1 ? 'ascending' : 'descending';
            },
        },
        created(){
            this.$parent.pageName = 'آرشیو پروپوزال های پژوهشی';
            this.getResults();
        },
        components: {
        }
    }
</script>

<style scoped>

</style>

