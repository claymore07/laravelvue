<template>
<div>
    <div class="container-fluid text-rtl text-right my-5">
        <div class="card my-5">
            <div class="card-header justify-content-around d-flex " style="direction: rtl">
                <div class="col">
                    <h3 class=" text-right">اطلاعات مقالات</h3>
                </div>
                <div class="card-tools">
                    <button class="btn btn-success" @click="goback"><i style="font-size: 16px" class="fal fa-undo"></i> بازگشت</button>
                </div><!-- /card-tools -->
            </div><!-- /.card-header -->
            <div class="card-body  px-0">
                <table class="table table-hover table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th class="font-18"><i class="fal fa-file-edit fa-fw"></i>اطلاعات مقاله</th>
                        <th v-if="checkList">موارد ناقص</th>
                    </tr>
                    </thead>
                    <tbody v-if="paper.id">
                    <tr>
                        <td class="font-16">
                            <span class="blue">عنوان:</span>
                            <span class="mr-3">{{paper.title}}</span>
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
                            <span class="blue ">چکیده:</span><br>
                            <div v-html="paper.abstract"></div>
                            <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('چکیده')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
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
                        <td class="font-16">
                            <span class="blue ">نویسندگان:</span>
                            <span v-for="author of paper.authors" class="mr-3 ">
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
                        <td class="font-16 ">
                            <span class="blue ">آدرس Doi مقاله: </span>
                            <span class="mr-3"> {{paper.doi}} </span>
                            <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('Doi')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>

                        </td>
                        <td v-if="checkList">
                            <p-check
                                :checked="checkListForm.list && checkListForm.list.includes('Doi')"
                                @change.native="onChange('Doi', $event)"
                                type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                <i slot="extra" class="icon far fa-check"></i>
                            </p-check>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-16">
                            <span class="blue ">لینک:</span>
                            <button class="mr-3 btn btn-info btn-lg" target="_blank" :href="paper.link">لینک صفحه مقاله
                            </button>
                            <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('لینک')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>

                        </td>
                        <td v-if="checkList">
                            <p-check
                                :checked="checkListForm.list && checkListForm.list.includes('لینک')"
                                @change.native="onChange('لینک', $event)"
                                type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                <i slot="extra" class="icon far fa-check"></i>
                            </p-check>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-16">
                            <span class="blue ">نوع مستخرج:</span>
                            <span class="mr-3 "> {{paper.excerpt.name}} </span>
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
                    <tr v-if="paper.excerpt_id == '1'">
                        <td class="font-16">
                            <span class="blue ">نوع موظفی:</span>
                            <span v-if="paper.license_to == '0'" class="mr-3 "> موظفی طرح </span>
                            <span v-else class="mr-3 "> مازاد موظفی </span>
                            <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نوع موظفی')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                        </td>
                        <td v-if="checkList">
                            <p-check
                                :checked="checkListForm.list && checkListForm.list.includes('نوع موظفی')"
                                @change.native="onChange('نوع موظفی', $event)"
                                type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                <i slot="extra" class="icon far fa-check"></i>
                            </p-check>
                        </td>
                    </tr>
                    <tr v-if="paper.excerpt_id == '3'">
                        <td class="font-16">
                            <span class="blue ">توضیحات مجوز:</span>
                            <span class="mr-3 "> {{paper.license}} </span>
                            <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('توضیحات مجوز')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                        </td>
                        <td v-if="checkList">
                            <p-check
                                :checked="checkListForm.list && checkListForm.list.includes('توضیحات مجوز')"
                                @change.native="onChange('توضیحات مجوز', $event)"
                                type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                <i slot="extra" class="icon far fa-check"></i>
                            </p-check>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-16">
                            <span class="blue ">کلمات کلید:</span>
                            <span v-for="tag of paper.tags" class="mr-3 "> {{tag.name}}، </span>
                            <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('کلمات کلید')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
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
                            <span v-for="(file, index) of paper.files" class="mr-3 ">
                                    <div v-if="checkFileType(file)" class="btn-group text-ltr" role="group" aria-label="Basic example">
                                         <a  class="btn btn-lg btn-info" :href="'/files/papers/'+file.name"><i class="fal fa-download fa-fw"></i>  </a>
                                         <a  class="btn btn-lg btn-info" :href="'/files/papers/'+file.name">ضمیمه {{index+1|faDigit}}  <i class="fal fa-file-archive fa-fw"></i></a>
                                    </div>
                                    <div v-else class="btn-group text-ltr" role="group" aria-label="Basic example">
                                      <a  :href="'/files/papers/'+file.name" class="btn btn-lg btn-info"><i class="fal fa-download"></i></a>
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
                            <span class="blue ">تاریح پذیرش:</span>
                            <span class="mr-3 "> {{paper.publish_date | myDate}} هجری شمسی</span>
                            <span class="mr-3 "> {{paper.publish_date | myDateEN}} میلادی</span>
                            <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('تاریح پذیرش')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                        </td>
                        <td v-if="checkList">
                            <p-check
                                :checked="checkListForm.list && checkListForm.list.includes('تاریح پذیرش')"
                                @change.native="onChange('تاریح پذیرش', $event)"
                                type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                <i slot="extra" class="icon far fa-check"></i>
                            </p-check>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-16">
                            <span class="blue ">تاریح چاپ:</span>
                            <span class="mr-3 "> {{paper.accept_date | myDate}} هجری شمسی</span>
                            <span class="mr-3 "> {{paper.accept_date | myDateEN}} میلادی</span>
                            <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('تاریح چاپ')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                        </td>
                        <td v-if="checkList">
                            <p-check
                                :checked="checkListForm.list && checkListForm.list.includes('تاریح چاپ')"
                                @change.native="onChange('تاریح چاپ', $event)"
                                type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                <i slot="extra" class="icon far fa-check"></i>
                            </p-check>
                        </td>
                    </tr>
                    <tr class="table-dark">
                        <td class="font-18">
                            <span v-if="jourType" class="mr-3 "> اطلاعات مجله</span>
                            <span v-else class="mr-3 "> اطلاعات کنفرانس</span>
                        </td>
                        <td v-if="checkList" ></td>
                    </tr>
                    <tr>
                        <td class="font-16">
                            <span class="blue ">نوع مقاله:</span>
                            <span v-if="jourType" class="mr-3 "> ژونالی</span>
                            <span v-else class="mr-3 "> کنفرانسی</span>
                        </td>
                        <td v-if="checkList">

                        </td>
                    </tr>
                    <!-- journal detail part -->
                    <tr v-if="jourType">
                        <td class="font-16">
                            <span class="blue ">نوع مجله:</span>
                            <span class="mr-3 "> {{jtypename}}</span>
                            <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نوع مجله')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                        </td>
                        <td v-if="checkList">
                            <p-check
                                :checked="checkListForm.list && checkListForm.list.includes('نوع مجله')"
                                @change.native="onChange('نوع مجله', $event)"
                                type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                <i slot="extra" class="icon far fa-check"></i>
                            </p-check>
                        </td>
                    </tr>
                    <tr v-if="jourType">
                        <td class="font-16">
                            <span class="blue ">نام مجله:</span>
                            <span class="mr-3 "> {{paper.paperable.name}}</span>
                            <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نام مجله')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                        </td>
                        <td v-if="checkList">
                            <p-check
                                :checked="checkListForm.list && checkListForm.list.includes('نام مجله')"
                                @change.native="onChange('نام مجله', $event)"
                                type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                <i slot="extra" class="icon far fa-check"></i>
                            </p-check>
                        </td>
                    </tr>
                    <tr v-if="jourType">
                        <td class="font-16">
                            <span class="blue ">نام ناشر:</span>
                            <span class="mr-3 "> {{paper.paperable.publisher}}</span>
                            <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نام ناشر')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                        </td>
                        <td v-if="checkList">
                            <p-check
                                :checked="checkListForm.list && checkListForm.list.includes('نام ناشر')"
                                @change.native="onChange('نام ناشر', $event)"
                                type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                <i slot="extra" class="icon far fa-check"></i>
                            </p-check>
                        </td>
                    </tr>
                    <tr v-if="jourType">
                        <td class="font-16">
                            <span class="blue d-inline-block">شماره ISSN:</span>
                            <span class="mr-3 d-inline-block"> {{paper.paperable.issn}}</span>
                            <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('ISSN')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                        </td>
                        <td v-if="checkList">
                            <p-check
                                :checked="checkListForm.list && checkListForm.list.includes('ISSN')"
                                @change.native="onChange('ISSN', $event)"
                                type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                <i slot="extra" class="icon far fa-check"></i>
                            </p-check>
                        </td>
                    </tr>
                    <tr v-if="jourType">
                        <td class="font-16">
                            <span class="blue d-inline-block">شماره pISSN:</span>
                            <span class="mr-3 d-inline-block"> {{paper.paperable.pissn}}</span>
                            <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('pISSN')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                        </td>
                        <td v-if="checkList">
                            <p-check
                                :checked="checkListForm.list && checkListForm.list.includes('pISSN')"
                                @change.native="onChange('pISSN', $event)"
                                type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                <i slot="extra" class="icon far fa-check"></i>
                            </p-check>
                        </td>
                    </tr>
                    <tr v-if="jourType">
                        <td class="font-16">
                            <span class="blue d-inline-block">ضریب IF:</span>
                            <span class="mr-3 d-inline-block"> {{paper.paperable.IFactor}}</span>
                            <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('IF')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                        </td>
                        <td v-if="checkList">
                            <p-check
                                :checked="checkListForm.list && checkListForm.list.includes('IF')"
                                @change.native="onChange('IF', $event)"
                                type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                <i slot="extra" class="icon far fa-check"></i>
                            </p-check>
                        </td>
                    </tr>
                    <tr v-if="jourType">
                        <td class="font-16">
                            <span class="blue d-inline-block">ضریب پنج ساله IF:</span>
                            <span class="mr-3 d-inline-block"> {{paper.paperable.FIF}}</span>
                            <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('ضریب پنج ساله IF')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                        </td>
                        <td v-if="checkList">
                            <p-check
                                :checked="checkListForm.list && checkListForm.list.includes('ضریب پنج ساله IF')"
                                @change.native="onChange('ضریب پنج ساله IF', $event)"
                                type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                <i slot="extra" class="icon far fa-check"></i>
                            </p-check>
                        </td>
                    </tr>
                    <tr v-if="jourType">
                        <td class="font-16">
                            <span class="blue d-inline-block">رتبه JCR:</span>
                            <span class="mr-3 d-inline-block"> {{paper.paperable.JCR}}</span>
                            <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('JCR')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                        </td>
                        <td v-if="checkList">
                            <p-check
                                :checked="checkListForm.list && checkListForm.list.includes('JCR')"
                                @change.native="onChange('JCR', $event)"
                                type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                <i slot="extra" class="icon far fa-check"></i>
                            </p-check>
                        </td>
                    </tr>
                    <tr v-if="jourType">
                        <td class="font-16">
                            <span class="blue d-inline-block">ضریب JRK:</span>
                            <span class="mr-3 d-inline-block"> {{paper.paperable.JRK}}</span>
                            <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('JRK')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                        </td>
                        <td v-if="checkList">
                            <p-check
                                :checked="checkListForm.list && checkListForm.list.includes('JRK')"
                                @change.native="onChange('JRK', $event)"
                                type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                <i slot="extra" class="icon far fa-check"></i>
                            </p-check>
                        </td>
                    </tr>
                    <!-- /journal detail part -->
                    <!-- conference detail part -->

                    <tr v-if="confType">
                        <td class="font-16">
                            <span class="blue d-inline-block">نوع کنفرانس:</span>
                            <span class="mr-3 d-inline-block"> {{conftypename}}</span>
                            <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نوع کنفرانس')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                        </td>
                        <td v-if="checkList">
                            <p-check
                                :checked="checkListForm.list && checkListForm.list.includes('نوع کنفرانس')"
                                @change.native="onChange('نوع کنفرانس', $event)"
                                type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                <i slot="extra" class="icon far fa-check"></i>
                            </p-check>
                        </td>
                    </tr>
                    <tr v-if="confType">
                        <td class="font-16">
                            <span class="blue d-inline-block">نام کنفرانس:</span>
                            <span class="mr-3 d-inline-block"> {{paper.paperable.name}}</span>
                            <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نام کنفرانس')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                        </td>
                        <td v-if="checkList">
                            <p-check
                                :checked="checkListForm.list && checkListForm.list.includes('نام کنفرانس')"
                                @change.native="onChange('نام کنفرانس', $event)"
                                type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                <i slot="extra" class="icon far fa-check"></i>
                            </p-check>
                        </td>
                    </tr>
                    <tr v-if="confType">
                        <td class="font-16">
                            <span class="blue d-inline-block">نام برگزار کننده:</span>
                            <span class="mr-3 d-inline-block"> {{paper.paperable.organizer}}</span>
                            <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نام برگزار کننده')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                        </td>
                        <td v-if="checkList">
                            <p-check
                                :checked="checkListForm.list && checkListForm.list.includes('نام برگزار کننده')"
                                @change.native="onChange('نام برگزار کننده', $event)"
                                type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                <i slot="extra" class="icon far fa-check"></i>
                            </p-check>
                        </td>
                    </tr>
                    <tr v-if="confType">
                        <td class="font-16">
                            <span class="blue d-inline-block">نام شهر:</span>
                            <span class="mr-3 d-inline-block"> {{paper.paperable.city}}</span>
                            <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('نام شهر')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                        </td>
                        <td v-if="checkList">
                            <p-check
                                :checked="checkListForm.list && checkListForm.list.includes('نام شهر')"
                                @change.native="onChange('نام شهر', $event)"
                                type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                <i slot="extra" class="icon far fa-check"></i>
                            </p-check>
                        </td>
                    </tr>
                    <tr v-if="confType">
                        <td class="font-16">
                            <span class="blue d-inline-block">دوره برگزاری:</span>
                            <span class="mr-3 d-inline-block"> {{paper.paperable.period}}</span>
                            <span class="red float-left font-20" v-if="checkListForm.list && checkListForm.list.includes('دوره برگزاری')" title="عدم تایید"><i class="fa fa-times-circle"></i></span>
                        </td>
                        <td v-if="checkList">
                            <p-check
                                :checked="checkListForm.list && checkListForm.list.includes('دوره برگزاری')"
                                @change.native="onChange('دوره برگزاری', $event)"
                                type="checkbox" class="p-icon p-curve p-pulse p-bigger text-ltr" color="info-o">
                                <i slot="extra" class="icon far fa-check"></i>
                            </p-check>
                        </td>
                    </tr>
                    <tr v-if="checkList">
                        <td colspan="2">
                            <label for="status" class="blue mt-3">وضعیت بررسی: </label>
                            <select v-model="checkListForm.status"
                                    :class="[(  checkListForm.errors.has('status') ? 'is-invalid': ''  )]"
                                    @change="form2.errors.clear('status')"
                                    class="custom-select" name="" id="status">
                                <option  selected disabled>انتخاب گزینه</option>
                                <option value="1" ><i class="fa-check"></i>تایید</option>
                                <option value="2" >عدم تایید</option>
                            </select>
                            <i v-show="checkListForm.errors.has('status')" class="red far fa-exclamation-triangle"></i>
                            <span v-show="checkListForm.errors.has('status')" class="red d-inline-block">{{ checkListForm.errors.get('status') }}</span>
                            <br>
                            <label for="id2" class="blue mt-3">توضیحات: </label>
                            <tinymce  :other_options="options" name="comment" id="id2"></tinymce>

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
                <button @click="paperEditModal" class="btn btn-lg mx-1 btn-dark">ویرایش  مقاله</button>
                <button v-if="checkList" @click="checkListSubmit" class="btn btn-lg btn-success mx-5"><i class="fal fa-check fa-fw"></i>ثبت نتبجه بررسی</button>
                <button @click="toggleCheckList"  class="btn btn-lg mx-1 btn-warning">چک لیست بررسی</button>
            </div>
        </div>
    </div><!-- /container -->

    <!--paper Edit  modal -->
    <div v-if="paper.id" class="modal  fade" id="paperEditModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabe2"><i
                        class="far fa-file-alt fa-fw"></i>ویرایش مقاله</h5>
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
                        <tab-content title="اطلاعات مقاله" :before-change="paperValidation"  icon="far fa-file-alt">

                            <form @submit.prevent="createPaper()"
                                  @keydown="form.onKeydown($event)" @change="form.onKeydown($event)" data-vv-scope="form-1" id="Form">
                                <div  class="form-group my-4 text-right">
                                    <label class="blue ">عنوان مقاله<i class="red mx-1">*</i>:</label>
                                    <input   type="text" name="title"
                                             placeholder="عنوان مقاله"
                                             v-validate="'required'"
                                             class="form-control" v-model="form.title"
                                             :class="[( errors.has('form-1.title') || form.errors.has('title') ? 'is-invalid': ''  ), ((paper.lang == '0' )?'text-right':'text-left') ]"
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
                                    <select v-validate="'required'" data-vv-name="excerpt_id"
                                        class="custom-select custom-select-lg mb-3" id="excerpt_id"
                                            :class="[( errors.has('form-1.excerpt_id') || form.errors.has('excerpt_id') ? 'is-invalid': ''  )]"
                                            @change="removeError('excerpt_id')"
                                            v-model="form.excerpt_id"
                                    >
                                        <option selected disabled>انتخاب گزینه مورد نظر</option>
                                        <option  v-for="(item, index) of excerpts" v-bind:value="item.id">{{item.text}}</option>
                                    </select>


                                    <i v-show="errors.has('form-1.excerpt_id') || form.errors.has('excerpt_id')" class="red far fa-exclamation-triangle"></i>
                                    <span v-show="errors.has('form-1.excerpt_id')" class="red d-inline-block">{{ errors.first('form-1.excerpt_id') }}</span>
                                    <span v-show="form.errors.has('excerpt_id')" class="red d-inline-block">{{ form.errors.get('excerpt_id') }}</span>
                                </div>
                                <div v-if="form.excerpt_id == '1'">
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
                                <div  v-if="form.excerpt_id == '3'">
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
                                    <date-picker @change="removeError('publish_date')"  format="YYYY-MM-DD" :class="[( errors.has('form-1.publish_date') || form.errors.has('publish_date') ? 'is-invalid': ''  )]"  v-validate="'required'" name="publish_date" v-model="form.publish_date" locale="fa,en"></date-picker>
                                    <has-error :form="form" field="publish_date"></has-error>
                                    <div class="text-rtl">
                                        <i v-show="errors.has('form-1.publish_date')|| form.errors.has('publish_date')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show="errors.has('form-1.publish_date') " class="red d-inline-block text-rtl">{{ errors.first('form-1.publish_date') }}</span>
                                        <span v-show="form.errors.has('publish_date')" class="red d-inline-block text-rtl">{{ form.errors.get('publish_date') }}</span>
                                    </div>
                                </div>
                                <div class=" mt-4" style="direction: ltr; text-align: right" >
                                    <label class="blue text-right  text-rtl">تاریخ پذیرش<i class="red mx-1">*</i>:</label>
                                    <date-picker @change="removeError('accept_date')" format="YYYY-MM-DD"  :class="[( errors.has('form-1.accept_date') || form.errors.has('accept_date') ? 'is-invalid': ''  )] " v-validate="'required'" name="accept_date" v-model="form.accept_date" locale="fa,en"></date-picker>
                                    <div class="text-rtl">
                                        <i v-show="errors.has('form-1.accept_date')|| form.errors.has('accept_date')" class="red far fa-exclamation-triangle"></i>
                                        <span v-show="errors.has('form-1.accept_date') " class="red d-inline-block text-rtl text-rtl">{{ errors.first('form-1.accept_date') }}</span>
                                        <span v-show="form.errors.has('accept_date')" class="red d-inline-block text-rtl text-rtl">{{ form.errors.get('accept_date') }}</span>
                                    </div>
                                </div>
                                <div class="form-group mt-4 text-right">
                                    <label class="blue text-right">فایل های ضمیمه<i class="red mx-1">*</i>:</label>
                                </div>
                                <div class="mt-2 text-right">
                                    <span>آیا می خواهید در فایل های ضمیمه تغییر اعمال کنید؟</span>
                                    <button @click="fileChange(true)" class="btn btn-info btn-lg">آری</button>
                                    <button v-if="fileChanging" @click="fileChange(false)" class="btn btn-warning btn-lg">خیر</button>
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
                                <div v-if="fileChanging" class="custom-file text-ltr text-right mt-3 mb-5">
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
                                                @tag-removed="onTagRemoved"
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
                                    <div v-if="confForm" class="form-group my-3 text-right">
                                        <label class="blue">نوع کنفرانس <i class="red mx-1">*</i>:</label>
                                        <select v-validate="'required'" data-vv-name="conftype_id"
                                                class="custom-select custom-select-lg mb-3" id="conftype_id"
                                                :class="[( errors.has('form2.conftype_id') || form.errors.has('conftype_id') ? 'is-invalid': ''  )]"
                                                @change="removeError('conftype_id')"
                                                v-model="form.conftype_id"
                                        >
                                            <option selected disabled>انتخاب گزینه مورد نظر</option>
                                            <option  v-for="(item, index) of conftypes" v-bind:value="item.id">{{item.text}}</option>
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
                                    <div v-if="confForm" class="form-group my-3 text-right">
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
                                    <div v-if="confForm" class="form-group my-3 text-right">
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
                                </div>

                                <div >
                                    <div v-if="journalForm" class="form-group my-3 text-right">
                                        <label   class="blue">نوع مجله <i class="red mx-1">*</i>:</label>
                                        <select v-validate="'required'" data-vv-name="jtype_id"
                                                class="custom-select custom-select-lg mb-3" id="jtype_id"
                                                :class="[( errors.has('form2.jtype_id') || form.errors.has('jtype_id') ? 'is-invalid': ''  )]"
                                                @change="removeError('jtype_id')"
                                                v-model="form.jtype_id"
                                        >
                                            <option selected disabled>انتخاب گزینه مورد نظر</option>
                                            <option  v-for="(item, index) of jtypes" v-bind:value="item.id">{{item.text}}</option>
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

                                    <div v-if="journalForm" class="form-group my-3 text-right">
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
                                        <label v-if="journalForm"  class="blue ">pISSN:</label>
                                        <input v-if="journalForm"  type="text" name="pISSN"
                                               placeholder="1111-1111"
                                               v-mask="'####-###X'"
                                               class="form-control" v-model="form.pISSN" >
                                    </div>
                                    <div class="form-group my-4 text-right">
                                        <label v-if="journalForm"  class="blue ">IF:</label>
                                        <input v-if="journalForm"  type="number" min="0" name="pIF"
                                               placeholder=""
                                               class="form-control" v-model="form.pIF" >
                                    </div>
                                    <div class="form-group my-4 text-right">
                                        <label v-if="journalForm"  class="blue ">IF پنج ساله:</label>
                                        <input v-if="journalForm"  type="number" min="0" name="pFIF"
                                               placeholder=""
                                               class="form-control" v-model="form.pFIF" >
                                    </div>
                                    <div class="form-group my-4 text-right">
                                        <label v-if="journalForm"  class="blue ">JCR</label>
                                        <input v-if="journalForm"  type="text"  name="pJCR"
                                               placeholder="Q1"
                                               v-mask="'Q#'"
                                               class="form-control" v-model="form.pJCR" >
                                    </div>

                                    <div class="form-group my-4 text-right">
                                        <label v-if="journalForm"  class="blue ">JRK:</label>
                                        <input v-if="journalForm"  type="number" min="0" max="100" name="pJRK"
                                               placeholder=""
                                               class="form-control" v-model="form.pJRK" >
                                    </div>
                                </div>
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
    </div><!-- /paper Edit  modal  -->
    <!--pdf show modal -->
    <div class="modal  fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i
                        class="far fa-file-alt fa-fw"></i> مشاهده ضمیمه مقاله</h5>
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
</div>
</template>

