<template>
    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12 mt-3">
                <div class="card card-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header text-white text-right" style="height: 250px;background: url('/img/photo1.png') center center;">
                        <h3 class="widget-user-username">پروفایل: <span v-if="form.hasProfile">{{form.Fname + ' ' + form.Lname}}</span> <span v-else>{{form.name}} پروفایل ناقص</span></h3>
                        <h5 v-if="form.type == 'admin'" class="widget-user-desc">مسئول سیستم</h5>
                        <h5 v-else-if="form.type == 'author'" class="widget-user-desc">کارشناس</h5>
                        <h5 v-else class="widget-user-desc">کاربر</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" :src="getProfilePhoto()" alt="User Avatar">
                    </div>
                    <div class="card-footer">
                         <div class="row">

                        </div>
                        <!-- /.row-->
                    </div>
                </div>
            </div>

            <!-- tab -->

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills text-right" style="direction: rtl!important;">
                            <li class="nav-item "><a class="nav-link active show" href="#timeline" data-toggle="tab">فعالیت ها</a></li>
                            <li class="nav-item "><a  class="nav-link " href="#settings" data-toggle="tab">تنظیمات</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div v-if="showResult" class="row justify-content-center  mt-2">
                            <apexchart ref="charting1" id="chart1" class="col-lg-11 mt-2" height="450" type="line" :options="options" :series="series"></apexchart>
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
                        <div class="tab-content">
                            <!-- Activity Tab -->
                            <div class="tab-pane active show text-right text-rtl" id="timeline">
                                <!-- The timeline -->
                                <div class="accordion" id="accordionExample">
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h2 class="mb-0">
                                                <button @click="getResults('Journal')" class="btn btn-link"
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
                                            <button @click="getResults('Conference')" class="btn btn-link collapsed"
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
                                                <button @click="getResults('Book')" class="btn btn-link collapsed"
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
                                                <button @click="getResults('Project')" class="btn btn-link collapsed"
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
                                                <button @click="getResults('Invention')" class="btn btn-link collapsed"
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
                                                <button @click="getResults('Referee')" class="btn btn-link collapsed"
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
                                                <button @click="getResults('Reward')" class="btn btn-link collapsed"
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
                                                <button @click="getResults('Thesis')" class="btn btn-link collapsed"
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
                                                <button @click="getResults('TEDChair')" class="btn btn-link collapsed"
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
                                                <button @click="getResults('Grant')" class="btn btn-link collapsed"
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
                                                <button @click="getResults('Course')" class="btn btn-link collapsed"
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
                                                <button @click="getResults('Booklet')" class="btn btn-link collapsed"
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
                            </div><!-- /END timeline tab -->
                            <!-- Setting Tab -->
                            <div class="tab-pane " id="settings">
                                <form class="form-horizontal" @submit.prevent="updateInfo" @keydown="form.onKeydown($event)" id="Form">
                                    <div class="form-group mt-4 text-right">
                                        <label class="blue">نام:</label>
                                        <input  type="text"  name="Fname" placeholder="نام"
                                               class="form-control" v-model="form.Fname"
                                               pattern="[^A-Za-z0-9.-_+*/×-]{1,30}"
                                               data-error-pattern-mismatch="نام باید فارسی باشد!"

                                               :class="{ 'is-invalid': form.errors.has('Fname') } " @input="() => {}">
                                        <has-error :form="form" field="Fname"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">نام خانوادگی:</label>
                                        <input  v-model="form.Lname"
                                               placeholder="نام خانوادگی"
                                               pattern="[^A-Za-z0-9.-_+*/×-]{1,30}"
                                               data-error-pattern-mismatch="نام خانوادگی باید فارسی باشد!"
                                               required
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('Lname') }">
                                        <has-error :form="form" field="Lname"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">نام کاربری:</label>
                                        <input v-model="form.name" type="text" name="name" placeholder="نام کاربری"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('name') }"
                                               pattern="[A-Za-z]{6,}"
                                               data-error-pattern-mismatch="نام کاربری باید به زبان انگلیسی به طول بیش از 6 کاراکتر باشد!"
                                               data-error-generic="این فیلد باید تکمیل شود."
                                               required>
                                        <has-error :form="form" field="name"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">رایان نامه:</label>
                                        <input v-model="form.email" type="email" name="email" placeholder="example@gmail.com"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('email') }"
                                               required >
                                        <has-error :form="form" field="email"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">کلمه عبور:</label>

                                        <input  v-model="form.password" type="password" name="password" placeholder="کلمه عبور ( حداقل 6 کاراکتر)"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('password') }"
                                        >
                                        <has-error :form="form" field="password"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">شماره سیبا:</label>
                                        <input v-model="form.siba" type="text" maxlength="13" name="siba"id="siba" placeholder="0000000000000"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('siba') }"
                                               pattern="[0-9]{13}"
                                               data-error-pattern-mismatch="شماره حساب سیبا باید عدد و بطول 13 باشد!"
                                               required>
                                        <has-error :form="form" field="siba"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">نشماره موبایل:</label>
                                        <input v-model="form.phone" type="tel" maxlength="11" name="phone"id="phone" placeholder="09111111111"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }"
                                               pattern="[0-9]{11}"
                                               data-error-pattern-mismatch="شماره موبایل باید عدد و بطول 11 باشد!"
                                               required>
                                        <has-error :form="form" field="phone"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">شماره پرسنلی:</label>
                                        <input  v-model="form.personal_id" type="text" name="personal_id" placeholder="111"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('personal_id') }"
                                               pattern="[0-9]{3,12}"
                                               data-error-pattern-mismatch="شماره پرسنلی باید عدد و حداقل به طول 3  باشد!"
                                               required>
                                        <has-error :form="form" field="personal_id"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">خلاصه بیوگرافی:</label>
                                        <textarea v-model="form.bio" name="bio" id="bio"
                                                  placeholder="خلاصه بیوگرافی:"
                                                  class="form-control"
                                                  :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                                        <has-error :form="form" field="bio"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right d-none">
                                        <label class="blue">نوع دسترسی به سامانه:</label>
                                        <select name="type" v-model="form.type" id="type" class="form-control test1"
                                                :class="{ 'is-invalid': form.errors.has('type') }">
                                            <option selected disabled value="">نوع دسترسی به سامانه</option>
                                            <option value="admin">Admin</option>
                                            <option value="user">Standard User</option>
                                            <option value="author">Author</option>
                                        </select>
                                        <has-error :form="form" field="type"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">آخرین مدرک تحصیلی:</label>
                                        <Select2 class="form-control select2-form-control"
                                                 :class="{ 'is-invalid': form.errors.has('degree_id') }" v-model="form.degree_id"
                                                 :options="degrees"
                                                 @change="removeError('degree_id')"
                                                 :settings="{theme: 'bootstrap4', placeholder: 'آخرین مدرک تحصیلی', width: '100%' }">
                                        </Select2>
                                        <has-error :form="form" field="degree_id"></has-error>
                                    </div>
                                    <div class="form-group my-5  text-right">
                                        <label class="blue">مرتبه علمی:</label>
                                        <Select2 class="form-control select2-form-control"
                                                 :class="{ 'is-invalid': form.errors.has('rank_id') }" v-model="form.rank_id"
                                                 :options="ranks"
                                                 @change="removeError('rank_id')"
                                                 :settings="{theme: 'bootstrap4', placeholder: 'مرتبه علمی', width: '100%' }">
                                        </Select2>
                                        <has-error :form="form" field="rank_id"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">نوع عضویت در باشگاه پژوهشگران:</label>
                                        <Select2 class="form-control select2-form-control" id="member_id"
                                                 :class="{ 'is-invalid': form.errors.has('member_id') }" v-model="form.member_id"
                                                 :options="members"
                                                 @change="removeError('member_id')"
                                                 :settings="{theme: 'bootstrap4', placeholder: 'نوع عضویت در باشگاه پژوهشگران', width: '100%' }">
                                        </Select2>
                                        <has-error :form="form" field="member_id"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">گروه آموزشی:</label>
                                        <Select2 class="form-control select2-form-control" id="department_id"
                                                 :class="{ 'is-invalid': form.errors.has('department_id') }"
                                                 v-model="form.department_id"
                                                 :options="departments"
                                                 @change="removeError('department_id')"
                                                 :settings="{theme: 'bootstrap4', placeholder: 'گروه آموزشی', width: '100%' }">
                                        </Select2>
                                        <has-error :form="form" field="department_id"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">نام دانشکده:</label>
                                        <Select2 class="form-control select2-form-control" id="faculty_id"
                                                 :class="{ 'is-invalid': form.errors.has('faculty_id') }" v-model="form.faculty_id"
                                                 :options="faculties"
                                                 @change="removeError('faculty_id')"
                                                 :settings="{theme: 'bootstrap4', placeholder: 'نام دانشکده', width: '100%' }">
                                        </Select2>
                                        <has-error :form="form" field="faculty_id"></has-error>
                                    </div>
                                    <div class="form-group my-5 text-right">
                                        <label class="blue">نوع همکاری با دانشگاه:</label>
                                        <Select2 @change="baseToggle(), removeError('position_id')" class="form-control select2-form-control" id="position_id"
                                                 :class="{ 'is-invalid': form.errors.has('position_id') }" v-model="form.position_id"
                                                 :options="positions"
                                                 :settings="{theme: 'bootstrap4', placeholder: 'نوع همکاری با دانشگاه', width: '100%' }">
                                        </Select2>
                                        <has-error :form="form" field="position_id"></has-error>
                                    </div>
                                    <div v-if="baseMode" class="form-group my-5 text-right">
                                        <label class="blue">پایه:</label>
                                        <input v-model="form.base" :class="{ 'is-invalid': form.errors.has('base') }"
                                               style="direction: rtl; text-align: right !important;"
                                               class="form-control text-ltr text-left addon" id="base1" placeholder="1"
                                               pattern="[0-9]{1,2}"
                                               data-error-pattern-mismatch="شماره پرسنلی باید عدد و حداقل به طول 3  باشد!"
                                                min="1"
                                               required name="base" type="number">
                                        <has-error :form="form" field="base"></has-error>
                                    </div>


                                    <div class="custom-file">
                                        <input @change="updateProfile" name="photo" type="file" class="custom-file-input" id="customFile" data-browse="Bestand kiezen">
                                        <label v-if="photoName === ''" class="custom-file-label"  for="customFile">انتخاب فایل تصویر</label>
                                        <label v-else class="custom-file-label"  for="customFile">{{photoName}}</label>
                                    </div>

                                    <div class="form-group mt-5">

                                            <button :disabled="form.busy" type="submit" class="btn  ripple btn-lg btn-block btn-success">برروزرسانی</button>

                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- end tabs -->
        </div>
    </div>
