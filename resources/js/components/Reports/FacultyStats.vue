<template>
    <div class="container-fluid">
        <div class="col-md-12 mt-3" v-if="$gate.isAdminOrAuthor()">
            <div class="card card-4">
                <div class="card-header  " style="direction: rtl">
                    <div class="row justify-content-between  text-right">
                        <div class="col-xl-4 m-3">
                            <h4 class=" text-right"><i class="fal fa-file-chart-line fa-fw"></i>گزارش نموداری براساس دانشکده ها</h4>
                        </div>
                    </div><!-- /card-tools -->

                </div><!-- /.card-header -->
                <div class="card-body  p-4">

                    <div class="row justify-content-start  mt-3">

                        <div class="col-lg-4  mt-3 mr-2" >
                            <div class="form-group mb-3 text-right">
                                <label class="blue text-right  text-rtl">ترم :</label>
                                <!-- @change="searchit" -->
                                <Select2  class="form-control select2-form-control non-modal-select2" id="term_id"
                                          v-model="term_id"
                                          :options="terms"
                                          :settings="{theme: 'bootstrap4', placeholder: 'انتخاب ترم', width: '100%' ,multiple: true}">
                                </Select2>
                            </div>
                        </div>
                        <div class="col-lg-4  mt-3 mr-2" >
                            <div class="form-group mb-3 text-right">
                                <label class="blue text-right  text-rtl">دسته ها :</label>
                                <!-- @change="searchit" -->
                                <select  v-model="query_type" class="custom-select">
                                    <option selected value="Journal">مقالات ژورنالی</option>
                                    <option selected value="Conference">مقالات کنفرانسی</option>
                                    <option selected value="Book">کتاب ها</option>
                                    <option selected value="Project">طرح های پژوهشی</option>
                                    <option selected value="Invention">اختراعات</option>
                                    <option selected value="TEDChair">کرسی های نظریه پردازی</option>
                                    <option selected value="Referee">داوری ها</option>
                                    <option selected value="ResearchActivity">فعالیت های اجرایی پژوهشی</option>
                                    <option selected value="Thesis">پایان نامه ها</option>
                                    <option selected value="Reward">جوایز</option>
                                    <option selected value="Grant">بودجه های جذب شده</option>
                                    <option selected value="Booklet">جزوات</option>
                                    <option selected value="Course">دوره ها</option>

                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-4 mt-3  mr-2">
                            <div  style="direction: ltr; text-align: right" >
                                <label class="blue text-right  text-rtl">از تاریخ :</label>

                                <span class="float-left font-16 "> {{start_date | myDate}}</span>
                                <date-picker format="YYYY-MM-DD" v-model="start_date" name="start_date" locale="fa,en"></date-picker>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-3  mr-2">
                            <div  style="direction: ltr; text-align: right" >
                                <label class="blue text-right  text-rtl">تا تاریخ :</label>

                                <span class="float-left font-16 "> {{end_date | myDate}}</span>
                                <date-picker format="YYYY-MM-DD" name="end_date" locale="fa,en" v-model="end_date"></date-picker>

                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center  mt-2">

                        <button @click="getResults()"  type="button" class="btn btn-info mr-3 mt-2 btn-lg"><i  class="fal fa-eye text-white ml-3"></i>مشاهده گزارش</button>
                        <button @click="resetForm()"  type="button" class="btn btn-warning mr-3 mt-2 btn-lg"><i  class="fal fa-retweet text-white ml-3"></i>بازنشانی فرم گزارش</button>

                    </div>
                    <div v-if="showResult" class="row justify-content-center  mt-2">
                        <apexchart ref="charting" id="chart1" class="col-lg-10 mt-5" height="600" type="bar" :options="options" :series="series"></apexchart>
                    </div>
                    <div v-if="showResult" class="row justify-content-center  ">
                        <button @click="changeDate(0)" class="btn btn-success btn-sm">تایید شده</button>
                        <button @click="changeDate(1)" class="btn btn-secondary btn-sm mr-1">بررسی نشده</button>
                        <button @click="changeDate(2)" class="btn btn-danger btn-sm mr-1">تایید نشده</button>
                    </div>
                    <div v-if="showResult" class="row justify-content-center  mt-5">
                         <apexchart type=pie  class="col-lg-8"  :options="radialchartOptions" :series="seriesRadial" />
                    </div>

                </div>
            </div>
        </div>
        <div v-if="!$gate.isAdminOrAuthor()">
            <not-found></not-found>
        </div><!-- /404 page -->
    </div>

