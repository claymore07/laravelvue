<template>
    <div>

        <div class="container-fluid">
            <div class="col-md-12 mt-3" >
                <div class="card card-4">
                    <div class="card-header  " style="direction: rtl">
                        <div class="row justify-content-between  text-right">
                            <div class="col-xl-4 m-3">
                                <h4 class=" text-right"><i class="fal fa-books fa-fw"></i> آرشیو کتب</h4>
                            </div>
                            <div class="col-xl-4  " >
                                <button class="btn btn-block-only btn-success ripple mt-3 mx-xl-2 float-left" @click="newModal"><i style="font-size: 16px" class="fal fa-file-plus"></i> افزودن کتاب</button>
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
                                <th>عنوان کتاب</th>
                                <th>نوع کتاب</th>

                                <th>نام صاحب کتاب</th>
                                <th>وضعیت بررسی</th>
                                <th @click="toggle()" :class="['sort-control', sortType]">تاریخ ثبت</th>
                                <th>ابزارهای ویرایشی</th>
                                <th>
                                    <select class="persian-num" v-model="perPage" @change="getResults()">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </th>
                            </tr>
                            <tr v-if="books.length <= 0">
                                <td colspan="7"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                            </tr>
                            <tr v-for="(book, index) in books" :key="book.id">
                                <td class="persian-num">{{counter(index) }}</td>
                                <td>{{ book.title | truncate(40) }}</td>


                                <td>{{ book.booktype  }}</td>
                                <td>{{ book.Author_name  }}</td>
                                <td v-if="book.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                <td v-else-if="book.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                <td v-else-if="book.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                <td v-else-if="book.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                <td>{{ book.created_at | myDate  }}</td>
                                <td colspan="2">
                                    <router-link :to="{ name: 'bookEdit', params: { id: book.id }}">
                                        <i class="fa fa-edit blue"></i>
                                    </router-link>
                                    /
                                    <a href="#" @click="deleteBook(book.id)">
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
                        <span class="table-detail persian-num">
                        تعداد
                        {{(this.numTo - this.numStart + 1)  }}
                        از
 {{this.total }}                   </span>
                    </div><!-- /card-footer --->
                </div>
            </div><!-- /col-md-12 --->


        </div><!-- /container-fluid -->
        <div   class="modal  fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i
                            class="fa fa-book fa-fw"></i> ثبت کتاب جدید</h5>
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
                            <!--  -->
                            <tab-content title="اطلاعات کتاب"  :before-change="bookValidation" icon="far fa-book">

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


                                    <div class="form-group my-3 text-right">
                                        <label class="blue text-right">فایل های ضمیمه<i class="red mx-1">*</i>:</label>
                                        <span class="red"><br/>
                                                اسکن روی جلد
                                                <br/>
                                            اسکن صفحه شناسنامه کتاب
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

                                </form>

                            </tab-content>
                            <!--    -->
                            <tab-content  title="اطلاعات شناسنامه کتاب" :before-change="detailValidation" icon="far fa-clipboard-list-check">
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
                            <tab-content title="اطلاعات نویسندگان"   icon="fa fa-user-plus"    >
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

                                            <th scope="col"> حذف</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(author, index) of form.authors">
                                            <th scope="row">{{index+1 | faDigit}}</th>
                                            <td>{{author}}</td>
                                            <td>{{form.affiliations[index]}}</td>

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
                    <div class="modal-body text-right text-rtl" style="height: 600px; overflow-y: scroll" >
                        <div v-html="regulation"></div>
                    </div><!-- modal-body -->
                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- / Info show modal  -->

    </div>
</template>

