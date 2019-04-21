<template>
    <div>
        <div class="container-fluid text-rtl text-right my-5">
            <div class="card card-4 my-5">
                <div class="card-header justify-content-around d-flex " style="direction: rtl">
                    <div class="col">
                        <h3 class=" text-right"><i class="fal fa-project-diagram fa-fw"></i> اطلاعات طرح پژوهشی و فناوری</h3>
                    </div>
                    <div class="card-tools">
                        <button class="btn btn-success" @click="goback"><i style="font-size: 16px" class="fal fa-undo"></i> بازگشت</button>
                    </div><!-- /card-tools -->
                </div><!-- /.card-header -->
                <div class="card-body  px-0">
                    <table class="table table-hover table-striped">
                        <thead class="thead-dark">
                        <tr>
                            <th class="font-18"><i class="fal fa-project-diagram fa-fw"></i> اطلاعات طرح پژوهشی</th>
                            <th v-if="checkList">موارد ناقص</th>
                        </tr>
                        </thead>
                        <tbody v-if="project.id">
                        <tr>
                            <td class="font-16">
                                <span class="blue">عنوان طرح پژوهشی:</span>
                                <span class="mr-3">{{project.title}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('عنوان طرح پژوهشی')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('عنوان طرح پژوهشی')"
                                         @change.native="onChange('عنوان طرح پژوهشی', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue ">نویسندگان:</span>
                                <span v-for="author of project.Authors" class="mr-3 ">
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
                                <span class="blue">نوع طرح پژوهشی:</span>
                                <span class="mr-3">{{project.project_type}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نوع طرح پژوهشی')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('نوع طرح پژوهشی')"
                                         @change.native="onChange('نوع طرح پژوهشی', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>


                        <tr>
                            <td class="font-16">
                                <span class="blue">سازمان طرف قرارداد:</span>
                                <span class="mr-3">{{project.organization}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('سازمان طرف قرارداد')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('سازمان طرف قرارداد')"
                                         @change.native="onChange('سازمان طرف قرارداد', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>

                        <tr>
                            <td class="font-16">
                                <span class="blue">بودجه طرح پژوهشی:</span>
                                <span  class="mr-3">{{project.budget | currency}} </span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('بودجه طرح پژوهشی')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
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
                                <span class="blue ">تاریخ تصویب در شورای پژوهشی:</span>
                                <span class="mr-3 "> {{project.council_aprovedate | myDate}} هجری شمسی</span>
                                <span class="mr-3 "> {{project.council_aprovedate | myDateEN}} میلادی</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('تاریخ تصویب')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check
                                    :checked="checkListForm.list && checkListForm.list.includes('تاریخ تصویب')"
                                    @change.native="onChange('تاریخ تصویب', $event)"
                                    type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue ">تاریخ دفاع:</span>
                                <span class="mr-3 "> {{project.defense_date | myDate}} هجری شمسی</span>
                                <span class="mr-3 "> {{project.defense_date | myDateEN}} میلادی</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('تاریخ دفاع')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check
                                    :checked="checkListForm.list && checkListForm.list.includes('تاریخ دفاع')"
                                    @change.native="onChange('تاریخ دفاع', $event)"
                                    type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue ">فایل های ضمیمه:</span>
                                <span v-for="(file, index) of project.files" class="mr-3 ">
                                    <div v-if="checkFileType(file)" class="btn-group text-ltr" role="group" aria-label="Basic example">
                                         <a  class="btn btn-lg btn-info" :href="'../files/projects/'+file.name"><i class="fal fa-download fa-fw"></i>  </a>
                                         <a  class="btn btn-lg btn-info" :href="'../files/projects/'+file.name">ضمیمه {{index+1|faDigit}}  <i class="fal fa-file-archive fa-fw"></i></a>
                                    </div>
                                    <div v-else class="btn-group text-ltr" role="group" aria-label="Basic example">
                                      <a  :href="'../files/projects/'+file.name" class="btn btn-lg btn-info"><i class="fal fa-download"></i></a>
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
                                <span  v-show="!TermChange" class="mr-3">{{project.term_name}}</span>
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
                                <span v-if="project.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</span>
                                <span v-else-if="project.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</span>
                                <span v-else-if="project.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</span>
                                <span v-else-if="project.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</span>
                                <span v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</span>
                            </td>
                            <td v-if="checkList">
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue ">امتیاز کسب شده:</span>
                                <span v-if="project.status != '1'"  ><i class="fal fa-question"></i>  {{'امتیازی ثبت نشده' }}</span>
                                <span v-else >  {{project.score | faDigits }}</span>
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
                                            <input type="number" :min="project.minScore" :max="project.maxScore" name="score"
                                                   placeholder=""
                                                   :class="[( errors.has('checkListForm.score') || checkListForm.errors.has('score') ? 'is-invalid': ''  )]"
                                                   v-validate="{min_value:project.minScore,max_value:project.maxScore}"
                                                   class="form-control w-50" v-model="checkListForm.score" >
                                        </div>
                                        <div class="form-group mb-2">
                                            <span>توجه: امتیاز این آیتم با توجه به بخشنامه در بازه {{project.minScore}} و {{project.maxScore}} در نظر گرفته میشود.</span>
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
                    <button v-if="project.status != 3 && project.status != 1" @click="projectEditModal" class="btn btn-lg mx-1 btn-secondary">ویرایش  طرح پژوهشی</button>
                    <button v-if="checkList" @click="checkListSubmit" class="btn btn-lg btn-success mx-5"><i class="fal fa-check fa-fw"></i>ثبت نتبجه بررسی</button>

                    <button @click="checkListHistory" class="btn btn-lg mx-1 btn-secondary"><i class="fal fa-history fa-fw mx-2"></i>تاریخچه بررسی</button>
                    <button v-if="$gate.isAdmin()" @click="toggleCheckList"  class="btn btn-lg mx-1 btn-warning">چک لیست بررسی</button>
                </div>
            </div>
        </div><!-- /container -->
        <div  v-if="$gate.isAdmin()||$gate.isAuthor()" class="modal  fade" id="projectEditModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i
                            class="far fa-users-class fa-fw"></i> ویرایش اطلاعات طرح پژوهشی</h5>
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
                            <h2 slot="title">تکمیل طرح‌ پژوهشی</h2>
                            <!--  -->
                            <tab-content title="طرح‌ پژوهشی" :before-change="projectValidation"  icon="far fa-project-diagram">
                                <form @submit.prevent="createProject()" @keydown="form.onKeydown($event)" @change="form.onKeydown($event)" data-vv-scope="form" id="Form">

                                    <div class="modal-body">
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">عنوان طرح پژوهشی و فناوری<i class="red mx-1">*</i>:</label>
                                            <input  type="text"  name="title" placeholder="عنوان طرح پژوهشی و فناوری"
                                                    class="form-control" v-model="form.title"
                                                    v-validate="'required'"
                                                    autofocus
                                                    :class="{ 'is-invalid': form.errors.has('title') || errors.has('form.title') } " >
                                            <i v-show="errors.has('form.title') || form.errors.has('title')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.title')" class="red d-inline-block">{{ errors.first('form.title') }}</span>
                                            <span v-show="form.errors.has('title')" class="red d-inline-block">{{ form.errors.get('title') }}</span>
                                        </div>
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">نوع طرح پژوهشی<i class="red mx-1">*</i>:</label>
                                            <Select2 v-validate="'required'" data-vv-name="project_types_id"
                                                     class="form-control select2-form-control" id="project_types_id"
                                                     :class="[( errors.has('form.project_types_id') || form.errors.has('project_types_id') ? 'is-invalid': ''  )]"
                                                     v-model="form.project_types_id"
                                                     :options="project_types"
                                                     @change="removeError('project_types_id')"
                                                     :settings="{theme: 'bootstrap4', placeholder: 'نوع طرح پژوهشی', width: '100%' }">
                                            </Select2>

                                            <i v-show="errors.has('form.project_types_id') || form.errors.has('project_types_id')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.project_types_id')" class="red d-inline-block">{{ errors.first('form.project_types_id') }}</span>
                                            <span v-show="form.errors.has('project_types_id')" class="red d-inline-block">{{ form.errors.get('project_types_id') }}</span>
                                        </div>
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">سازمان طرف قرارداد<i class="red mx-1">*</i>:</label>
                                            <input  type="text"  name="organization" placeholder="سازمان طرف قرارداد"
                                                    class="form-control" v-model="form.organization"
                                                    v-validate="'required'"
                                                    :class="{ 'is-invalid': form.errors.has('organization') || errors.has('form.organization')} " @input="() => {}">
                                            <i v-show="errors.has('form.organization') || form.errors.has('organization')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.organization')" class="red d-inline-block">{{ errors.first('form.organization') }}</span>
                                            <span v-show="form.errors.has('organization')" class="red d-inline-block">{{ form.errors.get('organization') }}</span>
                                        </div>
                                        <div  class="form-group my-3 text-right">
                                            <label class="blue ">بودجه طرح پژوهشی<i class="red mx-1">*</i>:{{ form.budget | currency}}</label>
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
                                        <div class=" my-3" style="direction: ltr; text-align: right" >
                                            <label class="blue text-right  text-rtl">تاریخ تصویب در شورای پژوهشی<i class="red mx-1">*</i>:</label>
                                            <br> <span class="float-left font-16 "> {{form.council_aprovedate | myDate}}</span>
                                            <date-picker @change="removeError('council_aprovedate')" format="YYYY-MM-DD"
                                                         v-validate="'required'"
                                                         :class="[ errors.has('form.council_aprovedate') || form.errors.has('council_aprovedate') ? 'is-invalid': ''  ] "
                                                         name="council_aprovedate" v-model="form.council_aprovedate" locale="fa,en"></date-picker>
                                            <div class="text-rtl">
                                                <i v-show="errors.has('form.council_aprovedate') || form.errors.has('council_aprovedate')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form.council_aprovedate')" class="red d-inline-block">{{ errors.first('form.council_aprovedate') }}</span>
                                                <span v-show="form.errors.has('council_aprovedate')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('council_aprovedate') }}</span>
                                            </div>
                                        </div>
                                        <div class=" my-3" style="direction: ltr; text-align: right" >
                                            <label class="blue text-right  text-rtl">تاریخ دفاع<i class="red mx-1">*</i>:</label>
                                            <br> <span class="float-left font-16 "> {{form.defense_date | myDate}}</span>
                                            <date-picker @change="removeError('defense_date')" format="YYYY-MM-DD"
                                                         v-validate="'required'"
                                                         :class="[ errors.has('form.defense_date') || form.errors.has('defense_date') ? 'is-invalid': ''  ] "
                                                         name="defense_date" v-model="form.defense_date" locale="fa,en"></date-picker>
                                            <div class="text-rtl">
                                                <i v-show="errors.has('form.defense_date') || form.errors.has('defense_date')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form.defense_date')" class="red d-inline-block">{{ errors.first('form.defense_date') }}</span>
                                                <span v-show="form.errors.has('defense_date')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('defense_date') }}</span>
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
                                    </div>

                                </form>
                            </tab-content>
                            <tab-content title="اطلاعات نویسندگان"  icon="fa fa-user-plus" :before-change="authorValidation"   >
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
                                            <th scope="col"> نویسنده مسئول<i class="red mx-1">*</i></th>
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
                                            <td><label class="radio"> </label>
                                                <p-radio v-validate="'required'" v-model="form.isresponsible"
                                                         name="isresponsible" :value="index" type="radio" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                                    <i slot="extra" class="icon far fa-check"></i>
                                                </p-radio>

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
                            class="far fa-file-alt fa-fw"></i> مشاهده ضمیمه طرح پژوهشی</h5>
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
    import farsi from 'vee-validate/dist/locale/fa';
    import Select2 from 'v-select2-component';
    export default {
        name: "ProjectEdit",
        data(){
            return {
                options: { // tinyMce toolbar options
                    language_url: '../js/fa_IR.js', //This url points to location of persian language file.
                    toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat',
                    toolbar1: ' cut copy paste | ltr rtl | | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor',
                    plugins:['advlist autolink lists link image charmap print preview hr anchor pagebreak', 'searchreplace wordcount visualblocks visualchars code fullscreen', 'insertdatetime media nonbreaking save table contextmenu directionality','template paste textcolor colorpicker textpattern imagetools toc help emoticons hr codesample'],
                },
                project:{},
                project_types:[],
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
                    organization: '',
                    fileChangeType:'',
                    project_types_id: '',
                    council_aprovedate: '',
                    defense_date: '',
                    isresponsible:'',
                    budget:'',
                    authors:[],
                    affiliations:[],
                    files:[],
                }),
                term_form: new Form({
                    id:'',
                    model:'Project',
                    term_id:'',
                }),
            }
        },
        methods:{
            // if the all paper submission validate it will submit the data to server
            onComplete: function(){
                this.$Progress.start();
                let loader1 = Vue.$loading.show();
                this.form.submit('post', `/api/projectUpdate/${this.project.id}`, {
                    // Transform form data to FormData
                    transformRequest: [function (data, headers) {
                        return objectToFormData(data)
                    }]
                }).then((response) => {
                    // sets the data
                    loader1.hide();
                    this.resetFormWizard();
                    this.project = response.data.data;
                    this.checkListItems = response.data.data.checkList;
                    this.editFormPrepare();
                    // UI modal Hide, progress bar finish , show the toase
                    $('#projectEditModal').modal('hide');
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
            authorValidation(){
                return this.$validator.validateAll('form-4').then(result => {
                    if (!result) {
                        this.errorSwal('باید مسئول طرح پژوهشی انتخاب شود!');
                        return false;
                    }
                    return true;
                });
            },
            projectValidation(){
                return this.$validator.validateAll('form').then(result => {
                    if (!result) {
                        this.errorSwal('اطلاعات طرح پژوهشی دارای خطا می باشد!');
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
                            this.project.status = 2;
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
                this.checkListForm.post('/api/projectCheckList')
                    .then((response) => {
                        this.checkListItems.unshift(response.data.checkListItem);
                        this.project.status = this.checkListForm.status;
                        this.project.score = response.data.score;
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
                if(this.project.status != '0') {
                    if (this.checkListItems.length > 0 && this.project.status != '1') {
                        this.checkListForm.list = $.map(this.checkListItems[0].list, function (value, index) {
                            return [value];
                        });
                    }
                    if (this.checkListItems.length > 0){
                        this.checkListForm.comment = this.checkListItems[0].comment;
                        this.checkListForm.status = this.project.status;
                    }
                }
                this.checkListForm.score = this.project.score;

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
                this.$router.push({path:'/projects'});
            },
            // shows bookEditModal
            projectEditModal(){
                $('#projectEditModal').modal('show');
            },
            // prepares the edit form data
            editFormPrepare(){
                this.form.fill(this.project);
                this.form.fileChangeType = '';
                this.form.authors = [];
                this.form.affiliations = [];
                this.form.files =[];

                for(var j=0; j<this.project.Authors.length; j++){
                    this.form.authors.push(this.project.Authors[j].name);
                    this.form.affiliations.push(this.project.Authors[j].affiliation);
                    if(this.project.Authors[j].corresponding != '-1'){
                        this.form.isresponsible = this.project.Authors[j].corresponding;
                    }
                }

            },
            pdfModal(name){
                this.pdfFileName = '../files/projects/'+name+'#page=1';
                $('#pdfModal').modal('show');
            },
            // checks the file type on render to see if it is pdf or zip
            checkFileType(file){
                var fileName = file.name.split(".");
                return fileName[1] == 'zip' || fileName[1] == 'rar'? true:false;
            },
            // on page load gets thesis data based on the received it
            getProjectData(id){
                axios.get(`/api/project/${id}`)
                    .then(response => {
                        this.project = response.data.data;
                        this.checkListItems = response.data.data.checkList;
                        this.term_form.term_id = this.project.term_id;
                        this.prepareCheckList();
                        this.editFormPrepare();
                    })
                    .catch((e)=>{
                            console.log(e);
                        }
                    );
            },
            // gets necessary data for form like
            getProjectRelation(){
                axios.get('/api/projectRelation')
                    .then(response => {
                        this.project_types = response.data.project_types;
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
                        this.project.term_name = res.data.term_name;
                        this.project.term_id = res.data.term_id;
                        this.TermChange = false;
                        this.$Progress.finish();
                    })
                    .catch((e)=>{
                        loader1.hide();
                        console.log(e);
                        this.$Progress.fail();
                    })
            },
            createProject(){

            }
        },
        created(){
            this.$parent.pageName = 'آرشیو طرح‌های پژوهشی و فناوری';
            this.$validator.localize('farsi', {
                messages: farsi.messages,
                attributes: {
                    title: 'عنوان طرح‌های پژوهشی',
                    organization: 'سازمان طرف قرارداد',
                    budget: 'بودجه طرح پژوهشی',
                    isresponsible: 'مسئول طرح پژوهشی',
                    project_types_id: 'نوع طرح پژوهشی و فناوری',
                    council_aprovedate: 'تاریخ تصویب شورای پژوهشی',
                    defense_date: 'تاریخ دفاع طرح پژوهشی',
                    files: 'فایل های ضمیمه',
                    fileChangeType: 'نوع تغییر فایل ها',
                    score: 'امتیاز',
                }
            });
            this.id = this.$route.params.id;
            this.getProjectRelation();
            this.getProjectData(this.id);
        },
        components:{
            Select2,
        }
    }
</script>

<style scoped>

</style>
