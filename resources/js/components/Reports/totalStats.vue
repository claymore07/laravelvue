<template>
    <div class="container-fluid">
        <div class="col-md-12 mt-3" v-if="$gate.isAdminOrAuthor()">
            <div class="card card-4">
                <div class="card-header  " style="direction: rtl">
                    <div class="row justify-content-between  text-right">
                        <div class="col-xl-4 m-3">
                            <h4 class=" text-right"><i class="fal fa-file-chart-line fa-fw"></i>گزارش نموداری وضعیت رسیدگی کلی آثار</h4>
                        </div>
                    </div><!-- /card-tools -->

                </div><!-- /.card-header -->
                <div class="card-body  p-4">

                    <div class="row justify-content-start  mt-3">

                        <div class="col-lg-4  mt-3 mr-2" >
                            <div class="form-group mb-3 text-right">
                                <label class="blue text-right  text-rtl">ترم :</label>
                                <!-- @change="searchit" -->
                                <Select2  class="form-control select2-form-control" id="term_id"
                                          v-model="term_id"
                                          :options="terms"
                                          :settings="{theme: 'bootstrap4', placeholder: 'انتخاب ترم', width: '100%' ,multiple: true}">
                                </Select2>
                            </div>
                        </div>
                        <div class="col-lg-4  mt-3 mr-2" >

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
                        <apexchart ref="charting" id="chart1" class="col-lg-12 mt-5" height="600" type="bar" :options="options" :series="series"></apexchart>
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
        name: "totalStats",
        data() {
            return {
                terms: [],
                total:0,
                result: [],

                titles: ['تایید شده','رد شده','بررسی نشده','عدم تایید موقت','اصلاح شده'],
                colors : [ '#28a745' , '#dc3545','#20c997', '#fd7e14', '#17a2b8'],
                start_date: '',
                end_date: '',
                term_id: [],
                showResult: false,

                options: {
                    chart: {
                        id: 'vuechart-example'
                    },
                    colors: [ '#28a745' , '#dc3545','#20c997', '#fd7e14', '#17a2b8'],
                    plotOptions: {
                        bar: {
                            distributed: true
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        enabledOnSeries: undefined,
                        formatter: val => this.$options.filters.faDigits(Math.round(val*100)/100) ,
                        style: {
                            fontSize: '14px',
                            fontFamily: 'IRANSans, Arial, sans-serif',
                        },

                    },
                    xaxis: {
                        categories: [],
                        labels: {
                            show: true,
                            rotate: 0,
                            rotateAlways: true,
                            style: {
                                colors: [ '#28a745' , '#dc3545','#20c997', '#fd7e14', '#17a2b8'],
                                fontSize: '18px',
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

            resetForm(){
                this.term_id= [];
                this.start_date='';
                this.end_date='';
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
                axios.post('/api/termStats?term_id=' + this.term_id +
                    '&start_date=' + this.start_date + '&end_date=' + this.end_date  )
                    .then(response => {
                        loader1.hide();
                        this.options = {...this.options,...{
                                title: {
                                    text: `نمودار وضعیت رسیدگی کلی آثار || تعداد کل: ${response.data.total}  `,
                                    align: 'center'
                                },
                                xaxis: {
                                    categories: Object.values(this.titles)
                                }
                            }};

                        this.result = response.data.result;
                        this.total = response.data.total;
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
                    data: this.result
                },
                ]
            },
            chartTitle: function () {

                    return this.total;

            }
        },
        created(){
            this.$parent.pageName = 'گزارش نموداری رسیدگی کلی آثار';
            this.getTermsList();
        },
        components: {
            Select2,
        }

    }
</script>

<style scoped>

</style>


