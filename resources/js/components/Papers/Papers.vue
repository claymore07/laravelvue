<template>
<div>

    <div class="container-fluid">
        <div class="col-md-12 mt-3" v-if="$gate.isAdminOrUser">
            <div class="card card-4">
                <div class="card-header  " style="direction: rtl">
                    <div class="row justify-content-between  text-right">
                        <div class="col-xl-4 m-3">
                            <h4 class=" text-right"><i class="fal fa-pencil-ruler  fa-fw"></i>آرشیو مقالات</h4>
                        </div>
                        <div class="col-xl-4  " >
                            <button class="btn btn-block-only btn-success ripple mt-3 mx-xl-2 float-left" @click="newModal"> <i style="font-size: 16px" class="fal fa-file-plus"></i> افزودن مقاله جدید</button>
                            <button class="btn btn-block-only btn-info ripple mt-3 mx-xl-2 float-left" @click="infoModal"><i style="font-size: 16px" class="far fa-info-circle"></i> راهنمای بخشنامه</button>
                        </div>


                    </div><!-- /card-tools -->


                </div><!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <div class="row justify-content-center no-gutters">
                        <div class="col-lg-7 mt-3  mr-2">

                            <div class="input-group  ">
                                <input class="form-control"  type="search" placeholder="جستجو..." aria-label="جستجو"
                                       v-model="search" @keyup="searchit()"><!--    -->
                                <div class="input-group-append">
                                    <button class="btn btn-navbar"  type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3  mt-3 mr-2" >
                            <div class="input-group mb-3 ">
                                <select v-model="filter" @change="searchit" class="custom-select">
                                    <option selected disabled>پالایش بر اساس:</option>
                                    <option value="5">همه</option>
                                    <option value="0">بررسی نشده</option>
                                    <option value="4">اصلاح شده</option>
                                    <option value="1">تایید شده</option>
                                    <option value="2">عدم تایید موقت</option>
                                    <option value="3">عدم تایید قطعی</option>
                                </select>
                                <div class="input-group-append " >
                                    <span class="input-group-text" style="border: none!important; background: none"  title="پالایش براساس"><i class="fal  blue fa-filter"></i> </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-hover text-right">
                        <tbody>
                        <tr>
                            <th>شماره</th>
                            <th>نام مقاله</th>
                            <th>نوع مقاله</th>
                            <th>عنوان ژونال یا کنفرانس</th>
                            <th>نام صاحب مقاله</th>
                            <th>وضعیت بررسی</th>
                            <th @click="toggle()" :class="['sort-control', sortType]">تاریخ ثبت</th>
                            <th>ابزارهای ویرایشی</th>
                        </tr>
                        <tr v-for="(paper, index) in papers" :key="paper.id">
                            <td>{{counter(index) | faDigit}}</td>
                            <td>{{ paper.title | truncate(40) }}</td>
                            <td>{{ paper.paper_type }}</td>
                            <td >{{paper.publisher_name | truncate(40)}} </td>

                            <td>{{ paper.Author_name  }}</td>
                            <td v-if="paper.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                            <td v-else-if="paper.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                            <td v-else-if="paper.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                            <td v-else-if="paper.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                            <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                            <td>{{ paper.created_at | myDate  }}</td>
                            <td>
                                <router-link :to="{ name: 'paperedit', params: { id: paper.id }}">
                                <i class="fa fa-edit blue"></i>
                                </router-link>
                                /
                                <a href="#" @click="deletePaper(paper.id)">
                                    <i class="fa fa-trash red"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div> <!-- /.card-body -->
                <div class="card-footer d-flex flex-row justify-content-md-center" style="min-height: 60px">
                    <pagination v-if="" :data="allData" @pagination-change-page="getResults" :limit="1"
                                :show-disabled="true">
                        <span slot="prev-nav"><i class="fa fa-angle-double-right"></i></span>
                        <span slot="next-nav"><i class="fa fa-fw fa-angle-double-left"></i></span>
                    </pagination>
                    <span class="table-detail">
                        تعداد
                        {{(this.numTo - this.numStart + 1) | faDigit  }}
                        از
 {{this.total | faDigit}}                   </span>
                </div><!-- /card-footer --->
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
                                <tab-content title="انتخاب نوع مقاله" :before-change="chooseTypeCheck"  icon="far fa-file-check">
                                    <div class="col-md-10 mx-auto my-5 text-center ">

                                        <button @click="changePaperType('fajur', 0)"
                                                class="btn btn-lg w-20 mt-3 mx-1 btn-info order-3 text-white ripple"><i v-if="paperSelected === 0" class="fal fa-check text-white"></i> ژورنال فارسی
                                        </button>
                                        <button @click="changePaperType('enjur', 1)"
                                                class="btn btn-lg w-20 mt-3 mx-1 btn-info order-0 text-white ripple"><i v-if="paperSelected === 1" class="fal fa-check text-white"></i> ژورنال لاتین
                                        </button>

                                        <button @click="changePaperType('faconf', 2)"
                                                class="btn btn-lg w-20 mt-3 mx-1 btn-info order-2 text-white ripple"><i v-if="paperSelected === 2" class="fal fa-check text-white"></i> کنفرانس فارسی
                                        </button>
                                        <button  @click="changePaperType('enconf', 3)"
                                                class="btn btn-lg w-20 mt-3 mx-1 btn-info order-1 text-white ripple"><i v-if="paperSelected === 3" class="fal fa-check text-white"></i> کنفرانس لاتین
                                        </button>
                                    </div>
                                </tab-content><!-- /fitst-tab -->
                                <!--  -->
                                <tab-content title="اطلاعات مقاله" :before-change="paperValidation"  icon="far fa-file-alt">

                                    <form @submit.prevent="createPaper()"
                                          @keydown="form.onKeydown($event)" @change="form.onKeydown($event)" data-vv-scope="form-1" id="Form">
                                        <div  class="form-group my-3 text-right">
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
                                            <i v-show=" form.errors.has('doi')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="form.errors.has('doi')" class="red d-inline-block">{{ form.errors.get('doi') }}</span>
                                        </div>
                                        <div class="form-group my-3 text-right">
                                            <label class="blue ">لینک مقاله:</label>
                                            <input type="text" name="link"
                                                   placeholder="لینک با در نظر گرفتن http://"
                                                   v-validate="'url: {require_protocol: true }'"
                                                   class="form-control text-ltr text-left" v-model="form.link"
                                                   :class="[( errors.has('form-1.link') || form.errors.has('link') ? 'is-invalid': ''  ) ]">
                                            <i v-show="errors.has('form-1.link') || form.errors.has('link')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form-1.link')" class="red d-inline-block">{{ errors.first('form-1.link') }}</span>
                                            <span v-show="form.errors.has('link')" class="red d-inline-block">{{ form.errors.get('link') }}</span>
                                        </div>
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">مستخرج از<i class="red mx-1">*</i>:</label>
                                            <Select2 v-validate="'required'"
                                                     class="form-control select2-form-control" id="excerpt_id"
                                                     :class="[( errors.has('form-1.excerpt_id') || form.errors.has('excerpt_id') ? 'is-invalid': ''  )]"
                                                     v-model="form.excerpt_id"
                                                     :options="excerpts"
                                                     @change="removeError('excerpt_id')"
                                                     data-vv-name="excerpt_id"
                                                     :settings="{theme: 'bootstrap4', placeholder: 'نوع مستخرج از:', width: '100%' }">
                                            </Select2>

                                            <i v-show="errors.has('form-1.excerpt_id') || form.errors.has('excerpt_id')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form-1.excerpt_id')" class="red d-inline-block">{{ errors.first('form-1.excerpt_id') }}</span>
                                            <span v-show="form.errors.has('excerpt_id')" class="red d-inline-block">{{ form.errors.get('excerpt_id') }}</span>
                                        </div>
                                        <div v-if="form.excerpt_id === '1'">
                                            <div class="form-group my-3 text-right">
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
                                                <i v-show="errors.has('form-1.license_to') || form.errors.has('license_to')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form-1.license_to')" class="red d-inline-block">{{ errors.first('form-1.license_to') }}</span>
                                                <span v-show="form.errors.has('license_to')" class="red d-inline-block">{{ form.errors.get('license_to') }}</span>
                                            </div>
                                        </div>
                                        <div  v-if="form.excerpt_id === '3'">
                                            <div class="form-group my-3 text-right">
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

                                        <div class=" my-3" style="direction: ltr; text-align: right" >
                                            <label class="blue text-right  text-rtl">تاریخ پذیرش<i class="red mx-1">*</i>:</label>
                                            <br> <span class="float-left font-16 "> {{form.publish_date | myDate}}</span>
                                            <date-picker @change="removeError('publish_date')" format="YYYY-MM-DD"
                                                         :class="[( errors.has('form-1.publish_date') || form.errors.has('publish_date') ? 'is-invalid': ''  )] "
                                                         v-validate="'required'" name="publish_date" v-model="form.publish_date" locale="fa,en"></date-picker>
                                            <div class="text-rtl">
                                                <i v-show="errors.has('form-1.publish_date')|| form.errors.has('publish_date')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form-1.publish_date') " class="red d-inline-block text-rtl text-rtl">{{ errors.first('form-1.publish_date') }}</span>
                                                <span v-show="form.errors.has('publish_date')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('publish_date') }}</span>
                                            </div>
                                        </div>
                                        <div class=" my-3" style="direction: ltr; text-align: right" >
                                            <label class="blue text-right  text-rtl">تاریخ پذیرش<i class="red mx-1">*</i>:</label>
                                            <br> <span class="float-left font-16 "> {{form.accept_date | myDate}}</span>
                                            <date-picker @change="removeError('accept_date')" format="YYYY-MM-DD"
                                                         :class="[( errors.has('form-1.accept_date') || form.errors.has('accept_date') ? 'is-invalid': ''  )] "
                                                         v-validate="'required'" name="accept_date" v-model="form.accept_date" locale="fa,en"></date-picker>
                                            <div class="text-rtl">
                                                <i v-show="errors.has('form-1.accept_date')|| form.errors.has('accept_date')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form-1.accept_date') " class="red d-inline-block text-rtl text-rtl">{{ errors.first('form-1.accept_date') }}</span>
                                                <span v-show="form.errors.has('accept_date')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('accept_date') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group my-3 text-right">
                                            <label class="blue text-right">فایل های ضمیمه<i class="red mx-1">*</i>:</label>
                                            <span class="red"><br/>
                                                فایل اصلی مقاله در قالب pdf
                                                <br/>
                                                سایر فایل های مربوطه بصورت یک فایل فشرده با پسونده zip
                                            </span>
                                        </div>

                                        <div class="custom-file text-ltr text-right mb-5">
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
                                <!--  -->
                                <tab-content  title="اطلاعات مجله یا کنفرانس" :before-change="confValidation"  icon="far fa-book-open">
                                   <form  @submit.prevent="createPaper()"
                                          @keydown="form.onKeydown($event)" @change="form.onKeydown($event)" data-vv-scope="form2"  id="form-2">
                                        <div >
                                            <div v-if="confForm" class="form-group my-3 text-right">
                                                <label class="blue">نوع کنفرانس <i class="red mx-1">*</i>:</label>
                                                <select v-validate="'required'" data-vv-name="conftype_id"
                                                        class="form-control" id="conftype_id"
                                                        :class="[( errors.has('form2.conftype_id') || form.errors.has('conftype_id') ? 'is-invalid': ''  )]"
                                                        v-model="form.conftype_id"
                                                        @change="removeError('conftype_id')"
                                                        >
                                                    <option selected disabled value="">انتخاب نوع کنفرانس ...</option>
                                                    <option v-for="conftype in conftypes" :key="conftype.id" :value="conftype.id">{{conftype.text}}</option>
                                                </select>
                                                <i v-show="errors.has('form2.conftype_id') || form.errors.has('conftype_id')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form2.conftype_id')" class="red d-inline-block">{{ errors.first('form2.conftype_id') }}</span>
                                                <span v-show="form.errors.has('conftype_id')" class="red d-inline-block">{{ form.errors.get('conftype_id') }}</span>
                                            </div>

                                            <div  v-if="confForm" class="form-group my-3 text-right">
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

                                            <div v-if="confForm" class="form-group my-3 text-right">
                                                <label class="blue ">برگزار کننده<i class="red mx-1">*</i>:</label>
                                                <input  type="text" name="organizer"
                                                        placeholder="دانشگاه شیراز"
                                                        v-validate="'required'"
                                                        class="form-control" v-model="form.organizer"
                                                        :class="[( errors.has('form2.organizer') || form.errors.has('organizer') ? 'is-invalid': ''  ) ]"
                                                >
                                                <i v-show="errors.has('form2.organizer') || form.errors.has('organizer')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form2.organizer')" class="red d-inline-block">{{ errors.first('form2.organizer') }}</span>
                                                <span v-show="form.errors.has('organizer')" class="red d-inline-block">{{ form.errors.get('organizer') }}</span>
                                            </div>
                                            <div v-if="confForm" class="form-group my-3 text-right">
                                                <label class="blue ">شهر<i class="red mx-1">*</i>:</label>
                                                <input  type="text" name="city"
                                                        placeholder=" شیراز"
                                                        v-validate="'required'"
                                                        class="form-control" v-model="form.city"
                                                        :class="[( errors.has('form2.city') || form.errors.has('city') ? 'is-invalid': ''  ) ]"
                                                >
                                                <i v-show="errors.has('form2.city') || form.errors.has('city')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form2.city')" class="red d-inline-block">{{ errors.first('form2.city') }}</span>
                                                <span v-show="form.errors.has('city')" class="red d-inline-block">{{ form.errors.get('city') }}</span>
                                            </div>
                                            <div v-if="confForm" class="form-group my-3 text-right">
                                                <label class="blue ">دوره برگزاری<i class="red mx-1">*</i>:</label>
                                                <input  type="number" name="period" step="1" min="1"
                                                        placeholder="0"
                                                        v-validate="'required|integer'"
                                                        class="form-control" v-model="form.period"
                                                        :class="[( errors.has('form2.period') || form.errors.has('period') ? 'is-invalid': ''  ) ]"
                                                >
                                                <i v-show="errors.has('form2.period') || form.errors.has('period')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form2.period')" class="red d-inline-block">{{ errors.first('form2.period') }}</span>
                                                <span v-show="form.errors.has('period')" class="red d-inline-block">{{ form.errors.get('period') }}</span>
                                            </div>
                                        </div><!--  /conference detail end -->

                                        <div >
                                            <div v-if="journalForm" class="form-group my-3 text-right">
                                                <label   class="blue">نوع مجله <i class="red mx-1">*</i>:</label>
                                                <select v-validate="'required'" data-vv-name="jtype_id"
                                                         class="form-control" id="jtype_id"
                                                         :class="[( errors.has('form2.jtype_id') || form.errors.has('jtype_id') ? 'is-invalid': ''  )]"
                                                         v-model="form.jtype_id"
                                                         @change="removeError('jtype_id')"
                                                >
                                                    <option selected disabled value="">انتخاب نوع مجله ...</option>
                                                    <option v-for="jtype in jtypes" :key="jtypes.id" :value="jtype.id">{{jtype.text}}</option>
                                                </select>

                                                <i v-show="errors.has('form2.jtype_id') || form.errors.has('jtype_id')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form2.jtype_id')" class="red d-inline-block">{{ errors.first('form2.jtype_id') }}</span>
                                                <span v-show="form.errors.has('jtype_id')" class="red d-inline-block">{{ form.errors.get('jtype_id') }}</span>
                                            </div>

                                            <div v-if="journalForm" class="form-group my-3 text-right">
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

                                            <div v-if="journalForm" class="form-group my-3 text-right">
                                                <label   class="blue ">نام ناشر<i class="red mx-1">*</i>:</label>
                                                <input  type="text" name="publisher"
                                                        placeholder=" نام ناشر"
                                                        v-validate="'required'"
                                                        class="form-control" v-model="form.publisher"
                                                        :class="[( errors.has('form2.publisher') || form.errors.has('publisher') ? 'is-invalid': ''  ) ]"
                                                >
                                                <i v-show="errors.has('form2.publisher') || form.errors.has('publisher')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form2.publisher')" class="red d-inline-block">{{ errors.first('form2.publisher') }}</span>
                                                <span v-show="form.errors.has('publisher')" class="red d-inline-block">{{ form.errors.get('publisher') }}</span>
                                            </div>

                                            <div v-if="journalForm" class="form-group my-3 text-right">
                                                <label class="blue ">ISSN<i class="red mx-1">*</i>:</label>
                                                <input    type="text" name="issn"
                                                        placeholder="1111-1111"
                                                        v-mask="'####-###X'"
                                                        v-validate="'required'"
                                                        class="form-control" v-model="form.issn"
                                                        :class="[( errors.has('form2.issn') || form.errors.has('issn') ? 'is-invalid': ''  ) ]"
                                                >
                                                <i v-show="errors.has('form2.issn') || form.errors.has('issn')" class="red far fa-exclamation-triangle"></i>
                                                <span v-show="errors.has('form2.issn')" class="red d-inline-block">{{ errors.first('form2.issn') }}</span>
                                                <span v-show="form.errors.has('issn')" class="red d-inline-block">{{ form.errors.get('issn') }}</span>
                                            </div>

                                            <div class="form-group my-3 text-right">
                                                <label v-if="journalForm"  class="blue ">pissn:</label>
                                                <input v-if="journalForm"  type="text" name="pissn"
                                                        placeholder="1111-1111"
                                                        v-mask="'####-###X'"
                                                        class="form-control" v-model="form.pissn" >
                                            </div>
                                            <div class="form-group my-3 text-right">
                                                <label v-if="journalForm"  class="blue ">IF:</label>
                                                <input v-if="journalForm"  type="number" min="0" name="IFactor"
                                                        placeholder=""
                                                        class="form-control" v-model="form.IFactor" >
                                            </div>
                                            <div class="form-group my-3 text-right">
                                                <label v-if="journalForm"  class="blue ">IF پنج ساله:</label>
                                                <input v-if="journalForm"  type="number" min="0" name="FIF"
                                                        placeholder=""
                                                        class="form-control" v-model="form.FIF" >
                                            </div>
                                            <div class="form-group my-3 text-right">
                                                <label v-if="journalForm"  class="blue ">JCR</label>
                                                <input v-if="journalForm"  type="text"  name="JCR"
                                                       placeholder="Q1"
                                                       v-mask="'##'"
                                                        class="form-control" v-model="form.JCR" >
                                            </div>

                                            <div class="form-group my-3 text-right">
                                                <label v-if="journalForm"  class="blue ">JRK:</label>
                                                <input v-if="journalForm"  type="number" min="0" max="100" name="JRK"
                                                       placeholder=""
                                                       class="form-control" v-model="form.JRK" >
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
                                            <th scope="col"> حذف</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(author, index) of form.authors">
                                            <th scope="row">{{index+1 | faDigit}}</th>
                                            <td>{{author}}</td>
                                            <td>{{form.affiliations[index]}}</td>
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

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /modal -->
        <!-- Info Modal -->
        <div class="modal  fade" id="InfoModal" tabindex="-1" role="dialog" aria-labelledby="InfoModal" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="InfoModal2"><i
                            class="fal fa-info-circle fa-fw"></i>مشاهد آیین نامه</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="height: 600px; overflow-y: scroll" >
                        <table class="table table-bordered table-hover text-right">
                            <thead>
                            <td class="align-middle text-center">شماره بند</td>
                            <td class="align-middle text-center" colspan="1">موضوعات</td>
                            <td class="align-middle text-center" colspan="1">حداکثرامتیاز در واحد کار یا نیم سال</td>
                            <td class="align-middle text-center" colspan="1">حداکثر امتیاز در هر موضوع</td>
                            <td class="align-middle text-center" colspan="1">حداقل امتیاز لازم در هر دوره ارتقاء</td>
                            </thead>
                            <tr>
                                <td class="align-middle text-center"  rowspan="2">بند 8</td>
                                <td width="40%" class="align-middle" rowspan="1">1. گزارش های علمی طرح های پژوهشی و فناوری خاتمه یافته در داخل موسسه با تایید معاون پژوهشی
                                </td>
                                <td class="align-middle  text-center">تا 2</td>
                                <td class="align-middle  text-center" rowspan="1"> 6 </td>
                                <td class="align-middle  text-center" rowspan="1"> - </td>
                            </tr>
                            <tr>
                                <td width="40%" class="align-middle" rowspan="1">2. گزارش های علمی طرح های پژوهشی و فناوری با طرف قرارداد خارج از موسسه تایید شده نهاد سفارش دهنده، که تا حدامکان نکات زیر در نظر گرفته شود: <br>
                                    - استانی، منطقه ای، ملی یا بین المللی بودن موضوع طرح
                                    <br>
                                    - گزارش طرح های تحقیقاتی مشترک با دانشگاه ها و موسسه های علمی خارج از کشور تا 1/2 برار.
                                </td>
                                <td class="align-middle  text-center">تا 15</td>
                                <td class="align-middle  text-center" rowspan="1"> - </td>
                                <td class="align-middle  text-center" rowspan="1"> - </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    تبصره 1. ویژه اعضای هیات علمی موسسه های تحت نظارت وزارت علوم<br/>
                                    تبصره 2. طرح های که نتیجه مسئولیت اجرایی یا حقوقی باشد امتیازی تعلق نمی گیرد.
                                </td>
                            </tr>
                        </table>
                    </div><!-- modal-body -->
                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- / Info show modal  -->

    </div><!-- /container-fluid -->