<script>
    import farsi from 'vee-validate/dist/locale/fa';
    import Select2 from 'v-select2-component';
    export default {
        name: "Books",
        data(){
            return {
                filter:5,
                perPage:5,
                regulation:'',
                books:{},
                allData :{},
                excerpts:[],
                bookTypes:[],
                search: '',     // search term
                order: 1,       // order 1 for desc and 0  for asc
                total: 0,       // total number of papers
                numToShow: 0,   // number of papers shown in this page
                numStart: 0,    // starting row number
                numTo: 0,       // ending number
                searchResult: false,
                fileName:[],    // For UI rendering and displaying the choosen file Names
                attachments:[],
                author:'',
                affiliation:'',
                f:new FormData, // creates the new FormData object to store selected files data
                // form data of VForm data object witch will be used to fill and submit the form
                form: new Form({
                    title:'',
                    booktype_id:'',
                    excerpt_id:'',
                    isbn:'',
                    subject:'',
                    publisher:'',
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
            }
        },
        methods:{
            // if the all paper submission validate it will submit the data to server
            onComplete: function(){
                this.$Progress.start();
                this.form.submit('post', '/api/book', {
                    // Transform form data to FormData
                    transformRequest: [function (data, headers) {
                        return objectToFormData(data)
                    }]
                }).then(() => {
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide');
                    this.successToast('کتاب با موفقیت ثبت شد.');
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

                        if(e.response.status == 405){
                            let starts = this.$options.filters.myDate(window.term.starts_at);
                            let ends = this.$options.filters.myDate(window.term.ends_at);
                            this.errorSwal(`تاریخ ثبت اطلاعات در ترم جاری از بازه ${starts} تا بازه ${ends} می باشد. امکان ثبت در تاریخ کنون وجود ندارد.`);
                        }else{
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        }
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
                this.form.reset();
                this.$refs.wizard.reset();
                this.$validator.reset();
            },
            removeError(field){
                this.form.errors.clear(field)
            },
            counter(i) {
                return this.numStart + i;
            },
            toggle() {
                this.order *= -1;
                this.getResults();
            },
            searchit(){
                this.$parent.searchit();
            },
            newModal() {
                $('#addNew').modal('show');
                $('#addNew').on('shown.bs.modal', function() {
                    $(this).find('[autofocus]').focus();
                });
            },
            infoModal() {
                $('#InfoModal').modal('show');
            },
            deleteBook(id){
                swal({
                    title: 'آیا از حذف کتاب مورد نظر مطمئن هستید؟',
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
                        this.form.delete(`/api/book/${id}`).then(() => {
                            this.successSwal('کتاب مورد نظر با موفقیت حذف شد.');
                            Fire.$emit('AfterCreate');
                        }).catch((e) => {
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        });
                    } else {
                        this.warningSwal('شما این عملیات را لغو کردید.');
                    }
                })
            },
            getResults(page = 1, que = '') {
                let loader1 = Vue.$loading.show();

                let sortOrder = this.order === 1 ? 'asc' : 'desc';
                if (this.searchResult) {
                    que = this.search;
                    axios.get('/api/findBook?order=' + sortOrder + '&q=' + que +'&filter='+this.filter
                        +'&page=' + page +'&perPage=' + this.perPage)
                        .then(response => {
                            loader1.hide();
                            this.allData = response.data;
                            this.books = response.data.data;
                            this.total = response.data.meta.total;
                            this.numToShow = response.data.meta.per_page;
                            this.numStart = response.data.meta.from;
                            this.numTo = response.data.meta.to;
                        }).catch(error =>{
                        loader1.hide();
                    });
                } else {
                    axios.get('/api/book?order=' + sortOrder + '&page=' + page +
                        '&filter='+this.filter +'&perPage=' + this.perPage)
                        .then(response => {
                            loader1.hide();
                            this.allData = response.data;
                            this.books = response.data.data;
                            this.total = response.data.meta.total;
                            this.numToShow = response.data.meta.per_page;
                            this.numStart = response.data.meta.from;
                            this.numTo = response.data.meta.to;
                        }).catch(error =>{
                        loader1.hide();
                    });
                }
            },
            // gets necessary data for form like excerpts and conference types and journal types
            getBookRelation(){
                axios.get('/api/bookRelation')
                    .then(response => {
                        this.excerpts = response.data.excerpts;
                        this.bookTypes = response.data.bookTypes;
                    })
                    .catch((e)=>{
                            //  console.log(e);
                        }
                    );
            },
            prepareRegulation() {
                axios.get(`/api/regulationDetail/2`).then((response)=>{
                    this.regulation = response.data.data.detail;
                }).catch(()=>{
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            createBook(){

            }
        },
        computed:{
            sortType() {
                return this.order === 1 ? 'ascending' : 'descending';
            },
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
                }
            });
            this.$parent.pageName = 'آرشیو کتب';
            //this.getBookRelation();

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
            this.getResults();
            this.prepareRegulation();
            this.getBookRelation();
            this.form.reset();
        },
        components:{
            Select2,
        }
    }
</script>

<style scoped>

</style>
