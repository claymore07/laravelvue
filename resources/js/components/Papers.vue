<template>
<div>

    <div class="container-fluid">
        <div class="col-md-12 mt-3" v-if="$gate.isAdmin()||$gate.isAuthor()">
            <div class="card">
                <div class="card-header justify-content-around d-flex " style="direction: rtl">
                    <div class="col">
                        <h3 class=" text-right">آرشیو مقالات</h3>
                    </div>
                    <div class="col w-50">
                        <div class="input-group input-group-sm">
                            <input class="w-75"   type="search" placeholder="جستجو..." aria-label="جستجو">
                            <!-- v-model="search" @keyup="searchit()" -->
                            <div class="input-group-append">
                                <button class="btn btn-navbar"  type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <button class="btn btn-success" @click="newModal"><i class="fas fa-user-plus fa-fw" ></i> افزودن کاربر جدید</button>
                    </div><!-- /card-tools -->
                </div><!-- /.card-header -->
                <div class="card-body">
                </div>
            </div>
        </div><!-- /col-md-12 --->

        <div  v-if="$gate.isAdmin()||$gate.isAuthor()" class="modal  fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i
                            class="far fa-file-alt fa-fw"></i> ثبت مقاله جدید</h5>
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
                                <h2 slot="title">تکمیل اطلاعات مقاله</h2>
                                <!--  -->
                                <tab-content title="انتخاب نوع مقاله" :before-change="chooseType" icon="far fa-file-check">
                                    <div class="col-md-10 mx-auto my-5 text-center ">

                                        <button @click="changePaperType('fajur')"
                                                class="btn btn-lg w-20 mt-3 mx-1 btn-info order-3 text-white">ژورنال فارسی
                                        </button>
                                        <button @click="changePaperType('enjur')"
                                                class="btn btn-lg w-20 mt-3 mx-1 btn-info order-0 text-white">ژورنال لاتین
                                        </button>

                                        <button @click="changePaperType('faconf')"
                                                class="btn btn-lg w-20 mt-3 mx-1 btn-info order-2 text-white">کنفرانس فارسی
                                        </button>
                                        <button  @click="changePaperType('enconf')"
                                                class="btn btn-lg w-20 mt-3 mx-1 btn-info order-1 text-white">کنفرانس لاتین
                                        </button>
                                    </div>
                                </tab-content><!-- /fitst-tab -->
                                <tab-content title="اطلاعات مقاله" :before-change="paperValidation"  icon="far fa-file-alt">

                                    <form @submit.prevent="createPaper()"
                                          @keydown="form.onKeydown($event)" @change="form.onKeydown($event)" data-vv-scope="form-1" id="Form">
                                        <div  class="form-group my-4 text-right">
                                            <label class="blue ">عنوان مقاله<i class="red mx-1">*</i>:</label>
                                            <input   type="text" name="title"
                                                   placeholder="عنوان مقاله"
                                                   v-validate="'required'"
                                                   class="form-control" v-model="form.title"
                                                   :class="[( errors.has('form-1.title') || form.errors.has('title') ? 'is-invalid': ''  ), ((paperType === 'fajur' || paperType === 'faconf')?'text-right':'text-left') ]"
                                            >
                                            <i v-show=" errors.has('form-1.title') || form.errors.has('title')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show=" errors.has('form-1.title')" class="red d-inline-block">{{ errors.first('form-1.title') }}</span>
                                            <span v-show="form.errors.has('title')" class="red d-inline-block">{{ form.errors.get('title') }}</span>
                                        </div>
                                        <div class="form-group mb-4 mt-2 text-right">

                                            <label class="blue">شماره Doi:</label>
                                            <input   type="text" name="doi" placeholder="Doi مقاله"
                                                   class="form-control" v-model="form.doi"
                                                   :class="[( errors.has('form-1.doi') || form.errors.has('doi') ? 'is-invalid': ''  )] "
                                            >
                                            <has-error :form="form" field="doi"></has-error>
                                        </div>
                                        <div class="form-group my-4 text-right">
                                            <label class="blue ">لینک مقاله<i class="red mx-1">*</i>:</label>
                                            <input type="text" name="link"
                                                   placeholder="لینک با در نظر گرفتن http://"
                                                   v-validate="'required|url: {require_protocol: true }'"
                                                   class="form-control text-ltr text-left" v-model="form.link"
                                                   :class="[( errors.has('form-1.link') || form.errors.has('link') ? 'is-invalid': ''  ) ]">
                                            <i v-show="errors.has('form-1.link') || form.errors.has('link')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form-1.link')" class="red d-inline-block">{{ errors.first('form-1.link') }}</span>
                                            <span v-show="form.errors.has('link')" class="red d-inline-block">{{ form.errors.get('link') }}</span>
                                        </div>
                                        <div class="form-group my-4 text-right">
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
                                        <div v-if="form.excerpt_id === '1'">
                                            <div class="form-group mt-4 text-right">
                                                <label class="blue text-right">نوع مجوز<i class="red mx-1">*</i>:</label>
                                            </div>
                                            <div class="form-group mb-4 text-right border-bottom">
                                                <p-radio v-model="form.license_to" name="license_to" value="0" class="p-icon p-curve p-bigger p-pulse text-ltr"  color="info-o">
                                                    <i slot="extra" class="icon far fa-check"></i>
                                                    موظفی طرح
                                                </p-radio>
                                                <p-radio v-validate="'required'" v-model="form.license_to"
                                                         name="license_to" value="1" type="radio" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                                    <i slot="extra" class="icon far fa-check"></i>
                                                    مازاد موظفی
                                                </p-radio>

                                                <br>
                                                <has-error :form="form" field="license_to"></has-error>
                                                <i v-show="errors.has('form-1.license_to') || form.errors.has('license_to')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form-1.license_to')" class="red d-inline-block">{{ errors.first('form-1.license_to') }}</span>
                                                <span v-show="form.errors.has('license_to')" class="red d-inline-block">{{ form.errors.get('license_to') }}</span>
                                            </div>
                                        </div>
                                        <div  v-if="form.excerpt_id === '3'">
                                            <div class="form-group my-4 text-right">
                                                <label class="blue">توضیحات و شماره مجوز<i class="red mx-1">*</i>:</label>
                                                <label for="license" class="blue"></label>
                                                <input id="license" name="license" type="text"
                                                       v-model="form.license"
                                                       v-validate="'required'"
                                                       placeholder="مثال: این طرح دارای شماره مجوز 124231 از شورای پژوهش می باشد."
                                                       class="form-control  text-right text-rtl"
                                                       :class="[( errors.has('form-1.license') || form.errors.has('license') ? 'is-invalid': ''  )] ">

                                                <i v-show="errors.has('form-1.license') || form.errors.has('license')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form-1.license')" class="red d-inline-block">{{ errors.first('form-1.license') }}</span>
                                                <span v-show="form.errors.has('license')" class="red d-inline-block">{{ form.errors.get('license') }}</span>
                                            </div>
                                        </div>
                                        <div class=" mt-4" style="direction: ltr; text-align: right"  >
                                             <label class="blue text-right text-rtl">تاریخ چاپ<i class="red mx-1">*</i>:</label>
                                            <date-picker @change="removeError('publish_date')"  format="YYYY-M-D" :class="[( errors.has('form-1.publish_date') || form.errors.has('publish_date') ? 'is-invalid': ''  )]"  v-validate="'required'" name="publish_date" v-model="form.publish_date" locale="fa,en"></date-picker>
                                            <has-error :form="form" field="publish_date"></has-error>
                                            <div class="text-rtl">
                                                <i v-show="errors.has('form-1.publish_date')|| form.errors.has('publish_date')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form-1.publish_date') " class="red d-inline-block text-rtl">{{ errors.first('form-1.publish_date') }}</span>
                                                <span v-show="form.errors.has('publish_date')" class="red d-inline-block text-rtl">{{ form.errors.get('publish_date') }}</span>
                                            </div>
                                        </div>
                                        <div class=" mt-4" style="direction: ltr; text-align: right" >
                                            <label class="blue text-right  text-rtl">تاریخ پذیرش<i class="red mx-1">*</i>:</label>
                                            <date-picker @change="removeError('accept_date')" format="YYYY-M-D"  :class="[( errors.has('form-1.accept_date') || form.errors.has('accept_date') ? 'is-invalid': ''  )] " v-validate="'required'" name="accept_date" v-model="form.accept_date" locale="fa,en"></date-picker>
                                            <div class="text-rtl">
                                                <i v-show="errors.has('form-1.accept_date')|| form.errors.has('accept_date')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form-1.accept_date') " class="red d-inline-block text-rtl text-rtl">{{ errors.first('form-1.accept_date') }}</span>
                                                <span v-show="form.errors.has('accept_date')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('accept_date') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group mt-4 text-right">
                                            <label class="blue text-right">فایل های ضمیمه<i class="red mx-1">*</i>:</label>
                                        </div>

                                        <div class="custom-file text-ltr text-right mb-5">
                                            <input @change="fieldChange" multiple v-validate="'required|ext:zip,pdf|size:5000'" name="files" type="file" class="custom-file-input" id="customFile" >
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
                                        <div class="form-group mt-2 text-right">
                                            <label class="blue text-right">کلمات کلیدی<i class="red mx-1">*</i>:</label>
                                            <tags-input name="tags" element-id="tags"
                                                        @tag-added="removeError('tags')"
                                                        v-model="form.tags"
                                                        v-validate="'required'"
                                                        :add-tags-on-comma="true"
                                                        :placeholder="'کلمات کلیدی'">
                                            </tags-input>
                                            <i v-show="errors.has('form-1.tags')||form.errors.has('tags')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form-1.tags')" class="red d-inline-block">{{ errors.first('form-1.tags') }}</span>
                                            <span v-show="form.errors.has('tags')" class="red d-inline-block">{{ form.errors.get('tags') }}</span>
                                        </div>
                                        <div class="text-right mt-1 mb-4" >
                                            <label class="blue text-right">چکیده<i class="red mx-1">*</i>:</label><br>
                                            <i v-show="errors.has('form-1.abstract')||form.errors.has('abstract')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form-1.abstract')" class="red d-inline-block">{{ errors.first('form-1.abstract') }}</span>
                                            <span v-show="form.errors.has('abstract')" class="red d-inline-block">{{ form.errors.get('abstract') }}</span>
                                        <tinymce @editorChange="removeError('abstract')" :other_options="options" v-validate="'required'" name="abstract" v-model="form.abstract" id="d1"></tinymce>

                                        </div>
                                    </form>

                                </tab-content>
                                <tab-content  title="اطلاعات مجله یا کنفرانس" :before-change="confValidation"  icon="far fa-book-open">
                                   <form  @submit.prevent="createPaper()"
                                          @keydown="form.onKeydown($event)" @change="form.onKeydown($event)" data-vv-scope="form2"  id="form-2">
                                        <div >
                                            <div v-if="paperType === 'enconf' || paperType === 'faconf'" class="form-group my-3 text-right">
                                                <label class="blue">نوع کنفرانس <i class="red mx-1">*</i>:</label>
                                                <Select2 v-validate="'required'" data-vv-name="conftype_id"
                                                         class="form-control select2-form-control" id="conftype_id"
                                                         :class="[( errors.has('form2.conftype_id') || form.errors.has('conftype_id') ? 'is-invalid': ''  )]"
                                                         v-model="form.conftype_id"
                                                         :options="conftypes"
                                                         @change="removeError('conftype_id')"
                                                         :settings="{theme: 'bootstrap4', placeholder: 'نوع کنفرانس', width: '100%' }">
                                                </Select2>

                                                <i v-show="errors.has('form2.conftype_id') || form.errors.has('conftype_id')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form2.conftype_id')" class="red d-inline-block">{{ errors.first('form2.conftype_id') }}</span>
                                                <span v-show="form.errors.has('conftype_id')" class="red d-inline-block">{{ form.errors.get('conftype_id') }}</span>
                                            </div>

                                            <div  v-if="paperType === 'enconf' || paperType === 'faconf'" class="form-group my-3 text-right">
                                                <label class="blue ">نام کنفرانس<i class="red mx-1">*</i>:</label>
                                                <input  type="text" name="confname"
                                                        :placeholder="'نام کنفرانس'"
                                                        v-validate="'required'"
                                                        class="form-control" v-model="form.confname"
                                                        :class="[( errors.has('form2.confname') || form.errors.has('confname') ? 'is-invalid': ''  ) ]"
                                                >
                                                <i v-show="errors.has('form2.confname') || form.errors.has('confname')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form2.confname')" class="red d-inline-block">{{ errors.first('form2.confname') }}</span>
                                                <span v-show="form.errors.has('confname')" class="red d-inline-block">{{ form.errors.get('confname') }}</span>
                                            </div>

                                            <div v-if="paperType === 'enconf' || paperType === 'faconf'" class="form-group my-3 text-right">
                                                <label class="blue ">برگزار کننده<i class="red mx-1">*</i>:</label>
                                                <input  type="text" name="conforganizer"
                                                        placeholder="دانشگاه شیراز"
                                                        v-validate="'required'"
                                                        class="form-control" v-model="form.conforganizer"
                                                        :class="[( errors.has('form2.conforganizer') || form.errors.has('conforganizer') ? 'is-invalid': ''  ) ]"
                                                >
                                                <i v-show="errors.has('form2.conforganizer') || form.errors.has('conforganizer')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form2.conforganizer')" class="red d-inline-block">{{ errors.first('form2.conforganizer') }}</span>
                                                <span v-show="form.errors.has('conforganizer')" class="red d-inline-block">{{ form.errors.get('conforganizer') }}</span>
                                            </div>
                                            <div v-if="paperType === 'enconf' || paperType === 'faconf'" class="form-group my-3 text-right">
                                                <label class="blue ">شهر<i class="red mx-1">*</i>:</label>
                                                <input  type="text" name="confcity"
                                                        placeholder=" شیراز"
                                                        v-validate="'required'"
                                                        class="form-control" v-model="form.confcity"
                                                        :class="[( errors.has('form2.confcity') || form.errors.has('confcity') ? 'is-invalid': ''  ) ]"
                                                >
                                                <i v-show="errors.has('form2.confcity') || form.errors.has('confcity')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form2.confcity')" class="red d-inline-block">{{ errors.first('form2.confcity') }}</span>
                                                <span v-show="form.errors.has('confcity')" class="red d-inline-block">{{ form.errors.get('confcity') }}</span>
                                            </div>
                                            <div v-if="paperType === 'enconf' || paperType === 'faconf'" class="form-group my-3 text-right">
                                                <label class="blue ">دوره برگزاری<i class="red mx-1">*</i>:</label>
                                                <input  type="number" name="confperiod" step="1" min="1"
                                                        placeholder="0"
                                                        v-validate="'required|integer'"
                                                        class="form-control" v-model="form.confperiod"
                                                        :class="[( errors.has('form2.confperiod') || form.errors.has('confcity') ? 'is-invalid': ''  ) ]"
                                                >
                                                <i v-show="errors.has('form2.confperiod') || form.errors.has('confcity')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form2.confperiod')" class="red d-inline-block">{{ errors.first('form2.confperiod') }}</span>
                                                <span v-show="form.errors.has('confperiod')" class="red d-inline-block">{{ form.errors.get('confperiod') }}</span>
                                            </div>
                                        </div><!--  /conference detail end -->

                                        <div >
                                            <div v-if="paperType === 'enjur' || paperType === 'fajur'" class="form-group my-3 text-right">
                                                <label   class="blue">نوع مجله <i class="red mx-1">*</i>:</label>
                                                <Select2  v-validate="'required'" data-vv-name="jtype_id"
                                                         class="form-control select2-form-control" id="jtype_id"
                                                         :class="[( errors.has('form2.jtype_id') || form.errors.has('jtype_id') ? 'is-invalid': ''  )]"
                                                         v-model="form.jtype_id"
                                                         :options="jtypes"
                                                         @change="removeError('jtype_id')"
                                                         :settings="{theme: 'bootstrap4', placeholder: 'نوع مجله', width: '100%' }">
                                                </Select2>

                                                <i v-show="errors.has('form2.jtype_id') || form.errors.has('jtype_id')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form2.jtype_id')" class="red d-inline-block">{{ errors.first('form2.jtype_id') }}</span>
                                                <span v-show="form.errors.has('jtype_id')" class="red d-inline-block">{{ form.errors.get('jtype_id') }}</span>
                                            </div>

                                            <div v-if="paperType === 'enjur' || paperType === 'fajur'" class="form-group my-3 text-right">
                                                <label   class="blue ">نام مجله<i class="red mx-1">*</i>:</label>
                                                <input   type="text" name="jname"
                                                        placeholder=" نام مجله"
                                                        v-validate="'required'"
                                                        class="form-control" v-model="form.jname"
                                                        :class="[( errors.has('form2.jname') || form.errors.has('jname') ? 'is-invalid': ''  ) ]"
                                                >
                                                <i v-show="errors.has('form2.jname') || form.errors.has('jname')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form2.jname')" class="red d-inline-block">{{ errors.first('form2.jname') }}</span>
                                                <span v-show="form.errors.has('jname')" class="red d-inline-block">{{ form.errors.get('jname') }}</span>
                                            </div>

                                            <div v-if="paperType === 'enjur' || paperType === 'fajur'" class="form-group my-3 text-right">
                                                <label   class="blue ">نام ناشر<i class="red mx-1">*</i>:</label>
                                                <input  type="text" name="jpublisher"
                                                        placeholder=" نام ناشر"
                                                        v-validate="'required'"
                                                        class="form-control" v-model="form.jpublisher"
                                                        :class="[( errors.has('form2.jpublisher') || form.errors.has('jpublisher') ? 'is-invalid': ''  ) ]"
                                                >
                                                <i v-show="errors.has('form2.jpublisher') || form.errors.has('jpublisher')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form2.jpublisher')" class="red d-inline-block">{{ errors.first('form2.jpublisher') }}</span>
                                                <span v-show="form.errors.has('jpublisher')" class="red d-inline-block">{{ form.errors.get('jpublisher') }}</span>
                                            </div>

                                            <div v-if="paperType === 'enjur' || paperType === 'fajur'" class="form-group my-3 text-right">
                                                <label class="blue ">ISSN<i class="red mx-1">*</i>:</label>
                                                <input    type="text" name="jISSN"
                                                        placeholder="1111-1111"
                                                        v-mask="'####-###X'"
                                                        v-validate="'required'"
                                                        class="form-control" v-model="form.jISSN"
                                                        :class="[( errors.has('form2.jISSN') || form.errors.has('jISSN') ? 'is-invalid': ''  ) ]"
                                                >
                                                <i v-show="errors.has('form2.jISSN') || form.errors.has('jISSN')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form2.jISSN')" class="red d-inline-block">{{ errors.first('form2.jISSN') }}</span>
                                                <span v-show="form.errors.has('jISSN')" class="red d-inline-block">{{ form.errors.get('jISSN') }}</span>
                                            </div>

                                            <div class="form-group my-4 text-right">
                                                <label v-if="paperType === 'enjur' || paperType === 'fajur'"  class="blue ">pISSN:</label>
                                                <input v-if="paperType === 'enjur' || paperType === 'fajur'"  type="text" name="pISSN"
                                                        placeholder="1111-1111"
                                                        v-mask="'####-###X'"
                                                        class="form-control" v-model="form.pISSN" >
                                            </div>
                                            <div class="form-group my-4 text-right">
                                                <label v-if="paperType === 'enjur' || paperType === 'fajur'"  class="blue ">IF:</label>
                                                <input v-if="paperType === 'enjur' || paperType === 'fajur'"  type="number" min="0" name="pIF"
                                                        placeholder=""
                                                        class="form-control" v-model="form.pIF" >
                                            </div>
                                            <div class="form-group my-4 text-right">
                                                <label v-if="paperType === 'enjur' || paperType === 'fajur'"  class="blue ">IF پنج ساله:</label>
                                                <input v-if="paperType === 'enjur' || paperType === 'fajur'"  type="number" min="0" name="pFIF"
                                                        placeholder=""
                                                        class="form-control" v-model="form.pFIF" >
                                            </div>
                                            <div class="form-group my-4 text-right">
                                                <label v-if="paperType === 'enjur' || paperType === 'fajur'"  class="blue ">JCR</label>
                                                <input v-if="paperType === 'enjur' || paperType === 'fajur'"  type="text"  name="pJCR"
                                                       placeholder="Q1"
                                                       v-mask="'Q#'"
                                                        class="form-control" v-model="form.pJCR" >
                                            </div>

                                            <div class="form-group my-4 text-right">
                                                <label v-if="paperType === 'enjur' || paperType === 'fajur'"  class="blue ">JRK:</label>
                                                <input v-if="paperType === 'enjur' || paperType === 'fajur'"  type="number" min="0" max="100" name="pJRK"
                                                       placeholder=""
                                                       class="form-control" v-model="form.pJRK" >
                                            </div>
                                        </div><!--  /journal detail end -->
                                    </form>
                                </tab-content>
