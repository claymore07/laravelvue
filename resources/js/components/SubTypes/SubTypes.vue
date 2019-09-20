<template>
    <div class="container-fluid">
        <div class="col-md-12 mt-3" v-if="$gate.isAdminOrAuthor()">
            <div class="card card-4">
                <div class="card-header  " style="direction: rtl">
                    <div class="justify-content-around d-lg-flex text-right">
                        <div class="col-lg-7 m-3">
                            <h4 class=" text-right"> <i class="fal fa-boxes ml-2"></i>فهرست عناوین زیر نوع آثار پژوهشی</h4>
                        </div>
                        <div class="col-lg-5 mt-3">


                        </div>


                    </div><!-- /card-tools -->


                </div><!-- /.card-header -->
                <div class="card-body table-responsive p-0">

                    <table class="table table-hover text-right">
                        <tbody>
                        <tr>
                            <th>شماره</th>
                            <th>عنوان</th>

                            <th>ابزارهای ویرایشی</th>
                        </tr>
                        <tr>
                            <td> {{1|faDigit}}</td>
                            <td>  فهرست عناوین کنفرانسی</td>
                            <td>
                                <a class="mr-2" href="#"  @click="perpareConfTypeList">
                                    <i class="fa fa-edit blue"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{2|faDigit}}</td>
                            <td>  فهرست عناوین ژونالی</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="perpareJournalTypeList"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{3|faDigit}}</td>
                            <td>  فهرست عناوین کتب</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="perpareBookTypeList"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{4|faDigit}}</td>
                            <td>  فهرست عناوین پایان نامه</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="perpareThesesTypeList"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{5|faDigit}}</td>
                            <td>  فهرست عناوین کرسی های نظریه پردازی</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="perpareTedTypeList"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{6|faDigit}}</td>
                            <td>  فهرست عناوین داوری</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="perpareRefereeTypeList"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{7|faDigit}}</td>
                            <td>  فهرست عناوین طرح های پژوهشی و فناوری</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="perpareProjectTypeList"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{8|faDigit}}</td>
                            <td>  فهرست عناوین اختراعات و اکتشافات</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="perpareInventionTypeList"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{9|faDigit}}</td>
                            <td>  فهرست فعالیت های اجرایی پژوهشی</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="perpareResearchActivityTypeList"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div><!-- card-body -->
                <div class="card-footer d-flex flex-row justify-content-md-center" style="min-height: 60px">


                </div><!-- /card-footer --->
            </div>
        </div>
        <div v-if="$gate.isAdminOrAuthor()" class="modal  fade" id="confTypeListModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i
                            class="fas fa-building fa-fw"></i> فهرست عناوین کنفرانسی</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" >
                        <div class="text-right text-rtl">
                            <i v-show=" confTypeForm.errors.has('name')" class="red far fa-exclamation-triangle "></i>
                            <span v-show="confTypeForm.errors.has('name')" class="red d-inline-block ">{{ confTypeForm.errors.get('name') }}</span>
                        </div>
                        <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"> نوع کنفرانس</th>
                                <th scope="col">تعداد آثار ثبت شده</th>
                                <th></th>
                                <th scope="col"> ویرایش</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(confType, index) of confTypeList">
                                <th scope="row">{{index+1 | faDigit}}</th>
                                <td class="w-50"><label  v-show="editOffset != index">{{confType.name}}</label>
                                    <input :id = "'item-conftype-'+index" v-show="editOffset == index"  type="text" name="name"
                                           :placeholder="'عنوان زیر نوع'"
                                           class="form-control"
                                           @keyup="removeError('name', 'conftype')"
                                           @keydown.enter.pervent=""
                                           :class="{ 'is-invalid': confTypeForm.errors.has('name') }"
                                           v-model="confTypeForm.name"
                                    >
                                </td>

                                <td style="font-family: IRANSans2, Tahoma, sans-serif">
                                    <span>{{confType.count}}</span>
                                </td>
                                <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateConfType(index)">ثبت تغییرات</button></td>
                                <td>
                                    <a class="" @click="startEditing(index, confType.id, 'conftype')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    /
                                    <a @click="deleteConfType(index,confType.id)" href="#" class="btn btn-link" :class="[confType.count == 0?'':'disabled']" >
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div id="ConfTypeTitleContainer">
                            <div class="form-group mb-3 mt-5  text-right">
                                <label class="blue ">عنوان زیر نوع<i class="red mx-1">*</i>:</label>
                                <input  type="text" name="name"
                                        :placeholder="'عنوان زیر نوع'"
                                        @keydown.enter.pervent=""
                                        class="form-control" v-model="addTitle.name" >
                            </div>
                            <button @click="addConfType" class="btn btn-block btn-info mb-5"><i class="fas fa-user-plus fa-fw"></i> افزودن زیر عنوان</button>
                        </div>
                    </div><!-- modal-body -->
                    <div class="modal-footer">

                    </div>

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->
        <div v-if="$gate.isAdminOrAuthor()" class="modal  fade" id="journalTypeListModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2"><i
                            class="fas fa-building fa-fw"></i> فهرست عناوین ژونالی</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" >
                        <div class="text-right text-rtl">
                            <i v-show=" jTypeForm.errors.has('name')" class="red far fa-exclamation-triangle "></i>
                            <span v-show="jTypeForm.errors.has('name')" class="red d-inline-block ">{{ jTypeForm.errors.get('name') }}</span>
                        </div>
                        <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"> نوع ژونال</th>
                                <th scope="col">تعداد آثار ثبت شده</th>
                                <th></th>
                                <th scope="col"> ویرایش</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(jType, index) of journalTypeList">
                                <th scope="row">{{index+1 | faDigit}}</th>
                                <td class="w-50"><label  v-show="editOffset != index">{{jType.name}}</label>
                                    <input :id = "'item-jType-'+index" v-show="editOffset == index"  type="text" name="name"
                                           :placeholder="'عنوان زیر نوع'"
                                           class="form-control"
                                           @keyup="removeError('name', 'jType')"
                                           @keydown.enter.pervent=""
                                           :class="{ 'is-invalid': jTypeForm.errors.has('name') }"
                                           v-model="jTypeForm.name"
                                    >
                                </td>

                                <td style="font-family: IRANSans2, Tahoma, sans-serif">
                                    <span>{{jType.count}}</span>
                                </td>
                                <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateJType(index)">ثبت تغییرات</button></td>
                                <td>
                                    <a class="" @click="startEditing(index, jType.id, 'jType')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    /
                                    <a @click="deleteJType(index,jType.id)" href="#" class="btn btn-link" :class="[jType.count == 0?'':'disabled']" >
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div id="jTypeTitleContainer">
                            <div class="form-group mb-3 mt-5  text-right">
                                <label class="blue ">عنوان زیر نوع<i class="red mx-1">*</i>:</label>
                                <input  type="text" name="name"
                                        :placeholder="'عنوان زیر نوع'"
                                        @keydown.enter.pervent=""
                                        class="form-control" v-model="addTitle.name" >
                            </div>
                            <button @click="addJType" class="btn btn-block btn-info mb-5"><i class="fas fa-user-plus fa-fw"></i> افزودن زیر عنوان</button>
                        </div>
                    </div><!-- modal-body -->
                    <div class="modal-footer">

                    </div>

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->
        <div v-if="$gate.isAdminOrAuthor()" class="modal  fade" id="bookTypeListModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel3"><i
                            class="fas fa-building fa-fw"></i> فهرست عناوین کتب</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" >
                        <div class="text-right text-rtl">
                            <i v-show="bookTypeForm.errors.has('name')" class="red far fa-exclamation-triangle "></i>
                            <span v-show="bookTypeForm.errors.has('name')" class="red d-inline-block ">{{ bookTypeForm.errors.get('name') }}</span>
                        </div>
                        <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"> نوع کتاب</th>
                                <th scope="col">تعداد آثار ثبت شده</th>
                                <th></th>
                                <th scope="col"> ویرایش</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(bookType, index) of bookTypeList">
                                <th scope="row">{{index+1 | faDigit}}</th>
                                <td class="w-50"><label  v-show="editOffset != index">{{bookType.name}}</label>
                                    <input :id = "'item-bookType-'+index" v-show="editOffset == index"  type="text" name="name"
                                           :placeholder="'عنوان زیر نوع'"
                                           class="form-control"
                                           @keyup="removeError('name', 'bookType')"
                                           @keydown.enter.pervent=""
                                           :class="{ 'is-invalid': bookTypeForm.errors.has('name') }"
                                           v-model="bookTypeForm.name"
                                    >
                                </td>

                                <td style="font-family: IRANSans2, Tahoma, sans-serif">
                                    <span>{{bookType.count}}</span>
                                </td>
                                <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateBookType(index)">ثبت تغییرات</button></td>
                                <td>
                                    <a class="" @click="startEditing(index, bookType.id, 'bookType')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    /
                                    <a @click="deleteBookType(index,bookType.id)" href="#" class="btn btn-link" :class="[bookType.count == 0?'':'disabled']" >
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div id="bookTypeTitleContainer">
                            <div class="form-group mb-3 mt-5  text-right">
                                <label class="blue ">عنوان زیر نوع<i class="red mx-1">*</i>:</label>
                                <input  type="text" name="name"
                                        :placeholder="'عنوان زیر نوع'"
                                        @keydown.enter.pervent=""
                                        class="form-control" v-model="addTitle.name" >
                            </div>
                            <button @click="addBookType" class="btn btn-block btn-info mb-5"><i class="fas fa-user-plus fa-fw"></i> افزودن زیر عنوان</button>
                        </div>
                    </div><!-- modal-body -->
                    <div class="modal-footer">

                    </div>

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->
        <div v-if="$gate.isAdminOrAuthor()" class="modal  fade" id="ThesisTypeListModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel4"><i
                            class="fas fa-building fa-fw"></i> فهرست عناوین پایان نامه</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" >
                        <div class="text-right text-rtl">
                            <i v-show="thesesTypeForm.errors.has('name')" class="red far fa-exclamation-triangle "></i>
                            <span v-show="thesesTypeForm.errors.has('name')" class="red d-inline-block ">{{ thesesTypeForm.errors.get('name') }}</span>
                        </div>
                        <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"> نوع پایان نامه</th>
                                <th scope="col">تعداد آثار ثبت شده</th>
                                <th></th>
                                <th scope="col"> ویرایش</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(thesesType, index) of thesesTypeList">
                                <th scope="row">{{index+1 | faDigit}}</th>
                                <td class="w-50"><label  v-show="editOffset != index">{{thesesType.name}}</label>
                                    <input :id = "'item-thesesType-'+index" v-show="editOffset == index"  type="text" name="name"
                                           :placeholder="'عنوان زیر نوع'"
                                           class="form-control"
                                           @keyup="removeError('name', 'thesesType')"
                                           @keydown.enter.pervent=""
                                           :class="{ 'is-invalid': thesesTypeForm.errors.has('name') }"
                                           v-model="thesesTypeForm.name"
                                    >
                                </td>

                                <td style="font-family: IRANSans2, Tahoma, sans-serif">
                                    <span>{{thesesType.count}}</span>
                                </td>
                                <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateThesesType(index)">ثبت تغییرات</button></td>
                                <td>
                                    <a class="" @click="startEditing(index, thesesType.id, 'thesesType')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    /
                                    <a @click="deleteThesesType(index,thesesType.id)" href="#" class="btn btn-link" :class="[thesesType.count == 0?'':'disabled']" >
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div id="thesesTypeTitleContainer">
                            <div class="form-group mb-3 mt-5  text-right">
                                <label class="blue ">عنوان زیر نوع<i class="red mx-1">*</i>:</label>
                                <input  type="text" name="name"
                                        :placeholder="'عنوان زیر نوع'"
                                        @keydown.enter.pervent=""
                                        class="form-control" v-model="addTitle.name" >
                            </div>
                            <button @click="addThesesType" class="btn btn-block btn-info mb-5"><i class="fas fa-user-plus fa-fw"></i> افزودن زیر عنوان</button>
                        </div>
                    </div><!-- modal-body -->
                    <div class="modal-footer">

                    </div>

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->
        <div v-if="$gate.isAdminOrAuthor()" class="modal  fade" id="TedTypeListModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel5"><i
                            class="fas fa-building fa-fw"></i> فهرست عناوین کرسی های نظریه پردازی</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" >
                        <div class="text-right text-rtl">
                            <i v-show="tedTypeForm.errors.has('name')" class="red far fa-exclamation-triangle "></i>
                            <span v-show="tedTypeForm.errors.has('name')" class="red d-inline-block ">{{ tedTypeForm.errors.get('name') }}</span>
                        </div>
                        <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"> نوع کرسی</th>
                                <th scope="col">تعداد آثار ثبت شده</th>
                                <th></th>
                                <th scope="col"> ویرایش</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(tedType, index) of tedTypeList">
                                <th scope="row">{{index+1 | faDigit}}</th>
                                <td class="w-50"><label  v-show="editOffset != index">{{tedType.name}}</label>
                                    <input :id = "'item-tedType-'+index" v-show="editOffset == index"  type="text" name="name"
                                           :placeholder="'عنوان زیر نوع'"
                                           class="form-control"
                                           @keyup="removeError('name', 'tedType')"
                                           @keydown.enter.pervent=""
                                           :class="{ 'is-invalid': tedTypeForm.errors.has('name') }"
                                           v-model="tedTypeForm.name"
                                    >
                                </td>

                                <td style="font-family: IRANSans2, Tahoma, sans-serif">
                                    <span>{{tedType.count}}</span>
                                </td>
                                <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateTedType(index)">ثبت تغییرات</button></td>
                                <td>
                                    <a class="" @click="startEditing(index, tedType.id, 'tedType')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    /
                                    <a @click="deleteTedType(index,tedType.id)" href="#" class="btn btn-link" :class="[tedType.count == 0?'':'disabled']" >
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div id="tedTypeTitleContainer">
                            <div class="form-group mb-3 mt-5  text-right">
                                <label class="blue ">عنوان زیر نوع<i class="red mx-1">*</i>:</label>
                                <input  type="text" name="name"
                                        :placeholder="'عنوان زیر نوع'"
                                        @keydown.enter.pervent=""
                                        class="form-control" v-model="addTitle.name" >
                            </div>
                            <button @click="addTedType" class="btn btn-block btn-info mb-5"><i class="fas fa-user-plus fa-fw"></i> افزودن زیر عنوان</button>
                        </div>
                    </div><!-- modal-body -->
                    <div class="modal-footer">

                    </div>

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->
        <div v-if="$gate.isAdminOrAuthor()" class="modal  fade" id="RefereeTypeListModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel6"><i
                            class="fas fa-building fa-fw"></i>فهرست عناوین داوری</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" >
                        <div class="text-right text-rtl">
                            <i v-show="refereeTypeForm.errors.has('name')" class="red far fa-exclamation-triangle "></i>
                            <span v-show="refereeTypeForm.errors.has('name')" class="red d-inline-block ">{{ refereeTypeForm.errors.get('name') }}</span>
                        </div>
                        <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"> نوع داوری</th>
                                <th scope="col">تعداد آثار ثبت شده</th>
                                <th></th>
                                <th scope="col"> ویرایش</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(refereeType, index) of refereeTypeList">
                                <th scope="row">{{index+1 | faDigit}}</th>
                                <td class="w-50"><label  v-show="editOffset != index">{{refereeType.name}}</label>
                                    <input :id = "'item-refereeType-'+index" v-show="editOffset == index"  type="text" name="name"
                                           :placeholder="'عنوان زیر نوع'"
                                           class="form-control"
                                           @keyup="removeError('name', 'refereeType')"
                                           @keydown.enter.pervent=""
                                           :class="{ 'is-invalid': refereeTypeForm.errors.has('name') }"
                                           v-model="refereeTypeForm.name"
                                    >
                                </td>

                                <td style="font-family: IRANSans2, Tahoma, sans-serif">
                                    <span>{{refereeType.count}}</span>
                                </td>
                                <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateRefereeType(index)">ثبت تغییرات</button></td>
                                <td>
                                    <a class="" @click="startEditing(index, refereeType.id, 'refereeType')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    /
                                    <a @click="deleteRefereeType(index,refereeType.id)" href="#" class="btn btn-link" :class="[refereeType.count == 0?'':'disabled']" >
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div id="refereeTypeTitleContainer">
                            <div class="form-group mb-3 mt-5  text-right">
                                <label class="blue ">عنوان زیر نوع<i class="red mx-1">*</i>:</label>
                                <input  type="text" name="name"
                                        :placeholder="'عنوان زیر نوع'"
                                        @keydown.enter.pervent=""
                                        class="form-control" v-model="addTitle.name" >
                            </div>
                            <button @click="addRefereeType" class="btn btn-block btn-info mb-5"><i class="fas fa-user-plus fa-fw"></i> افزودن زیر عنوان</button>
                        </div>
                    </div><!-- modal-body -->
                    <div class="modal-footer">

                    </div>

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->
        <div v-if="$gate.isAdminOrAuthor()" class="modal  fade" id="ProjectTypeListModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel7"><i
                            class="fas fa-building fa-fw"></i>فهرست عناوین طرح های پژوهشی و فناوری</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" >
                        <div class="text-right text-rtl">
                            <i v-show="projectTypeForm.errors.has('name')" class="red far fa-exclamation-triangle "></i>
                            <span v-show="projectTypeForm.errors.has('name')" class="red d-inline-block ">{{ projectTypeForm.errors.get('name') }}</span>
                        </div>
                        <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"> نوع طرح پژوهشی</th>
                                <th scope="col">تعداد آثار ثبت شده</th>
                                <th></th>
                                <th scope="col"> ویرایش</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(projectType, index) of projectTypeList">
                                <th scope="row">{{index+1 | faDigit}}</th>
                                <td class="w-50"><label  v-show="editOffset != index">{{projectType.name}}</label>
                                    <input :id = "'item-projectType-'+index" v-show="editOffset == index"  type="text" name="name"
                                           :placeholder="'عنوان زیر نوع'"
                                           class="form-control"
                                           @keyup="removeError('name', 'projectType')"
                                           @keydown.enter.pervent=""
                                           :class="{ 'is-invalid': projectTypeForm.errors.has('name') }"
                                           v-model="projectTypeForm.name"
                                    >
                                </td>

                                <td style="font-family: IRANSans2, Tahoma, sans-serif">
                                    <span>{{projectType.count}}</span>
                                </td>
                                <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateProjectType(index)">ثبت تغییرات</button></td>
                                <td>
                                    <a class="" @click="startEditing(index, projectType.id, 'projectType')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    /
                                    <a @click="deleteProjectType(index,projectType.id)" href="#" class="btn btn-link" :class="[projectType.count == 0?'':'disabled']" >
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div id="projectTypeTitleContainer">
                            <div class="form-group mb-3 mt-5  text-right">
                                <label class="blue ">عنوان زیر نوع<i class="red mx-1">*</i>:</label>
                                <input  type="text" name="name"
                                        :placeholder="'عنوان زیر نوع'"
                                        @keydown.enter.pervent=""
                                        class="form-control" v-model="addTitle.name" >
                            </div>
                            <button @click="addProjectType" class="btn btn-block btn-info mb-5"><i class="fas fa-user-plus fa-fw"></i> افزودن زیر عنوان</button>
                        </div>

                    </div><!-- modal-body -->
                    <div class="modal-footer">

                    </div>

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->
        <div v-if="$gate.isAdminOrAuthor()" class="modal  fade" id="InventionTypeListModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel8"><i
                            class="fas fa-building fa-fw"></i>فهرست عناوین اختراعات و اکتشافات</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" >
                        <div class="text-right text-rtl">
                            <i v-show="inventionTypeForm.errors.has('name')" class="red far fa-exclamation-triangle "></i>
                            <span v-show="inventionTypeForm.errors.has('name')" class="red d-inline-block ">{{ inventionTypeForm.errors.get('name') }}</span>
                        </div>
                        <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"> نوع طرح اختراع</th>
                                <th scope="col">تعداد آثار ثبت شده</th>
                                <th></th>
                                <th scope="col"> ویرایش</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(inventionType, index) of inventionTypeList">
                                <th scope="row">{{index+1 | faDigit}}</th>
                                <td class="w-50"><label  v-show="editOffset != index">{{inventionType.name}}</label>
                                    <input :id = "'item-inventionType-'+index" v-show="editOffset == index"  type="text" name="name"
                                           :placeholder="'عنوان زیر نوع'"
                                           class="form-control"
                                           @keyup="removeError('name', 'inventionType')"
                                           @keydown.enter.pervent=""
                                           :class="{ 'is-invalid': inventionTypeForm.errors.has('name') }"
                                           v-model="inventionTypeForm.name"
                                    >
                                </td>

                                <td style="font-family: IRANSans2, Tahoma, sans-serif">
                                    <span>{{inventionType.count}}</span>
                                </td>
                                <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateInventionType(index)">ثبت تغییرات</button></td>
                                <td>
                                    <a class="" @click="startEditing(index, inventionType.id, 'inventionType')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    /
                                    <a @click="deleteInventionType(index,inventionType.id)" href="#" class="btn btn-link" :class="[inventionType.count == 0?'':'disabled']" >
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div id="inventionTypeTitleContainer">
                            <div class="form-group mb-3 mt-5  text-right">
                                <label class="blue ">عنوان زیر نوع<i class="red mx-1">*</i>:</label>
                                <input  type="text" name="name"
                                        :placeholder="'عنوان زیر نوع'"
                                        @keydown.enter.pervent=""
                                        class="form-control" v-model="addTitle.name" >
                            </div>
                            <button @click="addInventionType" class="btn btn-block btn-info mb-5"><i class="fas fa-user-plus fa-fw"></i> افزودن زیر عنوان</button>
                        </div>
                    </div><!-- modal-body -->
                    <div class="modal-footer">

                    </div>

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div>
        <div v-if="$gate.isAdminOrAuthor()" class="modal  fade" id="researchActivityTypeListModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel111"><i
                            class="fas fa-building fa-fw"></i>فهرست عناوین فعالیت های اجرایی پژوهشی</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" >
                        <div class="text-right text-rtl">
                            <i v-show="researchActivityTypeForm.errors.has('name')" class="red far fa-exclamation-triangle "></i>
                            <span v-show="researchActivityTypeForm.errors.has('name')" class="red d-inline-block ">{{ researchActivityTypeForm.errors.get('name') }}</span>
                        </div>
                        <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"> نوع طرح فعالیت</th>
                                <th scope="col">تعداد آثار ثبت شده</th>
                                <th></th>
                                <th scope="col"> ویرایش</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(researchActivityType, index) of researchActivityTypeList">
                                <th scope="row">{{index+1 | faDigit}}</th>
                                <td class="w-50"><label  v-show="editOffset != index">{{researchActivityType.name}}</label>
                                    <input :id = "'item-researchActivityType-'+index" v-show="editOffset == index"  type="text" name="name"
                                           :placeholder="'عنوان زیر نوع'"
                                           class="form-control"
                                           @keyup="removeError('name', 'researchActivityType')"
                                           @keydown.enter.pervent=""
                                           :class="{ 'is-invalid': researchActivityTypeForm.errors.has('name') }"
                                           v-model="researchActivityTypeForm.name"
                                    >
                                </td>

                                <td style="font-family: IRANSans2, Tahoma, sans-serif">
                                    <span>{{researchActivityType.count}}</span>
                                </td>
                                <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateResearchActivityType(index)">ثبت تغییرات</button></td>
                                <td>
                                    <a class="" @click="startEditing(index, researchActivityType.id, 'researchActivityType')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    /
                                    <a @click="deleteResearchActivityType(index,researchActivityType.id)" href="#" class="btn btn-link" :class="[researchActivityType.count == 0?'':'disabled']" >
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div id="researchActivityTypeTitleContainer">
                            <div class="form-group mb-3 mt-5  text-right">
                                <label class="blue ">عنوان زیر نوع<i class="red mx-1">*</i>:</label>
                                <input  type="text" name="name"
                                        :placeholder="'عنوان زیر نوع'"
                                        @keydown.enter.pervent=""
                                        class="form-control" v-model="addTitle.name" >
                            </div>
                            <button @click="addResearchActivityType" class="btn btn-block btn-info mb-5"><i class="fas fa-user-plus fa-fw"></i> افزودن زیر عنوان</button>
                        </div>
                    </div><!-- modal-body -->
                    <div class="modal-footer">

                    </div>

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->
        <div v-if="!$gate.isAdminOrAuthor()">
            <not-found></not-found>
        </div><!-- /404 page -->
    </div>