<script>
    import Select2 from 'v-select2-component';
    import farsi from 'vee-validate/dist/locale/fa';
    export default {
        name: "PaperEdit",
        data(){
            return {
                options: { // tinyMce toolbar options
                    language_url: '/js/fa_IR.js', //This url points to location of persian language file.
                    toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat',
                    toolbar1: ' cut copy paste | ltr rtl | | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor',
                    plugins:['advlist autolink lists link image charmap print preview hr anchor pagebreak', 'searchreplace wordcount visualblocks visualchars code fullscreen', 'insertdatetime media nonbreaking save table contextmenu directionality','template paste textcolor colorpicker textpattern imagetools toc help emoticons hr codesample'],
                },
                id:'',              // paper id
                paper:{},           // paper object received from server
                type:'',            // sets the paper type if 0 means journal and 1 means conference
                pdfFileName:'',     // will be used to display pdf files in modal
                conftypename:'',    // if paper type is conference sets the conf type name
                jtypename:'',       // if paper type is journal sets the journal type name
                editOffset: -1,     // for managing author editing form status used if -1 the form will be hide
                confForm:false,     // if paper type is conference sets to true to show the conference edit form
                journalForm:false,  // if paper type is journal sets to true to show the journal edit form
                fileChanging:false, // if user wants to change any file or upload file
                excerpts:[],        // excerpts list
                conftypes:[],       // conference type list
                jtypes:[],          // conference type list
                fileName:[],        // For UI rendering and displaying the choosen file Names
                attachments:[],
                paperType:'',
                author:'',
                affiliation:'',
                fileChangeType:'-1',    // sets of the file change type, whether it is addition to previous files or replacement
                checkList:false,
                checkListItems:'',
                checkListItem:[],
                checkListForm: new Form({
                    id:'',
                    list:null,
                    status:null,
                    comments:''
                }),
                f:new FormData,         // creates the new FormData object to store selected files data
                // form data of VForm data object witch will be used to fill and submit the form
                form: new Form({
                    lang:'0',
                    tags:[],
                    tagsRemoved:[],
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
                    authors:[],
                    affiliations:[],
                    isresponsible:'',
                    paperType:''
                })
            };
        },
        computed:{
          jourType(){
              return this.type == '0';
          },
          confType(){
              return this.type == '1';
          },
        },
        methods:{
            prepareCheckList(){
                if(this.checkListItems.length > 0 && this.paper.status != '1'){
                    this.checkListForm.list = this.checkListItems[0].list;
                    this.checkListForm.comment = this.checkListItems[0].comment;
                    this.checkListForm.status = this.paper.status;
                }
            },
            checkListSubmit(){
                this.$Progress.start();
                this.checkListForm.id =this.id;
                this.checkListForm.post('/api/paperCheckList')
                    .then(() => {
                       // Fire.$emit('AfterCreate');
                      //  $('#addNew').modal('hide');
                        this.successToast('اطلاعات کاربر جدید با موفقیت ثبت شد.');
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
            toggleCheckList(){
              this.checkList = !this.checkList;
              if(this.checkListForm.list.length < 1){
                  this.checkListForm.status = 1;
              }else{
                  this.checkListForm.status = 2;
              }
            },
            // if the all paper submission validate it will submit the data to server
            onComplete: function(){
                this.$Progress.start();
                this.form.submit('post', '/api/paperUpdate/'+this.paper.id, {
                    // Transform form data to FormData
                    transformRequest: [function (data, headers) {
                        return objectToFormData(data)
                    }]
                }).then((response) => {
                    // sets the data
                    this.resetFormWizard();
                    this.paper = response.data.paper;// set the received paper data to paper property
                    this.conftypename = response.data.conftypename;  // if paper type is conference sets the conf type name
                    this.jtypename = response.data.jtypename;   // if paper type is journal sets the journal type name
                    this.editFormPrepare();

                    // UI modal Hide, progress bar finish , show the toase
                    $('#paperEditModal').modal('hide');
                    this.successToast('مقاله با موفقیت ویرایش شد.');
                    this.$Progress.finish();
                }).catch((e) => {

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
            /** these functions are responsible for form input error handling and change state*/
            // resets all the form modal related state and variables
            resetFormWizard() {
                this.fileName=[];
                this.attachments = [];
                this.authors = [];
                this.paperType = '';
                this.author = '';
                this.affiliation = '';
                this.fileChanging = false;
                this.form.reset();         // resets the Vform
                this.$refs.wizard.reset(); // resets the vue-form-wizard
                this.$validator.reset();   // resets the vee-validate
            },
            // goes to papers list page
            goback(){
                this.$router.push({path:'/papers'});
            },
            // shows paperEditModal
            paperEditModal(){
                $('#paperEditModal').modal('show');
            },
            // shows pdf modal
            pdfModal(name){
                this.pdfFileName = '/files/papers/'+name+'#page=1';
                $('#pdfModal').modal('show');
            },
            // checks the file type on render to see if it is pdf or zip
            checkFileType(file){
              var fileName = file.name.split(".");
              return fileName[1] == 'zip'? true:false;
            },
            // on page load gets paper data based on the received it
            getpaperdata(id){
                axios.get('/api/paper/'+id)
                    .then(response => {
                       this.paper = response.data.paper;// set the received paper data to paper property
                       this.type = response.data.type;  // sets the paper type if 0 means journal and 1 means conference
                       this.conftypename = response.data.conftypename;  // if paper type is conference sets the conf type name
                       this.jtypename = response.data.jtypename;   // if paper type is journal sets the journal type name
                        this.checkListItems = response.data.checklist;
                        this.prepareCheckList();
                       this.editFormPrepare();
                        if(this.type == '0'){
                            this.journalForm = true;
                            this.form.paperType = 'jur';
                        }else{
                            this.confForm = true;
                            this.form.paperType = 'conf';
                        }
                    })
                    .catch((e)=>{
                            console.log(e);
                        }
                    );
            },
            // gets the necessary data for edit form
            getPaperRelation(){
                axios.get('/api/paperRelation')
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
            // prepares the edit form data
            editFormPrepare(){
              this.form.title = this.paper.title;
              this.form.abstract = this.paper.abstract;
              this.form.doi = this.paper.doi;
              this.form.link = this.paper.link;
              this.form.excerpt_id = this.paper.excerpt_id.toString();
              this.form.license = this.paper.license;
              if(this.paper.license_to != null){
                  this.form.license_to = this.paper.license_to.toString();
              }
              this.form.publish_date = this.paper.publish_date;
              this.form.accept_date = this.paper.accept_date;

              for(var i = 0; i < this.paper.tags.length; i++){
                  this.form.tags.push( this.paper.tags[i].name);
              }

              if(this.type == '0'){
                  this.form.jtype_id = this.paper.paperable.jtype_id;
                  this.form.jname = this.paper.paperable.name;
                  this.form.jpublisher = this.paper.paperable.publisher;
                  this.form.jISSN = this.paper.paperable.issn;
                  this.form.pISSN = this.paper.paperable.pissn;
                  this.form.pIF = this.paper.paperable.IFactor;
                  this.form.pFIF = this.paper.paperable.FIF;
                  this.form.pJCR = this.paper.paperable.JCR;
                  this.form.pJRK = this.paper.paperable.JRK;
              }else{
                  this.form.conftype_id = this.paper.paperable.conftype_id;
                  this.form.confname = this.paper.paperable.name;
                  this.form.confcity = this.paper.paperable.city;
                  this.form.conforganizer = this.paper.paperable.organizer;
                  this.form.confperiod = this.paper.paperable.period;
              }
                for(var j=0; j<this.paper.authors.length; j++){
                    this.form.authors.push(this.paper.authors[j].name);
                    this.form.affiliations.push(this.paper.authors[j].affiliation);
                    if(this.paper.authors[j].corresponding != '-1'){
                        this.form.isresponsible = this.paper.authors[j].corresponding;
                    }
                }
            },
            // gets the removed tags and pushes it removed tag list *** not used in this page
            onTagRemoved(slug){
                this.form.tagsRemoved.push(slug);
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
            // remove field error from form.errors bag onChange
            removeError(field){
                this.form.errors.clear(field)
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
                this.form.isresponsible = '';
            },
            // sets of the file change type, whether it is addition to previous files or replacement
            fileChange(term){
                this.fileChanging = term;
                if(!term){
                    this.form.files=[];
                }
            },
            createPaper(){
            },
        },
        created(){
            this.$parent.pageName = 'جزئیات مقالات';
            this.$validator.localize('farsi', {
                messages: farsi.messages,
                attributes: {
                    title: 'عنوان مقاله',
                    abstract: 'چکیده مقاله',
                    publish_date: 'تاربخ چاپ',
                    accept_date: 'تاربخ پذیرش',
                    files: 'فایل های ضمیمه',
                    fileChangeType: 'نوع تغییر فایل ها',
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
            this.id = this.$route.params.id;
            this.getpaperdata(this.id);
            this.getPaperRelation();


        },
        components:{
            Select2,
        }

    }
</script>

<style scoped>

</style>
