<template>
    <div>
        <div class="container-fluid text-rtl text-right my-5">
            <div class="card card-4 my-5">
                <div class="card-header justify-content-around d-flex " style="direction: rtl">
                    <div class="col">
                        <h3 class=" text-right"><i class="fal fa-microscope fa-fw"></i> اطلاعات اختراع، اکتشاف یا تولید علمی</h3>
                    </div>
                    <div class="card-tools">
                        <button class="btn btn-success" @click="goback"><i style="font-size: 16px" class="fal fa-undo"></i> بازگشت</button>
                    </div><!-- /card-tools -->
                </div><!-- /.card-header -->
                <div class="card-body  px-0">
                    <table class="table table-hover table-striped">
                        <thead class="thead-dark">
                        <tr>
                            <th class="font-18"><i class="fal fa-microscope fa-fw"></i> اطلاعات اختراع، اکتشاف یا تولید علمی</th>
                            <th v-if="checkList">موارد ناقص</th>
                        </tr>
                        </thead>
                        <tbody v-if="invention.id">
                        <tr>
                            <td class="font-16">
                                <span class="blue">عنوان اختراع، اکتشاف یا تولید علمی:</span>
                                <span class="mr-3">{{invention.title}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('عنوان اختراع‌')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('عنوان اختراع‌')"
                                         @change.native="onChange('عنوان اختراع‌', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">نوع اختراع، اکتشاف یا تولید علمی:</span>
                                <span class="mr-3">{{invention.invention_type}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نوع اختراع')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('نوع اختراع')"
                                         @change.native="onChange('نوع اختراع', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">نام مخترع:</span>
                                <span class="mr-3">{{invention.Author_name}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نام مخترع')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('نام مخترع')"
                                         @change.native="onChange('نام مخترع', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr v-if="invention.invention_types_id == 9">
                            <td class="font-16">
                                <span class="blue">آیا پتنت ثبت شده به فروش رسیده یا بصورت لیسانس از آن استفاده شده است؟ </span>
                                <span v-if="invention.license == 0" class="mr-3"><i class="fa fa-times red fa-fw"></i> خیر</span>
                                <span v-if="invention.license == 1" class="mr-3"><i class="fa fa-check green fa-fw"></i> بله</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نحوه استفاده از پتنت')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('نحوه استفاده از پتنت')"
                                         @change.native="onChange('نحوه استفاده از پتنت', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr v-if="invention.invention_types_id == 9">
                            <td class="font-16">
                                <span class="blue">شماره ثبت پتنت:</span>
                                <span class="mr-3">{{invention.license_number}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('شماره ثبت پتنت')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('شماره ثبت پتنت')"
                                         @change.native="onChange('شماره ثبت پتنت', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr v-if="invention.invention_types_id == 9">
                            <td class="font-16">
                                <span class="blue">نام موسسه وابسته یا Affiliation ثبت شده در پتنت:</span>
                                <span class="mr-3">{{invention.affiliation}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نام موسسه وابسته')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('نام موسسه وابسته')"
                                         @change.native="onChange('نام موسسه وابسته', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr v-if="invention.invention_types_id == 8">
                            <td class="font-16">
                                <span class="blue">نام شرکت ثبت شده:</span>
                                <span class="mr-3">{{invention.company_name}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نام شرکت')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('نام شرکت')"
                                         @change.native="onChange('نام شرکت', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr v-if="invention.invention_types_id == 8">
                            <td class="font-16">
                                <span class="blue">نوع شرکت ثبت شده:</span>
                                <span class="mr-3">{{invention.company_type}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نوع شرکت')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('نوع شرکت')"
                                         @change.native="onChange('نوع شرکت', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr v-if="invention.invention_types_id == 8">
                            <td class="font-16">
                                <span class="blue">آدرس شرکت ثبت شده:</span>
                                <span class="mr-3">{{invention.company_address}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('آدرس شرکت')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('آدرس شرکت')"
                                         @change.native="onChange('آدرس شرکت', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr v-if="invention.invention_types_id == 8">
                            <td class="font-16">
                                <span class="blue">شماره ثبت شرکت:</span>
                                <span class="mr-3">{{invention.registration_number}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('شماره ثبت شرکت')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('شماره ثبت شرکت')"
                                         @change.native="onChange('شماره ثبت شرکت', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>


                        <tr>
                            <td class="font-16">
                                <span class="blue ">تاریخ ثبت یا صدور مجوز:</span>
                                <span class="mr-3 "> {{invention.submit_date | myDate}} هجری شمسی</span>
                                <span class="mr-3 "> {{invention.submit_date | myDateEN}} میلادی</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('تاریخ ثبت یا صدور مجوز')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check
                                    :checked="checkListForm.list && checkListForm.list.includes('تاریخ ثبت یا صدور مجوز')"
                                    @change.native="onChange('تاریخ ثبت یا صدور مجوز', $event)"
                                    type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue ">فایل های ضمیمه:</span>
                                <span v-for="(file, index) of invention.files" class="mr-3 ">
                                    <div v-if="checkFileType(file)" class="btn-group text-ltr" role="group" aria-label="Basic example">
                                         <a  class="btn btn-lg btn-info" :href="'../files/inventions/'+file.name"><i class="fal fa-download fa-fw"></i>  </a>
                                         <a  class="btn btn-lg btn-info" :href="'../files/inventions/'+file.name">ضمیمه {{index+1|faDigit}}  <i class="fal fa-file-archive fa-fw"></i></a>
                                    </div>
                                    <div v-else class="btn-group text-ltr" role="group" aria-label="Basic example">
                                      <a  :href="'../files/inventions/'+file.name" class="btn btn-lg btn-info"><i class="fal fa-download"></i></a>
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
                                <span v-show="!TermChange"  class="mr-3">{{invention.term_name}}</span>
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
                                <span v-if="invention.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</span>
                                <span v-else-if="invention.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</span>
                                <span v-else-if="invention.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</span>
                                <span v-else-if="invention.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</span>
                                <span v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</span>
                            </td>
                            <td v-if="checkList">
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue ">امتیاز کسب شده:</span>
                                <span v-if="invention.status != '1'"  ><i class="fal fa-question"></i>  {{'امتیازی ثبت نشده' }}</span>
                                <span v-else >  {{invention.score | faDigits }}</span>
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
                                            <input type="number" :min="invention.minScore" :max="invention.maxScore" name="score"
                                                   placeholder=""
                                                   :class="[( errors.has('checkListForm.score') || checkListForm.errors.has('score') ? 'is-invalid': ''  )]"
                                                   v-validate="{min_value:invention.minScore,max_value:invention.maxScore}"
                                                   class="form-control w-50" v-model="checkListForm.score" >
                                        </div>
                                        <div class="form-group mb-2">
                                            <span>توجه: امتیاز این آیتم با توجه به بخشنامه در بازه {{invention.minScore}} و {{invention.maxScore}} در نظر گرفته میشود.</span>
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
                    <!-- tedEditModal checkListSubmit toggleCheckList checkListHistory-->
                    <button v-if="invention.status != 3 && invention.status != 1" @click="inventionEditModal" class="btn btn-lg mx-1 btn-secondary">ویرایش  اختراع</button>
                    <button @click="checkListHistory" class="btn btn-lg mx-1 btn-secondary"><i class="fal fa-history fa-fw mx-2"></i>تاریخچه بررسی</button>
                    <button v-if="checkList" @click="checkListSubmit" class="btn btn-lg btn-success mx-5"><i class="fal fa-check fa-fw"></i>ثبت نتبجه بررسی</button>
                    <button v-if="$gate.isAdmin()" @click="toggleCheckList"  class="btn btn-lg mx-1 btn-warning">چک لیست بررسی</button>
                </div>
            </div>
        </div><!-- /container -->

        <div  v-if="$gate.isAdmin()||$gate.isAuthor()" class="modal  fade" id="inventionEditModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i
                            class="far fa-microscope fa-fw"></i> ویرایش اطلاعات اختراع، اکتشاف یا تولید علمی جدید</h5>
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
                            <h2 slot="title">تکمیل اطلاعات اختراع، اکتشاف یا تولید علمی جدید</h2>
                            <!--  -->
                            <tab-content title="اطلاعات اختراع"   :before-change="inventionValidation" icon="far fa-microscope">
                                <form @submit.prevent="createCourse()" @keydown="form.onKeydown($event)" @change="form.onKeydown($event)" data-vv-scope="form" id="Form">

                                    <div class="modal-body">
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">عنوان اختراع، اکتشاف یا تولید علمی<i class="red mx-1">*</i>:</label>
                                            <input  type="text"  name="title" placeholder="عنوان اختراع، اکتشاف یا تولید علمی"
                                                    class="form-control" v-model="form.title"
                                                    v-validate="'required'"
                                                    autofocus
                                                    :class="{ 'is-invalid': form.errors.has('title') || errors.has('form.title') } " >
                                            <i v-show="errors.has('form.title') || form.errors.has('title')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.title')" class="red d-inline-block">{{ errors.first('form.title') }}</span>
                                            <span v-show="form.errors.has('title')" class="red d-inline-block">{{ form.errors.get('title') }}</span>
                                        </div>
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">نوع عنوان اختراع، اکتشاف یا تولید علمی<i class="red mx-1">*</i>:</label>
                                            <Select2 v-validate="'required'" data-vv-name="invention_types_id"
                                                     class="form-control select2-form-control" id="invention_types_id"
                                                     :class="[( errors.has('form.invention_types_id') || form.errors.has('invention_types_id') ? 'is-invalid': ''  )]"
                                                     v-model="form.invention_types_id"
                                                     :options="invention_types"
                                                     @change="removeError('invention_types_id')"
                                                     :settings="{theme: 'bootstrap4', placeholder: 'نوع عنوان اختراع، اکتشاف یا تولید علمی', width: '100%' }">
                                            </Select2>

                                            <i v-show="errors.has('form.invention_types_id') || form.errors.has('invention_types_id')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.invention_types_id')" class="red d-inline-block">{{ errors.first('form.invention_types_id') }}</span>
                                            <span v-show="form.errors.has('invention_types_id')" class="red d-inline-block">{{ form.errors.get('invention_types_id') }}</span>
                                        </div>
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">نقش در اختراع، اکتشاف یا تولید علمی<i class="red mx-1">*</i>:</label>
                                            <select v-model="form.post"
                                                    data-vv-name="post"
                                                    :class="{ 'is-invalid': form.errors.has('post')|| errors.has('form.post') }"
                                                    v-validate="'required'"
                                                    @change="removeError('post')"
                                                    class="form-control">
                                                <option selected disabled  value="">انتخاب گزینه ...</option>
                                                <option value="مسئول">مسئول</option>
                                                <option value="عضو تیم">عضو تیم</option>
                                            </select>
                                            <i v-show="errors.has('form.post') || form.errors.has('post')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.post')" class="red d-inline-block">{{ errors.first('form.post') }}</span>
                                            <span v-show="form.errors.has('post')" class="red d-inline-block">{{ form.errors.get('post') }}</span>
                                        </div>
                                        <div  class="form-group my-3 text-right">
                                            <label   class="blue ">نام مرجع تایید کننده<i class="red mx-1">*</i>:</label>
                                            <input   type="text" name="authorities"
                                                     placeholder="نام مرجع تایید کننده"
                                                     v-validate="'required'"
                                                     class="form-control" v-model="form.authorities"
                                                     :class="[( errors.has('form.authorities') || form.errors.has('authorities') ? 'is-invalid': ''  ) ]"
                                            >
                                            <i v-show="errors.has('form.authorities') || form.errors.has('authorities')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.authorities')" class="red d-inline-block">{{ errors.first('form.authorities') }}</span>
                                            <span v-show="form.errors.has('authorities')" class="red d-inline-block">{{ form.errors.get('authorities') }}</span>
                                        </div>


                                        <div class=" my-3" style="direction: ltr; text-align: right" >
                                            <label class="blue text-right  text-rtl">تاریخ ثبت اختراع یا صدور تاییدیه<i class="red mx-1">*</i>:</label>
                                            <br> <span class="float-left font-16 "> {{form.submit_date | myDate}}</span>
                                            <date-picker @change="removeError('submit_date')" format="YYYY-MM-DD"
                                                         v-validate="'required'"
                                                         :class="[ errors.has('form.submit_date') || form.errors.has('submit_date') ? 'is-invalid': ''  ] "
                                                         name="submit_date" v-model="form.submit_date" locale="fa,en"></date-picker>
                                            <div class="text-rtl">
                                                <i v-show="errors.has('form.submit_date') || form.errors.has('submit_date')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form.submit_date')" class="red d-inline-block">{{ errors.first('form.submit_date') }}</span>
                                                <span v-show="form.errors.has('submit_date')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('submit_date') }}</span>
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
                                                اسکن گواهی داوری درصورت وجود بصورت pdf<br>
                                                اسکن گواهی نظارت در صورت وجود بصورت pdf<br>
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
                            <tab-content v-if="form.invention_types_id == 8 || form.invention_types_id == 9" title="اطلاعات سایر اطلاعات" :before-change="detailValidation"  icon="far fa-clipboard-list-check">
                                <form  @submit.prevent="createBook()"
                                       @keydown="form.onKeydown($event)" @change="form.onKeydown($event)" data-vv-scope="form-2"  id="form-2">
                                    <div >
                                        <div v-if="form.invention_types_id == 9" class="form-group my-3 text-right ">
                                            <label class="blue text-right  text-rtl"><i class="red mx-1">*</i>آیا پتنت ثبت شده به فروش رسیده یا بصورت لیسانس از آن استفاده شده است؟<i class="red mx-1">*</i></label>
                                            <p-radio v-model="form.license"   name="license" value="1"  class="p-icon p-curve p-bigger p-pulse text-ltr"  color="info-o">
                                                <i slot="extra" class="icon far fa-check"></i>
                                                بله
                                            </p-radio>
                                            <p-radio v-validate="'required'" v-model="form.license"
                                                     name="license" value="0"   type="radio"  class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                                <i slot="extra" class="icon far fa-check"></i>
                                                خیر
                                            </p-radio>

                                            <br>
                                            <i v-show="errors.has('form-2.license') || form.errors.has('license')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form-2.license')" class="red d-inline-block">{{ errors.first('form-2.license') }}</span>
                                            <span v-show="form.errors.has('license')" class="red d-inline-block">{{ form.errors.get('license') }}</span>
                                        </div>

                                        <div  v-if="form.invention_types_id == 9"  class="form-group my-3 text-right">
                                            <label   class="blue ">نام موسسه وابسته یا Affiliation ثبت شده در پتنت<i class="red mx-1">*</i>:</label>
                                            <input   type="text" name="affiliation"
                                                     data-vv-name="affiliation"
                                                     placeholder="نام موسسه وابسته"
                                                     v-validate="'required'"
                                                     class="form-control" v-model="form.affiliation"
                                                     :class="[( errors.has('form-2.affiliation') || form.errors.has('affiliation') ? 'is-invalid': ''  ) ]"
                                            >
                                            <i v-show="errors.has('form-2.affiliation') || form.errors.has('affiliation')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form-2.affiliation')" class="red d-inline-block">{{ errors.first('form-2.affiliation') }}</span>
                                            <span v-show="form.errors.has('affiliation')" class="red d-inline-block">{{ form.errors.get('affiliation') }}</span>
                                        </div>
                                        <div v-if="form.invention_types_id == 9"  class="form-group my-3 text-right">
                                            <label   class="blue ">شماره ثبت پتنت<i class="red mx-1">*</i>:</label>
                                            <input   type="text" name="license_number"
                                                     data-vv-name="license_number"
                                                     placeholder="شماره ثبت پتنت"
                                                     v-validate="'required'"
                                                     class="form-control" v-model="form.license_number"
                                                     :class="[( errors.has('form-2.license_number') || form.errors.has('license_number') ? 'is-invalid': ''  ) ]"
                                            >
                                            <i v-show="errors.has('form-2.license_number') || form.errors.has('license_number')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form-2.license_number')" class="red d-inline-block">{{ errors.first('form-2.license_number') }}</span>
                                            <span v-show="form.errors.has('license_number')" class="red d-inline-block">{{ form.errors.get('license_number') }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div v-if="form.invention_types_id == 8" class="form-group my-3 text-right">
                                            <label   class="blue ">نام شرکت<i class="red mx-1">*</i>:</label>
                                            <input   type="text" name="company_name"
                                                     placeholder="نام شرکت"
                                                     v-validate="'required'"
                                                     class="form-control" v-model="form.company_name"
                                                     :class="[( errors.has('form-2.company_name') || form.errors.has('company_name') ? 'is-invalid': ''  ) ]"
                                            >
                                            <i v-show="errors.has('form-2.company_name') || form.errors.has('company_name')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form-2.company_name')" class="red d-inline-block">{{ errors.first('form-2.company_name') }}</span>
                                            <span v-show="form.errors.has('company_name')" class="red d-inline-block">{{ form.errors.get('company_name') }}</span>
                                        </div>
                                        <div  v-if="form.invention_types_id == 8" class="form-group my-3 text-right">
                                            <label   class="blue ">نوع شرکت ثبت شده<i class="red mx-1">*</i>:</label>
                                            <input   type="text" name="company_type"
                                                     data-vv-name="company_type"
                                                     placeholder="نوع شرکت ثبت شده( سهامی عام و...)"
                                                     v-validate="'required'"
                                                     class="form-control" v-model="form.company_type"
                                                     :class="[( errors.has('form-2.company_type') || form.errors.has('company_type') ? 'is-invalid': ''  ) ]"
                                            >
                                            <i v-show="errors.has('form-2.company_type') || form.errors.has('company_type')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form-2.company_type')" class="red d-inline-block">{{ errors.first('form-2.company_type') }}</span>
                                            <span v-show="form.errors.has('company_type')" class="red d-inline-block">{{ form.errors.get('company_type') }}</span>
                                        </div>
                                        <div  v-if="form.invention_types_id == 8" class="form-group my-3 text-right">
                                            <label   class="blue ">آدرس شرکت ثبت شده<i class="red mx-1">*</i>:</label>
                                            <input   type="text" name="company_address"
                                                     data-vv-name="company_address"
                                                     placeholder="آدرس شرکت ثبت شده"
                                                     v-validate="'required'"
                                                     class="form-control" v-model="form.company_address"
                                                     :class="[( errors.has('form-2.company_address') || form.errors.has('company_address') ? 'is-invalid': ''  ) ]"
                                            >
                                            <i v-show="errors.has('form-2.company_address') || form.errors.has('company_address')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form-2.company_address')" class="red d-inline-block">{{ errors.first('form-2.company_address') }}</span>
                                            <span v-show="form.errors.has('company_address')" class="red d-inline-block">{{ form.errors.get('company_address') }}</span>
                                        </div>
                                        <div  v-if="form.invention_types_id == 8" class="form-group my-3 text-right">
                                            <label   class="blue ">شماره ثبت شرکت<i class="red mx-1">*</i>:</label>
                                            <input   type="text" name="registration_number"
                                                     data-vv-name="registration_number"
                                                     placeholder="شماره ثبت شرکت"
                                                     v-validate="'required'"
                                                     class="form-control" v-model="form.registration_number"
                                                     :class="[( errors.has('form-2.registration_number') || form.errors.has('registration_number') ? 'is-invalid': ''  ) ]"
                                            >
                                            <i v-show="errors.has('form-2.registration_number') || form.errors.has('registration_number')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form-2.registration_number')" class="red d-inline-block">{{ errors.first('form-2.registration_number') }}</span>
                                            <span v-show="form.errors.has('registration_number')" class="red d-inline-block">{{ form.errors.get('registration_number') }}</span>
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
        name: "InventionEdit",
        data(){
            return{
                options: { // tinyMce toolbar options
                    language_url: '../js/fa_IR.js', //This url points to location of persian language file.
                    toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat',
                    toolbar1: ' cut copy paste | ltr rtl | | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor',
                    plugins:['advlist autolink lists link image charmap print preview hr anchor pagebreak', 'searchreplace wordcount visualblocks visualchars code fullscreen', 'insertdatetime media nonbreaking save table contextmenu directionality','template paste textcolor colorpicker textpattern imagetools toc help emoticons hr codesample'],
                },
                invention:{},
                invention_types:[],
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
                    comment:'',
                    score:''
                }),
                f:new FormData, // creates the new FormData object to store selected files data
                // form data of VForm data object witch will be used to fill and submit the form
                form: new Form({
                    title:'',
                    invention_types_id: '',
                    post: '',
                    authorities: '',
                    license: '',
                    license_number: '',
                    affiliation: '',
                    registration_number: '',
                    company_name: '',
                    company_type: '',
                    company_address: '',
                    submit_date: '',
                    files:[],
                }),
                term_form: new Form({
                    id:'',
                    model:'Invention',
                    term_id:'',
                }),
            }
        },
        methods:{
            // if the all paper submission validate it will submit the data to server
            onComplete: function(){
                this.$Progress.start();
                let loader1 = Vue.$loading.show();
                this.form.submit('post', `/api/inventionUpdate/${this.invention.id}`, {
                    // Transform form data to FormData
                    transformRequest: [function (data, headers) {
                        return objectToFormData(data)
                    }]
                }).then((response) => {
                    // sets the data
                    loader1.hide();
                    this.resetFormWizard();
                    this.invention = response.data.data;
                    this.checkListItems = response.data.data.checkList;
                    this.editFormPrepare();
                    // UI modal Hide, progress bar finish , show the toase
                    $('#inventionEditModal').modal('hide');
                    this.successToast('اطلاعات اختراع با موفقیت ویرایش شد.');
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
            inventionValidation(){
                return this.$validator.validateAll('form').then(result => {
                    if (!result) {
                        this.errorSwal('اطلاعات اختراع دارای خطا می باشد!');
                        return false;
                    }
                    return true;
                });
            },
            // validate invention form in step 1
            detailValidation(){
                return this.$validator.validateAll('form-2').then(result => {
                    if (!result) {
                        this.errorSwal('اطلاعات تکمیلی، دارای خطا می باشد!');
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
                            this.invention.status = 2;
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
                this.checkListForm.post('/api/inventionCheckList')
                    .then((response) => {
                        this.checkListItems.unshift(response.data.checkListItem);
                        this.invention.status = this.checkListForm.status;
                        this.invention.score = response.data.score;
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
                if(this.invention.status != '0') {
                    if (this.checkListItems.length > 0 && this.invention.status != '1') {
                        this.checkListForm.list = $.map(this.checkListItems[0].list, function (value, index) {
                            return [value];
                        });
                    }
                    if (this.checkListItems.length > 0) {
                        this.checkListForm.comment = this.checkListItems[0].comment;
                        this.checkListForm.status = this.invention.status;
                    }
                }
                this.checkListForm.score = this.invention.score;
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
                this.$router.push({path:'/inventions'});
            },
            // shows tedEditModal
            inventionEditModal(){
                $('#inventionEditModal').modal('show');
            },
            // prepares the edit form data
            editFormPrepare(){
                this.form.fill(this.invention);
                this.form.fileChangeType = '';
                this.form.files =[];
            },
            pdfModal(name){
                this.pdfFileName = '../files/inventions/'+name+'#page=1';
                $('#pdfModal').modal('show');
            },
            // checks the file type on render to see if it is pdf or zip
            checkFileType(file){
                var fileName = file.name.split(".");
                return fileName[1] == 'zip' || fileName[1] == 'rar' ? true:false;
            },
            // on page load gets ted data based on the received it
            gettedData(id){
                axios.get(`/api/invention/${id}`)
                    .then(response => {
                        this.invention = response.data.data;
                        this.checkListItems = response.data.data.checkList;
                        this.term_form.term_id = this.invention.term_id;
                        this.prepareCheckList();
                        this.editFormPrepare();
                    })
                    .catch((e)=>{
                            console.log(e);
                        }
                    );
            },
            // gets necessary data for form like
            getInventionRelation(){
                axios.get('/api/inventionRelation')
                    .then(response => {
                        this.invention_types = response.data.invention_types;
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
                        this.invention.term_name = res.data.term_name;
                        this.invention.term_id = res.data.term_id;
                        this.TermChange = false;
                        this.$Progress.finish();
                    })
                    .catch((e)=>{
                        loader1.hide();
                        console.log(e);
                        this.$Progress.fail();
                    })
            },
            createCourse(){
            }
        },
        computed:{

        },
        created(){
            this.$parent.pageName = 'آرشیو اختراعات';
            this.$validator.localize('farsi', {
                messages: farsi.messages,
                attributes: {
                    title: 'عنوان اختراع یا اکتشاف یا تولید علمی',
                    invention_types_id: 'نوع اختراع یا اکتشاف',
                    post: 'نقش در ثبت اختراع یا اکتشاف',
                    authorities: 'نام مرجع تایید کننده',
                    license: 'پاسخ به نحوه استفاده از پتنت',
                    license_number: 'شماره پتنت',
                    affiliation: 'آدرس Affiliation ثبت شده در اختراع',
                    registration_number: 'شماره ثبت شرکت',
                    company_name: 'نام شرکت',
                    company_type: 'نوع شرکت ثبت شده',
                    company_address: 'آدرس شرکت',
                    submit_date: 'تاریخ ثبت یا صدور تاییدیه',
                    files: 'فایل های ضمیمه',
                    fileChangeType: 'نوع تغییر فایل ها',
                    score: 'امتیاز',
                }
            });
            this.id = this.$route.params.id;
            this.gettedData(this.id);
            this.getInventionRelation();
        },
        components: {
            Select2,
        }
    }
</script>

<style scoped>

</style>