</template>

<script>
    import Select2 from 'v-select2-component';
    export default {
        name: "FacultyStats",
        data() {
            return {
                terms: [],
                data:[],
                success: [],
                failed: [],
                unchecked: [],

                titles: [],
                query_type: 'Journal',
                start_date: '',
                end_date: '',
                term_id: [],
                showResult: false,
                radialchartOptions: {
                    dataLabels: {
                        enabled: true,
                        enabledOnSeries: undefined,
                        formatter: val => this.$options.filters.faDigits(Math.round(val*100)/100) + '%',
                        style: {
                            fontSize: '14px',
                            fontFamily: 'IRANSans, Arial, sans-serif',
                        },

                    },
                    tooltip: {
                        y: {
                            formatter: val => this.$options.filters.faDigits(val) ,
                        }
                    },
                    chart: {
                        toolbar: {
                            show: true,
                            tools: {
                                download: true,
                                selection: true,
                                zoom: true,
                                zoomin: true,
                                zoomout: true,
                                pan: true,
                                reset: true | '<img src="/static/icons/reset.png" width="20">',
                                customIcons: []
                            },
                            autoSelected: 'zoom'
                        },
                    },
                    legend: {
                        show: true,
                        fontSize: '14px',
                        fontFamily: 'IRANSans, Arial',
                    },
                    labels: [],
                },

                options: {
                    dataLabels: {
                        enabled: true,
                        enabledOnSeries: undefined,
                        formatter: val => this.$options.filters.faDigits(Math.round(val*100)/100) ,
                        style: {
                            fontSize: '14px',
                            fontFamily: 'IRANSans, Arial, sans-serif',
                        },

                    },
                    chart: {
                        id: 'vuechart-example'
                    },
                    xaxis: {
                        categories: [],
                        labels: {
                            show: true,
                            // rotate: -45,
                            // rotateAlways: true,
                            style: {

                                fontSize: '12px',
                                fontFamily: 'IRANSans, Arial, sans-serif',
                                cssClass: 'apexcharts-xaxis-label',
                            },
                        },
                        lines: {
                             show: true
                        }
                    },

                    legend: {
                        show: true,
                        position: 'top',
                        horizontalAlign: 'center',
                        fontSize: '18px',
                        fontFamily: 'IRANSans, Arial',
                    },
                    yaxis: {
                        labels: {
                            formatter: val => this.$options.filters.faDigits(Math.round(val*100)/100),
                            style: {
                                color: '#000000',
                                fontSize: '16px',
                                fontFamily: 'IRANSans, Arial, sans-serif',
                            },
                        },
                        title: {
                            text: 'تعداد',
                            style: {
                                color: undefined,
                                fontSize: '16px',
                                fontFamily: 'IRANSans, Arial, sans-serif',
                                cssClass: 'apexcharts-yaxis-title',
                            },
                        },

                        lines: {
                            show: true
                        }
                    }
                },
               // series: this.makeData()
            }
        },
        methods:{
            changeDate(type){
              if(type === 0){
                  this.radialchartOptions = {...this.radialchartOptions,...{
                          title: {
                              text: `نمودار درصد  ${this.chartTitle} پذیرفته شده براساس دانشکده`,
                              align: 'center'
                          },
                      }};
                  this.data = this.success;
              }else if(type === 1){
                  this.radialchartOptions = {...this.radialchartOptions,...{
                          title: {
                              text: `نمودار درصد  ${this.chartTitle} بررسی نشده براساس دانشکده`,
                              align: 'center'
                          },
                      }};
                  this.data = this.unchecked;
              }else if(type === 2){
                  this.radialchartOptions = {...this.radialchartOptions,...{
                          title: {
                              text: `نمودار درصد  ${this.chartTitle} تایید نشده براساس دانشکده`,
                              align: 'center'
                          },
                      }};
                  this.data = this.failed;
              }
            },
            resetForm(){
                this.term_id= [];
                this.start_date='';
                this.end_date='';
                this.query_type= 'Journal';
                this.showResult = false;
            },
            getResults(){
                if(this.start_date !== '' || this.end_date !== '') {
                    if (!moment(this.start_date).isBefore(this.end_date)) {
                        this.errorSwal('بازه شروع تاریخ گزارش باید از تاریخ اتمام آن قبل تر باشد!');
                        return false;
                    }
                }

                let loader1 = Vue.$loading.show();
                axios.post('/api/facultyStats?term_id=' + this.term_id +
                    '&start_date=' + this.start_date + '&end_date=' + this.end_date + '&query_type=' + this.query_type )
                    .then(response => {
                        loader1.hide();
                        this.options = {...this.options,...{
                                title: {
                                    text: `نمودار وضعیت رسیدگی به ${this.chartTitle} براساس دانشکده`,
                                    align: 'center'
                                },
                                xaxis: {
                                    categories: Object.values(response.data.titles)
                                }
                            }};
                        this.radialchartOptions = {...this.radialchartOptions,...{
                                title: {
                                    text: `نمودار درصد  ${this.chartTitle} پذیرفته شده براساس دانشکده`,
                                    align: 'center'
                                },
                                labels:  Object.values(response.data.titles)

                            }};
                        this.success = response.data.success;
                        this.data = this.success;
                        this.failed = response.data.failed;
                        this.unchecked = response.data.unchecked;
                        this.showResult = true;
                    }).catch(error => {
                    loader1.hide();
                });
            },

            getTermsList(){
                axios.post('/api/termsList')
                    .then(response=>{
                        this.terms = response.data.terms;
                    })
            }
        },
        computed: {
            series: function() {
                return [{
                    name: 'تایید شده',
                    data: this.success
                },{
                    name: 'تایید نشده',
                    data: this.failed
                },{
                    name: 'بررسی نشده',
                    data: this.unchecked
                }
                ]
            },
            seriesRadial: function() {
                return  this.data;

            },
            chartTitle: function () {
                if(this.query_type === 'Journal'){
                    return 'مقالات ژونالی';
                }else if(this.query_type === 'Conference'){
                    return 'مقالات کنفرانسی';
                }else if(this.query_type === 'Book'){
                    return 'کتاب ها';
                }else if(this.query_type === 'Project'){
                    return 'طرح های پژوهشی';
                }else if(this.query_type === 'Invention'){
                    return 'اختراعات';
                }else if(this.query_type === 'TEDChair'){
                    return 'کرسی های نظریه پردازی';
                }else if(this.query_type === 'Referee'){
                    return 'داوری ها';
                }else if(this.query_type === 'Thesis'){
                    return 'پایان نامه ها';
                }else if(this.query_type === 'Reward'){
                    return 'جوایز';
                }else if(this.query_type === 'Grant'){
                    return 'بودجه های جذب شده';
                }else if(this.query_type === 'Booklet'){
                    return 'جزوات';
                }else if(this.query_type === 'Course'){
                    return 'دوره ها';
                }
            }
        },
        created(){
            this.$parent.pageName = 'گزارش نموداری براساس دانشکده ها';
            this.getTermsList();
        },
        components: {
            Select2,
        }

    }
</script>

<style scoped>

</style>