<!--  -->
                                <tab-content title="اطلاعات نویسندگان"  icon="fa fa-user-plus" :before-change="authorValidation"   >
                                    <form @submit.prevent="addAuthor"
                                          @keydown="form.onKeydown($event)" @change="form.onKeydown($event)"  data-vv-scope="form-4" id="Form4">
                                    <div class="text-right ">
                                        <span>لیست نویسندگان:</span><br>
                                        <i v-show="errors.has('form-4.isresponsible')||form.errors.has('isresponsible')||form.errors.has('authorsjson')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show="errors.has('form-4.isresponsible')" class="red d-inline-block">{{ errors.first('form-4.isresponsible') }}</span>
                                        <span v-show="form.errors.has('isresponsible')" class="red d-inline-block">{{ form.errors.get('isresponsible') }}</span>
                                        <span v-show="form.errors.has('authorsjson')" class="red d-inline-block">{{ form.errors.get('authorsjson') }}</span>

                                    </div>
                                    <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">نام و نام خانوادگی</th>
                                            <th scope="col">آدرس</th>
                                            <th scope="col"> نویسنده مسئول<i class="red mx-1">*</i></th>
                                            <th scope="col"> حذف</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(author, index) of authors">
                                            <th scope="row">{{index+1 | faDigit}}</th>
                                            <td>{{author.name}}</td>
                                            <td>{{author.affiliation}}</td>
                                            <td><label class="radio"> </label>
                                                <p-radio v-validate="'required'" v-model="form.isresponsible"
                                                         name="isresponsible" :value="index" type="radio" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                                    <i slot="extra" class="icon far fa-check"></i>
                                                </p-radio>

                                            </td>
                                            <td>
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

                </div>
            </div>
        </div>

    </div>