</template>

<script>
    export default {
        name: "SubTypes",
        data(){
            return{

                confTypeList:{},
                bookTypeList:{},
                journalTypeList:{},
                thesesTypeList:{},
                tedTypeList:{},
                refereeTypeList:{},
                projectTypeList:{},
                inventionTypeList:{},
                researchActivityTypeList:{},

                editOffset: -1,     // for managing author editing form status used if -1 the form will be hide
                addTitle: new Form({
                    name:'',
                }),
                confTypeForm: new Form({
                    id:'',
                    name:'',
                }),
                jTypeForm: new Form({
                    id:'',
                    name:'',
                }),
                bookTypeForm: new Form({
                    id:'',
                    name:'',
                }),
                thesesTypeForm: new Form({
                    id:'',
                    name:'',
                }),
                tedTypeForm: new Form({
                    id:'',
                    name:'',
                }),
                refereeTypeForm: new Form({
                    id:'',
                    name:'',
                }),
                projectTypeForm: new Form({
                    id:'',
                    name:'',
                }),
                inventionTypeForm: new Form({
                    id:'',
                    name:'',
                }),

                researchActivityTypeForm: new Form({
                    id:'',
                    name:'',
                }),
            }
        },
        methods:{
            nothing(){},
            perpareJournalTypeList(){
                let loader1 = Vue.$loading.show();
                axios.get('/api/getJournalTypes').then((response)=>{
                    loader1.hide();
                    this.journalTypeList = response.data.journalTypeList;
                    this.editOffset = -1;
                    $('#journalTypeListModal').modal('show');
                }).catch(()=>{
                    loader1.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            perpareConfTypeList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getConfTypes').then((response)=>{
                    loader.hide();
                    this.confTypeList = response.data.confTypeList;
                    this.editOffset = -1;
                    $('#confTypeListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            perpareBookTypeList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getBookTypes').then((response)=>{
                    loader.hide();
                    this.bookTypeList = response.data.bookTypeList;
                    this.editOffset = -1;
                    $('#bookTypeListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            perpareThesesTypeList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getThesesTypes').then((response)=>{
                    loader.hide();
                    this.thesesTypeList = response.data.thesesTypeList;
                    this.editOffset = -1;
                    $('#ThesisTypeListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            perpareTedTypeList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getTEDTypes').then((response)=>{
                    loader.hide();
                    this.tedTypeList = response.data.tedTypeList;
                    this.editOffset = -1;
                    $('#TedTypeListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            perpareRefereeTypeList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getRefereeTypes').then((response)=>{
                    loader.hide();
                    this.refereeTypeList = response.data.refereeTypeList;
                    this.editOffset = -1;
                    $('#RefereeTypeListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            perpareProjectTypeList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getProjectTypes').then((response)=>{
                    loader.hide();
                    this.projectTypeList = response.data.projectTypeList;
                    this.editOffset = -1;
                    $('#ProjectTypeListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            perpareInventionTypeList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getInventionTypes').then((response)=>{
                    loader.hide();
                    this.inventionTypeList = response.data.inventionTypeList;
                    this.editOffset = -1;
                    $('#InventionTypeListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },

            perpareResearchActivityTypeList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getResearchActivityTypes').then((response)=>{
                    loader.hide();
                    this.researchActivityTypeList = response.data.researchActivityTypeList;
                    this.editOffset = -1;
                    $('#researchActivityTypeListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            // enables author editing form
            startEditing(index, id, type){
                this.editOffset = index;
                if(type == "conftype"){
                    this.confTypeForm.fill(this.confTypeList[index]);
                    this.$nextTick(function(){
                        document.getElementById('item-'+type+'-'+this.editOffset).focus()
                    }.bind(this));
                }else if(type == "jType"){
                    this.jTypeForm.fill(this.journalTypeList[index]);
                    this.$nextTick(function(){
                        document.getElementById('item-'+type+'-'+this.editOffset).focus()
                    }.bind(this));
                }else if(type == "bookType"){
                    this.bookTypeForm.fill(this.bookTypeList[index]);
                    this.$nextTick(function(){
                        document.getElementById('item-'+type+'-'+this.editOffset).focus()
                    }.bind(this));
                }else if(type == "thesesType"){
                    this.thesesTypeForm.fill(this.thesesTypeList[index]);
                    this.$nextTick(function(){
                        document.getElementById('item-'+type+'-'+this.editOffset).focus()
                    }.bind(this));
                }else if(type == "tedType"){
                    this.tedTypeForm.fill(this.tedTypeList[index]);
                    this.$nextTick(function(){
                        document.getElementById('item-'+type+'-'+this.editOffset).focus()
                    }.bind(this));
                }else if(type == "refereeType"){
                    this.refereeTypeForm.fill(this.refereeTypeList[index]);
                    this.$nextTick(function(){
                        document.getElementById('item-'+type+'-'+this.editOffset).focus()
                    }.bind(this));
                }else if(type == "projectType"){
                    this.projectTypeForm.fill(this.projectTypeList[index]);
                    this.$nextTick(function(){
                        document.getElementById('item-'+type+'-'+this.editOffset).focus()
                    }.bind(this));
                }else if(type == "inventionType"){
                    this.inventionTypeForm.fill(this.inventionTypeList[index]);
                    this.$nextTick(function(){
                        document.getElementById('item-'+type+'-'+this.editOffset).focus()
                    }.bind(this));
                }else if(type == "researchActivityType"){
                    this.researchActivityTypeForm.fill(this.researchActivityTypeList[index]);
                    this.$nextTick(function(){
                        document.getElementById('item-'+type+'-'+this.editOffset).focus()
                    }.bind(this));
                }
            },

            isIntOrFloat(n){
                return (Number(n) === n && n % 1 === 0) || (Number(n) === n && n % 1 !== 0);
            },

            updateConfType(index) {
                this.confTypeForm.put('/api/updateConfTypeTitle/' + this.confTypeForm.id)
                    .then((response) => {
                        this.confTypeList[index]['name'] = response.data.name;
                        this.successToast('اطلاعات زیر عنوان با موفقیت بروزرسانی شد.');
                        this.confTypeForm.reset();
                        this.editOffset = -1;
                    }).catch(() => {
                    this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                });
            },
            deleteConfType(index, id) {
                swal({
                    title: 'آیا از حذف زیر نوع مورد نظر مطمئن هستید؟',
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
                        this.confTypeForm.delete('/api/deleteConfTypeTitle/' + id)
                            .then((response) => {
                                this.confTypeList.splice(index,1);
                                this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                            }).catch(() => {
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        });
                    } else {
                        this.warningSwal('شما این عملیات را لغو کردید.');
                    }
                })

            },
            addConfType() {
                if(this.addTitle.name.trim()) {
                    this.addTitle.post('/api/addConfTypeTitle')
                        .then((response) => {
                            this.confTypeList.push(response.data);
                            this.addTitle.reset();
                            this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                    });
                }
            },

            updateJType(index) {
                this.jTypeForm.put('/api/updateJTypeTitle/' + this.jTypeForm.id)
                    .then((response) => {
                        this.journalTypeList[index]['name'] = response.data.name;
                        this.successToast('اطلاعات زیر عنوان با موفقیت بروزرسانی شد.');
                        this.jTypeForm.reset();
                        this.editOffset = -1;
                    }).catch(() => {
                    this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                });
            },
            deleteJType(index, id) {
                swal({
                    title: 'آیا از حذف زیر نوع مورد نظر مطمئن هستید؟',
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
                        this.jTypeForm.delete('/api/deleteJTypeTitle/' + id)
                            .then((response) => {
                                this.journalTypeList.splice(index,1);
                                this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                            }).catch(() => {
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        });
                    } else {
                        this.warningSwal('شما این عملیات را لغو کردید.');
                    }
                })
            },
            addJType() {
                if(this.addTitle.name.trim()) {
                    this.addTitle.post('/api/addJTypeTitle')
                        .then((response) => {
                            this.journalTypeList.push(response.data);
                            this.addTitle.reset();
                            this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                    });
                }
            },
            updateBookType(index) {
                this.bookTypeForm.put('/api/updateBookTypeTitle/' + this.bookTypeForm.id)
                    .then((response) => {
                        this.bookTypeList[index]['name'] = response.data.name;
                        this.successToast('اطلاعات زیر عنوان با موفقیت بروزرسانی شد.');
                        this.bookTypeForm.reset();
                        this.editOffset = -1;
                    }).catch(() => {
                    this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                });
            },
            deleteBookType(index, id) {
                swal({
                    title: 'آیا از حذف زیر نوع مورد نظر مطمئن هستید؟',
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
                        this.bookTypeForm.delete('/api/deleteBookTypeTitle/' + id)
                            .then((response) => {
                                this.bookTypeList.splice(index,1);
                                this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                            }).catch(() => {
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        });
                    } else {
                        this.warningSwal('شما این عملیات را لغو کردید.');
                    }
                })
            },
            addBookType() {
                if(this.addTitle.name.trim()) {
                    this.addTitle.post('/api/addBookTypeTitle')
                        .then((response) => {
                            this.bookTypeList.push(response.data);
                            this.addTitle.reset();
                            this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                    });
                }
            },

            updateThesesType(index) {
                this.thesesTypeForm.put('/api/updateThesesTypeTitle/' + this.thesesTypeForm.id)
                    .then((response) => {
                        this.thesesTypeList[index]['name'] = response.data.name;
                        this.successToast('اطلاعات زیر عنوان با موفقیت بروزرسانی شد.');
                        this.thesesTypeForm.reset();
                        this.editOffset = -1;
                    }).catch(() => {
                    this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                });
            },
            deleteThesesType(index, id) {
                swal({
                    title: 'آیا از حذف زیر نوع مورد نظر مطمئن هستید؟',
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
                        this.thesesTypeForm.delete('/api/deleteThesesTypeTitle/' + id)
                            .then((response) => {
                                this.thesesTypeList.splice(index,1);
                                this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                            }).catch(() => {
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        });
                    } else {
                        this.warningSwal('شما این عملیات را لغو کردید.');
                    }
                })
            },
            addThesesType() {
                if(this.addTitle.name.trim()) {
                    this.addTitle.post('/api/addThesesTypeTitle')
                        .then((response) => {
                            this.thesesTypeList.push(response.data);
                            this.addTitle.reset();
                            this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                    });
                }
            },

            updateTedType(index) {
                this.tedTypeForm.put('/api/updateTEDTypeTitle/' + this.tedTypeForm.id)
                    .then((response) => {
                        this.tedTypeList[index]['name'] = response.data.name;
                        this.successToast('اطلاعات زیر عنوان با موفقیت بروزرسانی شد.');
                        this.tedTypeForm.reset();
                        this.editOffset = -1;
                    }).catch(() => {
                    this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                });
            },
            deleteTedType(index, id) {
                swal({
                    title: 'آیا از حذف زیر نوع مورد نظر مطمئن هستید؟',
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
                        this.tedTypeForm.delete('/api/deleteTEDTypeTitle/' + id)
                            .then((response) => {
                                this.tedTypeList.splice(index,1);
                                this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                            }).catch(() => {
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        });
                    } else {
                        this.warningSwal('شما این عملیات را لغو کردید.');
                    }
                })
            },
            addTedType() {
                if(this.addTitle.name.trim()) {
                    this.addTitle.post('/api/addTEDTypeTitle')
                        .then((response) => {
                            this.tedTypeList.push(response.data);
                            this.addTitle.reset();
                            this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                    });
                }
            },

            updateRefereeType(index) {
                this.refereeTypeForm.put('/api/updateRefereeTypeTitle/' + this.refereeTypeForm.id)
                    .then((response) => {
                        this.refereeTypeList[index]['name'] = response.data.name;
                        this.successToast('اطلاعات زیر عنوان با موفقیت بروزرسانی شد.');
                        this.refereeTypeForm.reset();
                        this.editOffset = -1;
                    }).catch(() => {
                    this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                });
            },
            deleteRefereeType(index, id) {
                swal({
                    title: 'آیا از حذف زیر نوع مورد نظر مطمئن هستید؟',
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
                        this.refereeTypeForm.delete('/api/deleteRefereeTypeTitle/' + id)
                            .then((response) => {
                                this.refereeTypeList.splice(index,1);
                                this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                            }).catch(() => {
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        });
                    } else {
                        this.warningSwal('شما این عملیات را لغو کردید.');
                    }
                })
            },
            addRefereeType() {
                if(this.addTitle.name.trim()) {
                    this.addTitle.post('/api/addRefereeTypeTitle')
                        .then((response) => {
                            this.refereeTypeList.push(response.data);
                            this.addTitle.reset();
                            this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                    });
                }
            },

            updateProjectType(index) {
                this.projectTypeForm.put('/api/updateProjectTypeTitle/' + this.projectTypeForm.id)
                    .then((response) => {
                        this.projectTypeList[index]['name'] = response.data.name;
                        this.successToast('اطلاعات زیر عنوان با موفقیت بروزرسانی شد.');
                        this.projectTypeForm.reset();
                        this.editOffset = -1;
                    }).catch(() => {
                    this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                });
            },
            deleteProjectType(index, id) {
                swal({
                    title: 'آیا از حذف زیر نوع مورد نظر مطمئن هستید؟',
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
                        this.projectTypeForm.delete('/api/deleteProjectTypeTitle/' + id)
                            .then((response) => {
                                this.projectTypeList.splice(index,1);
                                this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                            }).catch(() => {
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        });
                    } else {
                        this.warningSwal('شما این عملیات را لغو کردید.');
                    }
                })
            },
            addProjectType() {
                if(this.addTitle.name.trim()) {
                    this.addTitle.post('/api/addProjectTypeTitle')
                        .then((response) => {
                            this.projectTypeList.push(response.data);
                            this.addTitle.reset();
                            this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                    });
                }
            },

            updateInventionType(index) {
                this.inventionTypeForm.put('/api/updateInventionTypeTitle/' + this.inventionTypeForm.id)
                    .then((response) => {
                        this.inventionTypeList[index]['name'] = response.data.name;
                        this.successToast('اطلاعات زیر عنوان با موفقیت بروزرسانی شد.');
                        this.inventionTypeForm.reset();
                        this.editOffset = -1;
                    }).catch(() => {
                    this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                });
            },
            deleteInventionType(index, id) {
                swal({
                    title: 'آیا از حذف زیر نوع مورد نظر مطمئن هستید؟',
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
                        this.inventionTypeForm.delete('/api/deleteInventionTypeTitle/' + id)
                            .then((response) => {
                                this.inventionTypeList.splice(index,1);
                                this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                            }).catch(() => {
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        });
                    } else {
                        this.warningSwal('شما این عملیات را لغو کردید.');
                    }
                })
            },
            addInventionType() {
                if(this.addTitle.name.trim()) {
                    this.addTitle.post('/api/addInventionTypeTitle')
                        .then((response) => {
                            this.inventionTypeList.push(response.data);
                            this.addTitle.reset();
                            this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                    });
                }
            },


            updateResearchActivityType(index) {
                this.researchActivityTypeForm.put('/api/updateResearchActivityTypeTitle/' + this.researchActivityTypeForm.id)
                    .then((response) => {
                        this.researchActivityTypeList[index]['name'] = response.data.name;
                        this.successToast('اطلاعات زیر عنوان با موفقیت بروزرسانی شد.');
                        this.researchActivityTypeForm.reset();
                        this.editOffset = -1;
                    }).catch(() => {
                    this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                });
            },
            deleteResearchActivityType(index, id) {
                swal({
                    title: 'آیا از حذف زیر نوع مورد نظر مطمئن هستید؟',
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
                        this.researchActivityTypeForm.delete('/api/deleteResearchActivityTypeTitle/' + id)
                            .then((response) => {
                                this.researchActivityTypeList.splice(index,1);
                                this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                            }).catch(() => {
                            this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        });
                    } else {
                        this.warningSwal('شما این عملیات را لغو کردید.');
                    }
                })
            },
            addResearchActivityType() {
                if(this.addTitle.name.trim()) {
                    this.addTitle.post('/api/addResearchActivityTypeTitle')
                        .then((response) => {
                            this.researchActivityTypeList.push(response.data);
                            this.addTitle.reset();
                            this.successToast('اطلاعات زیر عنوان با موفقیت حذف شد.');
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                    });
                }
            },

            removeError(field, type){
                if(type == "conftype") {
                    this.confTypeForm.errors.clear(field)
                }else if(type == "jType"){
                    this.jTypeForm.errors.clear(field)
                }else if(type == "bookType"){
                    this.bookTypeForm.errors.clear(field)
                }else if(type == "thesesType"){
                    this.thesesTypeForm.errors.clear(field)
                }else if(type == "tedType"){
                    this.tedTypeForm.errors.clear(field)
                }else if(type == "refereeType"){
                    this.refereeTypeForm.errors.clear(field)
                }else if(type == "projectType"){
                    this.projectTypeForm.errors.clear(field)
                }else if(type == "inventionType"){
                    this.inventionTypeForm.errors.clear(field)
                }else if(type == "reseachActivityType"){
                    this.reseachActivityType.errors.clear(field)
                }
            },
        },
        computed:{

        },

        mounted(){
            $('.Form').html5cvm({
                generic: 'این گزینه باید تکمیل شود!',
                typeMismatch: "نوع داده ورودی همخوانی ندارد."
            });
        },
        created(){
            this.$parent.pageName = 'مدیریت امتیازات'
            swal.fire({
                title: 'توجه!!',
                text: 'اطلاعات این بخش دارای حساسیت بالایی می باشد و در صورت عدم دقت می تواند صحت کل اطلاعات سامانه را از بین ببرد!',
                type: 'warning',
                focusConfirm: true,
                confirmButtonText: 'متوجه شدم!',
            });
        },
        component:{

        }
    }
</script>

<style scoped>

</style>



