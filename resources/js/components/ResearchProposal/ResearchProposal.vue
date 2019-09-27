<template>
    <div>

        <div class="container-fluid">
            <div class="col-md-12 mt-3" >
                <div class="card card-4">
                    <div class="card-header  " style="direction: rtl">
                        <div class="row justify-content-between  text-right">
                            <div class="col-xl-4 m-3">
                                <h4 class=" text-right"><i class="fal fa-scroll-old fa-fw"></i>پروپوزال طرح‌های پژوهشی</h4>
                            </div>
                            <div class="col-xl-4  " >
                                <button class="btn btn-block-only btn-success ripple mt-3 mx-xl-2 float-left" @click="newModal"> <i style="font-size: 16px" class="fal fa-file-plus"></i> افزودن طرح پژوهشی</button>
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
                                        <option value="8">همه</option>
                                        <option value="0">بررسی نشده</option>
                                        <option value="5">تحت داوری</option>
                                        <option value="6">تایید و ارسال برای داوری</option>
                                        <option value="4">اصلاح شده</option>
                                        <option value="1">تایید شده</option>
                                        <option value="7">تایید شده با اصلاحات</option>
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
                                <th>عنوان طرح پژوهشی</th>
                                <th>نوع طرح</th>
                                <th>نام مجری</th>
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
                            <tr v-if="proposals.length <= 0">
                                <td colspan="7"><h4 class="text-center">هیچ نتیجه ای یافت نشد.</h4></td>
                            </tr>
                            <tr v-for="(proposal, index) in proposals" :key="proposal.id">
                                <td class="persian-num">{{counter(index)}}</td>
                                <td>{{ proposal.title | truncate(40) }}</td>
                                <td>{{ proposal.proposal_type  }}</td>


                                <td>{{ proposal.Author_name  }}</td>
                                <td v-if="proposal.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</td>
                                <td v-else-if="proposal.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</td>
                                <td v-else-if="proposal.status == '5'"  class="green"><i class="fal fa-search"></i>  {{'تحت داوری' }}</td>
                                <td v-else-if="proposal.status == '6'"  class="green"><i class="fal fa-search"></i>  {{'تایید و ارسال برای داوری' }}</td>
                                <td v-else-if="proposal.status == '7'"  class="green"><i class="fal fa-search"></i>  {{'تایید شده با اصلاحات' }}</td>
                                <td v-else-if="proposal.status == '2'"  class="orange"><i class="far fa-exclamation-triangle"></i>  {{'عدم تایید موقت' }}</td>
                                <td v-else-if="proposal.status == '3'"  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</td>
                                <td v-else class="cyan"><i class="fal fa-exclamation"></i>  {{'اصلاح شده' }}</td>
                                <td>{{ proposal.created_at | myDate  }}</td>
                                <td colspan="2">
                                    <router-link :to="{ name: 'researchProposalEdit', params: { id: proposal.id }}">
                                        <i class="fa fa-edit blue"></i>
                                    </router-link>
                                    /
                                    <a href="#" @click="deleteProposal(proposal.id)">
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
                        {{(this.numTo - this.numStart + 1)    }}
                        از
 {{this.total  }}                   </span>
                    </div><!-- /card-footer --->
                </div>
            </div><!-- /col-md-12 --->
            <div   class="modal  fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><i
                                class="fas fa-scroll-old fa-fw"></i> ثبت پروپوزال طرح‌ پژوهشی جدید </h5>

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
                            <h2 slot="title">تکمیل پروپوزال طرح‌ پژوهشی</h2>
                            <!--  -->
                            <tab-content title="پروپوزال پژوهشی" :before-change="proposalValidation"  icon="far fa-scroll-old">
                                <form @submit.prevent="createProposal()" @keydown="form.onKeydown($event)" @change="form.onKeydown($event)" data-vv-scope="form" id="Form">

                                    <div class="modal-body">
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">عنوان فارسی طرح پژوهشی<i class="red mx-1">*</i>:</label>
                                            <input  type="text"  name="title" placeholder="عنوان فارسی طرح پژوهشی"
                                                    class="form-control" v-model="form.title"
                                                    v-validate="'required'"
                                                    autofocus
                                                    :class="{ 'is-invalid': form.errors.has('title') || errors.has('form.title') } " >
                                            <i v-show="errors.has('form.title') || form.errors.has('title')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.title')" class="red d-inline-block">{{ errors.first('form.title') }}</span>
                                            <span v-show="form.errors.has('title')" class="red d-inline-block">{{ form.errors.get('title') }}</span>
                                        </div>
                                        <div class="form-group my-3 text-right">
                                            <label class="blue">عنوان انگلیسی طرح پژوهشی<i class="red mx-1">*</i>:</label>
                                            <input  type="text"  name="en_title" placeholder="عنوان طرح پژوهشی و فناوری"
                                                    class="form-control" v-model="form.en_title"
                                                    v-validate="'required'"
                                                    :class="{ 'is-invalid': form.errors.has('en_title') || errors.has('form.en_title') } " >
                                            <i v-show="errors.has('form.en_title') || form.errors.has('en_title')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.en_title')" class="red d-inline-block">{{ errors.first('form.en_title') }}</span>
                                            <span v-show="form.errors.has('en_title')" class="red d-inline-block">{{ form.errors.get('en_title') }}</span>
                                        </div>
                                        <div class="form-group my-4 text-right">
                                            <label class="blue">نوع طرح پژوهشی<i class="red mx-1">*</i>:</label>
                                            <Select2 v-validate="'required'" data-vv-name="proposal_type_id"
                                                     class="form-control select2-form-control" id="proposal_type_id"
                                                     :class="[( errors.has('form.proposal_type_id') || form.errors.has('proposal_type_id') ? 'is-invalid': ''  )]"
                                                     v-model="form.proposal_type_id"
                                                     :options="proposal_types"
                                                     @change="removeError('proposal_type_id')"
                                                     :settings="{theme: 'bootstrap4', placeholder: 'نوع طرح پژوهشی', width: '100%' }">
                                            </Select2>

                                            <i v-show="errors.has('form.proposal_type_id') || form.errors.has('proposal_type_id')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form.proposal_type_id')" class="red d-inline-block">{{ errors.first('form.proposal_type_id') }}</span>
                                            <span v-show="form.errors.has('proposal_type_id')" class="red d-inline-block">{{ form.errors.get('proposal_type_id') }}</span>
                                        </div>
                                        <div class="form-group my-4 text-right">
                                            <label class="blue">نوع کاربرد طرح پژوهشی<i class="red mx-1">*</i>:</label>
                                            <Select2 v-validate="'required'" data-vv-name="proposal_usage_id"
                                                     class="form-control select2-form-control" id="proposal_usage_id"
                                                     :class="[( errors.has('form.proposal_usage_id') || form.errors.has('proposal_usage_id') ? 'is-invalid': ''  )]"
                                                     v-model="form.proposal_usage_id"
                                                     :options="proposal_usages"
                                                     @change="removeError('proposal_usage_id')"
                                                     :settings="{theme: 'bootstrap4', placeholder: 'نوع کاربرد طرح پژوهشی', width: '100%' }">
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
                                            <label class="blue">محل اجرای طرح<i class="red mx-1">*</i>:</label>
                                            <input  type="text"  name="project_location" placeholder="محل اجرای طرح"
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
                                            <label class="blue ">بودجه طرح پژوهشی<i class="red mx-1">*</i>:{{ form.budget | currency}}<span >ریال</span></label>
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
                                            <label class="blue text-right">فایل های ضمیمه:<i class="red mx-1">*</i>:</label>
                                            <span class="red"><br/>
                                                اسکن قرارداد بصورت pdf<br>
                                                اسکن مجوز شورای بصورت pdf در صورت وجود<br>
                                                اسکن صورت جلسه دفاع بصورت pdf در صورت وجود<br>
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
                                            <tinymce @editorChange="removeError('abstract')" :other_options="options" v-validate="'required'" name="abstract" v-model="form.abstract" id="d1"></tinymce>
                                        </div>
                                        <div class="text-right mt-1 mb-4" >
                                            <label class="blue text-right">مقدمه<i class="red mx-1">*</i>:</label><br>
                                            <i v-show="errors.has('form2.introduction')||form.errors.has('introduction')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form2.introduction')" class="red d-inline-block">{{ errors.first('form2.introduction') }}</span>
                                            <span v-show="form.errors.has('introduction')" class="red d-inline-block">{{ form.errors.get('introduction') }}</span>
                                            <tinymce @editorChange="removeError('introduction')" :other_options="options" v-validate="'required'" name="introduction" v-model="form.introduction" id="d2"></tinymce>
                                        </div>
                                        <div class="text-right mt-1 mb-4" >
                                            <label class="blue text-right">بیان مسئله<i class="red mx-1">*</i>:</label><br>
                                            <i v-show="errors.has('form2.problem')||form.errors.has('problem')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form2.problem')" class="red d-inline-block">{{ errors.first('form2.problem') }}</span>
                                            <span v-show="form.errors.has('problem')" class="red d-inline-block">{{ form.errors.get('problem') }}</span>
                                            <tinymce @editorChange="removeError('problem')" :other_options="options" v-validate="'required'" name="problem" v-model="form.problem" id="d3"></tinymce>
                                        </div>
                                        <div class="text-right mt-1 mb-4" >
                                            <label class="blue text-right">نوآوری پروپوزال پیشنهادی<i class="red mx-1">*</i>:</label><br>
                                            <i v-show="errors.has('form2.innovation')||form.errors.has('innovation')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form2.innovation')" class="red d-inline-block">{{ errors.first('form2.innovation') }}</span>
                                            <span v-show="form.errors.has('innovation')" class="red d-inline-block">{{ form.errors.get('innovation') }}</span>
                                            <tinymce @editorChange="removeError('innovation')" :other_options="options" v-validate="'required'" name="innovation" v-model="form.innovation" id="d4"></tinymce>
                                        </div>
                                        <div class="text-right mt-1 mb-4" >
                                            <label class="blue text-right">نیازمندی ها<i class="red mx-1">*</i>:</label><br>
                                            <i v-show="errors.has('form2.requirements')||form.errors.has('requirements')" class="red far fa-exclamation-triangle"></i>
                                            <span v-show="errors.has('form2.requirements')" class="red d-inline-block">{{ errors.first('form2.requirements') }}</span>
                                            <span v-show="form.errors.has('requirements')" class="red d-inline-block">{{ form.errors.get('requirements') }}</span>
                                            <tinymce @editorChange="removeError('requirements')" :other_options="options" v-validate="'required'" name="requirements" v-model="form.requirements" id="d5"></tinymce>
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
                </div>
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


        </div><!-- /container-fluid -->
    </div>
