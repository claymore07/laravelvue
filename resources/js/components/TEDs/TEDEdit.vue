<template>
    <div>
        <div class="container-fluid text-rtl text-right my-5">
            <div class="card card-4 my-5">
                <div class="card-header justify-content-around d-flex " style="direction: rtl">
                    <div class="col">
                        <h3 class=" text-right"><i class="fal fa-lightbulb-on fa-fw"></i> اطلاعات کرسی‌  نظریه پردازی ‌</h3>
                    </div>
                    <div class="card-tools">
                        <button class="btn btn-success" @click="goback"><i style="font-size: 16px" class="fal fa-undo"></i> بازگشت</button>
                    </div><!-- /card-tools -->
                </div><!-- /.card-header -->
                <div class="card-body  px-0">
                    <table class="table table-hover table-striped">
                        <thead class="thead-dark">
                        <tr>
                            <th class="font-18"><i class="fal fa-lightbulb-on fa-fw"></i> اطلاعات کرسی‌  نظریه پردازی </th>
                            <th v-if="checkList">موارد ناقص</th>
                        </tr>
                        </thead>
                        <tbody v-if="ted.id">
                        <tr>
                            <td class="font-16">
                                <span class="blue">عنوان کرسی‌:</span>
                                <span class="mr-3">{{ted.title}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('عنوان کرسی‌')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('عنوان کرسی‌')"
                                         @change.native="onChange('عنوان کرسی‌', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">نوع کرسی‌:</span>
                                <span class="mr-3">{{ted.ted_type}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نوع کرسی‌')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('نوع کرسی‌')"
                                         @change.native="onChange('نوع کرسی‌', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">نام ارائه دهنده:</span>
                                <span class="mr-3">{{ted.Author_name}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نام ارائه دهنده')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('نام ارائه دهنده')"
                                         @change.native="onChange('نام ارائه دهنده', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">محل برگزاری:</span>
                                <span class="mr-3">{{ted.location}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('محل برگزاری')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('محل برگزاری')"
                                         @change.native="onChange('محل برگزاری', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>


                        <tr>
                            <td class="font-16">
                                <span class="blue ">تاریخ ارائه:</span>
                                <span class="mr-3 "> {{ted.presentation_date | myDate}} هجری شمسی</span>
                                <span class="mr-3 "> {{ted.presentation_date | myDateEN}} میلادی</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('تاریخ ارائه')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check
                                    :checked="checkListForm.list && checkListForm.list.includes('تاریخ ارائه')"
                                    @change.native="onChange('تاریخ ارائه', $event)"
                                    type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue ">فایل های ضمیمه:</span>
                                <span v-for="(file, index) of ted.files" class="mr-3 ">
                                    <div v-if="checkFileType(file)" class="btn-group text-ltr" role="group" aria-label="Basic example">
                                         <a  class="btn btn-lg btn-info" :href="'../files/tedchairs/'+file.name"><i class="fal fa-download fa-fw"></i>  </a>
                                         <a  class="btn btn-lg btn-info" :href="'../files/tedchairs/'+file.name">ضمیمه {{index+1|faDigit}}  <i class="fal fa-file-archive fa-fw"></i></a>
                                    </div>
                                    <div v-else class="btn-group text-ltr" role="group" aria-label="Basic example">
                                      <a  :href="'../files/tedchairs/'+file.name" class="btn btn-lg btn-info"><i class="fal fa-download"></i></a>
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
                                <span class="orange ">ترم ثبت شده:</span>
                                <span v-show="!TermChange" class="mr-3">{{ted.term_name}}</span>
                                <select v-show="TermChange" v-validate="'required'" data-vv-name="term_id"
                                        id="term_id"
                                        v-model="term_form.term_id"
                                        @change="removeError('term_id')"
                                >
                                    <option selected disabled value="">انتخاب ترم ...</option>
                                    <option v-for="term in terms" :key="term.id" :value="term.id">{{term.text}}</option>
                                </select>
                                <a v-show="TermChange" @click="termChangeSubmit" class="btn btn-primary text-white ripple" v-if="$gate.isAdminOrUser">ثبت تغییر ترم</a>
                                <a v-show="TermChange" @click="showTermChange" class="btn btn-danger text-white ripple" v-if="$gate.isAdminOrUser">لغو عملیات</a>
                                <a v-show="!TermChange" @click="showTermChange" class="btn btn-success text-white ripple" v-if="$gate.isAdminOrUser">تغییر ترم</a>

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
                                <span v-if="ted.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</span>
                                <span v-else-if="ted.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</span>
                                <span v-else-if="ted.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</span>
                                <span v-else-if="ted.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</span>
                                <span v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</span>
                            </td>
                            <td v-if="checkList">
                            </td>
                        </tr>
                        <tr v-show="checkList">
                            <td colspan="2">
                                <label for="status" class="blue mt-3">وضعیت بررسی: </label>
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
                                <br>
                                <label for="id2" class="blue mt-3">توضیحات: </label>
                                <i v-show="checkListForm.errors.has('comment')" class="red far fa-exclamation-triangle"></i>
                                <span v-show="checkListForm.errors.has('comment')" class="red d-inline-block">{{ checkListForm.errors.get('comment') }}</span>
                                <tinymce dir="rtl" @editorInit="e => e.setContent(checkListForm.comment)" v-model="checkListForm.comment" :other_options="options" name="comment" id="id2"></tinymce>

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
                    <!-- tedEditModal checkListSubmit toggleCheckList checkListHistory-->
                    <button v-if="ted.status != 3 && ted.status != 1" @click="tedEditModal" class="btn btn-lg mx-1 btn-secondary">ویرایش  کرسی</button>
                    <button @click="checkListHistory" class="btn btn-lg mx-1 btn-secondary"><i class="fal fa-history fa-fw mx-2"></i>تاریخچه بررسی</button>
                    <button v-if="checkList" @click="checkListSubmit" class="btn btn-lg btn-success mx-5"><i class="fal fa-check fa-fw"></i>ثبت نتبجه بررسی</button>
                    <button v-if="$gate.isAdmin()" @click="toggleCheckList"  class="btn btn-lg mx-1 btn-warning">چک لیست بررسی</button>
                </div>
            </div>
        </div><!-- /container -->

        <div  v-if="$gate.isAdmin()||$gate.isAuthor()" class="modal  fade" id="tedEditModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i
                            class="far fa-lightbulb-on fa-fw"></i> ویرایش اطلاعات دوره</h5>
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
                            <h2 slot="title">تکمیل اطلاعات کرسی</h2>
                            <!--  -->
                            <tab-content title="اطلاعات کرسی" :before-change="tedValidation"  icon="far fa-lightbulb-on">
                                <form @submit.prevent="updateTed()" @keydown="form.onKeydown($event)" @change="form.onKeydown($event)" data-vv-scope="form" id="Form">

                                    <div class="modal-body">
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">عنوان کرسی<i class="red mx-1">*</i>:</label>
                                            <input  type="text"  name="title" placeholder="عنوان کرسی"
                                                    class="form-control" v-model="form.title"
                                                    v-validate="'required'"
                                                    autofocus
                                                    :class="{ 'is-invalid': form.errors.has('title') || errors.has('form.title') } " >
                                            <i v-show="errors.has('form.title') || form.errors.has('title')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.form.title')" class="red d-inline-block">{{ errors.first('form.title') }}</span>
                                            <has-error :form="form" field="title"></has-error>
                                        </div>
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">نوع کرسی<i class="red mx-1">*</i>:</label>
                                            <Select2 v-validate="'required'" data-vv-name="ted_types_id"
                                                     class="form-control select2-form-control" id="ted_types_id"
                                                     :class="[( errors.has('form.ted_types_id') || form.errors.has('ted_types_id') ? 'is-invalid': ''  )]"
                                                     v-model="form.ted_types_id"
                                                     :options="ted_types"
                                                     @change="removeError('ted_types_id')"
                                                     :settings="{theme: 'bootstrap4', placeholder: 'نوع کرسی', width: '100%' }">
                                            </Select2>

                                            <i v-show="errors.has('form.ted_types_id') || form.errors.has('ted_types_id')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.ted_types_id')" class="red d-inline-block">{{ errors.first('form.ted_types_id') }}</span>
                                            <span v-show="form.errors.has('ted_types_id')" class="red d-inline-block">{{ form.errors.get('ted_types_id') }}</span>
                                        </div>
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">محل برگزاری<i class="red mx-1">*</i>:</label>
                                            <input  type="text"  name="location" placeholder="محل برگزاری"
                                                    class="form-control" v-model="form.location"
                                                    v-validate="'required'"
                                                    :class="{ 'is-invalid': form.errors.has('location') || errors.has('form.location')} " @input="() => {}">
                                            <i v-show="errors.has('form.location') || form.errors.has('location')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.location')" class="red d-inline-block">{{ errors.first('form.location') }}</span>
                                            <has-error :form="form" field="location"></has-error>
                                        </div>

                                        <div class=" my-3" style="direction: ltr; text-align: right" >
                                            <label class="blue text-right  text-rtl">تاریخ ارائه<i class="red mx-1">*</i>:</label>
                                            <br> <span class="float-left font-16 "> {{form.presentation_date | myDate}}</span>
                                            <date-picker @change="removeError('presentation_date')" format="YYYY-MM-DD"
                                                         v-validate="'required'"
                                                         :class="[ errors.has('form.presentation_date') || form.errors.has('presentation_date') ? 'is-invalid': ''  ] "
                                                         name="presentation_date" v-model="form.presentation_date" locale="fa,en"></date-picker>
                                            <div class="text-rtl">
                                                <i v-show="errors.has('form.presentation_date') || form.errors.has('presentation_date')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form.presentation_date')" class="red d-inline-block">{{ errors.first('form.presentation_date') }}</span>
                                                <span v-show="form.errors.has('presentation_date')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('presentation_date') }}</span>
                                            </div>
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
                                                <i v-show="errors.has('form.fileChangeType') || form.errors.has('fileChangeType')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form.fileChangeType')" class="red d-inline-block">{{ errors.first('form.fileChangeType') }}</span>
                                                <span v-show="form.errors.has('fileChangeType')" class="red d-inline-block">{{ form.errors.get('fileChangeType') }}</span>
                                            </div>
                                        </div>
                                        <div v-if="fileChanging" class="form-group my-3 text-right">
                                            <label class="blue text-right">فایل های ضمیمه<i class="red mx-1">*</i>:</label>
                                            <span class="red"><br/>
                                                اسکن گواهی برگزاری بصورت pdf<br>
                                                اسکن مجوز بصورت pdf<br>
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
                        <h5 class="modal-title" id="exampleModalLabel1"><i
                            class="far fa-file-alt fa-fw"></i> مشاهده ضمیمه کرسی نظریه پردازی</h5>
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
    </div>
</template>

<script>
    import Select2 from 'v-select2-component';
    import farsi from 'vee-validate/dist/locale/fa';
    export default {
        name: "TEDEdit",
        data(){
            return{
                options: { // tinyMce toolbar options
                    language_url: '../js/fa_IR.js', //This url points to location of persian language file.
                    toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat',
                    toolbar1: ' cut copy paste | ltr rtl | | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor',
                    plugins:['advlist autolink lists link image charmap print preview hr anchor pagebreak', 'searchreplace wordcount visualblocks visualchars code fullscreen', 'insertdatetime media nonbreaking save table contextmenu directionality','template paste textcolor colorpicker textpattern imagetools toc help emoticons hr codesample'],
                },
                ted:{},
                ted_types:[],
                terms:[],
                pdfFileName:'',     // will be used to display pdf files in modal
                fileName:[],    // For UI rendering and displaying the choosen file Names
                fileChanging:false, // if user wants to change any file or upload file
                editOffset: -1,     // for managing author editing form status used if -1 the form will be hide
                attachments:[],
                checkList:false,
                TermChange:false,
                checkListItems:{},
                checkListForm: new Form({
                    id:'',
                    list:[],
                    status:null,
                    comment:''
                }),
                f:new FormData, // creates the new FormData object to store selected files data
                // form data of VForm data object witch will be used to fill and submit the form
                form: new Form({
                    title:'',
                    location: '',
                    ted_types_id: '',
                    presentation_date: '',
                    files:[],
                }),
                term_form: new Form({
                    id:'',
                    model:'TED',
                    term_id:'',
                }),
            }
        },
        methods:{
            // if the all paper submission validate it will submit the data to server
            onComplete: function(){
                this.$Progress.start();
                let loader1 = Vue.$loading.show();
                this.form.submit('post', `/api/tedChairUpdate/${this.ted.id}`, {
                    // Transform form data to FormData
                    transformRequest: [function (data, headers) {
                        return objectToFormData(data)
                    }]
                }).then((response) => {
                    // sets the data
                    loader1.hide();
                    this.resetFormWizard();
                    this.ted = response.data.data;
                    this.checkListItems = response.data.data.checkList;
                    this.editFormPrepare();
                    // UI modal Hide, progress bar finish , show the toase
                    $('#tedEditModal').modal('hide');
                    this.successToast('اطلاعات کرسی با موفقیت ویرایش شد.');
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
            tedValidation(){
                return this.$validator.validateAll('form').then(result => {
                    if (!result) {
                        this.errorSwal('اطلاعات کرسی دارای خطا می باشد!');
                        return false;
                    }
                    return true;
                });
            },

            // gets necessary data for form like excerpts and conference types and journal types
            /** these functions are responsible for form input error handling and change state*/
            // resets all the form modal related state and variables
            resetFormWizard() {
                this.fileName=[];
                this.attachments = [];
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
                            this.ted.status = 2;
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
                this.checkListForm.post('/api/tedCheckList')
                    .then((response) => {
                        this.checkListItems.unshift(response.data.checkListItem);
                        this.ted.status = this.checkListForm.status;
                        this.successToast('نتایج بررسی با موفقیت ثبت شد.');
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
                if(this.ted.status != '0') {
                    if (this.checkListItems.length > 0 && this.ted.status != '1') {
                        this.checkListForm.list = $.map(this.checkListItems[0].list, function (value, index) {
                            return [value];
                        });
                    }
                    if (this.checkListItems.length > 0 ) {
                        this.checkListForm.comment = this.checkListItems[0].comment;
                        this.checkListForm.status = this.ted.status;
                    }
                }
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
                this.$router.push({path:'/teds'});
            },
            // shows tedEditModal
            tedEditModal(){
                $('#tedEditModal').modal('show');
            },
            // prepares the edit form data
            editFormPrepare(){
                this.form.fill(this.ted);
                this.form.fileChangeType = '';
                this.form.files =[];
            },
            pdfModal(name){
                this.pdfFileName = '../files/tedchairs/'+name+'#page=1';
                $('#pdfModal').modal('show');
            },
            // checks the file type on render to see if it is pdf or zip
            checkFileType(file){
                var fileName = file.name.split(".");
                return fileName[1] == 'zip' || fileName[1] == 'rar'? true:false;
            },
            // on page load gets ted data based on the received it
            gettedData(id){
                axios.get(`/api/tedChair/${id}`)
                    .then(response => {
                        this.ted = response.data.data;
                        this.checkListItems = response.data.data.checkList;
                        this.term_form.term_id = this.ted.term_id;
                        this.prepareCheckList();
                        this.editFormPrepare();

                    })
                    .catch((e)=>{
                            console.log('asdasdasdasdajkasa');
                        }
                    );
            },
            // gets necessary data for form like
            getTEDRelation(){
                axios.get('/api/tedChairRelation')
                    .then(response => {
                        this.ted_types = response.data.ted_types;
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
                this.$Progress.start();
                let loader1 = Vue.$loading.show();
                this.term_form.id = this.id;
                this.term_form.post('/api/termChange')
                    .then((res)=>{
                        loader1.hide();
                        this.ted.term_name = res.data.term_name;
                        this.ted.term_id = res.data.term_id;
                        this.TermChange = false;
                        this.$Progress.finish();
                    })
                    .catch((e)=>{
                        loader1.hide();
                        this.$Progress.fail();
                        console.log(e);
                    })
            },
            updateTed(){
            }
        },
        created(){
            this.$parent.pageName = 'آرشیو کرسی‌ها';
            this.$validator.localize('farsi', {
                messages: farsi.messages,
                attributes: {
                    title: 'عنوان دوره',
                    role: 'نقش در دوره',
                    fileChangeType: 'نوع تغییر فایل ها',
                    holding_date: 'تاربخ برگزاری',
                    duration: 'مدت زمان دوره',
                    organization:'سازمان برگزار کننده دوره',
                    place:'محل برگزاری',
                    files: 'فایل های ضمیمه',
                }
            });
            this.id = this.$route.params.id;
            this.gettedData(this.id);
            this.getTEDRelation();
        },
        components: {
            Select2,
        }
    }
</script>

<style scoped>

</style>

