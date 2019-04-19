<template>
    <div>
        <div class="container-fluid text-rtl text-right my-5">
            <div class="card card-4 my-5">
                <div class="card-header justify-content-around d-flex " style="direction: rtl">
                    <div class="col">
                        <h3 class=" text-right">اطلاعات پایان نامه</h3>
                    </div>
                    <div class="card-tools">
                        <button class="btn btn-success" @click="goback"><i style="font-size: 16px" class="fal fa-undo"></i> بازگشت</button>
                    </div><!-- /card-tools -->
                </div><!-- /.card-header -->
                <div class="card-body  px-0">
                    <table class="table table-hover table-striped">
                        <thead class="thead-dark">
                        <tr>
                            <th class="font-18"><i class="fal fa-file-edit fa-fw"></i>اطلاعات پایان نامه</th>
                            <th v-if="checkList">موارد ناقص</th>
                        </tr>
                        </thead>
                        <tbody v-if="thesis.id">
                        <tr>
                            <td class="font-16">
                                <span class="blue">عنوان:</span>
                                <span class="mr-3">{{thesis.title}}</span>
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
                                <span class="blue">نام استاد:</span>
                                <span class="mr-3">{{thesis.Author_name}}</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نام استاد')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check :checked="checkListForm.list && checkListForm.list.includes('نام استاد')"
                                         @change.native="onChange('نام استاد', $event)"
                                         type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue ">مقطع:</span>
                                <span class="mr-3">{{thesis.degree}}</span>

                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('مقطع')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check
                                    :checked="checkListForm.list && checkListForm.list.includes('مقطع')"
                                    @change.native="onChange('مقطع', $event)"
                                    type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue ">مسئولیت استاد:</span>
                                <span v-if="thesis.responsible == 0" class="mr-3">استاد راهنما</span>
                                <span v-if="thesis.responsible == 1" class="mr-3">استاد مشاور</span>

                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('مسئولیت استاد')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check
                                    :checked="checkListForm.list && checkListForm.list.includes('مسئولیت استاد')"
                                    @change.native="onChange('مسئولیت استاد', $event)"
                                    type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>

                        <tr>
                            <td class="font-16">
                                <span class="blue ">تاریخ تصویب گروه:</span>
                                <span class="mr-3 "> {{thesis.group_aprovedate | myDate}} هجری شمسی</span>
                                <span class="mr-3 "> {{thesis.group_aprovedate | myDateEN}} میلادی</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('تاریخ تصویب گروه')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check
                                    :checked="checkListForm.list && checkListForm.list.includes('تاریخ تصویب گروه')"
                                    @change.native="onChange('تاریخ تصویب گروه', $event)"
                                    type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue ">تاریخ تصویب شورای پژوهش:</span>
                                <span class="mr-3 "> {{thesis.council_aprovedate | myDate}} هجری شمسی</span>
                                <span class="mr-3 "> {{thesis.council_aprovedate | myDateEN}} میلادی</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('تاریخ تصویب شورای پژوهش')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check
                                    :checked="checkListForm.list && checkListForm.list.includes('تاریخ تصویب شورای پژوهش')"
                                    @change.native="onChange('تاریخ تصویب شورای پژوهش', $event)"
                                    type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue ">تاریخ دریافت کد:</span>
                                <span class="mr-3 "> {{thesis.code_date | myDate}} هجری شمسی</span>
                                <span class="mr-3 "> {{thesis.code_date | myDateEN}} میلادی</span>
                                <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('تاریخ دریافت کد')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                            </td>
                            <td v-if="checkList">
                                <p-check
                                    :checked="checkListForm.list && checkListForm.list.includes('تاریخ دریافت کد')"
                                    @change.native="onChange('تاریخ دریافت کد', $event)"
                                    type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                    <i slot="extra" class="icon far fa-check"></i>
                                </p-check>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue ">تاریخ دفاع:</span>
                                <span class="mr-3 "> {{thesis.defense_date | myDate}} هجری شمسی</span>
                                <span class="mr-3 "> {{thesis.defense_date | myDateEN}} میلادی</span>
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
                                <span class="orange ">ترم ثبت شده:</span>
                                <span  class="mr-3">{{thesis.term_name}}</span>

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
                                <span v-if="thesis.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</span>
                                <span v-else-if="thesis.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</span>
                                <span v-else-if="thesis.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</span>
                                <span v-else-if="thesis.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</span>
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
                    <!-- thesisEditModal checkListSubmit toggleCheckList checkListHistory-->
                    <button v-if="thesis.status != 3 && thesis.status != 1" @click="thesisEditModal" class="btn btn-lg mx-1 btn-secondary">ویرایش  پایان نامه</button>
                    <button @click="checkListHistory" class="btn btn-lg mx-1 btn-secondary"><i class="fal fa-history fa-fw mx-2"></i>تاریخچه بررسی</button>
                    <button v-if="checkList" @click="checkListSubmit" class="btn btn-lg btn-success mx-5"><i class="fal fa-check fa-fw"></i>ثبت نتبجه بررسی</button>
                    <button v-if="$gate.isAdmin()" @click="toggleCheckList"  class="btn btn-lg mx-1 btn-warning">چک لیست بررسی</button>
                </div>
            </div>
        </div><!-- /container -->
        <!-- thesisEditModal -->
        <div  v-if="$gate.isAdmin()||$gate.isAuthor()" class="modal  fade" id="thesisEditModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i
                            class="fas fa-book fa-fw"></i> ویرایش اطلاعات پایان نامه</h5>

                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form-wizard
                        back-button-text="مرحله قبل"
                        next-button-text="مرحله بعد"
                        finish-button-text="ثبت نهایی"
                        :start-index="0"
                        @on-complete="onComplete"
                        ref="wizard">
                        <h2 slot="title">تکمیل اطلاعات پایان نامه</h2>
                        <!--  -->
                        <tab-content title="اطلاعات پایان نامه" :before-change="thesisValidation"  icon="far fa-book">
                            <form @submit.prevent="createThesis()" @keydown="form.onKeydown($event)" @change="form.onKeydown($event)" data-vv-scope="form" id="Form">

                                <div class="modal-body">
                                    <div class="form-group my-3 text-right">
                                        <label class="blue">عنوان پایان نامه<i class="red mx-1">*</i>:</label>
                                        <input  type="text"  name="title" placeholder="عنوان پایان نامه"
                                                class="form-control" v-model="form.title"
                                                v-validate="'required'"
                                                autofocus
                                                :class="{ 'is-invalid': form.errors.has('title') || errors.has('form.title') } " @input="() => {}">
                                        <i v-show="errors.has('form.title') || form.errors.has('location')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show="errors.has('form.title')" class="red d-inline-block">{{ errors.first('form.title') }}</span>
                                        <span v-show="form.errors.has('title')" class="red d-inline-block">{{ form.errors.get('title') }}</span>

                                    </div>

                                    <div class="form-group my-3 text-right">
                                        <label class="blue">مقطع تحصیلی<i class="red mx-1">*</i>:</label>
                                        <Select2 class="form-control select2-form-control"
                                                 :class="{ 'is-invalid': form.errors.has('degree_id') || errors.has('form.degree_id')}" v-model="form.degree_id"
                                                 :options="degrees"
                                                 data-vv-name="degree_id"
                                                 v-validate="'required'"
                                                 @change="removeError('degree_id')"
                                                 :settings="{theme: 'bootstrap4', placeholder: 'مقطع تحصیلی', width: '100%' }">
                                        </Select2>
                                        <i v-show="errors.has('form.degree_id') || form.errors.has('degree_id')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show="errors.has('form.degree_id')" class="red d-inline-block">{{ errors.first('form.degree_id') }}</span>
                                        <span v-show="form.errors.has('degree_id')" class="red d-inline-block">{{ form.errors.get('degree_id') }}</span>
                                    </div>
                                    <div class="form-group my-3 text-right">
                                        <label class="blue">مسئولیت استاد در پایان نامه<i class="red mx-1">*</i>:</label>
                                        <select name="responsible"
                                                v-model="form.responsible"
                                                id="type" class="form-control test1"
                                                :class="{ 'is-invalid': form.errors.has('responsible') || errors.has('form.responsible')}"
                                                v-validate="'required'"
                                        >
                                            <option selected disabled value="">مسئولیت استاد در پایان نامه</option>
                                            <option value="0">استاد راهنما</option>
                                            <option value="1">استاد مشاور</option>

                                        </select>
                                        <i v-show="errors.has('form.responsible') || form.errors.has('responsible')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show="errors.has('form.responsible')" class="red d-inline-block">{{ errors.first('form.responsible') }}</span>
                                        <span v-show="form.errors.has('responsible')" class="red d-inline-block">{{ form.errors.get('responsible') }}</span>
                                    </div>
                                    <div class=" my-3" style="direction: ltr; text-align: right" >
                                        <label class="blue text-right  text-rtl">تاریخ تصویب در گروه<i class="red mx-1">*</i>:</label>
                                        <br> <span class="float-left font-16 "> {{form.group_aprovedate | myDate}}</span>
                                        <date-picker @change="removeError('group_aprovedate')" format="YYYY-MM-DD"
                                                     :class="[ form.errors.has('group_aprovedate') ? 'is-invalid': ''  ] "
                                                     v-validate="'required'"
                                                     name="group_aprovedate" v-model="form.group_aprovedate" locale="fa,en"></date-picker>
                                        <div class="text-rtl">
                                            <i v-show="errors.has('form.group_aprovedate') || form.errors.has('group_aprovedate')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.group_aprovedate')" class="red d-inline-block">{{ errors.first('form.group_aprovedate') }}</span>
                                            <span v-show="form.errors.has('group_aprovedate')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('group_aprovedate') }}</span>
                                        </div>
                                    </div>
                                    <div class=" my-3" style="direction: ltr; text-align: right" >
                                        <label class="blue text-right  text-rtl">تاریخ تصویب در شورای پژوهشی<i class="red mx-1">*</i>:</label>
                                        <br> <span class="float-left font-16 "> {{form.council_aprovedate | myDate}}</span>
                                        <date-picker @change="removeError('council_aprovedate')" format="YYYY-MM-DD"
                                                     :class="[ form.errors.has('council_aprovedate') ? 'is-invalid': ''  ] "
                                                     v-validate="'required'"
                                                     name="council_aprovedate" v-model="form.council_aprovedate" locale="fa,en"></date-picker>
                                        <div class="text-rtl">
                                            <i v-show="errors.has('form.council_aprovedate') || form.errors.has('council_aprovedate')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.council_aprovedate')" class="red d-inline-block">{{ errors.first('form.council_aprovedate') }}</span>
                                            <span v-show="form.errors.has('council_aprovedate')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('council_aprovedate') }}</span>
                                        </div>
                                    </div>
                                    <div class=" my-3" style="direction: ltr; text-align: right" >
                                        <label class="blue text-right  text-rtl">تاریخ دریافت کد<i class="red mx-1">*</i>:</label>
                                        <br> <span class="float-left font-16 "> {{form.code_date | myDate}}</span>
                                        <date-picker @change="removeError('code_date')" format="YYYY-MM-DD"
                                                     :class="[ form.errors.has('code_date') ? 'is-invalid': ''  ] "
                                                     v-validate="'required'"
                                                     name="code_date" v-model="form.code_date" locale="fa,en"></date-picker>
                                        <div class="text-rtl">
                                            <i v-show="errors.has('form.code_date') || form.errors.has('code_date')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.code_date')" class="red d-inline-block">{{ errors.first('form.code_date') }}</span>
                                            <span v-show="form.errors.has('code_date')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('code_date') }}</span>
                                        </div>
                                    </div>
                                    <div class=" my-3" style="direction: ltr; text-align: right" >
                                        <label class="blue text-right  text-rtl">تاریخ تصویب دفاع<i class="red mx-1">*</i>:</label>
                                        <br> <span class="float-left font-16 "> {{form.defense_date | myDate}}</span>
                                        <date-picker @change="removeError('defense_date')" format="YYYY-MM-DD"
                                                     :class="[ form.errors.has('defense_date') ? 'is-invalid': ''  ] "
                                                     v-validate="'required'"
                                                     name="defense_date" v-model="form.defense_date" locale="fa,en"></date-picker>
                                        <div class="text-rtl">
                                            <i v-show="errors.has('form.defense_date') || form.errors.has('defense_date')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.defense_date')" class="red d-inline-block">{{ errors.first('form.defense_date') }}</span>
                                            <span v-show="form.errors.has('defense_date')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('defense_date') }}</span>
                                        </div>
                                    </div>

                                </div>

                            </form>
                        </tab-content>
                    </form-wizard>
                </div>
            </div>
        </div><!-- /thesisEditModal -->
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
        name: "ThesisEdit",
        data(){
            return {
                options: { // tinyMce toolbar options
                    language_url: '../js/fa_IR.js', //This url points to location of persian language file.
                    toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat',
                    toolbar1: ' cut copy paste | ltr rtl | | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor',
                    plugins:['advlist autolink lists link image charmap print preview hr anchor pagebreak', 'searchreplace wordcount visualblocks visualchars code fullscreen', 'insertdatetime media nonbreaking save table contextmenu directionality','template paste textcolor colorpicker textpattern imagetools toc help emoticons hr codesample'],
                },
                id:'',
                thesis:{},
                degrees:[],
                checkList:false,
                checkListItems:{},
                checkListForm: new Form({
                    id:'',
                    list:[],
                    status:null,
                    comment:''
                }),
                form: new Form({
                    title:'',
                    degree_id:'',
                    responsible:'',
                    group_aprovedate:'',
                    council_aprovedate:'',
                    code_date:'',
                    defense_date:''
                }),
            }
        },
        methods:{
            deleteCheckListItem(id, index) {

                if(this.checkListItems.length > 1){
                    this.checkListForm.delete('/api/deleteCheckListItem/' + id).then(() => {
                        this.checkListItems.splice(index, 1);
                        this.checkListForm.list = $.map(this.checkListItems[0].list, function(value, index) {
                            return [value];
                        });
                        if(this.checkListForm.list.length > 0){
                            this.checkListForm.status = 2;
                            this.thesis.status = 2;
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
                this.checkListForm.post('/api/thesisCheckList')
                    .then((response) => {
                        this.checkListItems.unshift(response.data.checkListItem);
                        this.thesis.status = this.checkListForm.status;
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
                if(this.thesis.status != '0') {
                    if (this.checkListItems.length > 0 && this.thesis.status != '1') {
                        this.checkListForm.list = $.map(this.checkListItems[0].list, function (value, index) {
                            return [value];
                        });
                    }
                    if (this.checkListItems.length > 0) {
                        this.checkListForm.comment = this.checkListItems[0].comment;
                        this.checkListForm.status = this.thesis.status;
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
            removeError(field){
                this.form.errors.clear(field)
            },
            goback(){
                this.$router.push({path:'/thesis'});
            },
            // shows thesisEditModal
            thesisEditModal(){
                $('#thesisEditModal').modal('show');
                $('#thesisEditModal').on('shown.bs.modal', function() {
                    $(this).find('[autofocus]').focus();
                });
            },

            onComplete(id){
                this.$Progress.start();
                let loader1 = Vue.$loading.show();
                this.form.busy;
                this.form.put(`/api/thesis/${this.id}`)
                    .then((response)=>{
                        loader1.hide();
                        this.resetFormWizard();
                        this.thesis = response.data.data;
                        this.editFormPrepare();
                        $('#thesisEditModal').modal('hide');
                        this.successToast('اطلاعات پایان نامه با موفقیت ثبت شد.');
                        this.$Progress.finish();

                    })
                    .catch(() => {
                        loader1.hide();
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        this.$Progress.fail();
                    })
            },
            // prepares the edit form data
            editFormPrepare(){
                this.form.fill(this.thesis);
            },
            thesisValidation(){
                return this.$validator.validateAll('form').then(result => {
                    if (!result) {
                        this.errorSwal('اطلاعات پایان نامه دارای خطا می باشد!');
                        return false;
                    }
                    return true;
                });
            },
            resetFormWizard() {
                this.form.reset();
                this.$refs.wizard.reset();
                this.$validator.reset();
            },
            // on page load gets thesis data based on the received it
            getThesisData(id){
                axios.get(`/api/thesis/${id}`)
                    .then(response => {
                        this.thesis = response.data.data;
                        this.form.fill(this.thesis);
                        this.checkListItems = response.data.data.checkList;
                        this.prepareCheckList();
                    })
                    .catch((e)=>{
                            console.log(e);
                        }
                    );
            },
            // gets necessary data for form like excerpts and conference types and journal types
            getThesisRelation(){
                axios.get('/api/thesisRelation')
                    .then(response => {
                        this.degrees = response.data.data;
                    })
                    .catch((e)=>{
                            //  console.log(e);
                        }
                    );
            },
        },
        created(){
            this.$parent.pageName = 'آرشیو پایان نامه ها';
            this.$validator.localize('farsi', {
                messages: farsi.messages,
                attributes: {
                    title: 'عنوان پایان نامه',
                    group_aprovedate: 'تاربخ تصویب در گروه',
                    council_aprovedate: 'تاربخ تصویب در شورای پژوهشی',
                    code_date: 'تاربخ دریافت کد',
                    defense_date: 'تاربخ دفاع',
                    responsible: 'نوع مسئولیت استاد',
                    degree_id : 'مقطع تحصیلی'

                }
            });
            this.id = this.$route.params.id;
            this.getThesisRelation();
            this.getThesisData(this.id);
        },
        components:{
            Select2,
        }

    }
</script>

<style scoped>

</style>