</div>
</template>

<script>
    import Select2 from 'v-select2-component';
    import farsi from 'vee-validate/dist/locale/fa';

    export default {
        name: "Papers",

        data(){
            return{
                options: {
                    language_url: 'js/fa_IR.js', //This url points to location of persian language file.
                    toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat',
                    toolbar1: ' cut copy paste | ltr rtl | | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor',
                    plugins:['advlist autolink lists link image charmap print preview hr anchor pagebreak', 'searchreplace wordcount visualblocks visualchars code fullscreen', 'insertdatetime media nonbreaking save table contextmenu directionality','template paste textcolor colorpicker textpattern imagetools toc help emoticons hr codesample'],
                },

                excerpts:[],
                conftypes:[],
                jtypes:[],
                fileName:[],
                attachments:[],
                paperType:'',
                author:'',
                affiliation:'',
                authors:[],
                f:new FormData,
                form: new Form({
                    lang:'',
                    tags:[],
                    title: '',
                    abstract: '',
                    doi:'',
                    link:'',
                    license:'',
                    license_to:'',
                    publish_date: '',
                    accept_date: '',
                    excerpt_id: '',
                    files:[],
                    confname:'',
                    confcity:'',
                    conforganizer:'',
                    confperiod:'',
                    conftype_id:'',
                    jtype_id:'',
                    jname:'',
                    jpublisher:'',
                    jISSN:'',
                    pISSN:'',
                    pIF:'',
                    pFIF:'',
                    pJRK:'',
                    pJCR:'',
                    authorsjson:[],
                    isresponsible:'',
                    paperType:''
                })
            }
        },
        methods:{
            changePaperType(type){
              this.paperType = type;
              if(this.paperType === 'fajur' || this.paperType === 'faconf'){
                  this.form.lang = 'farsi';
              }else{
                  this.form.lang = 'en';
              }
              if(this.paperType === 'fajur' || this.paperType === 'enjur'){
                  this.form.paperType='jur';
              }else{
                  this.form.paperType='conf';
              }
            },
            removeAuthor(index){
                this.$delete(this.authors,index)
                this.form.isresponsible = '';
            },
            onComplete: function(){
                this.$Progress.start();
                this.form.authorsjson = JSON.stringify(this.authors)
                this.form.submit('post', 'api/paperValidation', {
                    // Transform form data to FormData
                    transformRequest: [function (data, headers) {
                        return objectToFormData(data)
                    }]
                }).then(() => {
                     Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide');
                    this.successToast('مقاله با موفقیت ثبت شد.')
                    this.resetFormWizard();
                    this.$Progress.finish();
                }).catch((e) => {
                        this.$Progress.fail();
                        let t = Object.keys(this.form.errors.all()).filter(function (key) {
                            return /^files./.test(key);
                        });
                        console.log('ssss')
                        if (!t.length) {
                        } else {
                            this.form.errors.set('files', 'نوع فایل باید یکی از انواع pdf یا zip باشد.')
                        }
                        this.errorSwal('در یکی از مراحل خطا دارید، لطفا مجدد بررسی کنید.');
                        return false;
                    }
                );
            },
            resetFormWizard() {
                this.fileName=[];
                this.attachments = [];
                this.authors = [];
                this.paperType = '';
                this.author = '';
                this.affiliation = '';
                this.form.reset();
                this.$refs.wizard.reset();
                this.$validator.reset();
            },
            newModal() {
               // this.resetFormWizard();
                $('#addNew').modal('show');
            },
            chooseType(){
                if(this.paperType === ''){
                    this.errorSwal('نوع مقاله را باید مشخص کنید!');
                    return false;
                }else {
                    return true;
                }
            },
            removeError(field){
              this.form.errors.clear(field)
            },
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
            addAuthor () {
                if(this.author.trim() && this.affiliation.trim()){
                    this.authors.push({
                        name: this.author,
                        affiliation: this.affiliation,
                    });
                    this.author = '';
                    this.affiliation = '';
                }

            },
            getPaperRelation(){
                axios.get('api/paperRelation')
                    .then(response => {
                        this.excerpts = response.data.excerpts;
                        this.conftypes = response.data.conftypes;
                        this.jtypes = response.data.jtypes;
                    })
                    .catch((e)=>{
                            console.log(e);
                        }
                    );
            },
            paperValidation(){
               return this.$validator.validateAll('form-1').then(result => {
                    if (!result) {
                        this.errorSwal('اطلاعات مقاله دارای خطا می باشد!');
                        return false;
                    }
                    return true;
                });
            },
            confValidation(){
               return this.$validator.validateAll('form2').then(result => {
                    if (!result) {
                        this.errorSwal('اطلاعات مجله یا کنفرانس دارای خطا می باشد!');
                        return false;
                    }
                    return true;
                });
            },
            authorValidation(){
               return this.$validator.validateAll('form-4').then(result => {
                    if (!result) {
                        this.errorSwal('باید نویسنده مسئول انتخاب شود!');
                        return false;
                    }
                    return true;
                });
            },
        },
        mounted:function () {

        },
        created(){
            this.$validator.localize('farsi', {
                messages: farsi.messages,
                attributes: {
                    title: 'عنوان مقاله',
                    abstract: 'چکیده مقاله',
                    publish_date: 'تاربخ چاپ',
                    accept_date: 'تاربخ پذیرش',
                    files: 'فایل های ضمیمه',
                    link: 'لینک مقاله',
                    tags: 'کلمات کلیدی',
                    excerpt_id:'نوع مستخرج بودن ',
                    license_to:'نوع موظفی ',
                    license:'توضیحات مجوز شورای پژوهش  ',
                    confname:'نام کنفرانس',
                    confcity:'شهر کنفرانس',
                    conforganizer:'برگزارکننده کنفرانس',
                    confperiod:'دوره کنفرانس',
                    conftype_id:'نوع کنفرانس',
                    jtype_id:'نوع مجله',
                    jname:'نام مجله',
                    jpublisher:'نام ناشر',
                    jISSN:'شماره ISSN',
                    isresponsible:'انتخاب نویسنده مسئول'
                }
            });
            this.getPaperRelation();
        },
        components: {
            Select2,
            }
    }
</script>

<style scoped>

</style>
