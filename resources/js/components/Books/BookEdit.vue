<template>
    <div>
        <div class="container-fluid text-rtl text-right my-5">
            <div class="card card-4 my-5">
                <div class="card-header justify-content-around d-flex " style="direction: rtl">
                    <div class="col">
                        <h3 class=" text-right"><i class="fal fa-books fa-fw"></i> اطلاعات کتاب</h3>
                    </div>
                    <div class="card-tools">
                        <button class="btn btn-success" @click="goback"><i style="font-size: 16px" class="fal fa-undo"></i> بازگشت</button>
                    </div><!-- /card-tools -->
                </div><!-- /.card-header -->
                <div class="card-body  px-0">
                    <table class="table table-hover table-striped">
                        <thead class="thead-dark">
                        <tr>
                            <th class="font-18"><i class="fal fa-book fa-fw"></i>اطلاعات کتاب</th>
                            <th v-if="checkList">موارد ناقص</th>
                        </tr>
                        </thead>
                        <tbody v-if="book.id">
                        <tr>
                            <td class="font-16">
                                <span class="blue">عنوان:</span>
                                <span class="mr-3">{{book.title}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('عنوان')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('عنوان')"
                                         @change.native="onChange('عنوان', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue ">نویسندگان:</span>
                                <span v-for="author of book.Authors" class="mr-3 ">
                               <span v-if="author.corresponding == '-1'">{{author.name}}،</span>
                               <span v-else style="text-decoration: underline red">{{author.name}}<i class="red">*</i>،</span>
                            </span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نویسندگان')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
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
                                <span class="blue">موضوع:</span>
                                <span class="mr-3">{{book.subject}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('موضوع')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('موضوع')"
                                         @change.native="onChange('موضوع', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>

                        <tr>
                            <td class="font-16">
                                <span class="blue">نوع کتاب:</span>
                                <span class="mr-3">{{book.booktype}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نوع کتاب')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('نوع کتاب')"
                                         @change.native="onChange('نوع کتاب', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>

                        <tr>
                            <td class="font-16">
                                <span class="blue ">نوع مستخرج:</span>
                                <span class="mr-3 "> {{book.excerpt}} </span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نوع مستخرج')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check
                                    :checked="checkListForm.list && checkListForm.list.includes('نوع مستخرج')"
                                    @change.native="onChange('نوع مستخرج', $event)"
                                    type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>

                        <tr>
                            <td class="font-16">
                                <span class="blue">ناشر:</span>
                                <span class="mr-3">{{book.publisher}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('ناشر')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('ناشر')"
                                         @change.native="onChange('ناشر', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>

                        <tr>
                            <td class="font-16">
                                <span class="blue">شابک:</span>
                                <span  class="mr-3">{{book.isbn}} </span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('شابک')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('شابک')"
                                         @change.native="onChange('شابک', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue ">تاریخ چاپ:</span>
                                <span class="mr-3 "> {{book.publish_year | myDate}} هجری شمسی</span>
                                <span class="mr-3 "> {{book.publish_year | myDateEN}} میلادی</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('تاریخ چاپ')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check
                                    :checked="checkListForm.list && checkListForm.list.includes('تاریخ چاپ')"
                                    @change.native="onChange('تاریخ چاپ', $event)"
                                    type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">نوبت چاپ:</span>
                                <span class="mr-3">{{book.publish_number}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نوبت چاپ')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('نوبت چاپ')"
                                         @change.native="onChange('نوبت چاپ', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">آیا ویرایش شده:</span>
                                <span v-if="book.edited == 0" class="mr-3"><i class="fa fa-times red"></i> </span>
                                <span v-if="book.edited == 1" class="mr-3"><i class="fa fa-check green"></i> </span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('ویرایش شده')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('ویرایش شده')"
                                         @change.native="onChange('ویرایش شده', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td v-if="book.edited == 1" class="font-16">
                                <span class="blue">نوبت ویرایش:</span>
                                <span  class="mr-3">{{book.edited_number}} </span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نوبت ویرایش')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList && book.edited == 1">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('نوبت ویرایش')"
                                         @change.native="onChange('نوبت ویرایش', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue ">فایل های ضمیمه:</span>
                                <span v-for="(file, index) of book.files" class="mr-3 ">
                                    <div v-if="checkFileType(file)" class="btn-group text-ltr" role="group" aria-label="Basic example">
                                         <a  class="btn btn-lg btn-info" :href="'../files/books/'+file.name"><i class="fal fa-download fa-fw"></i>  </a>
                                         <a  class="btn btn-lg btn-info" :href="'../files/books/'+file.name">ضمیمه {{index+1|faDigit}}  <i class="fal fa-file-archive fa-fw"></i></a>
                                    </div>
                                    <div v-else class="btn-group text-ltr" role="group" aria-label="Basic example">
                                      <a  :href="'../files/books/'+file.name" class="btn btn-lg btn-info"><i class="fal fa-download"></i></a>
                                      <button @click="pdfModal(file.name)" type="button" class="btn btn-lg btn-info">ضمیمه {{index+1|faDigit}} <i class="fal fa-file-pdf fa-fw"></i></button>

                                    </div>
                            </span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('فایل های ضمیمه')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
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
                            <td class="font-16">
                                <span class="blue">تیراژ کتاب:</span>
                                <span  class="mr-3">{{book.copy_number}} </span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('تیراژ کتاب')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('تیراژ کتاب')"
                                         @change.native="onChange('تیراژ کتاب', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">تعداد صفحات:</span>
                                <span  class="mr-3">{{book.pages}} </span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('تعداد صفحات')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('تعداد صفحات')"
                                         @change.native="onChange('تعداد صفحات', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">شماره کتابخانه ملی:</span>
                                <span  class="mr-3">{{book.national_code}} </span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('شماره کتابخانه ملی')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('شماره کتابخانه ملی')"
                                         @change.native="onChange('شماره کتابخانه ملی', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">رتبه بندی گنگره:</span>
                                <span  class="mr-3">{{book.congress_code}} </span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('رتبه بندی گنگره')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('رتبه بندی گنگره')"
                                         @change.native="onChange('رتبه بندی گنگره', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">رتبه دیویی:</span>
                                <span  class="mr-3">{{book.dewey_code}} </span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('رتبه دیویی')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('رتبه دیویی')"
                                         @change.native="onChange('رتبه دیویی', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>

                        <tr>
                            <td class="font-16">
                                <span class="orange ">ترم ثبت شده:</span>
                                <span v-show="!TermChange" class="mr-3">{{book.term_name}}</span>
                                <div class="d-inline-block" v-if="$gate.isAdminOrAuthor()">
                                    <select v-show="TermChange" v-validate="'required'" data-vv-name="term_id"
                                            id="term_id"
                                            v-model="term_form.term_id"
                                            @change="removeError('term_id')"
                                    >
                                        <option selected disabled value="">انتخاب ترم ...</option>
                                        <option v-for="term in terms" :key="term.id" :value="term.id">{{term.text}}</option>
                                    </select>
                                    <a v-show="TermChange" @click="termChangeSubmit" class="btn btn-primary text-white ripple">ثبت تغییر ترم</a>
                                    <a v-show="TermChange" @click="showTermChange" class="btn btn-danger text-white ripple" >لغو عملیات</a>
                                    <a v-show="!TermChange" @click="showTermChange" class="btn btn-success text-white ripple" >تغییر ترم</a>

                                </div>

                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('ترم ثبت شده')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check
                                    :checked="checkListForm.list && checkListForm.list.includes('ترم ثبت شده')"
                                    @change.native="onChange('ترم ثبت شده', $event)"
                                    type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>


                        <tr>
                            <td class="font-16">
                                <span class="blue ">وضعیت بررسی:</span>
                                <span v-if="book.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</span>
                                <span v-else-if="book.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</span>
                                <span v-else-if="book.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</span>
                                <span v-else-if="book.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</span>
                                <span v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</span>
                            </td>
                            <td v-if="checkList">
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue ">امتیاز کسب شده:</span>
                                <span v-if="book.status != '1'"  ><i class="fal fa-question"></i>  {{'امتیازی ثبت نشده' }}</span>
                                <span v-else >  {{book.score | faDigits }}</span>
                            </td>
                            <td v-if="checkList">
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
                                        <option value="1" ><i class="fa-check"></i>تایید</option>
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
                                    <div v-if="checkListForm.status == 1" class="form-inline">
                                        <div class="form-group w-25 text-right">
                                            <label class="blue ml-3">امتیاز:</label>
                                            <input type="number" :min="book.minScore" :max="book.maxScore" name="score"
                                                   placeholder=""
                                                   :class="[( errors.has('checkListForm.score') || checkListForm.errors.has('score') ? 'is-invalid': ''  )]"
                                                   v-validate="{min_value:book.minScore,max_value:book.maxScore}"
                                                   class="form-control w-50" v-model="checkListForm.score" >
                                        </div>
                                        <div class="form-group mb-2">
                                            <span>توجه: امتیاز این آیتم با توجه به بخشنامه در بازه {{book.minScore}} و {{book.maxScore}} در نظر گرفته میشود.</span>
                                        </div>
                                    </div>
                                    <i v-show="errors.has('checkListForm.score')||checkListForm.errors.has('score')" class="red far fa-exclamation-triangle"></i>
                                    <span v-show="errors.has('checkListForm.score')" class="red d-inline-block">{{ errors.first('checkListForm.score') }}</span>
                                    <span v-show="checkListForm.errors.has('score')" class="red d-inline-block">{{ checkListForm.errors.get('score') }}</span>
                                </form>
                            </td>
                        </tr>
                        <tr  v-show="checkList">
                            <td colspan="2">
                                <form  data-vv-scope="checkListForm">
                                    <label for="id2" class="blue mt-3">توضیحات: </label>
                                    <i v-show="checkListForm.errors.has('comment')" class="red far fa-exclamation-triangle"></i>
                                    <span v-show="checkListForm.errors.has('comment')" class="red d-inline-block">{{ checkListForm.errors.get('comment') }}</span>
                                    <tinymce dir="rtl" @editorInit="e => e.setContent(checkListForm.comment)" v-model="checkListForm.comment" :other_options="options" name="comment" id="id2"></tinymce>
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
                    <button v-if="book.status != 3 && book.status != 1" @click="bookEditModal" class="btn btn-lg mx-1 btn-secondary">ویرایش  کتاب</button>
                    <button v-if="checkList" @click="checkListSubmit" class="btn btn-lg btn-success mx-5"><i class="fal fa-check fa-fw"></i>ثبت نتبجه بررسی</button>

                    <button @click="checkListHistory" class="btn btn-lg mx-1 btn-secondary"><i class="fal fa-history fa-fw mx-2"></i>تاریخچه بررسی</button>
                    <button v-if="$gate.isAdminOrAuthor()" @click="toggleCheckList"  class="btn btn-lg mx-1 btn-warning">چک لیست بررسی</button>
                </div>
            </div>
        </div><!-- /container -->

        <div  class="modal  fade" id="bookEditModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1"><i
                            class="far fa-book-medical fa-fw"></i> ویرایش اطلاعات کتاب </h5>
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
                            <h2 slot="title">تکمیل اطلاعات کتاب</h2>
                            <!-- :before-change="bookValidation"  -->
                            <tab-content title="اطلاعات کتاب"  icon="far fa-book">

                                <form @submit.prevent="createBook()"
                                      @keydown="form.onKeydown($event)" @change="form.onKeydown($event)" data-vv-scope="form-1" id="Form">
                                    <div class="form-group my-3 text-right">
                                        <label class="blue">نوع کتاب<i class="red mx-1">*</i>:</label>
                                        <Select2 v-validate="'required'" data-vv-name="booktype_id"
                                                 class="form-control select2-form-control" id="booktype_id"
                                                 :class="[( errors.has('form-1.booktype_id') || form.errors.has('booktype_id') ? 'is-invalid': ''  )]"
                                                 v-model="form.booktype_id"
                                                 :options="bookTypes"
                                                 @change="removeError('booktype_id')"
                                                 autofocus
                                                 :settings="{theme: 'bootstrap4', placeholder: 'نوع کتاب', width: '100%' }">
                                        </Select2>

                                        <i v-show="errors.has('form-1.booktype_id') || form.errors.has('booktype_id')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show="errors.has('form-1.booktype_id')" class="red d-inline-block">{{ errors.first('form-1.booktype_id') }}</span>
                                        <span v-show="form.errors.has('booktype_id')" class="red d-inline-block">{{ form.errors.get('booktype_id') }}</span>
                                    </div>
                                    <div  class="form-group my-3 text-right">
                                        <label class="blue ">عنوان کتاب<i class="red mx-1">*</i>:</label>
                                        <input   type="text" name="title"
                                                 placeholder="عنوان کتاب"
                                                 v-validate="'required'"
                                                 class="form-control" v-model="form.title"
                                                 :class="[( errors.has('form-1.title') || form.errors.has('title') ? 'is-invalid': ''  ) ]"
                                        >
                                        <i v-show=" errors.has('form-1.title') || form.errors.has('title')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show=" errors.has('form-1.title')" class="red d-inline-block">{{ errors.first('form-1.title') }}</span>
                                        <span v-show="form.errors.has('title')" class="red d-inline-block">{{ form.errors.get('title') }}</span>
                                    </div>
                                    <div class="form-group my-3 text-right">
                                        <label class="blue">مستخرج از<i class="red mx-1">*</i>:</label>
                                        <Select2 v-validate="'required'" data-vv-name="excerpt_id"
                                                 class="form-control select2-form-control" id="excerpt_id"
                                                 :class="[( errors.has('form-1.excerpt_id') || form.errors.has('excerpt_id') ? 'is-invalid': ''  )]"
                                                 v-model="form.excerpt_id"
                                                 :options="excerpts"
                                                 @change="removeError('excerpt_id')"
                                                 :settings="{theme: 'bootstrap4', placeholder: 'نوع مستخرج از:', width: '100%' }">
                                        </Select2>

                                        <i v-show="errors.has('form-1.excerpt_id') || form.errors.has('excerpt_id')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show="errors.has('form-1.excerpt_id')" class="red d-inline-block">{{ errors.first('form-1.excerpt_id') }}</span>
                                        <span v-show="form.errors.has('excerpt_id')" class="red d-inline-block">{{ form.errors.get('excerpt_id') }}</span>
                                    </div>
                                    <div class="form-group mb-4 mt-2 text-right">

                                        <label class="blue">موضوع کتاب:</label>
                                        <input   type="text" name="subject" placeholder="موضوع کتاب"
                                                 class="form-control" v-model="form.subject"
                                                 v-validate="'required'"
                                                 :class="[( errors.has('form-1.subject') || form.errors.has('subject') ? 'is-invalid': ''  )] "
                                        >
                                        <i v-show=" errors.has('form-1.subject') || form.errors.has('subject')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show=" errors.has('form-1.subject')" class="red d-inline-block">{{ errors.first('form-1.subject') }}</span>
                                        <span v-show="form.errors.has('subject')" class="red d-inline-block">{{ form.errors.get('subject') }}</span>
                                    </div>
                                    <div class="form-group mb-4 mt-2 text-right">

                                        <label class="blue">اطلاعات ناشر:</label>
                                        <input   type="text" name="publisher" placeholder="اطلاعات ناشر"
                                                 class="form-control" v-model="form.publisher"
                                                 v-validate="'required'"
                                                 :class="[( errors.has('form-1.publisher') || form.errors.has('publisher') ? 'is-invalid': ''  )] "
                                        >
                                        <i v-show=" errors.has('form-1.publisher') || form.errors.has('publisher')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show=" errors.has('form-1.publisher')" class="red d-inline-block">{{ errors.first('form-1.publisher') }}</span>
                                        <span v-show="form.errors.has('publisher')" class="red d-inline-block">{{ form.errors.get('publisher') }}</span>
                                    </div>


                                    <div class="form-group mt-4 text-right">
                                        <label class="blue text-right">فایل های ضمیمه<i class="red mx-1">*</i>:</label>
                                    </div>
                                    <div class="mt-2 text-right">
                                        <span>آیا می خواهید در فایل های ضمیمه تغییر اعمال کنید؟</span>
                                        <a @click="fileChange(true)" class="text-white btn btn-info btn-lg">آری</a>
                                        <a v-if="fileChanging" @click="fileChange(false)" class="text-white btn btn-warning btn-lg">خیر</a>
                                    </div>
                                    <div v-if="fileChanging" class="mt-2 text-right">
                                        <div class="form-group mt-4 text-right">
                                            <label class="blue text-right">نوع تغییر<i class="red mx-1">*</i>:</label>
                                        </div>
                                        <div class="form-group mb-4 text-right border-bottom">
                                            <p-radio v-model="form.fileChangeType" name="fileChangeType" value="0" class="p-icon p-curve p-bigger p-pulse text-ltr"  color="info-o">
                                                <i slot="extra" class="icon far fa-check"></i>
                                                جایگزینی با فایل های قبلی
                                            </p-radio>
                                            <p-radio v-validate="'required'" v-model="form.fileChangeType"
                                                     name="fileChangeType" value="1" type="radio" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                                <i slot="extra" class="icon far fa-check"></i>
                                                افزودن به فایل های قبلی
                                            </p-radio>

                                            <br>
                                            <has-error :form="form" field="fileChangeType"></has-error>
                                            <i v-show="errors.has('form-1.fileChangeType') || form.errors.has('fileChangeType')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form-1.fileChangeType')" class="red d-inline-block">{{ errors.first('form-1.fileChangeType') }}</span>
                                            <span v-show="form.errors.has('fileChangeType')" class="red d-inline-block">{{ form.errors.get('fileChangeType') }}</span>
                                        </div>
                                    </div>
                                    <div v-if="fileChanging" class="form-group mt-4 text-right">
                                        <label class="blue text-right">فایل های ضمیمه<i class="red mx-1">*</i>:</label>
                                        <span class="red"><br/>
                                                اسکن روی جلد
                                                <br/>
                                            اسکن صفحه شناسنامه کتاب
                                                <br/>
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
                                            <i v-show="errors.has('form-1.files')|| form.errors.has('files')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form-1.files') " class="red d-inline-block">{{ errors.first('form-1.files') }}</span>
                                            <span v-show="form.errors.has('files')" class="red d-inline-block">{{ form.errors.get('files') }}</span>
                                        </div>
                                    </div>

                                </form>

                            </tab-content>
                            <!-- :before-change="detailValidation" -->
                            <tab-content  title="اطلاعات شناسنامه کتاب"   icon="far fa-clipboard-list-check">
                                <form  @submit.prevent="createBook()"
                                       @keydown="form.onKeydown($event)" @change="form.onKeydown($event)" data-vv-scope="form-2"  id="form-2">
                                    <div class=" my-3" style="direction: ltr; text-align: right" >
                                        <label class="blue text-right  text-rtl">تاریخ چاپ<i class="red mx-1">*</i>:</label>
                                        <br> <span class="float-left font-16 "> {{form.publish_year | myDate}}</span>
                                        <date-picker @change="removeError('publish_year')" format="YYYY-MM-DD"
                                                     :class="[( errors.has('form-2.publish_year') || form.errors.has('publish_year') ? 'is-invalid': ''  )] "
                                                     v-validate="'required'" name="publish_year" v-model="form.publish_year" locale="fa,en"></date-picker>
                                        <div class="text-rtl">
                                            <i v-show="errors.has('form-2.publish_year')|| form.errors.has('publish_year')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form-2.publish_year') " class="red d-inline-block text-rtl text-rtl">{{ errors.first('form-2.publish_year') }}</span>
                                            <span v-show="form.errors.has('publish_year')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('publish_year') }}</span>
                                        </div>
                                    </div>
                                    <div  class="form-group my-3 text-right">
                                        <label class="blue ">نوبت چاپ<i class="red mx-1">*</i>:</label>
                                        <input  type="number" name="publish_number" step="1" min="1"
                                                placeholder="0"
                                                v-validate="'required|integer'"
                                                class="form-control" v-model="form.publish_number"
                                                :class="[( errors.has('form-2.publish_number') || form.errors.has('publish_number') ? 'is-invalid': ''  ) ]"
                                        >
                                        <i v-show="errors.has('form-2.publish_number') || form.errors.has('publish_number')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show="errors.has('form-2.publish_number')" class="red d-inline-block">{{ errors.first('form-2.publish_number') }}</span>
                                        <span v-show="form.errors.has('publish_number')" class="red d-inline-block">{{ form.errors.get('publish_number') }}</span>
                                    </div>
                                    <div  class="form-group my-3 text-right">
                                        <label class="blue ">تیراژ چاپ<i class="red mx-1">*</i>:</label>
                                        <input  type="number" name="copy_number" step="1" min="1"
                                                placeholder="0"
                                                v-validate="'required|integer'"
                                                class="form-control" v-model="form.copy_number"
                                                :class="[( errors.has('form-2.copy_number') || form.errors.has('copy_number') ? 'is-invalid': ''  ) ]"
                                        >
                                        <i v-show="errors.has('form-2.copy_number') || form.errors.has('copy_number')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show="errors.has('form-2.copy_number')" class="red d-inline-block">{{ errors.first('form-2.copy_number') }}</span>
                                        <span v-show="form.errors.has('copy_number')" class="red d-inline-block">{{ form.errors.get('copy_number') }}</span>
                                    </div>
                                    <div  class="form-group my-3 text-right">
                                        <label class="blue ">تعداد صفحات<i class="red mx-1">*</i>:</label>
                                        <input  type="number" name="pages" step="1" min="1"
                                                placeholder="0"
                                                v-validate="'required|integer'"
                                                class="form-control" v-model="form.pages"
                                                :class="[( errors.has('form-2.pages') || form.errors.has('pages') ? 'is-invalid': ''  ) ]"
                                        >
                                        <i v-show="errors.has('form-2.pages') || form.errors.has('pages')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show="errors.has('form-2.pages')" class="red d-inline-block">{{ errors.first('form-2.pages') }}</span>
                                        <span v-show="form.errors.has('pages')" class="red d-inline-block">{{ form.errors.get('pages') }}</span>
                                    </div>

                                    <div class="form-group my-3 text-right">
                                        <label class="blue text-right">آیا کتاب ویرایش شده است؟<i class="red mx-1">*</i>:</label>
                                    </div>
                                    <div class="form-group mb-4 text-right border-bottom">
                                        <p-radio v-model="form.edited" name="edited" value="1" class="p-icon p-curve p-bigger p-pulse text-ltr"  color="info-o">
                                            <i slot="extra" class="icon far fa-check"></i>
                                            آری
                                        </p-radio>
                                        <p-radio v-validate="'required'" v-model="form.edited"
                                                 name="edited" value="0" type="radio" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                            <i slot="extra" class="icon far fa-check"></i>
                                            خیر
                                        </p-radio>

                                        <br>
                                        <has-error :form="form" field="edited"></has-error>
                                        <i v-show="errors.has('form-2.edited') || form.errors.has('edited')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show="errors.has('form-2.edited')" class="red d-inline-block">{{ errors.first('form-2.edited') }}</span>
                                        <span v-show="form.errors.has('edited')" class="red d-inline-block">{{ form.errors.get('edited') }}</span>
                                    </div>
                                    <div v-if="form.edited == 1"  class="form-group my-3 text-right">
                                        <label class="blue ">نوبت ویرایش<i class="red mx-1">*</i>:</label>
                                        <input  type="number" name="edited_number" step="1" min="1"
                                                placeholder="0"
                                                v-validate="'required|integer'"
                                                class="form-control" v-model="form.edited_number"
                                                :class="[( errors.has('form-2.edited_number') || form.errors.has('edited_number') ? 'is-invalid': ''  ) ]"
                                        >
                                        <i v-show="errors.has('form-2.edited_number') || form.errors.has('edited_number')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show="errors.has('form-2.edited_number')" class="red d-inline-block">{{ errors.first('form-2.edited_number') }}</span>
                                        <span v-show="form.errors.has('edited_number')" class="red d-inline-block">{{ form.errors.get('edited_number') }}</span>
                                    </div>

                                    <div  class="form-group my-3 text-right">
                                        <label class="blue ">شابک کتاب<i class="red mx-1">*</i>:</label>
                                        <input   type="text" name="isbn"
                                                 placeholder="شابک کتاب"
                                                 v-validate="'required'"
                                                 class="form-control" v-model="form.isbn"
                                                 :class="[( errors.has('form-2.isbn') || form.errors.has('isbn') ? 'is-invalid': ''  ) ]"
                                        >
                                        <i v-show=" errors.has('form-2.isbn') || form.errors.has('isbn')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show=" errors.has('form-2.isbn')" class="red d-inline-block">{{ errors.first('form-2.isbn') }}</span>
                                        <span v-show="form.errors.has('isbn')" class="red d-inline-block">{{ form.errors.get('isbn') }}</span>
                                    </div>

                                    <div  class="form-group my-3 text-right">
                                        <label class="blue ">شماره کتابخانه ملی:</label>
                                        <input   type="text" name="national_code"
                                                 placeholder="شماره کتابخانه ملی"
                                                 class="form-control" v-model="form.national_code"
                                                 :class="[( errors.has('form-2.national_code') || form.errors.has('national_code') ? 'is-invalid': ''  ) ]"
                                        >
                                        <i v-show=" errors.has('form-2.national_code') || form.errors.has('national_code')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show=" errors.has('form-2.national_code')" class="red d-inline-block">{{ errors.first('form-2.national_code') }}</span>
                                        <span v-show="form.errors.has('national_code')" class="red d-inline-block">{{ form.errors.get('national_code') }}</span>
                                    </div>

                                    <div  class="form-group my-3 text-right">
                                        <label class="blue ">رتبه بندی گنگره:</label>
                                        <input   type="text" name="congress_code"
                                                 placeholder="رتبه بندی گنگره"
                                                 class="form-control" v-model="form.congress_code"
                                                 :class="[( errors.has('form-2.congress_code') || form.errors.has('congress_code') ? 'is-invalid': ''  ) ]"
                                        >
                                        <i v-show=" errors.has('form-2.congress_code') || form.errors.has('congress_code')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show=" errors.has('form-2.congress_code')" class="red d-inline-block">{{ errors.first('form-2.congress_code') }}</span>
                                        <span v-show="form.errors.has('congress_code')" class="red d-inline-block">{{ form.errors.get('congress_code') }}</span>
                                    </div>

                                    <div  class="form-group my-3 text-right">
                                        <label class="blue ">رتبه بندی دیویی:</label>
                                        <input   type="text" name="dewey_code"
                                                 placeholder="رتبه بندی دیویی"
                                                 class="form-control" v-model="form.dewey_code"
                                                 :class="[( errors.has('form-2.dewey_code') || form.errors.has('dewey_code') ? 'is-invalid': ''  ) ]"
                                        >
                                        <i v-show=" errors.has('form-2.dewey_code') || form.errors.has('dewey_code')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show=" errors.has('form-2.dewey_code')" class="red d-inline-block">{{ errors.first('form-2.dewey_code') }}</span>
                                        <span v-show="form.errors.has('dewey_code')" class="red d-inline-block">{{ form.errors.get('dewey_code') }}</span>
                                    </div>
                                </form>
                            </tab-content>
                            <!--  -->
                            <tab-content title="اطلاعات نویسندگان"  icon="fa fa-user-plus"   >
                                <form @submit.prevent="addAuthor"
                                      @keydown="form.onKeydown($event)" @change="form.onKeydown($event)"  data-vv-scope="form-4" id="Form4">
                                    <div class="text-right ">
                                        <span>لیست نویسندگان:</span><br>
                                        <i v-show="errors.has('form-4.isresponsible')||form.errors.has('isresponsible')||form.errors.has('authors')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show="errors.has('form-4.isresponsible')" class="red d-inline-block">{{ errors.first('form-4.isresponsible') }}</span>
                                        <span v-show="form.errors.has('isresponsible')" class="red d-inline-block">{{ form.errors.get('isresponsible') }}</span>
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
                            class="far fa-file-alt fa-fw"></i> مشاهده ضمیمه کتاب</h5>
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
                                    <a  v-if="$gate.isAdminOrAuthor()" @click="deleteCheckListItem(checkListItem.id, index)"><i class="red fa fa-trash"></i></a>
                                </td>
                            </tr>
                        </table>
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
        name: "BookEdit",
        data(){
            return {
                options: { // tinyMce toolbar options
                    language_url: '../js/fa_IR.js', //This url points to location of persian language file.
                    toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat',
                    toolbar1: ' cut copy paste | ltr rtl | | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor',
                    plugins:['advlist autolink lists link image charmap print preview hr anchor pagebreak', 'searchreplace wordcount visualblocks visualchars code fullscreen', 'insertdatetime media nonbreaking save table contextmenu directionality','template paste textcolor colorpicker textpattern imagetools toc help emoticons hr codesample'],
                },
                book:{},
                excerpts:[],
                bookTypes:[],
                terms:[],
                pdfFileName:'',     // will be used to display pdf files in modal
                fileName:[],    // For UI rendering and displaying the choosen file Names
                fileChanging:false, // if user wants to change any file or upload file
                editOffset: -1,     // for managing author editing form status used if -1 the form will be hide
                attachments:[],
                author:'',
                affiliation:'',
                checkList:false,
                TermChange:false,
                checkListItems:{},
                checkListForm: new Form({
                    id:'',
                    list:[],
                    status:null,
                    comment:'',
                    score:''
                }),
                f:new FormData, // creates the new FormData object to store selected files data
                // form data of VForm data object witch will be used to fill and submit the form
                form: new Form({
                    title:'',
                    booktype_id:'',
                    excerpt_id:'',
                    isbn:'',
                    subject:'',
                    publisher:'',
                    fileChangeType:'',
                    edited:'',
                    edited_number:'',
                    publish_number:'',
                    publish_year:'',
                    copy_number:'',
                    pages:'',
                    national_code:'',
                    congress_code:'',
                    dewey_code:'',
                    files:[],
                    authors:[],
                    affiliations:[],
                }),
                term_form: new Form({
                    id:'',
                    model:'Book',
                    term_id:'',
                }),
            }
        },
        methods:{
            // if the all paper submission validate it will submit the data to server
            onComplete: function(){
                this.$Progress.start();
                let loader1 = Vue.$loading.show();
                this.form.submit('post', `/api/bookUpdate/${this.book.id}`, {
                    // Transform form data to FormData
                    transformRequest: [function (data, headers) {
                        return objectToFormData(data)
                    }]
                }).then((response) => {
                    // sets the data
                    loader1.hide();
                    this.resetFormWizard();
                    this.book = response.data.data;
                    this.checkListItems = response.data.data.checkList;
                    this.editFormPrepare();
                    // UI modal Hide, progress bar finish , show the toase
                    $('#bookEditModal').modal('hide');
                    this.successToast('مقاله با موفقیت ویرایش شد.');
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
            // validate book form in step 1
            bookValidation(){
                return this.$validator.validateAll('form-1').then(result => {
                    if (!result) {
                        this.errorSwal('اطلاعات کتاب دارای خطا می باشد!');
                        return false;
                    }
                    return true;
                });
            },
            // validate book form in step 1
            detailValidation(){
                return this.$validator.validateAll('form-2').then(result => {
                    if (!result) {
                        this.errorSwal('اطلاعات شناسنامه کتاب، دارای خطا می باشد!');
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
                            this.book.status = 2;
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
                this.checkListForm.post('/api/bookCheckList')
                    .then((response) => {
                        this.checkListItems.unshift(response.data.checkListItem);
                        this.book.status = this.checkListForm.status;
                        this.book.score = response.data.score;
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
                    this.checkListForm.status = 1;
                }
            },
            prepareCheckList(){
                if(this.book.status != '0') {
                    if (this.checkListItems.length > 0 && this.book.status != '1') {
                        this.checkListForm.list = $.map(this.checkListItems[0].list, function (value, index) {
                            return [value];
                        });
                    }
                    if (this.checkListItems.length > 0){
                        this.checkListForm.comment = this.checkListItems[0].comment;
                        this.checkListForm.status = this.book.status;
                    }
                }
                this.checkListForm.score = this.book.score;
            },
            toggleCheckList(){
                this.checkList = !this.checkList;
                if(this.checkListForm.list.length < 1){
                    this.checkListForm.status = 1;
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
            bookEditModal(){
                $('#bookEditModal').modal('show');
            },
            // prepares the edit form data
            editFormPrepare(){
                this.form.fill(this.book);
                this.form.fileChangeType = '';
                this.form.authors = [];
                this.form.affiliations = [];
                this.form.files =[];

                for(var j=0; j<this.book.Authors.length; j++){
                    this.form.authors.push(this.book.Authors[j].name);
                    this.form.affiliations.push(this.book.Authors[j].affiliation);
                }

            },
            pdfModal(name){
                this.pdfFileName = '../files/books/'+name+'#page=1';
                $('#pdfModal').modal('show');
            },
            // checks the file type on render to see if it is pdf or zip
            checkFileType(file){
                var fileName = file.name.split(".");
                return fileName[1] == 'zip' || fileName[1] == 'rar'? true:false;
            },
            // on page load gets thesis data based on the received it
            getBookData(id){
                axios.get(`/api/book/${id}`)
                    .then(response => {
                        this.book = response.data.data;
                        this.checkListItems = response.data.data.checkList;
                        this.term_form.term_id = this.book.term_id;
                        this.prepareCheckList();
                        this.editFormPrepare();
                    })
                    .catch((e)=>{
                            console.log(e);
                        }
                    );
            },
            // gets necessary data for form like excerpts and conference types and journal types
            getBookRelation(){
                axios.get('/api/bookRelation')
                    .then(response => {
                        this.excerpts = response.data.excerpts;
                        this.bookTypes = response.data.bookTypes;
                        this.terms = response.data.terms;
                    })
                    .catch((e)=>{
                            //  console.log(e);
                        }
                    );
            },
            showTermChange(){
                return this.TermChange = ! this.TermChange;
            },
            termChangeSubmit(){
                this.term_form.id = this.id;
                this.$Progress.start();
                let loader1 = Vue.$loading.show();
                this.term_form.post('/api/termChange')
                    .then((res)=>{
                        loader1.hide();
                        this.book.term_name = res.data.term_name;
                        this.book.term_id = res.data.term_id;
                        this.TermChange = false;
                        this.$Progress.finish();
                    })
                    .catch((e)=>{
                        loader1.hide();
                        console.log(e);
                        this.$Progress.fail();
                    })
            },
            createBook(){

            }
        },
        created(){
            this.$validator.localize('farsi', {
                messages: farsi.messages,
                attributes: {
                    title: 'عنوان کتاب',
                    booktype_id:'نوع کتاب',
                    excerpt_id:'نوع مستخرج بودن ',
                    isbn:'شابک کتاب',
                    subject:'موضوع کتاب',
                    publisher:'اطلاعات ناشر',
                    edited:'انتخاب نوع ویرایش',
                    edited_number:'نوبت ویرایش',
                    publish_number:'نوبت چاپ',
                    publish_year:'سال چاپ',
                    copy_number:'تعداد نسخه چاپ',
                    pages:'تعداد صفحات',
                    files: 'فایل های ضمیمه',
                    fileChangeType: 'نوع تغییر فایل ها',
                    score: 'امتیاز',
                }
            });
            this.$parent.pageName = 'آرشیو کتب';
            this.id = this.$route.params.id;
            this.getBookRelation();
            this.getBookData(this.id);
        },
        components:{
            Select2,
        }
    }
</script>

<style scoped>

</style>