</template>

<script>
    import Select2 from 'v-select2-component';
    import farsi from 'vee-validate/dist/locale/fa';
    export default {
        name: "ResearchProposal",
        data(){
            return{
                options: {// tinyMce toolbar options
                    height:'200px',
                    directionality : 'rtl',
                    language_url: '../js/fa_IR.js', //This url points to location of persian language file.
                    toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat',
                    toolbar2: ' cut copy paste | ltr rtl | | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor',
                    plugins:['advlist autolink lists link image charmap print preview hr anchor pagebreak', 'searchreplace wordcount visualblocks visualchars code fullscreen', 'insertdatetime media nonbreaking save table contextmenu directionality','template paste textcolor colorpicker textpattern imagetools toc help emoticons hr codesample'],
                },
                filter:6,
                perPage:5,
                regulation:'',
                proposals:{},
                proposal_types:[],
                proposal_usages:[],
                faculties:[],
                allData :{},
                search: '',     // search term
                order: 0,       // order 1 for desc and 0  for asc
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
                }),
            }
        },
        methods:{
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
            removeAuthor(index){
                this.$delete(this.form.authors,index);
                this.$delete(this.form.affiliations,index);
            },
            // validate the authors detail in last step
            authorValidation(){
                return this.$validator.validateAll('form-4').then(result => {
                    if (!result) {
                        this.errorSwal('باید مسئول طرح پژوهشی انتخاب شود!');
                        return false;
                    }
                    return true;
                });
            },
            proposalValidation(){
                return this.$validator.validateAll('form').then(result => {
                    if (!result) {
                        this.errorSwal('اطلاعات طرح پژوهشی دارای خطا می باشد!');
                        return false;
                    }
                    return true;
                });
            },
            proposalValidationPart2(){
                return this.$validator.validateAll('form2').then(result => {
                    if (!result) {
                        this.errorSwal('اطلاعات طرح پژوهشی دارای خطا می باشد!');
                        return false;
                    }
                    return true;
                });
            },
            onComplete(){
                this.$Progress.start();
                let loader1 = Vue.$loading.show();
                this.form.busy;

                this.form.submit('post', '/api/researchProposal', {
                    // Transform form data to FormData
                    transformRequest: [function (data, headers) {
                        return objectToFormData(data)
                    }]
                }).then((response) => {
                    loader1.hide();
                    this.proposals.unshift(response.data.data);
                    $('#addNew').modal('hide');
                    this.successToast('اطلاعات طرح پژوهشی جدید با موفقیت ثبت شد.');
                    this.$Progress.finish();
                    this.resetFormWizard();
                })
                    .catch((e) => {
                        loader1.hide();
                        let t = Object.keys(this.form.errors.all()).filter(function (key) {
                            return /^files./.test(key);
                        });

                        if (!t.length) {
                        } else {
                            this.form.errors.set('files', 'نوع فایل باید یکی از انواع pdf و rar یا zip باشد.')
                        }
                        if(e.response.status == 405){
                            let starts = this.$options.filters.myDate(window.term.starts_at);
                            let ends = this.$options.filters.myDate(window.term.ends_at);
                            this.errorSwal(`تاریخ ثبت اطلاعات در ترم جاری از بازه ${starts} تا بازه ${ends} می باشد. امکان ثبت در تاریخ کنون وجود ندارد.`);
                        }else{
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        }
                        this.$Progress.fail();
                    })

            },

            resetFormWizard() {
                this.fileName=[];
                this.attachments = [];
                this.form.reset();
                this.$refs.wizard.reset();
                this.$validator.reset();
            },
            deleteProposal(id){
                swal({
                    title: 'آیا از حذف پروپوزال طرح پژوهشی مورد نظر مطمئن هستید؟',
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
                        this.form.delete(`/api/researchProposal/${id}`).then(() => {
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
            getResults(page = 1, que = '') {
                let loader1 = Vue.$loading.show();

                let sortOrder = this.order === 1 ? 'asc' : 'desc';
                if (this.searchResult) {
                    que = this.search;
                    axios.get('/api/findResearchProposal?order=' + sortOrder + '&q=' + que +'&filter='+this.filter
                        +'&page=' + page +'&perPage=' + this.perPage)
                        .then(response => {
                            loader1.hide();
                            this.allData = response.data;
                            this.proposals = response.data.data;
                            this.total = response.data.meta.total;
                            this.numToShow = response.data.meta.per_page;
                            this.numStart = response.data.meta.from;
                            this.numTo = response.data.meta.to;
                        }).catch(error =>{
                        loader1.hide();
                    });
                } else {
                    axios.get('/api/researchProposal?order=' + sortOrder + '&page=' + page
                        +'&filter='+this.filter +'&perPage=' + this.perPage)
                        .then(response => {
                            loader1.hide();
                            this.allData = response.data;
                            this.proposals = response.data.data;
                            this.total = response.data.meta.total;
                            this.numToShow = response.data.meta.per_page;
                            this.numStart = response.data.meta.from;
                            this.numTo = response.data.meta.to;
                        }).catch(error =>{
                        loader1.hide();
                    });
                }
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
            prepareRegulation() {
                axios.get(`/api/regulationDetail/6`).then((response)=>{
                    this.regulation = response.data.data.detail;
                }).catch(()=>{
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            createProposal(){

            },

        },
        computed:{
            sortType() {
                return this.order === 1 ? 'ascending' : 'descending';
            },
        },
        created(){
            this.$parent.pageName = 'آرشیو پروپوزال های پژوهشی';
            this.$validator.localize('farsi', {
                messages: farsi.messages,
                attributes: {
                    title: 'عنوان فارسی پروپوزال',
                    en_title: 'عنوان انگلیسی پروپوزال',
                    budget: 'بودجه مورد نیاز پروپوزال',
                    value: 'ارزش تخمینی طرح',
                    proposal_type_id: 'انتخاب نوع پروپوزال',
                    proposal_usage_id: 'انتخاب نوع کاربرد پروپوزال',
                    faculty_id: 'انتخاب دانشکده مربوطه',
                    abstract: 'چکیده پروپوزال',
                    tags: 'کلمات کلیدی',
                    introduction: 'مقدمه پروپوزال',
                    problem: 'بیان مسئله پروپوزال',
                    innovation: 'نوآوری پروپوزال پیشنهادی',
                    requirements: 'نیازمندی های طرح',
                    duration: 'مدت زمان مورد نیاز',
                    project_location: 'محل اجرا و انجام پروپوزال',
                    files: 'فایل های ضمیمه',
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
            this.prepareRegulation();
            this.getResults();
            this.getProposalRelation();
            this.form.reset();
        },
        components: {
            Select2,
        }
    }
</script>

<style scoped>

</style>