</template>


<script>
    import Select2 from 'v-select2-component';
    export default {
        name: "Profile",
        data() {
            return {
                baseMode: true,         // checks if پایه or base required for use based on their position
                degrees: [],            // degrees array
                ranks: [],              // array of ranks or رتبه علمی
                members: [],            // array of نوع عضویت در باشگاه پژوهشگران
                departments: [],        // array of گروه های آموزشی
                faculties: [],          // array of دانشکده ها
                positions: [],          // array of نوع همکاری با دانشگاه
                photoName:'',           // user profile photo name
                form: new Form({
                    hasProfile: true,
                    id: '',
                    name: '',
                    Fname: '',
                    Lname: '',
                    email: '',
                    type: '',
                    bio: '',
                    photo: '',
                    password: '',
                    siba: '',
                    phone: '',
                    personal_id: '',
                    degree_id: '',
                    rank_id: '',
                    member_id: '',
                    position_id: '',
                    faculty_id: '',
                    department_id: '',
                    base: ''
                }),
                terms: [],
                data:[],
                scores: [],
                counts: [],
                Stats:[],
                allDatas:[],
                numStart:1,
                titles: [],
                query_type: 'Journal',
                term_id: 0,
                showResult: false,
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

            }
        },
        mounted() {
            $('#Form').html5cvm({
                generic: 'این گزینه باید تکمیل شود!',
                typeMismatch: "نوع داده ورودی همخوانی ندارد."
            });
        },
        methods:{
            counter(i) {
                return this.numStart + i;
            },
            changeTerm(){
                this.getProfileStats();
                this.getResults(this.query_type);
            },
            getResults(type = 'Journal') {
                let loader1 = Vue.$loading.show();

                axios.post('/api/personalReport?term_id=' + this.term_id + '&query_type='+type)
                    .then(response => {
                        loader1.hide();
                        this.numStart =1;
                        this.allDatas = response.data.data;
                        this.query_type = type;

                    }).catch(error => {
                    loader1.hide();
                });

            },
            getChartData(){
                axios.post('/api/personalChart' )
                    .then(response => {

                        this.options = {...this.options,...{
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
            getTermsList(){
                axios.post('/api/termsList')
                    .then(response=>{
                        this.terms = response.data.terms;
                    })
            },
            getProfileStats(){
                axios.post('/api/personalStats?term_id='+this.term_id)
                    .then(response=>{
                        this.Stats = response.data.data;
                    })
            },
            // remove field error from form.errors bag onChange
            removeError(field){
                this.form.errors.clear(field)
            },
            // shows or hides the پایه or base input based on the user position
            baseToggle() {
                if (this.form.position_id == 1 || this.form.position_id == 2 || this.form.position_id == 3) {
                    this.baseMode = true;
                } else {
                    this.baseMode = false;
                    this.form.base = 0;
                }
              //  console.log(this.baseMode);
            },
            farsiTypeInputSetter(e, field) {
                switch (field) {
                    case 'Fname':
                        this.form.Fname = e;
                        break;
                    case 'Lname':
                        this.form.Lname = e;
                        break;
                }
            },
            // loads the user profile photo if there is any or default photo
            getProfilePhoto(){
                let photo = (this.form.photo === 'profile.png') ? "/img/profile.png" : "/img/profile/"+ this.form.photo ;
                return photo;
            },
            // gets the necessary data to initialize user forms
            getProfileRation(){
                axios.get('/api/profileRelation')
                    .then(response => {
                        this.degrees = response.data.degrees;
                        this.ranks = response.data.ranks;
                        this.members = response.data.members;
                        this.departments = response.data.departments;
                        this.faculties = response.data.faculties;
                        this.positions = response.data.positions;
                    })
                    .catch((e)=>{
                           // console.log(e);
                        }
                    );
            },
            // handles the user form when submited
            updateInfo(){
                this.$Progress.start();
                if(this.form.password == ''){
                    this.form.password = undefined;
                }
                this.form.put('/api/profile/')
                    .then(()=>{
                        Fire.$emit('AfterCreate');
                        this.successToast('پروفایل شما با موفقیت بروزرسانی شد.')
                        this.$Progress.finish();
                    })
                    .catch(()=>{
                        this.$Progress.fail();
                    });
            },
            // handles the user profile upload form when submited
            updateProfile(e){

                let file = e.target.files[0];
                this.photoName = file.name;
                let reader = new FileReader();
                let limit = 1024 * 1024 * 2;
                if(file['size'] > limit){
                    this.errorSwal('حداکثر حجم مجاز 2Mb  می باشد.')
                    return false;
                }
                reader.onloadend = (file) => {
                    this.form.photo = reader.result;
                };

                reader.readAsDataURL(file);
            },
            // perpare user edit form // the @param user data
            fillForm(user) {
                this.baseMode = true;
                this.form.reset();
                this.form.fill(user);
                if (user.profile) {
                    /* this.form.fill(user.profile);*/
                    user.base = user.profile.base;
                     user.degree_id = user.profile.degree_id;
                     user.rank_id = user.profile.rank_id;
                     user.member_id = user.profile.member_id;
                     user.department_id = user.profile.department_id;
                     user.faculty_id = user.profile.faculty_id;
                     user.position_id = user.profile.position_id;
                     user.Fname = user.profile.Fname;
                     user.Lname = user.profile.Lname;
                     user.siba = user.profile.siba;
                     user.phone = user.profile.phone;
                     user.personal_id = user.profile.personal_id;
                    user.hasProfile = true;
                    if (user.position_id == 1 || user.position_id == 2 || user.position_id == 3) {
                        this.baseMode = true;
                    } else {
                        this.baseMode = false;
                        this.form.base = 0;
                    }
                } else {
                    user.hasProfile = false;
                }
                this.form.fill(user);
            },
            loadSetting(){
                axios.get("/api/profile")
                    .then((response)=>{
                        this.fillForm(response.data.user)
                    });
            }
        },computed: {
            series: function () {
                return [{
                    name: 'امتیازات',
                    data: this.scores
                }, {
                    name: 'تعداد آثار',
                    data: this.counts
                }
                ]
            },
        },
        created(){
            this.$parent.pageName = 'پروفایل شما';
            this.getProfileRation();
            Fire.$on('AfterCreate',() => {
                this.loadSetting();
            });
            this.getTermsList();
            this.getProfileStats();
            this.getResults();
            this.loadSetting();
            this.getChartData();

        },
        components: {
            Select2,
        }
    }
</script>

<style scoped>

</style>
