<template>
    <div class="container-fluid">
        <div class="row text-right text-rtl">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header  " style="direction: rtl">
                        <div class="row justify-content-between  text-right">
                            <div class="col-xl-4 m-3">

                                <h4 class=" text-right"><i class="fal fa-tachometer-alt fa-fw"></i>کارتابل پژوهشی</h4>
                            </div>
                        </div><!-- /card-tools -->

                    </div><!-- /.card-header -->
                    <div class="card-body">

                        <div v-if="showResult&&$gate.isAdmin()" class="row justify-content-center  no-gutters mt-2">
                            <apexchart ref="charting" id="chart1" class="col-lg-7 mt-5 order-lg-1"  type="bar" :options="options" :series="series"></apexchart>

                            <div class="col-sm-8 col-lg-5 mt-2 order-lg-0" >
                                <div class="mr-5">
                                    <button @click="changeDate(0)" class="btn btn-success btn-sm">تایید شده</button>
                                    <button @click="changeDate(1)" class="btn btn-secondary btn-sm mr-1">بررسی نشده</button>
                                    <button @click="changeDate(2)" class="btn btn-danger btn-sm mr-1">تایید نشده</button>
                                </div>
                                <apexchart type=pie  class="mt-2"   :options="radialchartOptions" :series="seriesRadial" />
                            </div>

                        </div>
                        <div v-if="showResult&&$gate.isUser()" class="row justify-content-center  mt-2">
                            <apexchart ref="charting1" id="chart2" class="col-lg-11 mt-2" height="450" type="line" :options="optionsUserChart" :series="seriesrChart"></apexchart>
                        </div>
                        <div class="row justify-content-start no-gutters mt-3">

                            <div class="col-lg-3  mt-3 mr-2" >
                                <div class="form-group mb-3 text-right">
                                    <label class="blue text-right  text-rtl">ترم :</label>
                                    <!-- @change="searchit" -->
                                    <select @change="changeTerm()"  v-model="term_id" class="custom-select">
                                        <option selected value="0">تمام ترم ها</option>
                                        <option v-for="term in terms" :value="term.id" :key="term.id">{{term.text}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button @click="getDashboardData('Journal')" class="btn btn-link"
                                                :class="[query_type==='Journal'||Stats['Journal']===0?'disabled':'']" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <i class="nav-icon fal fa-pencil-ruler nav-icon  "></i>
                                            مقالات ژورنالی <span class="badge badge-info">{{Stats['Journal'] | faDigit}}</span>
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseOne" class="collapse show table-responsive" aria-labelledby="headingOne" data-parent="#accordionExample">

                                    <table v-if="query_type === 'Journal'"   class="table table-sm  table-striped table-hover text-right">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>شماره</th>
                                            <th>نام مقاله</th>
                                            <th>نام نویسندگان</th>
                                            <th>نوع مقاله</th>
                                            <th>عنوان ژونال</th>
                                            <th>نام ناشر</th>
                                            <th>نوع ژورنال</th>
                                            <th>نوع مستخرج بودن</th>
                                            <th>ترم</th>
                                            <th>وضعیت بررسی</th>
                                            <th >تاریخ ثبت</th>
                                            <th> ویرایش</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr v-if="allDatas.length <= 0">
                                            <td colspan="21"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                                        </tr>
                                        <tr v-for="(paper, index) in allDatas" :key="paper.id">
                                            <td>{{counter(index) | faDigit}}</td>
                                            <td>{{ paper.title | truncate(40) }}</td>
                                            <td>{{ paper.Authors }}</td>
                                            <td>{{ paper.paper_type }}</td>
                                            <td >{{paper.journal_name | truncate(50)}} </td>
                                            <td >{{paper.publisher_name | truncate(50)}} </td>
                                            <td >{{paper.jtype_name}} </td>
                                            <td >{{paper.excerpt_name}} </td>
                                            <td >{{paper.term_name}} </td>
                                            <td v-if="paper.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                            <td v-else-if="paper.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                            <td v-else-if="paper.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                            <td v-else-if="paper.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                            <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                            <td colspan="1">{{ paper.created_at | myDate  }}</td>
                                            <td>
                                                <router-link :to="{ name: 'paperedit', params: { id: paper.id }}">
                                                    <i class="fa fa-edit blue"></i>
                                                </router-link>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button @click="getDashboardData('Conference')" class="btn btn-link collapsed"
                                                :class="[query_type==='Conference'||Stats['Conference']===0?'disabled':'']" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <i class="nav-icon fal fa-pencil-ruler nav-icon  "></i>
                                            مقالات کنفرانسی <span class="badge badge-info">{{Stats['Conference'] | faDigit}}</span>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse  table-responsive" aria-labelledby="headingTwo" data-parent="#accordionExample">

                                    <table v-if="query_type === 'Conference'"  class="table table-sm  table-striped table-hover text-right">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>شماره</th>
                                            <th>نام مقاله</th>
                                            <th>نام نویسندگان</th>
                                            <th>نوع مقاله</th>
                                            <th>عنوان کنفرانس</th>

                                            <th>نوع کنفرانس</th>
                                            <th>دوره برگزاری</th>
                                            <th>نوع مستخرج بودن</th>
                                            <th>ترم</th>
                                            <th>وضعیت بررسی</th>
                                            <th >تاریخ ثبت</th>
                                            <th> ویرایش</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr v-if="allDatas.length <= 0">
                                            <td colspan="17"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                                        </tr>
                                        <tr v-for="(paper, index) in allDatas" :key="paper.id">
                                            <td>{{counter(index) | faDigit}}</td>
                                            <td>{{ paper.title | truncate(40) }}</td>
                                            <td>{{ paper.Authors }}</td>
                                            <td>{{ paper.paper_type }}</td>
                                            <td >{{paper.conf_name | truncate(50)}} </td>
                                            <td >{{paper.conftype_name}} </td>
                                            <td >{{paper.period}} </td>
                                            <td >{{paper.excerpt_name}} </td>

                                            <td >{{paper.term_name}} </td>
                                            <td v-if="paper.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                            <td v-else-if="paper.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                            <td v-else-if="paper.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                            <td v-else-if="paper.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                            <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                            <td colspan="1">{{ paper.created_at | myDate  }}</td>
                                            <td>
                                                <router-link :to="{ name: 'paperedit', params: { id: paper.id }}">
                                                    <i class="fa fa-edit blue"></i>
                                                </router-link>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                        <button @click="getDashboardData('Book')" class="btn btn-link collapsed"
                                                :class="[query_type==='Book'||Stats['Book']===0?'disabled':'']" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            <i class="nav-icon fal fa-books nav-icon  "></i>
                                            کتاب ها <span class="badge badge-info">{{Stats['Book'] | faDigit}}</span>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseThree" class="collapse  table-responsive" aria-labelledby="headingThree" data-parent="#accordionExample">
                                    <table v-if="query_type === 'Book'" class="table table-sm table-striped table-hover text-right">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>شماره</th>
                                            <th>نام کتاب</th>
                                            <th>نام نویسندگان</th>
                                            <th>نوع کتاب</th>
                                            <th>نام ناشر</th>
                                            <th>موضوع کتاب</th>
                                            <th>تاریخ چاپ</th>
                                            <th>ترم</th>
                                            <th>وضعیت بررسی</th>
                                            <th >تاریخ ثبت</th>
                                            <th> ویرایش</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr v-if="allDatas.length <= 0">
                                            <td colspan="19"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                                        </tr>
                                        <tr v-for="(book, index) in allDatas" :key="book.id">
                                            <td>{{counter(index) | faDigit}}</td>
                                            <td>{{ book.title | truncate(40) }}</td>
                                            <td>{{ book.Authors }}</td>
                                            <td >{{book.publisher_name | truncate(50)}} </td>
                                            <td>{{ book.subject }}</td>
                                            <td>{{ book.booktype_name }}</td>
                                            <td >{{book.publish_year | myDate}} </td>
                                            <td >{{book.term_name}} </td>
                                            <td v-if="book.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                            <td v-else-if="book.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                            <td v-else-if="book.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                            <td v-else-if="book.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                            <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                            <td colspan="1">{{ book.created_at | myDate  }}</td>
                                            <td>
                                                <router-link :to="{ name: 'bookEdit', params: { id: book.id }}">
                                                    <i class="fa fa-edit blue"></i>
                                                </router-link>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <div class="card">
                                <div class="card-header" id="heading4">
                                    <h2 class="mb-0">
                                        <button @click="getDashboardData('Project')" class="btn btn-link collapsed"
                                                :class="[query_type==='Project'||Stats['Project']===0?'disabled':'']" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                            <i class="nav-icon fal fa-project-diagram nav-icon  "></i>
                                            طرح های پژوهشی و فناوری <span class="badge badge-info">{{Stats['Project'] | faDigit}}</span>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse4" class="collapse  table-responsive" aria-labelledby="heading4" data-parent="#accordionExample">
                                    <table v-if="query_type === 'Project'" class="table table-sm table-striped table-hover text-right">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>شماره</th>
                                            <th>عنوان طرح پژوهشی</th>
                                            <th>نام نویسندگان</th>
                                            <th>نوع طرح پژوهشی</th>
                                            <th>بودجه طرح پژوهشی(ریال)</th>
                                            <th>سازمان طرف قرارداد</th>
                                            <th>تاریخ دفاع</th>
                                            <th>ترم</th>
                                            <th>وضعیت بررسی</th>
                                            <th >تاریخ ثبت</th>
                                            <th> ویرایش</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr v-if="allDatas.length <= 0">
                                            <td colspan="15"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                                        </tr>
                                        <tr v-for="(project, index) in allDatas" :key="project.id">
                                            <td>{{counter(index) | faDigit}}</td>
                                            <td>{{ project.title | truncate(40) }}</td>
                                            <td>{{ project.Authors }}</td>
                                            <td>{{ project.project_type_name }}</td>
                                            <td>{{ project.budget | currency }}</td>
                                            <td >{{project.organization}} </td>
                                            <td>{{ project.defense_date  | myDate  }}</td>
                                            <td >{{project.term_name}} </td>
                                            <td v-if="project.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                            <td v-else-if="project.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                            <td v-else-if="project.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                            <td v-else-if="project.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                            <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                            <td colspan="1">{{ project.created_at | myDate  }}</td>
                                            <td>
                                                <router-link :to="{ name: 'projectEdit', params: { id: project.id }}">
                                                    <i class="fa fa-edit blue"></i>
                                                </router-link>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="heading5">
                                    <h2 class="mb-0">
                                        <button @click="getDashboardData('Invention')" class="btn btn-link collapsed"
                                                :class="[query_type==='Invention'||Stats['Invention']===0?'disabled':'']" type="button" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                            <i class="nav-icon fal fa-microscope nav-icon  "></i>
                                            اختراعات و اکتشافات <span class="badge badge-info">{{Stats['Invention'] | faDigit}}</span>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse5" class="collapse  table-responsive" aria-labelledby="heading5" data-parent="#accordionExample">
                                    <table v-if="query_type === 'Invention'" class="table table-sm table-striped table-hover text-right">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>شماره</th>
                                            <th>عنوان اختراع</th>
                                            <th>نوع اختراع</th>
                                            <th>سمت در تیم</th>
                                            <th>مرحع تایید کننده</th>
                                            <th>ترم</th>
                                            <th>وضعیت بررسی</th>
                                            <th>تاریخ ثبت</th>
                                            <th> ویرایش</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr v-if="allDatas.length <= 0">
                                            <td colspan="19"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                                        </tr>
                                        <tr v-for="(invention, index) in allDatas" :key="invention.id">
                                            <td>{{counter(index) | faDigit}}</td>
                                            <td>{{ invention.title | truncate(40) }}</td>
                                            <td>{{ invention.inventiontype_name }}</td>
                                            <td >{{invention.post}} </td>
                                            <td>{{ invention.authorities }}</td>
                                            <td >{{invention.term_name}} </td>
                                            <td v-if="invention.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                            <td v-else-if="invention.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                            <td v-else-if="invention.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                            <td v-else-if="invention.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                            <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                            <td colspan="1">{{ invention.created_at | myDate  }}</td>
                                            <td>
                                                <router-link :to="{ name: 'inventionEdit', params: { id: invention.id }}">
                                                    <i class="fa fa-edit blue"></i>
                                                </router-link>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="heading6">
                                    <h2 class="mb-0">
                                        <button @click="getDashboardData('Referee')" class="btn btn-link collapsed"
                                                :class="[query_type==='Referee'||Stats['Referee']===0?'disabled':'']" type="button" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                            <i class="nav-icon fal fa-gavel nav-icon  "></i>
                                            داوری ها <span class="badge badge-info">{{Stats['Referee'] | faDigit}}</span>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse6" class="collapse  table-responsive" aria-labelledby="heading6" data-parent="#accordionExample">
                                    <table v-if="query_type === 'Referee'" class="table table-sm table-striped table-hover text-right">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>شماره</th>
                                            <th>عنوان اثر داوری شده</th>
                                            <th>نوع اثر داوری شده</th>
                                            <th>تاریخ داوری</th>
                                            <th>ترم</th>
                                            <th>امتیاز کسب شده</th>
                                            <th>وضعیت بررسی</th>
                                            <th>تاریخ ثبت</th>
                                            <th> ویرایش</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr v-if="allDatas.length <= 0">
                                            <td colspan="15"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                                        </tr>
                                        <tr v-for="(referee, index) in allDatas" :key="referee.id">
                                            <td>{{counter(index) | faDigit}}</td>
                                            <td>{{ referee.title | truncate(40) }}</td>
                                            <td>{{ referee.referee_type_name }}</td>
                                            <td>{{ referee.referee_date  | myDate  }}</td>
                                            <td >{{referee.term_name}} </td>
                                            <td >{{referee.score}} </td>
                                            <td v-if="referee.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                            <td v-else-if="referee.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                            <td v-else-if="referee.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                            <td v-else-if="referee.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                            <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                            <td colspan="1">{{ referee.created_at | myDate  }}</td>
                                            <td>
                                                <router-link :to="{ name: 'refereeEdit', params: { id: referee.id }}">
                                                    <i class="fa fa-edit blue"></i>
                                                </router-link>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="heading7">
                                    <h2 class="mb-0">
                                        <button @click="getDashboardData('Reward')" class="btn btn-link collapsed"
                                                :class="[query_type==='Reward'||Stats['Reward']===0?'disabled':'']" type="button" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                            <i class="nav-icon fal fa-award nav-icon  "></i>
                                            جوایز <span class="badge badge-info">{{Stats['Reward'] | faDigit}}</span>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse7" class="collapse  table-responsive" aria-labelledby="heading7" data-parent="#accordionExample">
                                    <table v-if="query_type === 'Reward'" class="table table-sm table-striped table-hover text-right">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>شماره</th>
                                            <th>عنوان جشنواره، رقابت و یا مراسم</th>
                                            <th>عنوان جایزه</th>
                                            <th>نوع جشنواره، رقابت یا مراسم</th>
                                            <th>رتبه کسب شده</th>
                                            <th>تاریخ برگزاری</th>
                                            <th>ترم</th>
                                            <th>امتیاز کسب شده</th>
                                            <th>وضعیت بررسی</th>
                                            <th>تاریخ ثبت</th>
                                            <th> ویرایش</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr v-if="allDatas.length <= 0">
                                            <td colspan="15"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                                        </tr>
                                        <tr v-for="(reward, index) in allDatas" :key="reward.id">
                                            <td>{{counter(index) | faDigit}}</td>
                                            <td>{{ reward.name | truncate(40) }}</td>
                                            <td>{{ reward.title | truncate(40) }}</td>
                                            <td>{{ reward.type_name }}</td>
                                            <td><span v-if="reward.place == 1" class="mr-3">رتبه اول</span>
                                                <span v-else-if="reward.place == 2" class="mr-3">رتبه دوم</span>
                                                <span v-else-if="reward.place == 3" class="mr-3">رتبه سوم</span>
                                            </td>

                                            <td>{{ reward.holding_date  | myDate  }}</td>


                                            <td >{{reward.term_name}} </td>
                                            <td >{{reward.score}} </td>
                                            <td v-if="reward.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                            <td v-else-if="reward.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                            <td v-else-if="reward.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                            <td v-else-if="reward.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                            <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                            <td colspan="1">{{ reward.created_at | myDate  }}</td>
                                            <td>
                                                <router-link :to="{ name: 'rewardEdit', params: { id: reward.id }}">
                                                    <i class="fa fa-edit blue"></i>
                                                </router-link>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="heading8">
                                    <h2 class="mb-0">
                                        <button @click="getDashboardData('Thesis')" class="btn btn-link collapsed"
                                                :class="[query_type==='Thesis'||Stats['Thesis']===0?'disabled':'']" type="button" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                                            <i class="nav-icon fal fa-book nav-icon  "></i>
                                            پابان نامه ها <span class="badge badge-info">{{Stats['Thesis'] | faDigit}}</span>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse8" class="collapse  table-responsive" aria-labelledby="heading8" data-parent="#accordionExample">
                                    <table v-if="query_type === 'Thesis'" class="table table-sm table-striped table-hover text-right">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>شماره</th>
                                            <th>عنوان پایان نامه</th>
                                            <th>نوع پایان نامه</th>
                                            <th>تاریخ دفاع</th>
                                            <th>ترم</th>
                                            <th>امتیاز کسب شده</th>
                                            <th>وضعیت بررسی</th>
                                            <th >تاریخ ثبت</th>
                                            <th> ویرایش</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr v-if="allDatas.length <= 0">
                                            <td colspan="15"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                                        </tr>
                                        <tr v-for="(thesis, index) in allDatas" :key="thesis.id">
                                            <td>{{counter(index) | faDigit}}</td>
                                            <td>{{ thesis.title | truncate(40) }}</td>
                                            <td>{{ thesis.thesis_type_name }}</td>
                                            <td>{{ thesis.defense_date  | myDate  }}</td>

                                            <td >{{thesis.term_name}} </td>
                                            <td >{{thesis.score}} </td>
                                            <td v-if="thesis.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                            <td v-else-if="thesis.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                            <td v-else-if="thesis.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                            <td v-else-if="thesis.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                            <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                            <td colspan="1">{{ thesis.created_at | myDate  }}</td>
                                            <td>
                                                <router-link :to="{ name: 'thesisEdit', params: { id: thesis.id }}">
                                                    <i class="fa fa-edit blue"></i>
                                                </router-link>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="heading9">
                                    <h2 class="mb-0">
                                        <button @click="getDashboardData('TEDChair')" class="btn btn-link collapsed"
                                                :class="[query_type==='TEDChair'||Stats['Thesis']===0?'disabled':'']" type="button" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                                            <i class="nav-icon fal fa-lightbulb-on nav-icon  "></i>
                                            کرسی های نظریه پردازی <span class="badge badge-info">{{Stats['TEDChair'] | faDigit}}</span>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse9" class="collapse  table-responsive" aria-labelledby="heading9" data-parent="#accordionExample">
                                    <table v-if="query_type === 'TEDChair'" class="table table-sm table-striped table-hover text-right">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>شماره</th>
                                            <th>عنوان کرسی نظریه پزداری</th>
                                            <th>نوع کرسی</th>
                                            <th>محل برگزاری</th>
                                            <th>تاریخ ارائه</th>
                                            <th>ترم</th>
                                            <th>امتیاز کسب شده</th>
                                            <th>وضعیت بررسی</th>
                                            <th >تاریخ ثبت</th>
                                            <th> ویرایش</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr v-if="allDatas.length <= 0">
                                            <td colspan="14"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                                        </tr>
                                        <tr v-for="(ted, index) in allDatas" :key="ted.id">
                                            <td>{{counter(index) | faDigit}}</td>
                                            <td>{{ ted.title | truncate(40) }}</td>
                                            <td>{{ ted.ted_type_name }}</td>
                                            <td>{{ ted.location  }}</td>
                                            <td>{{ ted.presentation_date  | myDate  }}</td>

                                            <td >{{ted.term_name}} </td>
                                            <td >{{ted.score}} </td>
                                            <td v-if="ted.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                            <td v-else-if="ted.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                            <td v-else-if="ted.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                            <td v-else-if="ted.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                            <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                            <td colspan="1">{{ ted.created_at | myDate  }}</td>
                                            <td>
                                                <router-link :to="{ name: 'tedEdit', params: { id: ted.id }}">
                                                    <i class="fa fa-edit blue"></i>
                                                </router-link>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="heading10">
                                    <h2 class="mb-0">
                                        <button @click="getDashboardData('Grant')" class="btn btn-link collapsed"
                                                :class="[query_type==='Grant'||Stats['Grant']===0?'disabled':'']" type="button" data-toggle="collapse" data-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
                                            <i class="nav-icon fal fa-dollar-sign nav-icon  "></i>
                                            بودجه های جذب شده <span class="badge badge-info">{{Stats['Grant'] | faDigit}}</span>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse10" class="collapse  table-responsive" aria-labelledby="heading10" data-parent="#accordionExample">
                                    <table v-if="query_type === 'Grant'" class="table table-sm table-striped table-hover text-right">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>شماره</th>
                                            <th>عنوان بودجه جذب شده</th>
                                            <th>میزان بودجه</th>
                                            <th>نوع بودجه</th>
                                            <th>تاریخ تصویب</th>
                                            <th>ترم</th>
                                            <th>امتیاز کسب شده</th>
                                            <th>وضعیت بررسی</th>
                                            <th >تاریخ ثبت</th>
                                            <th> ویرایش</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr v-if="allDatas.length <= 0">
                                            <td colspan="15"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                                        </tr>
                                        <tr v-for="(grant, index) in allDatas" :key="grant.id">
                                            <td>{{counter(index) | faDigit}}</td>
                                            <td>{{ grant.title | truncate(40) }}</td>
                                            <td>{{ grant.budget | currency }}
                                                <span v-if="grant.type ==0">ریال</span>
                                                <span v-if="grant.type ==1">دلار</span> </td>

                                            <td>{{ grant.type_name }}</td>

                                            <td>{{ grant.submit_date  | myDate  }}</td>


                                            <td >{{grant.term_name}} </td>
                                            <td >{{grant.score}} </td>
                                            <td v-if="grant.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                            <td v-else-if="grant.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                            <td v-else-if="grant.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                            <td v-else-if="grant.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                            <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                            <td colspan="1">{{ grant.created_at | myDate  }}</td>
                                            <td>
                                                <router-link :to="{ name: 'grantEdit', params: { id: grant.id }}">
                                                    <i class="fa fa-edit blue"></i>
                                                </router-link>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="heading11">
                                    <h2 class="mb-0">
                                        <button @click="getDashboardData('Course')" class="btn btn-link collapsed"
                                                :class="[query_type==='Course'||Stats['Course']===0?'disabled':'']" type="button" data-toggle="collapse" data-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                                            <i class="nav-icon fal fa-users-class nav-icon  "></i>
                                            دوره ها <span class="badge badge-info">{{Stats['Course'] | faDigit}}</span>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse11" class="collapse  table-responsive" aria-labelledby="heading11" data-parent="#accordionExample">
                                    <table v-if="query_type === 'Course'" class="table table-sm table-striped table-hover text-right">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>شماره</th>
                                            <th>عنوان دوره</th>
                                            <th>نقش در دروه</th>
                                            <th>سازمان برگزار کننده</th>
                                            <th>مدت دوره</th>
                                            <th>تاریخ برگزاری</th>
                                            <th>ترم</th>
                                            <th>امتیاز کسب شده</th>
                                            <th>وضعیت بررسی</th>
                                            <th>تاریخ ثبت</th>
                                            <th> ویرایش</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr v-if="allDatas.length <= 0">
                                            <td colspan="15"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                                        </tr>
                                        <tr v-for="(course, index) in allDatas" :key="course.id">
                                            <td>{{counter(index) | faDigit}}</td>
                                            <td>{{ course.title | truncate(40) }}</td>
                                            <td>{{ course.role }}</td>
                                            <td>{{ course.organization }}</td>
                                            <td>{{ course.duration }}</td>
                                            <td>{{ course.holding_date  | myDate  }}</td>

                                            <td >{{course.term_name}} </td>
                                            <td >{{course.score}} </td>
                                            <td v-if="course.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                            <td v-else-if="course.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                            <td v-else-if="course.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                            <td v-else-if="course.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                            <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                            <td colspan="1">{{ course.created_at | myDate  }}</td>
                                            <td>
                                                <router-link :to="{ name: 'courseEdit', params: { id: course.id }}">
                                                    <i class="fa fa-edit blue"></i>
                                                </router-link>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="heading12">
                                    <h2 class="mb-0">
                                        <button @click="getDashboardData('Booklet')" class="btn btn-link collapsed"
                                                :class="[query_type==='Booklet'||Stats['Booklet']===0?'disabled':'']" type="button" data-toggle="collapse" data-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
                                            <i class="nav-icon fal fa-presentation nav-icon  "></i>
                                            جزوه ها <span class="badge badge-info">{{Stats['Booklet'] | faDigit}}</span>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse12" class="collapse  table-responsive" aria-labelledby="heading12" data-parent="#accordionExample">
                                    <table v-if="query_type === 'Booklet'" class="table table-sm table-striped table-hover text-right">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>شماره</th>
                                            <th>عنوان جزوه یا اسلاید</th>
                                            <th>نام درس</th>
                                            <th>نوع جزوه یا اسلاید</th>
                                            <th>مقطع</th>
                                            <th>تاریخ تالیف</th>
                                            <th>ترم</th>
                                            <th>امتیاز کسب شده</th>
                                            <th>وضعیت بررسی</th>
                                            <th >تاریخ ثبت</th>
                                            <th> ویرایش</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr v-if="allDatas.length <= 0">
                                            <td colspan="15"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                                        </tr>
                                        <tr v-for="(booklet, index) in allDatas" :key="booklet.id">
                                            <td>{{counter(index) | faDigit}}</td>
                                            <td>{{ booklet.title | truncate(40) }}</td>
                                            <td>{{ booklet.name | truncate(40) }}</td>

                                            <td>{{ booklet.booklet_type_name }}</td>
                                            <td>{{ booklet.degree }}</td>
                                            <td>{{ booklet.compilation_date  | myDate  }}</td>


                                            <td >{{booklet.term_name}} </td>
                                            <td >{{booklet.score}} </td>
                                            <td v-if="booklet.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                            <td v-else-if="booklet.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                            <td v-else-if="booklet.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                            <td v-else-if="booklet.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                            <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                            <td colspan="1">{{ booklet.created_at | myDate  }}</td>
                                            <td>
                                                <router-link :to="{ name: 'bookletEdit', params: { id: booklet.id }}">
                                                    <i class="fa fa-edit blue"></i>
                                                </router-link>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Dashboard",
        data(){
            return {
                terms: [],
                data:[],
                success: [],
                failed: [],
                unchecked: [],
                Stats:[],
                allDatas:[],
                numStart:1,
                titles: [],
                query_type: 'Journal',
                start_date: '',
                end_date: '',
                term_id: 0,
                showResult: false,
                radialchartOptions: {

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
                        position: 'bottom',
                        horizontalAlign: 'center',
                    },
                    labels: [],
                },
                optionsUserChart: {
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
                    yaxis: [{
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
                    },
                        {
                            seriesName: 'Income',
                            opposite: true,
                            axisTicks: {
                                show: true,
                            },
                            axisBorder: {
                                show: true,
                                color: '#00E396'
                            },
                            labels: {
                                style: {
                                    color: '#00E396',
                                }
                            },
                            title: {
                                text: "امتیاز",
                                style: {
                                    color: undefined,
                                    fontSize: '16px',
                                    fontFamily: 'IRANSans, Arial, sans-serif',
                                    cssClass: 'apexcharts-yaxis-title',
                                }
                            },
                        },
                    ]
                },
                options: {
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
            counter(i) {
                return this.numStart + i;
            },
            changeTerm(){
                this.getDashboardStats();
                this.getDashboardData(this.query_type);
            },
            getDashboardData(type = 'Journal') {
                let loader1 = Vue.$loading.show();

                if(this.$gate.isAdmin()){
                    this.query_type=type;
                    this.getResults();
                }
                axios.post('/api/dashboardReport?term_id=' + this.term_id + '&query_type='+type)
                    .then(response => {
                        loader1.hide();
                        this.numStart =1;
                        this.allDatas = response.data.data;
                        this.query_type = type;

                    }).catch(error => {
                    loader1.hide();
                });

            },
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
            getChartData(){
                axios.post('/api/personalStats' )
                    .then(response => {

                        this.optionsUserChart = {...this.optionsUserChart,...{
                                title: {
                                    text: `نمودار وضعیت تعداد آثار ثبت شده و امتیازات کسب شده`,
                                    align: 'center'
                                },
                                xaxis: {
                                    categories: Object.values(response.data.titles)
                                }
                            }};
                        this.counts = response.data.counts;
                        this.scores = response.data.scores;
                        this.showResult = true;
                    }).catch(error => {

                });
            },
            getResults(){

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
            },
            getDashboardStats(){
                axios.post('/api/dashboardStats?term_id='+this.term_id)
                    .then(response=>{
                        this.Stats = response.data.data;
                    })
            }
        },
        computed:{
            name(){
                return User.name();
            },
            lastSeen(){
                return User.lastSeen();
            },

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

            seriesrChart: function () {
                return [{
                    name: 'امتیازات',
                    data: this.scores
                }, {
                    name: 'تعداد آثار',
                    data: this.counts
                }
                ]
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
        created() {
            User.forceLogOut();
            this.getTermsList();
            this.getDashboardStats();
            this.getDashboardData();
            if(this.$gate.isAdmin()){
                this.getResults();
            }else{
                this.getChartData();
            }

        }
    }
</script>