</div>
</template>

<script>
    import Select2 from 'v-select2-component';
    import farsi from 'vee-validate/dist/locale/fa';

    export default {
        name: "Papers",

        data(){
            return{
                options: {// tinyMce toolbar options
                    language_url: '../js/fa_IR.js', //This url points to location of persian language file.
                    toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat',
                    toolbar1: ' cut copy paste | ltr rtl | | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor',
                    plugins:['advlist autolink lists link image charmap print preview hr anchor pagebreak', 'searchreplace wordcount visualblocks visualchars code fullscreen', 'insertdatetime media nonbreaking save table contextmenu directionality','template paste textcolor colorpicker textpattern imagetools toc help emoticons hr codesample'],
                },
                filter:5,

                papers:{},      // papers list object received from server
                allData:{},
                search: '',     // search term
                order: 1,       // order 1 for desc and 0  for asc
                total: 0,       // total number of papers
                numToShow: 0,   // number of papers shown in this page
                numStart: 0,    // starting row number
                numTo: 0,       // ending number
                searchResult: false,    // if there is search going on or not
                excerpts:[],     // excerpts list
                conftypes:[],   // conference type list
                jtypes:[],      // conference type list
                fileName:[],    // For UI rendering and displaying the choosen file Names
                attachments:[],
                paperType:'',
                paperSelected:'',
                author:'',
                affiliation:'',
                f:new FormData, // creates the new FormData object to store selected files data
                // form data of VForm data object witch will be used to fill and submit the form
                form: new Form({
                    lang:'0',
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
                    city:'',
                    organizer:'',
                    period:'',
                    conftype_id:'',
                    jtype_id:'',
                    jname:'',
                    publisher:'',
                    issn:'',
                    pissn:'',
                    IFactor:'',
                    FIF:'',
                    JRK:'',
                    JCR:'',
                    authors:[],
                    affiliations:[],
                    isresponsible:'',
                    paperType:''
                })
            }
        },
        methods:{
            searchit(){
                this.$parent.searchit();
            },
            //  changes the paper Type and sets form.lang and form.paperType
            changePaperType(type, Selected){
                this.paperSelected = Selected;
              this.paperType = type;
              if(this.paperType === 'fajur' || this.paperType === 'faconf'){
                  this.form.lang = '0';
              }else{
                  this.form.lang = '1';
              }
              if(this.paperType === 'fajur' || this.paperType === 'enjur'){
                  this.form.paperType='jur';
              }else{
                  this.form.paperType='conf';
              }
            },
            // if the all paper submission validate it will submit the data to server
            onComplete: function(){
                this.$Progress.start();
                this.form.submit('post', '/api/paper', {
                    // Transform form data to FormData
                    transformRequest: [function (data, headers) {
                        return objectToFormData(data)
                    }]
                }).then(() => {
                     Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide');
                    this.successToast('مقاله با موفقیت ثبت شد.');
                    this.resetFormWizard();
                    this.$Progress.finish();
                }).catch((e) => {
                        this.$Progress.fail();
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
            /** these function validate each tab beforeChange */
            // checks if the user has been selected the paper type in step 1
            chooseTypeCheck(){
                if(this.paperType === ''){
                    this.errorSwal('نوع مقاله را باید مشخص کنید!');
                    return false;
                }else {
                    return true;
                }
            },
            // validate paper form in step 2
            paperValidation(){
                return this.$validator.validateAll('form-1').then(result => {
                    if (!result) {
                        this.errorSwal('اطلاعات مقاله دارای خطا می باشد!');
                        return false;
                    }
                    return true;
                });
            },
            // validate conference or journal form in step 3
            confValidation(){
                return this.$validator.validateAll('form2').then(result => {
                    if (!result) {
                        this.errorSwal('اطلاعات مجله یا کنفرانس دارای خطا می باشد!');
                        return false;
                    }
                    return true;
                });
            },
            // validate the authors detail in last step
            authorValidation(){
                return this.$validator.validateAll('form-4').then(result => {
                    if (!result) {
                        this.errorSwal('باید نویسنده مسئول انتخاب شود!');
                        return false;
                    }
                    return true;
                });
            },

            /** these functions are responsible for form input error handling and change state*/
            // resets all the form modal related state and variables
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
            // remove field error from form.errors bag onChange
            removeError(field){
              this.form.errors.clear(field)
            },
            // loads bootstrap modal on click
            newModal() {
                $('#addNew').modal('show');
               /* $('#addNew').on('shown.bs.modal', function() {
                    $(this).find('[autofocus]').focus();
                });*/
            },
            infoModal() {
                $('#InfoModal').modal('show');
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
            // removes author from form.authors array
            removeAuthor(index){
                this.$delete(this.form.authors,index);
                this.$delete(this.form.affiliations,index);
                this.form.isresponsible = '';
            },
            // gets necessary data for form like excerpts and conference types and journal types
            getPaperRelation(){
                axios.get('/api/paperRelation')
                    .then(response => {
                        this.excerpts = response.data.excerpts;
                        this.conftypes = response.data.conftypes;
                        this.jtypes = response.data.jtypes;
                    })
                    .catch((e)=>{
                          //  console.log(e);
                        }
                    );
            },
            getResults(page = 1, que = '') {
                let loader1 = Vue.$loading.show();

                let sortOrder = this.order === 1 ? 'asc' : 'desc';
                if (this.searchResult) {
                    que = this.search;
                    axios.get('/api/findPaper?order=' + sortOrder + '&q=' + que +'&filter='+this.filter +'&page=' + page)
                        .then(response => {
                            loader1.hide();
                            this.allData = response.data;
                            this.papers = response.data.data;
                            this.total = response.data.meta.total;
                            this.numToShow = response.data.meta.per_page;
                            this.numStart = response.data.meta.from;
                            this.numTo = response.data.meta.to;
                        }).catch(error =>{
                            loader1.hide();
                        });
                } else {
                    axios.get('/api/paper?order=' + sortOrder + '&page=' + page +'&filter='+this.filter)
                        .then(response => {
                            loader1.hide();
                            this.allData = response.data;
                            this.papers = response.data.data;
                            this.total = response.data.meta.total;
                            this.numToShow = response.data.meta.per_page;
                            this.numStart = response.data.meta.from;
                            this.numTo = response.data.meta.to;
                        }).catch(error =>{
                            loader1.hide();
                        });
                }
            },
            deletePaper(id) {
                swal({
                    title: 'آیا از حذف مقاله مورد نظر مطمئن هستید؟',
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
                        this.form.delete('/api/paper/' + id).then(() => {
                            this.successSwal('مقاله مورد نظر با موفقیت حذف شد.');
                            Fire.$emit('AfterCreate');
                        }).catch((e) => {
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        });
                    } else {
                        this.warningSwal('شما این عملیات را لغو کردید.');
                    }
                })
            },

            counter(i) {
                return this.numStart + i;
            },
            toggle() {
                this.order *= -1;
                this.getResults();
            },
        },
        computed:{
            confForm() {
                return this.paperType === 'enconf' || this.paperType === 'faconf';
            },
            journalForm() {
                return this.paperType === 'enjur' || this.paperType === 'fajur';
            },
            sortType() {
                return this.order === 1 ? 'ascending' : 'descending';
            },
        },
        mounted:function () {},
        created(){
            this.$parent.pageName = 'آرشیو مقالات';
            // add farsi dictionary to vee-validate components
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
                    city:'شهر کنفرانس',
                    organizer:'برگزارکننده کنفرانس',
                    period:'دوره کنفرانس',
                    conftype_id:'نوع کنفرانس',
                    jtype_id:'نوع مجله',
                    jname:'نام مجله',
                    publisher:'نام ناشر',
                    issn:'شماره ISSN',
                    isresponsible:'انتخاب نویسنده مسئول'
                }
            });
            Fire.$on('searching', () => {
                let page = 1;
                let query = this.search;
                this.searchResult = true;
                this.getResults(page, query);
            });
            Fire.$on('AfterCreate', () => {
                this.form.reset();
                this.getResults();
            });

            this.getPaperRelation();
            this.getResults();
            this.form.reset();
        },
        components: {
            Select2,
            }
    }
</script>

<style scoped>

</style>
