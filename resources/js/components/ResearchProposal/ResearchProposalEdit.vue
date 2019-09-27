<template>
    <div>
        <div class="container-fluid text-rtl text-right my-5">
            <div class="card card-4 my-5">
                <div class="card-header justify-content-around d-flex " style="direction: rtl">
                    <div class="col">
                        <h3 class=" text-right"><i class="fal fa-scroll-old fa-fw"></i> اطلاعات پروپوزال پژوهشی</h3>
                    </div>
                    <div class="card-tools">
                        <button class="btn btn-success" @click="goback"><i style="font-size: 16px" class="fal fa-undo"></i> بازگشت</button>
                    </div><!-- /card-tools -->
                </div><!-- /.card-header -->
                <div class="card-body  px-0">
                    <table class="table table-hover table-striped">
                        <thead class="thead-dark">
                        <tr>
                            <th class="font-18"><i class="fal fa-project-diagram fa-fw"></i> اطلاعات پروپوزال پژوهشی</th>
                            <th v-if="checkList">موارد ناقص</th>
                        </tr>
                        </thead>
                        <tbody v-if="proposal.id">
                        <tr>
                            <td class="font-16">
                                <span class="blue">عنوان فارسی :</span>
                                <span class="mr-3">{{proposal.title}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('عنوان فارسی')" title="عدم تایید"><i @click="checkListHistory"  class="fa fa-times-circle fe-pulse-w-pause "></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('عنوان فارسی')"
                                         @change.native="onChange('عنوان فارسی', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">عنوان انگلیسی :</span>
                                <span class="mr-3">{{proposal.en_title}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('عنوان انگلیسی')" title="عدم تایید"><i @click="checkListHistory"  class="fa fa-times-circle fe-pulse-w-pause "></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('عنوان انگلیسی')"
                                         @change.native="onChange('عنوان انگلیسی', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue ">نویسندگان:</span>
                                <span v-for="author of proposal.Authors" class="mr-3 ">
                                        <span >{{author.name}}،</span>
                                </span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نویسندگان')" title="عدم تایید"><i @click="checkListHistory"  class="fa fa-times-circle fe-pulse-w-pause "></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check
                                    :checked="checkListForm.list && checkListForm.list.includes('نویسندگان')"
                                    @change.native="onChange('نویسندگان', $event)"
                                    type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>

                        <tr>
                            <td class="font-16">
                                <span class="blue">نوع پروپوزال :</span>
                                <span class="mr-3">{{proposal.proposal_type}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نوع پروپوزال')" title="عدم تایید"><i @click="checkListHistory"  class="fa fa-times-circle fe-pulse-w-pause "></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('نوع پروپوزال')"
                                         @change.native="onChange('نوع پروپوزال', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">نوع کاربرد پروپوزال :</span>
                                <span class="mr-3">{{proposal.proposal_usage}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نوع کاربرد پروپوزال')" title="عدم تایید"><i @click="checkListHistory"  class="fa fa-times-circle fe-pulse-w-pause "></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('نوع کاربرد پروپوزال')"
                                         @change.native="onChange('نوع کاربرد پروپوزال', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">دانشکده :</span>
                                <span class="mr-3">{{proposal.faculty}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('دانشکده')" title="عدم تایید"><i @click="checkListHistory"  class="fa fa-times-circle fe-pulse-w-pause "></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('دانشکده')"
                                         @change.native="onChange('دانشکده', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">محل اجرا :</span>
                                <span class="mr-3">{{proposal.project_location}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('محل اجرا')" title="عدم تایید"><i @click="checkListHistory"  class="fa fa-times-circle fe-pulse-w-pause "></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('محل اجرا')"
                                         @change.native="onChange('محل اجرا', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">مدت زمان مورد نیاز :</span>
                                <span class="mr-3 persian-num">{{proposal.duration}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('مدت زمان مورد نیاز')" title="عدم تایید"><i @click="checkListHistory"  class="fa fa-times-circle fe-pulse-w-pause "></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('مدت زمان مورد نیاز')"
                                         @change.native="onChange('مدت زمان مورد نیاز', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>


                        <tr>
                            <td class="font-16">
                                <span class="blue">ارزش تخمینی پروژه:</span>
                                <span  class="mr-3 persian-num">{{proposal.value | currency}} ریال </span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('ارزش تخمینی پروژه')" title="عدم تایید"><i @click="checkListHistory"  class="fa fa-times-circle fe-pulse-w-pause "></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('ارزش تخمینی پروژه')"
                                         @change.native="onChange('ارزش تخمینی پروژه', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">بودجه طرح پژوهشی:</span>
                                <span  class="mr-3 persian-num">{{proposal.budget | currency}} ریال </span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('بودجه طرح پژوهشی')" title="عدم تایید"><i @click="checkListHistory"  class="fa fa-times-circle fe-pulse-w-pause "></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('بودجه طرح پژوهشی')"
                                         @change.native="onChange('بودجه طرح پژوهشی', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue ">کلمات کلید:</span>
                                <span v-for="tag of proposal.tags" class="mr-3 "> {{tag.name}}، </span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('کلمات کلید')" title="عدم تایید"><i @click="checkListHistory"  class="fa fa-times-circle fe-pulse-w-pause "></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check
                                    :checked="checkListForm.list && checkListForm.list.includes('کلمات کلید')"
                                    @change.native="onChange('کلمات کلید', $event)"
                                    type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue ">فایل های ضمیمه:</span>
                                <span v-for="(file, index) of proposal.files" class="mr-3 ">
                                    <div v-if="checkFileType(file)" class="btn-group text-ltr" role="group" aria-label="Basic example">
                                         <a  class="btn btn-lg btn-info" :href="'../files/proposals/'+file.name"><i class="fal fa-download fa-fw"></i>  </a>
                                         <a  class="btn btn-lg btn-info" :href="'../files/proposals/'+file.name">ضمیمه {{index+1|faDigit}}  <i class="fal fa-file-archive fa-fw"></i></a>
                                    </div>
                                    <div v-else class="btn-group text-ltr" role="group" aria-label="Basic example">
                                      <a  :href="'../files/proposals/'+file.name" class="btn btn-lg btn-info"><i class="fal fa-download"></i></a>
                                      <button @click="pdfModal(file.name)" type="button" class="btn btn-lg btn-info">ضمیمه {{index+1|faDigit}} <i class="fal fa-file-pdf fa-fw"></i></button>

                                    </div>
                            </span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('فایل های ضمیمه')" title="عدم تایید"><i @click="checkListHistory"  class="fa fa-times-circle fe-pulse-w-pause "></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check
                                    :checked="checkListForm.list && checkListForm.list.includes('فایل های ضمیمه')"
                                    @change.native="onChange('فایل های ضمیمه', $event)"
                                    type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16" >
                                <span class="blue ">چکیده :</span><br>
                                <div v-html="proposal.abstract"></div>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('چکیده')" title="عدم تایید"><i @click="checkListHistory"  class="fa fa-times-circle fe-pulse-w-pause "></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check
                                    :checked="checkListForm.list && checkListForm.list.includes('چکیده')"
                                    @change.native="onChange('چکیده', $event)"
                                    type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16" >
                                <span class="blue ">مقدمه :</span><br>
                                <div v-html="proposal.introduction"></div>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('مقدمه')" title="عدم تایید"><i @click="checkListHistory"  class="fa fa-times-circle fe-pulse-w-pause "></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check
                                    :checked="checkListForm.list && checkListForm.list.includes('مقدمه')"
                                    @change.native="onChange('مقدمه', $event)"
                                    type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16" >
                                <span class="blue ">بیان مسئله :</span><br>
                                <div v-html="proposal.problem"></div>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('بیان مسئله')" title="عدم تایید"><i @click="checkListHistory"  class="fa fa-times-circle fe-pulse-w-pause "></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check
                                    :checked="checkListForm.list && checkListForm.list.includes('بیان مسئله')"
                                    @change.native="onChange('بیان مسئله', $event)"
                                    type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16" >
                                <span class="blue ">نوآوری :</span><br>
                                <div v-html="proposal.innovation"></div>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نوآوری')" title="عدم تایید"><i @click="checkListHistory"  class="fa fa-times-circle fe-pulse-w-pause "></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check
                                    :checked="checkListForm.list && checkListForm.list.includes('نوآوری')"
                                    @change.native="onChange('نوآوری', $event)"
                                    type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16" >
                                <span class="blue ">نیازمندی ها :</span><br>
                                <div v-html="proposal.requirements"></div>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نیازمندی ها')" title="عدم تایید"><i @click="checkListHistory"  class="fa fa-times-circle fe-pulse-w-pause "></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check
                                    :checked="checkListForm.list && checkListForm.list.includes('نیازمندی ها')"
                                    @change.native="onChange('نیازمندی ها', $event)"
                                    type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>



                        <tr>
                            <td class="font-16">
                                <span class="blue ">وضعیت بررسی:</span>
                                <span v-if="proposal.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</span>
                                <span v-else-if="proposal.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</span>
                                <span v-else-if="proposal.status == '5'"  class="green"><i class="fal fa-search"></i>  {{'تحت داوری' }}</span>
                                <span v-else-if="proposal.status == '6'"  class="green"><i class="fal fa-search"></i>  {{'تایید و ارسال برای داوری' }}</span>
                                <span v-else-if="proposal.status == '7'"  class="green"><i class="fal fa-search"></i>  {{'تایید شده با اصلاحات' }}</span>
                                <span v-else-if="proposal.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</span>
                                <span v-else-if="proposal.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</span>
                                <span v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</span>
                            </td>
                        </tr>
                        <tr v-if="$gate.isAdminOrAuthor()&& proposal.show_reviewer_comments">
                            <td class="font-16">
                                <span class="blue ">وضعیت بررسی پیشین:</span>
                                <span v-if="proposal.last_status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</span>
                                <span v-else-if="proposal.last_status == '7'"  class="green"><i class="fal fa-search"></i>  {{'تایید شده با اصلاحات' }}</span>
                                <span v-else  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</span>
                            </td>
                        </tr>
                        <tr v-if="proposal.show_reviewer_comments">
                            <td  class="font-16">
                                <span class="blue ">نظر نهایی کارشناس<span> </span>:</span>
                                <div v-html="proposal.comment"></div>
                            </td>
                        </tr>
                        <tr v-if="proposal.show_reviewer_comments" v-for="(comment, index) of proposal.reviewer_comments">

                            <td  class="font-16">

                                <span class="blue ">نظر داور<span> {{index+1}}</span>:</span>

                                <span v-if="comment.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</span>
                                <span v-else-if="comment.status == '2'"  class="green"><i class="fal fa-search"></i>  {{'تایید شده با اصلاحات' }}</span>
                                <span v-else  class="red"><i class="fal fa-times"></i>  {{'عدم تایید' }}</span>
                                <br>
                                <span class="blue "> توضیحات :</span>
                                <div v-html="comment.comment"></div>
                            </td>
                        </tr>

                        <tr  v-show="checkList">
                            <td colspan="2">
                                <form  data-vv-scope="checkListForm">
                                    <label for="status" class="blue ">وضعیت بررسی: </label>
                                    <select v-model="checkListForm.status"
                                            :class="[(  checkListForm.errors.has('status') ? 'is-invalid': ''  )]"
                                            @change="checkListForm.errors.clear('status')"
                                            class="custom-select" name="" id="status">
                                        <option  selected disabled>انتخاب گزینه</option>
                                        <option value="6" ><i class="fa-check"></i>تایید و ارسال برای داوری</option>
                                        <option value="2" >عدم تایید موقت</option>
                                        <option value="3" >عدم تایید قطعی</option>
                                    </select>
                                    <i v-show="checkListForm.errors.has('status')" class="red far fa-exclamation-triangle"></i>
                                    <span v-show="checkListForm.errors.has('status')" class="red d-inline-block">{{ checkListForm.errors.get('status') }}</span>
                                </form>
                            </td>
                        </tr>
                        <tr  v-show="checkList">
                            <td colspan="2">
                                <form  data-vv-scope="checkListForm">
                                    <label for="id00" class="blue mt-3">توضیحات: </label>
                                    <i v-show="checkListForm.errors.has('comment')" class="red far fa-exclamation-triangle"></i>
                                    <span v-show="checkListForm.errors.has('comment')" class="red d-inline-block">{{ checkListForm.errors.get('comment') }}</span>
                                    <tinymce dir="rtl" @editorInit="e => e.setContent(checkListForm.comment)" v-model="checkListForm.comment" :other_options="options" name="comment" id="id00"></tinymce>
                                </form>
                            </td>
                        </tr>
                        <tr   class="text-center">
                            <td colspan="2">
                            </td>
                        </tr>
                        <!-- /conference detail part -->
                        </tbody><!-- /tbody -->
                    </table><!-- /table -->
                </div><!-- /card-body -->

            </div><!-- /card -->
            <div class="row align-content-center">
                <div class="fixed-bottom mx-auto d-md-flex bg-white   justify-content-center py-2">
                    <button v-if="proposal.status != 3 && proposal.status != 1 && proposal.status != 5 && proposal.status != 6 && proposal.last_status != 7" @click="proposalEditModal" class="btn btn-lg mx-1 btn-secondary">ویرایش  پروپوزال پژوهشی</button>
                    <button v-if="proposal.last_status == proposal.status && proposal.status == 7 && proposal.last_status == 7" @click="proposalEditModal" class="btn btn-lg mx-1 btn-secondary">ویرایش  پروپوزال پژوهشی</button>

                    <button v-if="$gate.isAdminOrAuthor()&& proposal.status == 6" @click="getReviewersList"  class="btn btn-lg btn-success mx-5">ارسال برای داوری</button>
                    <button v-if="$gate.isAdminOrAuthor()&& (proposal.status == 5 || proposal.status == 7 || proposal.last_status == 7)" @click="getReviewersList"  class="btn btn-lg btn-success mx-5">مشاهده وضعیت داوری</button>
                    <button v-if="checkList" @click="checkListSubmit" class="btn btn-lg btn-success mx-5"><i class="fal fa-check fa-fw"></i>ثبت نتبجه بررسی</button>

                    <button @click="checkListHistory" class="btn btn-lg mx-1 btn-secondary"><i class="fal fa-history fa-fw mx-2"></i>تاریخچه بررسی</button>
                    <button v-if="$gate.isAdminOrAuthor()" @click="toggleCheckList"  class="btn btn-lg mx-1 btn-warning">چک لیست بررسی</button>
                </div>
            </div>
        </div><!-- /container -->
        <div   class="modal  fade" id="proposalEditModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel22"><i
                            class="far fa-users-class fa-fw"></i> ویرایش اطلاعات پروپوزال پژوهشی</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" >
                        <form-wizard
                            back-button-text="مرحله قبل"
                            next-button-text="مرحله بعد"
                            finish-button-text="ثبت نهایی"
                            :start-index="0"
                            @on-complete="onComplete"
                            ref="wizard">
                            <h2 slot="title">تکمیل پروپوزال پروپوزال‌ پژوهشی</h2>
                            <!--  -->
                            <tab-content title="پروپوزال پژوهشی" :before-change="proposalValidation"  icon="far fa-scroll-old">
                                <form @submit.prevent="createProposal()" @keydown="form.onKeydown($event)" @change="form.onKeydown($event)" data-vv-scope="form" id="Form">

                                    <div class="modal-body">
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">عنوان فارسی پروپوزال پژوهشی<i class="red mx-1">*</i>:</label>
                                            <input  type="text"  name="title" placeholder="عنوان فارسی پروپوزال پژوهشی"
                                                    class="form-control" v-model="form.title"
                                                    v-validate="'required'"
                                                    autofocus
                                                    :class="{ 'is-invalid': form.errors.has('title') || errors.has('form.title') } " >
                                            <i v-show="errors.has('form.title') || form.errors.has('title')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.title')" class="red d-inline-block">{{ errors.first('form.title') }}</span>
                                            <span v-show="form.errors.has('title')" class="red d-inline-block">{{ form.errors.get('title') }}</span>
                                        </div>
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">عنوان انگلیسی پروپوزال پژوهشی<i class="red mx-1">*</i>:</label>
                                            <input  type="text"  name="en_title" placeholder="عنوان پروپوزال پژوهشی و فناوری"
                                                    class="form-control" v-model="form.en_title"
                                                    v-validate="'required'"
                                                    :class="{ 'is-invalid': form.errors.has('en_title') || errors.has('form.en_title') } " >
                                            <i v-show="errors.has('form.en_title') || form.errors.has('en_title')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.en_title')" class="red d-inline-block">{{ errors.first('form.en_title') }}</span>
                                            <span v-show="form.errors.has('en_title')" class="red d-inline-block">{{ form.errors.get('en_title') }}</span>
                                        </div>
                                        <div class="form-group my-4 text-right">
                                            <label class="blue">نوع پروپوزال پژوهشی<i class="red mx-1">*</i>:</label>
                                            <Select2 v-validate="'required'" data-vv-name="proposal_type_id"
                                                     class="form-control select2-form-control" id="proposal_type_id"
                                                     :class="[( errors.has('form.proposal_type_id') || form.errors.has('proposal_type_id') ? 'is-invalid': ''  )]"
                                                     v-model="form.proposal_type_id"
                                                     :options="proposal_types"
                                                     @change="removeError('proposal_type_id')"
                                                     :settings="{theme: 'bootstrap4', placeholder: 'نوع پروپوزال پژوهشی', width: '100%' }">
                                            </Select2>

                                            <i v-show="errors.has('form.proposal_type_id') || form.errors.has('proposal_type_id')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.proposal_type_id')" class="red d-inline-block">{{ errors.first('form.proposal_type_id') }}</span>
                                            <span v-show="form.errors.has('proposal_type_id')" class="red d-inline-block">{{ form.errors.get('proposal_type_id') }}</span>
                                        </div>
                                        <div class="form-group my-4 text-right">
                                            <label class="blue">نوع کاربرد پروپوزال پژوهشی<i class="red mx-1">*</i>:</label>
                                            <Select2 v-validate="'required'" data-vv-name="proposal_usage_id"
                                                     class="form-control select2-form-control" id="proposal_usage_id"
                                                     :class="[( errors.has('form.proposal_usage_id') || form.errors.has('proposal_usage_id') ? 'is-invalid': ''  )]"
                                                     v-model="form.proposal_usage_id"
                                                     :options="proposal_usages"
                                                     @change="removeError('proposal_usage_id')"
                                                     :settings="{theme: 'bootstrap4', placeholder: 'نوع کاربرد پروپوزال پژوهشی', width: '100%' }">
                                            </Select2>

                                            <i v-show="errors.has('form.proposal_usage_id') || form.errors.has('proposal_usage_id')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.proposal_usage_id')" class="red d-inline-block">{{ errors.first('form.proposal_usage_id') }}</span>
                                            <span v-show="form.errors.has('proposal_usage_id')" class="red d-inline-block">{{ form.errors.get('proposal_usage_id') }}</span>
                                        </div>
                                        <div class="form-group my-4 text-right">
                                            <label class="blue">دانشکده یا گروه علمی مربوطه<i class="red mx-1">*</i>:</label>
                                            <Select2 v-validate="'required'" data-vv-name="faculty_id"
                                                     class="form-control select2-form-control" id="faculty_id"
                                                     :class="[( errors.has('form.faculty_id') || form.errors.has('faculty_id') ? 'is-invalid': ''  )]"
                                                     v-model="form.faculty_id"
                                                     :options="faculties"
                                                     @change="removeError('faculty_id')"
                                                     :settings="{theme: 'bootstrap4', placeholder: 'دانشکده یا گروه علمی مربوطه', width: '100%' }">
                                            </Select2>

                                            <i v-show="errors.has('form.faculty_id') || form.errors.has('faculty_id')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.faculty_id')" class="red d-inline-block">{{ errors.first('form.faculty_id') }}</span>
                                            <span v-show="form.errors.has('faculty_id')" class="red d-inline-block">{{ form.errors.get('faculty_id') }}</span>
                                        </div>
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">محل اجرای پروپوزال<i class="red mx-1">*</i>:</label>
                                            <input  type="text"  name="project_location" placeholder="محل اجرای پروپوزال"
                                                    class="form-control" v-model="form.project_location"
                                                    v-validate="'required'"
                                                    :class="{ 'is-invalid': form.errors.has('project_location') || errors.has('form.project_location')} " @input="() => {}">
                                            <i v-show="errors.has('form.project_location') || form.errors.has('project_location')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.project_location')" class="red d-inline-block">{{ errors.first('form.project_location') }}</span>
                                            <span v-show="form.errors.has('project_location')" class="red d-inline-block">{{ form.errors.get('project_location') }}</span>
                                        </div>
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">مدت زمان مورد نیاز<i class="red mx-1">*</i>:</label>
                                            <input  type="text"  name="duration" placeholder="مدت زمان مورد نیاز"
                                                    class="form-control persian-num" v-model="form.duration"
                                                    v-validate="'required'"
                                                    :class="{ 'is-invalid': form.errors.has('duration') || errors.has('form.duration')} " @input="() => {}">
                                            <i v-show="errors.has('form.duration') || form.errors.has('duration')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.duration')" class="red d-inline-block">{{ errors.first('form.duration') }}</span>
                                            <span v-show="form.errors.has('duration')" class="red d-inline-block">{{ form.errors.get('duration') }}</span>
                                        </div>
                                        <div  class="form-group my-3 text-right">
                                            <label class="blue ">ارزش تخمینی پروژه<i class="red mx-1">*</i>:{{ form.value | currency}}<span >ریال</span></label>
                                            <input  type="number" name="value" step="1" min="1"
                                                    placeholder="1"
                                                    v-validate="'required|integer'"
                                                    class="form-control" v-model="form.value"
                                                    :class="[( errors.has('form.value') || form.errors.has('value') ? 'is-invalid': ''  ) ]"
                                            >
                                            <i v-show="errors.has('form.value') || form.errors.has('value')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.value')" class="red d-inline-block">{{ errors.first('form.value') }}</span>
                                            <span v-show="form.errors.has('value')" class="red d-inline-block">{{ form.errors.get('value') }}</span>
                                        </div>
                                        <div  class="form-group my-3 text-right">
                                            <label class="blue ">بودجه پروپوزال پژوهشی<i class="red mx-1">*</i>:{{ form.budget | currency}}<span >ریال</span></label>
                                            <input  type="number" name="budget" step="1" min="1"
                                                    placeholder="1"
                                                    v-validate="'required|integer'"
                                                    class="form-control" v-model="form.budget"
                                                    :class="[( errors.has('form.budget') || form.errors.has('budget') ? 'is-invalid': ''  ) ]"
                                            >
                                            <i v-show="errors.has('form.budget') || form.errors.has('budget')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.budget')" class="red d-inline-block">{{ errors.first('form.budget') }}</span>
                                            <span v-show="form.errors.has('budget')" class="red d-inline-block">{{ form.errors.get('budget') }}</span>
                                        </div>

                                        <div class="form-group my-3 text-right">
                                            <label class="blue text-right">فایل های ضمیمه<i class="red mx-1">*</i>:</label>
                                        </div>
                                        <div class="mt-2 text-right">
                                            <span>آیا می خواهید در فایل های ضمیمه تغییر اعمال کنید؟</span>
                                            <a @click="fileChange(true)" class="text-white btn btn-info btn-lg">آری</a>
                                            <a v-if="fileChanging" @click="fileChange(false)" class="text-white btn btn-warning btn-lg">خیر</a>
                                        </div>
                                        <div v-if="fileChanging" class="mt-2 text-right">
                                            <div class="form-group my-3 text-right">
                                                <label class="blue text-right">نوع تغییر<i class="red mx-1">*</i>:</label>
                                            </div>
                                            <div class="form-group mb-4 text-right border-bottom">
                                                <p-radio  v-model="form.fileChangeType" name="fileChangeType" value="0" class="p-icon p-curve p-bigger p-pulse text-ltr"  color="info-o">
                                                    <i slot="extra" class="icon far fa-check"></i>
                                                    جایگزینی با فایل های قبلی
                                                </p-radio>
                                                <p-radio v-validate="'required'" v-model="form.fileChangeType"
                                                         name="fileChangeType" value="1" type="radio" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                                    <i slot="extra" class="icon far fa-check"></i>
                                                    افزودن به فایل های قبلی
                                                </p-radio>

                                                <br>
                                                <i v-show="errors.has('form.fileChangeType') || form.errors.has('fileChangeType')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form.fileChangeType')" class="red d-inline-block">{{ errors.first('form.fileChangeType') }}</span>
                                                <span v-show="form.errors.has('fileChangeType')" class="red d-inline-block">{{ form.errors.get('fileChangeType') }}</span>
                                            </div>
                                        </div>
                                        <div v-if="fileChanging" class="form-group my-3 text-right">
                                            <label class="blue text-right">فایل های ضمیمه<i class="red mx-1">*</i>:</label>
                                            <span class="red"><br/>
                                                اسکن قرارداد بصورت pdf<br>
                                                اسکن مجوز شورای بصورت pdf در صورت وجود<br>
                                                اسکن صورت جلسه دفاع بصورت pdf در صورت وجود<br>
                                                سایر فایل های مربوطه بصورت یک فایل فشرده با پسونده zip
                                            </span>
                                        </div>
                                        <div v-if="fileChanging" class="custom-file text-ltr text-right mt-3 mb-5">
                                            <input @change="fieldChange" multiple v-validate="'required|ext:rar,zip,pdf|size:5000'" name="files" type="file" class="custom-file-input" id="customFile" >
                                            <label  class="custom-file-label"   for="customFile">انتخاب فایل های ضمیمه</label>
                                            <span class="badge badge-info my-2 mx-2" style="font-size: 14px; color: #ffffff; background-color: #17a2b8;"
                                                  v-for="item in fileName">{{item}}</span>
                                            <has-error :form="form" field="files"></has-error>
                                            <div class="text-rtl">
                                                <i v-show="errors.has('form.files')|| form.errors.has('files')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form.files') " class="red d-inline-block">{{ errors.first('form.files') }}</span>
                                                <span v-show="form.errors.has('files')" class="red d-inline-block">{{ form.errors.get('files') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group mt-2 text-right">
                                            <label class="blue text-right">کلمات کلیدی<i class="red mx-1">*</i>:</label>
                                            <span class="red"><br/>
                                                بعد از هر کلمه کلیدی، کلید Enter یا علامت comma انگلیسی را فشار دهید.
                                            </span>
                                            <tags-input name="tags" element-id="tags"
                                                        @tag-added="removeError('tags')"
                                                        v-model="form.tags"
                                                        v-validate="'required'"
                                                        :add-tags-on-comma="true"
                                                        :placeholder="'کلمات کلیدی'">
                                            </tags-input>
                                            <i v-show="errors.has('form.tags')||form.errors.has('tags')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.tags')" class="red d-inline-block">{{ errors.first('form.tags') }}</span>
                                            <span v-show="form.errors.has('tags')" class="red d-inline-block">{{ form.errors.get('tags') }}</span>
                                        </div>
                                    </div>
                                </form>
                            </tab-content>
                            <tab-content title="تکمیل اطلاعات پروپوزال" :before-change="proposalValidationPart2"  icon="far fa-scroll-old">
                                <form @submit.prevent="createProposal()" @keydown="form.onKeydown($event)" @change="form.onKeydown($event)" data-vv-scope="form2" id="Form2">

                                    <div class="modal-body">
                                        <div class="text-right mt-1 mb-4" >
                                            <label class="blue text-right">چکیده<i class="red mx-1">*</i>:</label><br>
                                            <i v-show="errors.has('form2.abstract')||form.errors.has('abstract')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form2.abstract')" class="red d-inline-block">{{ errors.first('form2.abstract') }}</span>
                                            <span v-show="form.errors.has('abstract')" class="red d-inline-block">{{ form.errors.get('abstract') }}</span>
                                            <tinymce @editorInit="e => e.setContent(form.abstract)" @editorChange="removeError('abstract')" :other_options="options" v-validate="'required'" name="abstract" v-model="form.abstract" id="d1"></tinymce>
                                        </div>
                                        <div class="text-right mt-1 mb-4" >
                                            <label class="blue text-right">مقدمه<i class="red mx-1">*</i>:</label><br>
                                            <i v-show="errors.has('form2.introduction')||form.errors.has('introduction')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form2.introduction')" class="red d-inline-block">{{ errors.first('form2.introduction') }}</span>
                                            <span v-show="form.errors.has('introduction')" class="red d-inline-block">{{ form.errors.get('introduction') }}</span>
                                            <tinymce @editorInit="e => e.setContent(form.introduction)" @editorChange="removeError('introduction')" :other_options="options" v-validate="'required'" name="introduction" v-model="form.introduction" id="d2"></tinymce>
                                        </div>
                                        <div class="text-right mt-1 mb-4" >
                                            <label class="blue text-right">بیان مسئله<i class="red mx-1">*</i>:</label><br>
                                            <i v-show="errors.has('form2.problem')||form.errors.has('problem')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form2.problem')" class="red d-inline-block">{{ errors.first('form2.problem') }}</span>
                                            <span v-show="form.errors.has('problem')" class="red d-inline-block">{{ form.errors.get('problem') }}</span>
                                            <tinymce @editorInit="e => e.setContent(form.problem)" @editorChange="removeError('problem')" :other_options="options" v-validate="'required'" name="problem" v-model="form.problem" id="d3"></tinymce>
                                        </div>
                                        <div class="text-right mt-1 mb-4" >
                                            <label class="blue text-right">نوآوری پروپوزال پیشنهادی<i class="red mx-1">*</i>:</label><br>
                                            <i v-show="errors.has('form2.innovation')||form.errors.has('innovation')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form2.innovation')" class="red d-inline-block">{{ errors.first('form2.innovation') }}</span>
                                            <span v-show="form.errors.has('innovation')" class="red d-inline-block">{{ form.errors.get('innovation') }}</span>
                                            <tinymce @editorInit="e => e.setContent(form.innovation)" @editorChange="removeError('innovation')" :other_options="options" v-validate="'required'" name="innovation" v-model="form.innovation" id="d4"></tinymce>
                                        </div>
                                        <div class="text-right mt-1 mb-4" >
                                            <label class="blue text-right">نیازمندی ها<i class="red mx-1">*</i>:</label><br>
                                            <i v-show="errors.has('form2.requirements')||form.errors.has('requirements')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form2.requirements')" class="red d-inline-block">{{ errors.first('form2.requirements') }}</span>
                                            <span v-show="form.errors.has('requirements')" class="red d-inline-block">{{ form.errors.get('requirements') }}</span>
                                            <tinymce @editorInit="e => e.setContent(form.requirements)" @editorChange="removeError('requirements')" :other_options="options" v-validate="'required'" name="requirements" v-model="form.requirements" id="d5"></tinymce>
                                        </div>
                                    </div>

                                </form>
                            </tab-content>

                            <tab-content title="اطلاعات نویسندگان"  icon="fa fa-user-plus" :before-change="authorValidation"   >
                                <form @submit.prevent="addAuthor"
                                      @keydown="form.onKeydown($event)" @change="form.onKeydown($event)"  data-vv-scope="form-4" id="Form4">
                                    <div class="text-right ">
                                        <span>لیست نویسندگان:</span><br>
                                        <i v-show="form.errors.has('authors')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show="form.errors.has('authors')" class="red d-inline-block">{{ form.errors.get('authors') }}</span>

                                    </div>
                                    <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">نام و نام خانوادگی</th>
                                            <th scope="col">آدرس</th>
                                            <th></th>
                                            <th scope="col"> حذف</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(author, index) of form.authors">
                                            <th scope="row">{{index+1 | faDigit}}</th>
                                            <td><span v-show="editOffset != index">{{author}}</span>
                                                <input :id = "'item-author-'+index" v-show="editOffset == index"  type="text" name="author"
                                                       :placeholder="'نام و نام خانواگی نویسنده'"
                                                       class="form-control"  v-model="form.authors[index]">
                                            </td>
                                            <td ><label  v-show="editOffset != index">{{form.affiliations[index]}}</label>
                                                <input :id = "'item-affiliation-'+index" v-show="editOffset == index"  type="text" name="author"
                                                       :placeholder="'نام و نام خانواگی نویسنده'"
                                                       class="form-control"
                                                       @keydown.enter="updateAuthor"
                                                       v-model="form.affiliations[index]">
                                            </td>

                                            <td> <button v-show="editOffset == index" class="btn btn-primary" @click="updateAuthor">ثبت تغییرات</button></td>
                                            <td>
                                                <a class="" @click="startEditing(index)"><i class=" green far fa-edit fa-fw"></i> </a> /
                                                <a class="" @click="removeAuthor(index)"><i class=" red far fa-user-times fa-fw"></i> </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div id="authorsContainer">
                                        <div class="form-group mb-3 mt-5  text-right">
                                            <label class="blue ">نام و نام خانواگی نویسنده<i class="red mx-1">*</i>:</label>
                                            <input  type="text" name="author"
                                                    :placeholder="'نام و نام خانواگی نویسنده'"
                                                    class="form-control" v-model="author" >
                                        </div>
                                        <div class="form-group mt-1 mb-3 text-right">
                                            <label class="blue ">آدرس یا Affiliation نویسنده<i class="red mx-1">*</i>:</label>
                                            <input  type="text" name="author"
                                                    :placeholder="'آدرس یا Affiliation نویسنده'"
                                                    class="form-control" v-model="affiliation"  >
                                        </div>
                                        <button @click="addAuthor" class="btn btn-block btn-info mb-5"><i class="fas fa-user-plus fa-fw"></i> افزودن نویسنده</button>
                                    </div>
                                </form>
                            </tab-content>
                        </form-wizard>
                    </div>

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div>

        <!--pdf show modal -->
        <div class="modal  fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i
                            class="far fa-file-alt fa-fw"></i> مشاهده ضمیمه پروپوزال پژوهشی</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="height: 600px" >
                        <embed type="application/pdf" :src="pdfFileName" width="100%" height="100%">
                    </div><!-- modal-body -->
                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /pdf show modal  -->
        <!--checkList History show modal -->
        <div class="modal  fade" id="checkListHistoryShow" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2"><i
                            class="fal fa-history fa-fw"></i> مشاهده تاریخچه بررسی</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="height: 600px; overflow-y: scroll" >
                        <table class="table table-sm table-hover text-right">
                            <tr v-for="(checkListItem, index) of checkListItems">
                                <td style="vertical-align: middle" class="bg-gray text-center">
                                    تاریخ <span>{{checkListItem.created_at | myDate}}</span>
                                </td>
                                <td>
                                    <span class="blue d-block">موارد تایید نشده:</span>
                                    <span class="mx-1" v-for="listItem in checkListItem.list">{{listItem}},</span>
                                    <br>
                                    <span  class="blue d-block">توضیحات:</span>
                                    <span v-html="checkListItem.comment">

                                </span>
                                </td>
                                <td style="vertical-align: middle">
                                    <a  v-if="$gate.isAdmin()" @click="deleteCheckListItem(checkListItem.id, index)"><i class="red fa fa-trash"></i></a>
                                </td>
                            </tr>
                        </table>
                    </div><!-- modal-body -->
                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->
        <div class="modal  fade" id="assignReviewerShow" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel4"><i
                            class="fal fa-history fa-fw"></i>انتخاب لیست داوران</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="height: 600px; overflow-y: scroll" >
                        <div v-if="proposal.status != 3 && proposal.status != 1 &&  proposal.status != 7 && proposal.last_status != 7" class="col-lg-12  mt-3 mr-2" >
                            <div class="form-group mb-3 text-right">
                                <label class="blue text-right  text-rtl">لیست اسامی :</label>
                                <!-- @change="searchit" -->
                                <Select2  class="form-control select2-form-control non-modal-select2" id="reviewer_id"
                                          v-model="assignReviewersForm.reviewers_ids"
                                          :options="available_reviewers"
                                          @change="removeError('reviewers_ids')"
                                          :settings="{theme: 'bootstrap4', placeholder: 'انتخاب داور', width: '100%' ,multiple: true}">
                                    <!--   --->
                                </Select2>
                            </div>
                            <div>
                                <button class="btn  btn-block btn-lg btn-success" @click="assignReviewers()"><i class="fas fa-user-plus fa-fw"></i>ارسال برای داوران</button>
                            </div>
                        </div>
                        <div v-if="show_reviewersList" class="col-lg-12  mt-3 mr-2" >
                            <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">نام و نام خانوادگی</th>
                                    <th class="w-50" scope="col">نظرات</th>
                                    <th scope="col">نظر نهایی</th>
                                    <th scope="col"> حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(reviewer, index) of reviewersList">
                                    <th scope="row">{{index+1 | faDigit}}</th>
                                    <td>{{reviewer.reviewer_name}}</td>
                                    <td><div v-html="reviewer.comment"></div></td>
                                    <td>
                                        <span v-if="reviewer.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</span>
                                        <span v-else-if="reviewer.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</span>
                                        <span v-else-if="reviewer.status == '2'"  class="cyan"><i class="fal fa-exclamation"></i>  {{'تایید با اصلاحات' }}</span>
                                        <span v-else-if="reviewer.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید' }}</span>
                                    </td>

                                    <td>
                                        <a v-if="proposal.status != 3 && proposal.status != 1 && proposal.status != 7 && proposal.last_status != 7" class="" @click="removeReview(reviewer.id, index)"><i class=" red far fa-user-times fa-fw"></i> </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div v-if="show_reviewersList" class="col-lg-12  mt-3 mr-2" >
                            <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                                <tr>
                                   <td>نظر نهایی پس از داوری</td>
                                   <td>
                                       <p-radio v-model="proposalStatusForm.status" name="status" value="1" class="p-icon p-curve p-bigger p-pulse text-ltr"  color="info-o">
                                           <i slot="extra" class="icon far fa-check"></i>
                                           تایید
                                       </p-radio>
                                   </td>
                                   <td>
                                       <p-radio v-model="proposalStatusForm.status" name="status" value="7" class="p-icon p-curve p-bigger p-pulse text-ltr"  color="info-o">
                                           <i slot="extra" class="icon far fa-check"></i>
                                           تایید با اصلاحات
                                       </p-radio>
                                   </td>
                                   <td>
                                       <p-radio v-model="proposalStatusForm.status" name="status" value="3" class="p-icon p-curve p-bigger p-pulse text-ltr"  color="info-o">
                                           <i slot="extra" class="icon far fa-check"></i>
                                           عدم تایید
                                       </p-radio>
                                   </td>
                                </tr>
                            </table>
                            <div class="text-right mt-1 mb-4" >
                                <label class="blue text-right">توضیحات کارشناس<i class="red mx-1">*</i>:</label><br>
                                <i v-show="proposalStatusForm.errors.has('comment')" class="red far fa-exclamation-triangle"></i>
                                <span v-show="proposalStatusForm.errors.has('comment')" class="red d-inline-block">{{ proposalStatusForm.errors.get('comment') }}</span>
                                <tinymce dir="rtl" @editorInit="e => e.setContent(proposalStatusForm.comment)" :other_options="options" v-validate="'required'" name="requirements" v-model="proposalStatusForm.comment" id="d15"></tinymce>
                            </div>
                            <div class="text-right mt-1 mb-4">
                                <button class="btn btn-block btn-lg btn-primary" :disabled="isDisabled" @click="updateProposalStatus">ثبت نظر نهایی</button>
                            </div>
                        </div>
                    </div><!-- modal-body -->
                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->
    </div>
</template>

<script>
    import farsi from 'vee-validate/dist/locale/fa';
    import Select2 from 'v-select2-component';
    export default {
        name: "ResearchProposalEdit",
        data(){
            return {
                options: { // tinyMce toolbar options
                    directionality : 'rtl',
                    language_url: '../js/fa_IR.js', //This url points to location of persian language file.
                    toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat',
                    toolbar2: ' cut copy paste | ltr rtl | | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor',
                    plugins:['advlist autolink lists link image charmap print preview hr anchor pagebreak', 'searchreplace wordcount visualblocks visualchars code fullscreen', 'insertdatetime media nonbreaking save table contextmenu directionality','template paste textcolor colorpicker textpattern imagetools toc help emoticons hr codesample'],
                },
                id:'',
                proposal:{},
                proposal_types:[],
                proposal_usages:[],
                available_reviewers:[],
                reviewersList:[],
                show_reviewersList:false,
                faculties:[],
                pdfFileName:'',     // will be used to display pdf files in modal
                fileName:[],    // For UI rendering and displaying the choosen file Names
                fileChanging:false, // if user wants to change any file or upload file
                editOffset: -1,     // for managing author editing form status used if -1 the form will be hide
                attachments:[],
                author:'',
                affiliation:'',
                checkList:false,
                checkListItems:{},
                checkListForm: new Form({
                    id:'',
                    list:[],
                    status:null,
                    comment:'',
                    score:''
                }),
                assignReviewersForm: new Form({
                    research_proposal_id:'',
                    reviewers_ids:[],
                }),
                proposalStatusForm: new Form({
                    status:0,
                    comment:'',
                }),
                removeReviewForm: new Form({
                    id:''
                }),
                f:new FormData, // creates the new FormData object to store selected files data
                // form data of VForm data object witch will be used to fill and submit the form
                form: new Form({
                    title:'',
                    en_title: '',
                    proposal_type_id: '',
                    proposal_usage_id: '',
                    faculty_id: '',
                    abstract: '',
                    introduction: '',
                    problem:'',
                    innovation:'',
                    requirements:'',
                    duration:'',
                    project_location:'',
                    budget:'',
                    value:'',
                    tags:[],
                    authors:[],
                    affiliations:[],
                    files:[],
                    fileChangeType:'',
                }),
            }
        },
        methods:{
            updateProposalStatus(){
                this.proposalStatusForm.put('/api/updateProposalStatus/'+this.id)
                    .then((response)=>{
                        this.proposal.status = this.proposalStatusForm.status;
                        this.proposal.comment = this.proposalStatusForm.comment;
                        this.successSwal('نظر نهایی در مورد پروپوزال با موفقیت ثبت شد.');
                    })
                    .catch((e)=>{
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                    })
            },
            removeReview(id, index){
                this.removeReviewForm.id = id;
                swal({
                    title: 'آیا از حذف داوری مورد نظر مطمئن هستید؟',
                    text: "این تغییر قابل بازگشت نخواهد بود",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله حذف می کنم',
                    cancelButtonText: 'لغو عملیات'
                }).then((result) => {
                    // send ajax request to server
                    if (result.value) {
                        this.removeReviewForm.delete(`/api/deleteReview/${id}`).then(() => {
                            this.reviewersList.splice(index,1);
                            this.getReviewersList()
                            this.successSwal('طرح پژوهشی مورد نظر با موفقیت حذف شد.');
                            Fire.$emit('AfterCreate');
                        }).catch((e) => {
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        });
                    } else {
                        this.warningSwal('شما این عملیات را لغو کردید.');
                    }
                })
            },
            assignReviewers(){
                this.assignReviewersForm.research_proposal_id = this.proposal.id;
                if(this.assignReviewersForm.reviewers_ids.length > 0){
                    this.assignReviewersForm.post('/api/assignReviewer')
                        .then((response) => {

                            for(var i=0;i<response.data.data.length; i++){
                                this.reviewersList.unshift(response.data.data[i]);
                            }
                            this.assignReviewersForm.reset();
                            this.show_reviewersList = true;
                            this.getReviewersList()
                            this.proposal.status = 5;
                            this.successToast('پروپوزال جهت بررسی با موفقیت برای داوران ارسال شد.');
                        })
                        .catch((e)=>{
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        });
                }
            },
            getReviewersList(){
                axios.get('/api/getReviewersList?faculty_id=' + this.proposal.faculty_id+ '&propsal_id=' + this.proposal.id)
                    .then(response => {
                        this.available_reviewers = response.data.reviewers;
                        $('#assignReviewerShow').modal('show');
                    })
                    .catch((e)=>{
                            //  console.log(e);
                        }
                    );

            },
            // if the all paper submission validate it will submit the data to server
            onComplete: function(){
                this.$Progress.start();
                let loader1 = Vue.$loading.show();
                this.form.submit('post', `/api/researchProposalUpdate/${this.proposal.id}`, {
                    // Transform form data to FormData
                    transformRequest: [function (data, headers) {
                        return objectToFormData(data)
                    }]
                }).then((response) => {
                    // sets the data
                    loader1.hide();
                    this.resetFormWizard();
                    this.proposal = response.data.data;
                    //this.checkListItems = response.data.data.checkList;
                    this.editFormPrepare();
                    // UI modal Hide, progress bar finish , show the toase
                    $('#proposalEditModal').modal('hide');
                    this.successToast('پروپوزال پروپوزال پژوهشی با موفقیت ویرایش شد.');
                    this.$Progress.finish();
                }).catch((e) => {
                        loader1.hide();
                        this.$Progress.fail();
                        // checks if uploaded files has error
                        let t = Object.keys(this.form.errors.all()).filter(function (key) {
                            return /^files./.test(key);
                        });

                        if (!t.length) {
                        } else {
                            this.form.errors.set('files', 'نوع فایل باید یکی از انواع pdf یا zip باشد.')
                        }
                        this.errorSwal('در یکی از مراحل خطا دارید، لطفا مجدد بررسی کنید.');
                        return false;
                    }
                );
            },
            // this function gets files selected by user and push it to form.files
            fieldChange(e){
                let selectedFiles=e.target.files;
                if(!selectedFiles.length){
                    return false;
                }
                this.form.files = [];
                this.fileName = [];
                for(let i=0;i<selectedFiles.length;i++){
                    this.fileName.push(selectedFiles[i].name);
                    this.form.files.push(selectedFiles[i]);
                }
            },
            // push or add the author detail to form.authors array
            addAuthor () {
                if(this.author.trim() && this.affiliation.trim()){
                    this.form.authors.push(this.author);
                    this.form.affiliations.push(this.affiliation);
                    this.author = '';
                    this.affiliation = '';
                }
            },
            authorValidation(){
                return this.$validator.validateAll('form-4').then(result => {
                    if (!result) {
                        this.errorSwal('باید مسئول پروپوزال پژوهشی انتخاب شود!');
                        return false;
                    }
                    return true;
                });
            },
            proposalValidation(){
                return this.$validator.validateAll('form').then(result => {
                    if (!result) {
                        this.errorSwal('اطلاعات پروپوزال پژوهشی دارای خطا می باشد!');
                        return false;
                    }
                    return true;
                });
            },
            proposalValidationPart2(){
                return this.$validator.validateAll('form2').then(result => {
                    if (!result) {
                        this.errorSwal('اطلاعات پروپوزال پژوهشی دارای خطا می باشد!');
                        return false;
                    }
                    return true;
                });
            },

            // enables author editing form
            startEditing(index){
                this.editOffset = index;
                this.$nextTick(function(){
                    document.getElementById('item-author-'+this.editOffset).focus()
                }.bind(this))
            },
            // closes the author editing form
            updateAuthor() {
                this.editOffset = -1
            },
            // removes author from form.authors array
            removeAuthor(index){
                this.$delete(this.form.authors,index);
                this.$delete(this.form.affiliations,index);
            },
            // gets necessary data for form like excerpts and conference types and journal types
            /** these functions are responsible for form input error handling and change state*/
            // resets all the form modal related state and variables
            resetFormWizard() {
                this.fileName=[];
                this.attachments = [];
                this.authors = [];
                this.author = '';
                this.affiliation = '';
                this.fileChanging = false;
                this.form.reset();
                this.$refs.wizard.reset();
                this.$validator.reset();
            },
            // sets of the file change type, whether it is addition to previous files or replacement
            fileChange(term){
                this.fileChanging = term;
                if(!term){
                    this.form.files=[];
                }
            },
            removeError(field){
                this.form.errors.clear(field)
            },

            deleteCheckListItem(id, index) {

                if(this.checkListItems.length > 1){
                    this.checkListForm.delete('/api/deleteCheckListItem/' + id).then(() => {
                        this.checkListItems.splice(index, 1);
                        this.checkListForm.list = $.map(this.checkListItems[0].list, function(value, index) {
                            return [value];
                        });
                        if(this.checkListForm.list.length > 0){
                            this.checkListForm.status = 2;
                            this.proposal.status = 2;
                        }
                        this.checkListForm.comment = this.checkListItems[0].comment;
                        this.successSwal('تاریخچه بررسی با موفقیت حذف شد.');

                    }).catch((e) => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                    });
                }else {
                    this.errorSwal('امکان حذف آخرین تاریخچه وجود ندارد!');
                }

            },
            checkListSubmit(){
                this.$Progress.start();
                this.checkListForm.id =this.id;
                this.checkListForm.post('/api/researchProposalCheckList')
                    .then((response) => {
                        this.checkListItems.unshift(response.data.checkListItem);
                        this.proposal.status = this.checkListForm.status;

                        this.successToast('نتایج بررسی با موفقیت ثبت شد.');
                        this.toggleCheckList();
                        this.$Progress.finish();

                    })
                    .catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        this.$Progress.fail();
                    })
            },
            onChange(value, $event){

                if (!this.checkListForm.list)
                    this.checkListForm.list = [];
                const index = this.checkListForm.list.findIndex(v => v == value);
                const checked = $event.target.checked;
                if (checked && index < 0){
                    this.checkListForm.list.push(value);
                    this.checkListForm.status = 2;
                }
                if (!checked && index >= 0)
                    this.checkListForm.list.splice(index, 1)
                if (this.checkListForm.list.length < 1){
                    this.checkListForm.status = 6;
                }
            },
            prepareCheckList(){
                if(this.proposal.status != '0') {
                    if (this.checkListItems.length > 0 && (this.proposal.status != '1' || this.proposal.status != '5' || this.proposal.status != '6')) {
                        this.checkListForm.list = $.map(this.checkListItems[0].list, function (value, index) {
                            return [value];
                        });
                    }
                    if (this.checkListItems.length > 0){
                        this.checkListForm.comment = this.checkListItems[0].comment;
                        this.checkListForm.status = this.proposal.status;
                    }
                }
                this.checkListForm.score = this.proposal.score;

            },
            toggleCheckList(){
                this.checkList = !this.checkList;
                if(this.checkListForm.list.length < 1){
                    this.checkListForm.status = 6;
                }else{
                    this.checkListForm.status = 2;
                }
            },
            checkListHistory(){
                $('#checkListHistoryShow').modal('show');
            },
            goback(){
                this.$router.go(-1);
            },
            // shows bookEditModal
            proposalEditModal(){
                $('#proposalEditModal').modal('show');
            },
            // prepares the edit form data
            editFormPrepare(){
                this.form.fill(this.proposal);
                this.form.fileChangeType = '';
                this.form.authors = [];
                this.form.affiliations = [];
                this.form.files =[];
                this.form.tags = [];
                for(var i = 0; i < this.proposal.tags.length; i++){
                    this.form.tags.push( this.proposal.tags[i].name);
                }
                for(var j=0; j<this.proposal.Authors.length; j++){
                    this.form.authors.push(this.proposal.Authors[j].name);
                    this.form.affiliations.push(this.proposal.Authors[j].affiliation);
                }

            },
            pdfModal(name){
                this.pdfFileName = '../files/proposals/'+name+'#page=1';
                $('#pdfModal').modal('show');
            },
            // checks the file type on render to see if it is pdf or zip
            checkFileType(file){
                var fileName = file.name.split(".");
                return fileName[1] == 'zip' || fileName[1] == 'rar'? true:false;
            },
            // on page load gets thesis data based on the received it
            getProposalData(id){
                axios.get(`/api/researchProposal/${id}`)
                    .then(response => {
                        this.proposal = response.data.data;
                        this.checkListItems = response.data.data.checkList;
                        //this.term_form.term_id = this.proposal.term_id;
                        if(this.proposal.reviewers_count > 0){
                            this.show_reviewersList = true;
                            this.reviewersList = this.proposal.reviewers;
                            if(this.proposal.status == '1' ||this.proposal.status == '7' ||this.proposal.status == '3'){
                                this.proposalStatusForm.status = `${this.proposal.status}`;
                                this.proposalStatusForm.comment = this.proposal.comment;
                            }else if(this.proposal.last_status == '7'){
                                this.proposalStatusForm.status = `${this.proposal.last_status}`;
                                this.proposalStatusForm.comment = this.proposal.comment;
                            }
                        }

                        this.prepareCheckList();
                        this.editFormPrepare();
                    })
                    .catch((e)=>{
                            console.log(e);
                        }
                    );
            },
            // gets necessary data for form like
            getProposalRelation(){
                axios.get('/api/researchProposalRelation')
                    .then(response => {
                        this.proposal_types = response.data.proposal_types;
                        this.proposal_usages = response.data.proposal_usages;
                        this.faculties = response.data.faculties;
                    })
                    .catch((e)=>{
                            //  console.log(e);
                        }
                    );
            },

            createProject(){

            }
        },
        computed:{
            isDisabled: function(){
                return !(this.proposalStatusForm.status == '1' ||this.proposalStatusForm.status == '7' ||this.proposalStatusForm.status == '3');
            }
        },
        created(){
            this.$parent.pageName = 'آرشیو پروپوزال های پژوهشی';
            this.$validator.localize('farsi', {
                messages: farsi.messages,
                attributes: {
                    title: 'عنوان فارسی پروپوزال',
                    en_title: 'عنوان انگلیسی پروپوزال',
                    budget: 'بودجه مورد نیاز پروپوزال',
                    value: 'ارزش تخمینی پروپوزال',
                    proposal_type_id: 'انتخاب نوع پروپوزال',
                    proposal_usage_id: 'انتخاب نوع کاربرد پروپوزال',
                    faculty_id: 'انتخاب دانشکده مربوطه',
                    abstract: 'چکیده پروپوزال',
                    tags: 'کلمات کلیدی',
                    introduction: 'مقدمه پروپوزال',
                    problem: 'بیان مسئله پروپوزال',
                    innovation: 'نوآوری پروپوزال پیشنهادی',
                    requirements: 'نیازمندی های پروپوزال',
                    duration: 'مدت زمان مورد نیاز',
                    project_location: 'محل اجرا و انجام پروپوزال',
                    files: 'فایل های ضمیمه',
                    fileChangeType: 'نوع تغییر فایل ها',
                }
            });
            this.id = this.$route.params.id;
            this.getProposalRelation();
            this.getProposalData(this.id);
        },
        components:{
            Select2,
        }
    }
</script>

<style scoped>

</style>
