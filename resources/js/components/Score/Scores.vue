<template>
    <div class="container-fluid">
        <div class="col-md-12 mt-3" v-if="$gate.isAdminOrAuthor()">
            <div class="card card-4">
                <div class="card-header  " style="direction: rtl">
                    <div class="justify-content-around d-lg-flex text-right">
                        <div class="col-lg-7 m-3">
                            <h4 class=" text-right"> <i class="fal fa-star ml-2"></i>فهرست عناوین شامل امتیاز</h4>
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
                                <a class="mr-2" href="#"  @click="prepareConfTypeList">
                                    <i class="fa fa-edit blue"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{2|faDigit}}</td>
                            <td>  فهرست عناوین ژونالی</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareJournalTypeList"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{3|faDigit}}</td>
                            <td>  فهرست عناوین کتب</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareBookTypeList"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{4|faDigit}}</td>
                            <td>  فهرست عناوین پایان نامه</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareThesesTypeList"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{5|faDigit}}</td>
                            <td>  فهرست عناوین کرسی های نظریه پردازی</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareTedTypeList"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{6|faDigit}}</td>
                            <td>  فهرست عناوین داوری</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareRefereeTypeList"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{7|faDigit}}</td>
                            <td>  فهرست عناوین طرح های پژوهشی و فناوری</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareProjectTypeList"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{8|faDigit}}</td>
                            <td>  فهرست عناوین اختراعات و اکتشافات</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareInventionTypeList"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{9|faDigit}}</td>
                            <td>  فهرست عناوین جوایز و افتخارات</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareRewardTypeList"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{10|faDigit}}</td>
                            <td>  فهرست عناوین گرنت</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareGrantTypeList"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{11|faDigit}}</td>
                            <td>  فهرست عناوین دوره ها</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareCourseTypeList"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{12|faDigit}}</td>
                            <td>  فهرست عناوین جزوه ها و اسلایدها</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareBookletTypeList"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{13|faDigit}}</td>
                            <td>  فهرست فعالیت های اجرایی پژوهشی</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareResearchActivityTypeList"></i>
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
                                <i v-show=" confTypeForm.errors.has('minscore')" class="red far fa-exclamation-triangle "></i>
                                <span v-show="confTypeForm.errors.has('minscore')" class="red d-inline-block ">{{ confTypeForm.errors.get('minscore') }}</span>
                            </div>
                            <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"> نوع کنفرانس</th>
                                    <th scope="col">کف امتیاز</th>
                                    <th scope="col">سقف امتیاز</th>
                                    <th></th>
                                    <th scope="col"> ویرایش</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(confType, index) of confTypeList">
                                    <th scope="row">{{index+1 | faDigit}}</th>
                                    <td><span>{{confType.name}}</span> </td>
                                    <td ><label  v-show="editOffset != index">{{confType.minscore | faDigits }}</label>
                                        <input :id = "'item-conftype-'+index" v-show="editOffset == index"  type="number" name="minscore"
                                               :placeholder="'کف امتیاز'"
                                               min="0"
                                               step="0.01"
                                               class="form-control"
                                               @keyup="removeError('minscore', 'conftype')"
                                               @keydown.enter.pervent=""
                                               :class="{ 'is-invalid': confTypeForm.errors.has('minscore') }"
                                               v-model.number="confTypeForm.minscore"
                                               >
                                    </td>
                                    <td>
                                        <label  v-show="editOffset != index">{{confType.maxscore | faDigits  }}</label>
                                        <input  v-show="editOffset == index"  type="number" name="maxscore"
                                               :placeholder="'سقف امتیاز'"
                                                min="0" step="0.01"
                                               class="form-control"
                                                @keyup="removeError('maxscore', 'conftype')"
                                                @keydown.enter.pervent=""
                                                :class="{ 'is-invalid': confTypeForm.errors.has('maxscore') }"
                                               v-model.number="confTypeForm.maxscore"

                                        >
                                    </td>
                                    <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateConfType(index)">ثبت تغییرات</button></td>
                                    <td>
                                        <a class="" @click="startEditing(index, confType.id, 'conftype')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
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
                                <i v-show=" jTypeForm.errors.has('minscore')" class="red far fa-exclamation-triangle "></i>
                                <span v-show="jTypeForm.errors.has('minscore')" class="red d-inline-block ">{{ jTypeForm.errors.get('minscore') }}</span>
                            </div>
                            <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"> نوع ژونال</th>
                                    <th scope="col">کف امتیاز</th>
                                    <th scope="col">سقف امتیاز</th>
                                    <th></th>
                                    <th scope="col"> ویرایش</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(jType, index) of journalTypeList">
                                    <th scope="row">{{index+1 | faDigit}}</th>
                                    <td><span>{{jType.name}}</span> </td>
                                    <td ><label  v-show="editOffset != index">{{jType.minscore | faDigits }}</label>
                                        <input :id = "'item-jType-'+index" v-show="editOffset == index"  type="number" name="minscore"
                                               :placeholder="'کف امتیاز'"
                                               min="0"
                                               step="0.01"
                                               class="form-control"
                                               @keyup="removeError('minscore', 'jType')"
                                               @keydown.enter.pervent=""
                                               :class="{ 'is-invalid': jTypeForm.errors.has('minscore') }"
                                               v-model.number="jTypeForm.minscore"
                                               >
                                    </td>
                                    <td>
                                        <label  v-show="editOffset != index">{{jType.maxscore | faDigits  }}</label>
                                        <input  v-show="editOffset == index"  type="number" name="maxscore"
                                               :placeholder="'سقف امتیاز'"
                                                min="0" step="0.01"
                                               class="form-control"
                                                @keyup="removeError('maxscore', 'jType')"
                                                @keydown.enter.pervent=""
                                                :class="{ 'is-invalid': jTypeForm.errors.has('maxscore') }"
                                               v-model.number="jTypeForm.maxscore"

                                        >
                                    </td>
                                    <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateJType(index)">ثبت تغییرات</button></td>
                                    <td>
                                        <a class="" @click="startEditing(index, jType.id, 'jType')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
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
                                <i v-show="bookTypeForm.errors.has('minscore')" class="red far fa-exclamation-triangle "></i>
                                <span v-show="bookTypeForm.errors.has('minscore')" class="red d-inline-block ">{{ bookTypeForm.errors.get('minscore') }}</span>
                            </div>
                            <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"> نوع کتاب</th>
                                    <th scope="col">کف امتیاز</th>
                                    <th scope="col">سقف امتیاز</th>
                                    <th></th>
                                    <th scope="col"> ویرایش</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(bookType, index) of bookTypeList">
                                    <th scope="row">{{index+1 | faDigit}}</th>
                                    <td><span>{{bookType.name}}</span> </td>
                                    <td ><label  v-show="editOffset != index">{{bookType.minscore | faDigits }}</label>
                                        <input :id = "'item-bookType-'+index" v-show="editOffset == index"  type="number" name="minscore"
                                               :placeholder="'کف امتیاز'"
                                               min="0"
                                               step="0.01"
                                               class="form-control"
                                               @keyup="removeError('minscore', 'bookType')"
                                               @keydown.enter.pervent=""
                                               :class="{ 'is-invalid': bookTypeForm.errors.has('minscore') }"
                                               v-model.number="bookTypeForm.minscore"
                                               >
                                    </td>
                                    <td>
                                        <label  v-show="editOffset != index">{{bookType.maxscore | faDigits  }}</label>
                                        <input  v-show="editOffset == index"  type="number" name="maxscore"
                                               :placeholder="'سقف امتیاز'"
                                                min="0" step="0.01"
                                               class="form-control"
                                                @keyup="removeError('maxscore', 'bookType')"
                                                @keydown.enter.pervent=""
                                                :class="{ 'is-invalid': bookTypeForm.errors.has('maxscore') }"
                                               v-model.number="bookTypeForm.maxscore"

                                        >
                                    </td><!--   -->
                                    <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateBookType(index)">ثبت تغییرات</button></td>
                                    <td>
                                        <a class="" @click="startEditing(index, bookType.id, 'bookType')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
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
                                <i v-show="thesesTypeForm.errors.has('minscore')" class="red far fa-exclamation-triangle "></i>
                                <span v-show="thesesTypeForm.errors.has('minscore')" class="red d-inline-block ">{{ thesesTypeForm.errors.get('minscore') }}</span>
                            </div>
                            <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"> نوع پایان نامه</th>
                                    <th scope="col">کف امتیاز</th>
                                    <th scope="col">سقف امتیاز</th>
                                    <th></th>
                                    <th scope="col"> ویرایش</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(thesesType, index) of thesesTypeList">
                                    <th scope="row">{{index+1 | faDigit}}</th>
                                    <td><span>{{thesesType.name}}</span> </td>
                                    <td ><label  v-show="editOffset != index">{{thesesType.minscore | faDigits }}</label>
                                        <input :id = "'item-thesesType-'+index" v-show="editOffset == index"  type="number" name="minscore"
                                               :placeholder="'کف امتیاز'"
                                               min="0"
                                               step="0.01"
                                               class="form-control"
                                               @keyup="removeError('minscore', 'thesesType')"
                                               @keydown.enter.pervent=""
                                               :class="{ 'is-invalid': thesesTypeForm.errors.has('minscore') }"
                                               v-model.number="thesesTypeForm.minscore"
                                               >
                                    </td>
                                    <td>
                                        <label  v-show="editOffset != index">{{thesesType.maxscore | faDigits  }}</label>
                                        <input  v-show="editOffset == index"  type="number" name="maxscore"
                                               :placeholder="'سقف امتیاز'"
                                                min="0" step="0.01"
                                               class="form-control"
                                                @keyup="removeError('maxscore', 'thesesType')"
                                                @keydown.enter.pervent=""
                                                :class="{ 'is-invalid': thesesTypeForm.errors.has('maxscore') }"
                                               v-model.number="thesesTypeForm.maxscore"

                                        >
                                    </td><!--   -->
                                    <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateThesesType(index)">ثبت تغییرات</button></td>
                                    <td>
                                        <a class="" @click="startEditing(index, thesesType.id, 'thesesType')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
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
                                <i v-show="tedTypeForm.errors.has('minscore')" class="red far fa-exclamation-triangle "></i>
                                <span v-show="tedTypeForm.errors.has('minscore')" class="red d-inline-block ">{{ tedTypeForm.errors.get('minscore') }}</span>
                            </div>
                            <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"> نوع کرسی</th>
                                    <th scope="col">کف امتیاز</th>
                                    <th scope="col">سقف امتیاز</th>
                                    <th></th>
                                    <th scope="col"> ویرایش</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(tedType, index) of tedTypeList">
                                    <th scope="row">{{index+1 | faDigit}}</th>
                                    <td><span>{{tedType.name}}</span> </td>
                                    <td ><label  v-show="editOffset != index">{{tedType.minscore | faDigits }}</label>
                                        <input :id = "'item-tedType-'+index" v-show="editOffset == index"  type="number" name="minscore"
                                               :placeholder="'کف امتیاز'"
                                               min="0"
                                               step="0.01"
                                               class="form-control"
                                               @keyup="removeError('minscore', 'tedType')"
                                               @keydown.enter.pervent=""
                                               :class="{ 'is-invalid': tedTypeForm.errors.has('minscore') }"
                                               v-model.number="tedTypeForm.minscore"
                                               >
                                    </td>
                                    <td>
                                        <label  v-show="editOffset != index">{{tedType.maxscore | faDigits  }}</label>
                                        <input  v-show="editOffset == index"  type="number" name="maxscore"
                                               :placeholder="'سقف امتیاز'"
                                                min="0" step="0.01"
                                               class="form-control"
                                                @keyup="removeError('maxscore', 'tedType')"
                                                @keydown.enter.pervent=""
                                                :class="{ 'is-invalid': tedTypeForm.errors.has('maxscore') }"
                                               v-model.number="tedTypeForm.maxscore"

                                        >
                                    </td><!--   -->
                                    <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateTedType(index)">ثبت تغییرات</button></td>
                                    <td>
                                        <a class="" @click="startEditing(index, tedType.id, 'tedType')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
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
                                <i v-show="refereeTypeForm.errors.has('minscore')" class="red far fa-exclamation-triangle "></i>
                                <span v-show="refereeTypeForm.errors.has('minscore')" class="red d-inline-block ">{{ refereeTypeForm.errors.get('minscore') }}</span>
                            </div>
                            <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"> نوع داوری</th>
                                    <th scope="col">کف امتیاز</th>
                                    <th scope="col">سقف امتیاز</th>
                                    <th></th>
                                    <th scope="col"> ویرایش</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(refereeType, index) of refereeTypeList">
                                    <th scope="row">{{index+1 | faDigit}}</th>
                                    <td><span>{{refereeType.name}}</span> </td>
                                    <td ><label  v-show="editOffset != index">{{refereeType.minscore | faDigits }}</label>
                                        <input :id = "'item-refereeType-'+index" v-show="editOffset == index"  type="number" name="minscore"
                                               :placeholder="'کف امتیاز'"
                                               min="0"
                                               step="0.01"
                                               class="form-control"
                                               @keyup="removeError('minscore', 'refereeType')"
                                               @keydown.enter.pervent=""
                                               :class="{ 'is-invalid': refereeTypeForm.errors.has('minscore') }"
                                               v-model.number="refereeTypeForm.minscore"
                                               >
                                    </td>
                                    <td>
                                        <label  v-show="editOffset != index">{{refereeType.maxscore | faDigits  }}</label>
                                        <input  v-show="editOffset == index"  type="number" name="maxscore"
                                               :placeholder="'سقف امتیاز'"
                                                min="0" step="0.01"
                                               class="form-control"
                                                @keyup="removeError('maxscore', 'tedType')"
                                                @keydown.enter.pervent=""
                                                :class="{ 'is-invalid': refereeTypeForm.errors.has('maxscore') }"
                                               v-model.number="refereeTypeForm.maxscore"

                                        >
                                    </td><!--   -->
                                    <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateRefereeType(index)">ثبت تغییرات</button></td>
                                    <td>
                                        <a class="" @click="startEditing(index, refereeType.id, 'refereeType')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
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
                                <i v-show="projectTypeForm.errors.has('minscore')" class="red far fa-exclamation-triangle "></i>
                                <span v-show="projectTypeForm.errors.has('minscore')" class="red d-inline-block ">{{ projectTypeForm.errors.get('minscore') }}</span>
                            </div>
                            <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"> نوع طرح پژوهشی</th>
                                    <th scope="col">کف امتیاز</th>
                                    <th scope="col">سقف امتیاز</th>
                                    <th></th>
                                    <th scope="col"> ویرایش</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(projectType, index) of projectTypeList">
                                    <th scope="row">{{index+1 | faDigit}}</th>
                                    <td><span>{{projectType.name}}</span> </td>
                                    <td ><label  v-show="editOffset != index">{{projectType.minscore | faDigits }}</label>
                                        <input :id = "'item-projectType-'+index" v-show="editOffset == index"  type="number" name="minscore"
                                               :placeholder="'کف امتیاز'"
                                               min="0"
                                               step="0.01"
                                               class="form-control"
                                               @keyup="removeError('minscore', 'projectType')"
                                               @keydown.enter.pervent=""
                                               :class="{ 'is-invalid': projectTypeForm.errors.has('minscore') }"
                                               v-model.number="projectTypeForm.minscore"
                                               >
                                    </td>
                                    <td>
                                        <label  v-show="editOffset != index">{{projectType.maxscore | faDigits  }}</label>
                                        <input  v-show="editOffset == index"  type="number" name="maxscore"
                                               :placeholder="'سقف امتیاز'"
                                                min="0" step="0.01"
                                               class="form-control"
                                                @keyup="removeError('maxscore', 'projectType')"
                                                @keydown.enter.pervent=""
                                                :class="{ 'is-invalid': projectTypeForm.errors.has('maxscore') }"
                                               v-model.number="projectTypeForm.maxscore"

                                        >
                                    </td><!--   -->
                                    <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateProjectType(index)">ثبت تغییرات</button></td>
                                    <td>
                                        <a class="" @click="startEditing(index, projectType.id, 'projectType')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
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
                                <i v-show="inventionTypeForm.errors.has('minscore')" class="red far fa-exclamation-triangle "></i>
                                <span v-show="inventionTypeForm.errors.has('minscore')" class="red d-inline-block ">{{ inventionTypeForm.errors.get('minscore') }}</span>
                            </div>
                            <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"> نوع طرح اختراع</th>
                                    <th scope="col">کف امتیاز</th>
                                    <th scope="col">سقف امتیاز</th>
                                    <th></th>
                                    <th scope="col"> ویرایش</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(inventionType, index) of inventionTypeList">
                                    <th scope="row">{{index+1 | faDigit}}</th>
                                    <td><span>{{inventionType.name}}</span> </td>
                                    <td ><label  v-show="editOffset != index">{{inventionType.minscore | faDigits }}</label>
                                        <input :id = "'item-inventionType-'+index" v-show="editOffset == index"  type="number" name="minscore"
                                               :placeholder="'کف امتیاز'"
                                               min="0"
                                               step="0.01"
                                               class="form-control"
                                               @keyup="removeError('minscore', 'inventionType')"
                                               @keydown.enter.pervent=""
                                               :class="{ 'is-invalid': inventionTypeForm.errors.has('minscore') }"
                                               v-model.number="inventionTypeForm.minscore"
                                               >
                                    </td>
                                    <td>
                                        <label  v-show="editOffset != index">{{inventionType.maxscore | faDigits  }}</label>
                                        <input  v-show="editOffset == index"  type="number" name="maxscore"
                                               :placeholder="'سقف امتیاز'"
                                                min="0" step="0.01"
                                               class="form-control"
                                                @keyup="removeError('maxscore', 'inventionType')"
                                                @keydown.enter.pervent=""
                                                :class="{ 'is-invalid': inventionTypeForm.errors.has('maxscore') }"
                                               v-model.number="inventionTypeForm.maxscore"

                                        >
                                    </td><!--   -->
                                    <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateInventionType(index)">ثبت تغییرات</button></td>
                                    <td>
                                        <a class="" @click="startEditing(index, inventionType.id, 'inventionType')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
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
                                <i v-show="researchActivityTypeForm.errors.has('minscore')" class="red far fa-exclamation-triangle "></i>
                                <span v-show="researchActivityTypeForm.errors.has('minscore')" class="red d-inline-block ">{{ researchActivityTypeForm.errors.get('minscore') }}</span>
                            </div>
                            <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"> نوع طرح فعالیت</th>
                                    <th scope="col">کف امتیاز</th>
                                    <th scope="col">سقف امتیاز</th>
                                    <th></th>
                                    <th scope="col"> ویرایش</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(researchActivityType, index) of researchActivityTypeList">
                                    <th scope="row">{{index+1 | faDigit}}</th>
                                    <td><span>{{researchActivityType.name}}</span> </td>
                                    <td ><label  v-show="editOffset != index">{{researchActivityType.minscore | faDigits }}</label>
                                        <input :id = "'item-researchActivityType-'+index" v-show="editOffset == index"  type="number" name="minscore"
                                               :placeholder="'کف امتیاز'"
                                               min="0"
                                               step="0.01"
                                               class="form-control"
                                               @keyup="removeError('minscore', 'inventionType')"
                                               @keydown.enter.pervent=""
                                               :class="{ 'is-invalid': researchActivityTypeForm.errors.has('minscore') }"
                                               v-model.number="researchActivityTypeForm.minscore"
                                               >
                                    </td>
                                    <td>
                                        <label  v-show="editOffset != index">{{researchActivityType.maxscore | faDigits  }}</label>
                                        <input  v-show="editOffset == index"  type="number" name="maxscore"
                                               :placeholder="'سقف امتیاز'"
                                                min="0" step="0.01"
                                               class="form-control"
                                                @keyup="removeError('maxscore', 'inventionType')"
                                                @keydown.enter.pervent=""
                                                :class="{ 'is-invalid': researchActivityTypeForm.errors.has('maxscore') }"
                                               v-model.number="researchActivityTypeForm.maxscore"

                                        >
                                    </td><!--   -->
                                    <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateResearchActivityType(index)">ثبت تغییرات</button></td>
                                    <td>
                                        <a class="" @click="startEditing(index, researchActivityType.id, 'researchActivityType')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div><!-- modal-body -->
                        <div class="modal-footer">

                        </div>

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->
        <div v-if="$gate.isAdminOrAuthor()" class="modal  fade" id="RewardTypeListModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel9"><i
                            class="fas fa-building fa-fw"></i>فهرست عناوین جوایز</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                        <div class="modal-body" >
                            <div class="text-right text-rtl">
                                <i v-show="rewardTypeForm.errors.has('minscore')" class="red far fa-exclamation-triangle "></i>
                                <span v-show="rewardTypeForm.errors.has('minscore')" class="red d-inline-block ">{{ rewardTypeForm.errors.get('minscore') }}</span>
                            </div>
                            <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"> نوع جایزه</th>
                                    <th scope="col">کف امتیاز</th>
                                    <th scope="col">سقف امتیاز</th>
                                    <th></th>
                                    <th scope="col"> ویرایش</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(rewardType, index) in rewardTypeList">
                                    <th scope="row">{{index+1 | faDigit}}</th>
                                    <td><span>{{rewardType.name}}</span> </td>
                                    <td ><label  v-show="editOffset != index">{{rewardType.minscore | faDigits }}</label>
                                        <input :id = "'item-rewardType-'+index" v-show="editOffset == index"  type="number" name="minscore"
                                               :placeholder="'کف امتیاز'"
                                               min="0"
                                               step="0.01"
                                               class="form-control"
                                               @keyup="removeError('minscore', 'rewardType')"
                                               @keydown.enter.pervent=""
                                               :class="{ 'is-invalid': rewardTypeForm.errors.has('minscore') }"
                                               v-model.number="rewardTypeForm.minscore"
                                               >
                                    </td>
                                    <td>
                                        <label  v-show="editOffset != index">{{rewardType.maxscore | faDigits  }}</label>
                                        <input  v-show="editOffset == index"  type="number" name="maxscore"
                                               :placeholder="'سقف امتیاز'"
                                                min="0" step="0.01"
                                               class="form-control"
                                                @keyup="removeError('maxscore', 'rewardType')"
                                                @keydown.enter.pervent=""
                                                :class="{ 'is-invalid': rewardTypeForm.errors.has('maxscore') }"
                                               v-model.number="rewardTypeForm.maxscore"

                                        >
                                    </td><!--   -->
                                    <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateRewardType(index)">ثبت تغییرات</button></td>
                                    <td>
                                        <a class="" @click="startEditing(index, rewardType.id, 'rewardType')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div><!-- modal-body -->
                        <div class="modal-footer">

                        </div>

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->
        <div v-if="$gate.isAdminOrAuthor()" class="modal  fade" id="GrantTypeListModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel10"><i
                            class="fas fa-building fa-fw"></i>فهرست عناوین گرنت</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                        <div class="modal-body" >
                            <div class="text-right text-rtl">
                                <i v-show="grantTypeForm.errors.has('minscore')" class="red far fa-exclamation-triangle "></i>
                                <span v-show="grantTypeForm.errors.has('minscore')" class="red d-inline-block ">{{ grantTypeForm.errors.get('minscore') }}</span>
                            </div>
                            <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"> نوع گرنت</th>
                                    <th scope="col">کف امتیاز</th>
                                    <th scope="col">سقف امتیاز</th>
                                    <th></th>
                                    <th scope="col"> ویرایش</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(grantType, index) in grantTypeList">
                                    <th scope="row">{{index+1 | faDigit}}</th>
                                    <td><span>{{grantType.name}}</span> </td>
                                    <td ><label  v-show="editOffset != index">{{grantType.minscore | faDigits }}</label>
                                        <input :id = "'item-grantType-'+index" v-show="editOffset == index"  type="number" name="minscore"
                                               :placeholder="'کف امتیاز'"
                                               min="0"
                                               step="0.01"
                                               class="form-control"
                                               @keyup="removeError('minscore', 'grantType')"
                                               @keydown.enter.pervent=""
                                               :class="{ 'is-invalid': grantTypeForm.errors.has('minscore') }"
                                               v-model.number="grantTypeForm.minscore"
                                               >
                                    </td>
                                    <td>
                                        <label  v-show="editOffset != index">{{grantType.maxscore | faDigits  }}</label>
                                        <input  v-show="editOffset == index"  type="number" name="maxscore"
                                               :placeholder="'سقف امتیاز'"
                                                min="0" step="0.01"
                                               class="form-control"
                                                @keyup="removeError('maxscore', 'grantType')"
                                                @keydown.enter.pervent=""
                                                :class="{ 'is-invalid': grantTypeForm.errors.has('maxscore') }"
                                               v-model.number="grantTypeForm.maxscore"

                                        >
                                    </td><!--   -->
                                    <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateGrantType(index)">ثبت تغییرات</button></td>
                                    <td>
                                        <a class="" @click="startEditing(index, grantType.id, 'grantType')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div><!-- modal-body -->
                        <div class="modal-footer">

                        </div>

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->
        <div v-if="$gate.isAdminOrAuthor()" class="modal  fade" id="CourseTypeListModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel11"><i
                            class="fas fa-building fa-fw"></i>فهرست عناوین دوره</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                        <div class="modal-body" >
                            <div class="text-right text-rtl">
                                <i v-show="courseTypeForm.errors.has('minscore')" class="red far fa-exclamation-triangle "></i>
                                <span v-show="courseTypeForm.errors.has('minscore')" class="red d-inline-block ">{{ courseTypeForm.errors.get('minscore') }}</span>
                            </div>
                            <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"> نوع دوره</th>
                                    <th scope="col">کف امتیاز</th>
                                    <th scope="col">سقف امتیاز</th>
                                    <th></th>
                                    <th scope="col"> ویرایش</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(courseType, index) in courseTypeList">
                                    <th scope="row">{{index+1 | faDigit}}</th>
                                    <td><span>{{courseType.name}}</span> </td>
                                    <td ><label  v-show="editOffset != index">{{courseType.minscore | faDigits }}</label>
                                        <input :id = "'item-courseType-'+index" v-show="editOffset == index"  type="number" name="minscore"
                                               :placeholder="'کف امتیاز'"
                                               min="0"
                                               step="0.01"
                                               class="form-control"
                                               @keyup="removeError('minscore', 'courseType')"
                                               @keydown.enter.pervent=""
                                               :class="{ 'is-invalid': courseTypeForm.errors.has('minscore') }"
                                               v-model.number="courseTypeForm.minscore"
                                               >
                                    </td>
                                    <td>
                                        <label  v-show="editOffset != index">{{courseType.maxscore | faDigits  }}</label>
                                        <input  v-show="editOffset == index"  type="number" name="maxscore"
                                               :placeholder="'سقف امتیاز'"
                                                min="0" step="0.01"
                                               class="form-control"
                                                @keyup="removeError('maxscore', 'courseType')"
                                                @keydown.enter.pervent=""
                                                :class="{ 'is-invalid': courseTypeForm.errors.has('maxscore') }"
                                               v-model.number="courseTypeForm.maxscore"

                                        >
                                    </td><!--   -->
                                    <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateCourseType(index)">ثبت تغییرات</button></td>
                                    <td>
                                        <a class="" @click="startEditing(index, courseType.id, 'courseType')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div><!-- modal-body -->
                        <div class="modal-footer">

                        </div>

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->
        <div v-if="$gate.isAdminOrAuthor()" class="modal  fade" id="BookletTypeListModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel12"><i
                            class="fas fa-building fa-fw"></i>فهرست عناوین جزوه ها و اسلایدها</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                        <div class="modal-body" >
                            <div class="text-right text-rtl">
                                <i v-show="bookletTypeForm.errors.has('minscore')" class="red far fa-exclamation-triangle "></i>
                                <span v-show="bookletTypeForm.errors.has('minscore')" class="red d-inline-block ">{{ bookletTypeForm.errors.get('minscore') }}</span>
                            </div>
                            <table class="table table-sm table-hover mt-2 mb-5 table-striped text-right text-rtl">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"> نوع جزوه</th>
                                    <th scope="col">کف امتیاز</th>
                                    <th scope="col">سقف امتیاز</th>
                                    <th></th>
                                    <th scope="col"> ویرایش</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(bookletType, index) in bookletTypeList">
                                    <th scope="row">{{index+1 | faDigit}}</th>
                                    <td><span>{{bookletType.name}}</span> </td>
                                    <td ><label  v-show="editOffset != index">{{bookletType.minscore | faDigits }}</label>
                                        <input :id = "'item-bookletType-'+index" v-show="editOffset == index"  type="number" name="minscore"
                                               :placeholder="'کف امتیاز'"
                                               min="0"
                                               step="0.01"
                                               class="form-control"
                                               @keyup="removeError('minscore', 'bookletType')"
                                               @keydown.enter.pervent=""
                                               :class="{ 'is-invalid': bookletTypeForm.errors.has('minscore') }"
                                               v-model.number="bookletTypeForm.minscore"
                                               >
                                    </td>
                                    <td>
                                        <label  v-show="editOffset != index">{{bookletType.maxscore | faDigits  }}</label>
                                        <input  v-show="editOffset == index"  type="number" name="maxscore"
                                               :placeholder="'سقف امتیاز'"
                                                min="0" step="0.01"
                                               class="form-control"
                                                @keyup="removeError('maxscore', 'bookletType')"
                                                @keydown.enter.pervent=""
                                                :class="{ 'is-invalid': bookletTypeForm.errors.has('maxscore') }"
                                               v-model.number="bookletTypeForm.maxscore"

                                        >
                                    </td><!--   -->
                                    <td> <button  v-show="editOffset == index" class="btn btn-primary" @click="updateBookletType(index)">ثبت تغییرات</button></td>
                                    <td>
                                        <a class="" @click="startEditing(index, bookletType.id, 'bookletType')"><i class=" green far fa-edit fa-fw"></i> </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
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
        name: "Scores",
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
                rewardTypeList:{},
                grantTypeList:{},
                courseTypeList:{},
                bookletTypeList:{},
                editOffset: -1,     // for managing author editing form status used if -1 the form will be hide
                confTypeForm: new Form({
                    id:'',
                    minscore:'',
                    maxscore:'',
                }),
                jTypeForm: new Form({
                    id:'',
                    minscore:'',
                    maxscore:'',
                }),
                bookTypeForm: new Form({
                    id:'',
                    minscore:'',
                    maxscore:'',
                }),
                thesesTypeForm: new Form({
                    id:'',
                    minscore:'',
                    maxscore:'',
                }),
                tedTypeForm: new Form({
                    id:'',
                    minscore:'',
                    maxscore:'',
                }),
                refereeTypeForm: new Form({
                    id:'',
                    minscore:'',
                    maxscore:'',
                }),
                projectTypeForm: new Form({
                    id:'',
                    minscore:'',
                    maxscore:'',
                }),
                inventionTypeForm: new Form({
                    id:'',
                    minscore:'',
                    maxscore:'',
                }),
                rewardTypeForm: new Form({
                    id:'',
                    minscore:'',
                    maxscore:'',
                }),
                grantTypeForm: new Form({
                    id:'',
                    minscore:'',
                    maxscore:'',
                }),
                courseTypeForm: new Form({
                    id:'',
                    minscore:'',
                    maxscore:'',
                }),
                bookletTypeForm: new Form({
                    id:'',
                    minscore:'',
                    maxscore:'',
                }),
                researchActivityTypeForm: new Form({
                    id:'',
                    minscore:'',
                    maxscore:'',
                }),
            }
        },
        methods:{
            nothing(){},
            prepareJournalTypeList(){
                let loader1 = Vue.$loading.show();
                axios.get('/api/getJournalType').then((response)=>{
                    loader1.hide();
                    this.journalTypeList = response.data.journalTypeList;
                    this.editOffset = -1;
                    $('#journalTypeListModal').modal('show');
                }).catch(()=>{
                    loader1.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            prepareConfTypeList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getConfType').then((response)=>{
                    loader.hide();
                    this.confTypeList = response.data.confTypeList;
                    this.editOffset = -1;
                    $('#confTypeListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            prepareBookTypeList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getBookType').then((response)=>{
                    loader.hide();
                    this.bookTypeList = response.data.bookTypeList;
                    this.editOffset = -1;
                    $('#bookTypeListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            prepareThesesTypeList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getThesesType').then((response)=>{
                    loader.hide();
                    this.thesesTypeList = response.data.thesesTypeList;
                    this.editOffset = -1;
                    $('#ThesisTypeListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            prepareTedTypeList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getTEDType').then((response)=>{
                    loader.hide();
                    this.tedTypeList = response.data.tedTypeList;
                    this.editOffset = -1;
                    $('#TedTypeListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            prepareRefereeTypeList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getRefereeType').then((response)=>{
                    loader.hide();
                    this.refereeTypeList = response.data.refereeTypeList;
                    this.editOffset = -1;
                    $('#RefereeTypeListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            prepareProjectTypeList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getProjectType').then((response)=>{
                    loader.hide();
                    this.projectTypeList = response.data.projectTypeList;
                    this.editOffset = -1;
                    $('#ProjectTypeListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            prepareInventionTypeList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getInventionType').then((response)=>{
                    loader.hide();
                    this.inventionTypeList = response.data.inventionTypeList;
                    this.editOffset = -1;
                    $('#InventionTypeListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            prepareRewardTypeList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getRewardType').then((response)=>{
                    loader.hide();
                    this.rewardTypeList = response.data.rewardTypeList;
                    this.editOffset = -1;
                    $('#RewardTypeListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            prepareGrantTypeList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getGrantType').then((response)=>{
                    loader.hide();
                    this.grantTypeList = response.data.grantTypeList;
                    this.editOffset = -1;
                    $('#GrantTypeListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            prepareCourseTypeList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getCourseType').then((response)=>{
                    loader.hide();
                    this.courseTypeList = response.data.courseTypeList;
                    this.editOffset = -1;
                    $('#CourseTypeListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            prepareBookletTypeList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getBookletType').then((response)=>{
                    loader.hide();
                    this.bookletTypeList = response.data.bookletTypes;
                    this.editOffset = -1;
                    $('#BookletTypeListModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            prepareResearchActivityTypeList(){
                let loader = Vue.$loading.show();
                axios.get('/api/getresearchActivityType').then((response)=>{
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
                }else if(type == "rewardType"){
                    this.rewardTypeForm.fill(this.rewardTypeList[index]);
                    this.$nextTick(function(){
                        document.getElementById('item-'+type+'-'+this.editOffset).focus()
                    }.bind(this));
                }else if(type == "grantType"){
                    this.grantTypeForm.fill(this.grantTypeList[index]);
                    this.$nextTick(function(){
                        document.getElementById('item-'+type+'-'+this.editOffset).focus()
                    }.bind(this));
                }else if(type == "courseType"){
                    this.courseTypeForm.fill(this.courseTypeList[index]);
                    this.$nextTick(function(){
                        document.getElementById('item-'+type+'-'+this.editOffset).focus()
                    }.bind(this));
                }else if(type == "bookletType"){
                    this.bookletTypeForm.fill(this.bookletTypeList[index]);
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
                if(this.isIntOrFloat(this.confTypeForm.minscore) && this.isIntOrFloat(this.confTypeForm.maxscore) ){
                    this.confTypeForm.minscore = this.confTypeForm.minscore.toFixed(2);
                    this.confTypeForm.maxscore = this.confTypeForm.maxscore.toFixed(2);
                    this.confTypeForm.put('/api/updateConfType/' + this.confTypeForm.id)
                        .then((response) => {
                            this.confTypeList[index]['minscore'] = response.data.minscore;
                            this.confTypeList[index]['maxscore'] = response.data.maxscore;
                            this.confTypeForm.reset();
                            this.editOffset = -1;
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        this.confTypeForm.minscore = Number(this.confTypeForm.minscore);
                        this.confTypeForm.maxscore = Number(this.confTypeForm.maxscore);
                    });
                }else {
                    this.errorSwal('کف یا سقف امتیاز نمی تواند خالی باشد!')
                }
            },

            updateJType(index) {
                if(this.isIntOrFloat(this.jTypeForm.minscore) && this.isIntOrFloat(this.jTypeForm.maxscore)  ){
                    this.jTypeForm.minscore = this.jTypeForm.minscore.toFixed(2);
                    this.jTypeForm.maxscore = this.jTypeForm.maxscore.toFixed(2);
                    this.jTypeForm.put('/api/updateJType/' + this.jTypeForm.id)
                        .then((response) => {
                            this.journalTypeList[index]['minscore'] = response.data.minscore;
                            this.journalTypeList[index]['maxscore'] = response.data.maxscore;
                            this.jTypeForm.reset();
                            this.editOffset = -1;
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        this.jTypeForm.minscore = Number(this.jTypeForm.minscore);
                        this.jTypeForm.maxscore = Number(this.jTypeForm.maxscore);
                    });
                }else {
                    this.errorSwal('کف یا سقف امتیاز نمی تواند خالی باشد!');
                }
            },
            updateBookType(index) {
                if(this.isIntOrFloat(this.bookTypeForm.minscore) && this.isIntOrFloat(this.bookTypeForm.maxscore)  ){
                    this.bookTypeForm.minscore = this.bookTypeForm.minscore.toFixed(2);
                    this.bookTypeForm.maxscore = this.bookTypeForm.maxscore.toFixed(2);
                    this.bookTypeForm.put('/api/updateBookType/' + this.bookTypeForm.id)
                        .then((response) => {
                            this.bookTypeList[index]['minscore'] = response.data.minscore;
                            this.bookTypeList[index]['maxscore'] = response.data.maxscore;
                            this.bookTypeForm.reset();
                            this.editOffset = -1;
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        this.bookTypeForm.minscore = Number(this.bookTypeForm.minscore);
                        this.bookTypeForm.maxscore = Number(this.bookTypeForm.maxscore);
                    });
                }else {
                    this.errorSwal('کف یا سقف امتیاز نمی تواند خالی باشد!');
                }
            },
            updateThesesType(index) {
                if(this.isIntOrFloat(this.thesesTypeForm.minscore) && this.isIntOrFloat(this.thesesTypeForm.maxscore)  ){
                    this.thesesTypeForm.minscore = this.thesesTypeForm.minscore.toFixed(2);
                    this.thesesTypeForm.maxscore = this.thesesTypeForm.maxscore.toFixed(2);
                    this.thesesTypeForm.put('/api/updateThesesType/' + this.thesesTypeForm.id)
                        .then((response) => {
                            this.thesesTypeList[index]['minscore'] = response.data.minscore;
                            this.thesesTypeList[index]['maxscore'] = response.data.maxscore;
                            this.thesesTypeForm.reset();
                            this.editOffset = -1;
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        this.thesesTypeForm.minscore = Number(this.thesesTypeForm.minscore);
                        this.thesesTypeForm.maxscore = Number(this.thesesTypeForm.maxscore);
                    });
                }else {
                    this.errorSwal('کف یا سقف امتیاز نمی تواند خالی باشد!');
                }
            },
            updateTedType(index) {
                if(this.isIntOrFloat(this.tedTypeForm.minscore) && this.isIntOrFloat(this.tedTypeForm.maxscore)  ){
                    this.tedTypeForm.minscore = this.tedTypeForm.minscore.toFixed(2);
                    this.tedTypeForm.maxscore = this.tedTypeForm.maxscore.toFixed(2);
                    this.tedTypeForm.put('/api/updateTEDType/' + this.tedTypeForm.id)
                        .then((response) => {
                            this.tedTypeList[index]['minscore'] = response.data.minscore;
                            this.tedTypeList[index]['maxscore'] = response.data.maxscore;
                            this.tedTypeForm.reset();
                            this.editOffset = -1;
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        this.tedTypeForm.minscore = Number(this.tedTypeForm.minscore);
                        this.tedTypeForm.maxscore = Number(this.tedTypeForm.maxscore);
                    });
                }else {
                    this.errorSwal('کف یا سقف امتیاز نمی تواند خالی باشد!');
                }
            },
            updateRefereeType(index) {
                if(this.isIntOrFloat(this.refereeTypeForm.minscore) && this.isIntOrFloat(this.refereeTypeForm.maxscore)  ){
                    this.refereeTypeForm.minscore = this.refereeTypeForm.minscore.toFixed(2);
                    this.refereeTypeForm.maxscore = this.refereeTypeForm.maxscore.toFixed(2);
                    this.refereeTypeForm.put('/api/updateRefereeType/' + this.refereeTypeForm.id)
                        .then((response) => {
                            this.refereeTypeList[index]['minscore'] = response.data.minscore;
                            this.refereeTypeList[index]['maxscore'] = response.data.maxscore;
                            this.refereeTypeForm.reset();
                            this.editOffset = -1;
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        this.refereeTypeForm.minscore = Number(this.refereeTypeForm.minscore);
                        this.refereeTypeForm.maxscore = Number(this.refereeTypeForm.maxscore);
                    });
                }else {
                    this.errorSwal('کف یا سقف امتیاز نمی تواند خالی باشد!');
                }
            },
            updateProjectType(index) {
                if(this.isIntOrFloat(this.projectTypeForm.minscore) && this.isIntOrFloat(this.projectTypeForm.maxscore)  ){
                    this.projectTypeForm.minscore = this.projectTypeForm.minscore.toFixed(2);
                    this.projectTypeForm.maxscore = this.projectTypeForm.maxscore.toFixed(2);
                    this.projectTypeForm.put('/api/updateProjectType/' + this.projectTypeForm.id)
                        .then((response) => {
                            this.projectTypeList[index]['minscore'] = response.data.minscore;
                            this.projectTypeList[index]['maxscore'] = response.data.maxscore;
                            this.projectTypeForm.reset();
                            this.editOffset = -1;
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        this.projectTypeForm.minscore = Number(this.projectTypeForm.minscore);
                        this.projectTypeForm.maxscore = Number(this.projectTypeForm.maxscore);
                    });
                }else {
                    this.errorSwal('کف یا سقف امتیاز نمی تواند خالی باشد!');
                }
            },
            updateInventionType(index) {
                if(this.isIntOrFloat(this.inventionTypeForm.minscore) && this.isIntOrFloat(this.inventionTypeForm.maxscore)  ){
                    this.inventionTypeForm.minscore = this.inventionTypeForm.minscore.toFixed(2);
                    this.inventionTypeForm.maxscore = this.inventionTypeForm.maxscore.toFixed(2);
                    this.inventionTypeForm.put('/api/updateInventionType/' + this.inventionTypeForm.id)
                        .then((response) => {
                            this.inventionTypeList[index]['minscore'] = response.data.minscore;
                            this.inventionTypeList[index]['maxscore'] = response.data.maxscore;
                            this.inventionTypeForm.reset();
                            this.editOffset = -1;
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        this.inventionTypeForm.minscore = Number(this.inventionTypeForm.minscore);
                        this.inventionTypeForm.maxscore = Number(this.inventionTypeForm.maxscore);
                    });
                }else {
                    this.errorSwal('کف یا سقف امتیاز نمی تواند خالی باشد!');
                }
            },
            updateResearchActivityType(index) {
                if(this.isIntOrFloat(this.researchActivityTypeForm.minscore) && this.isIntOrFloat(this.researchActivityTypeForm.maxscore)  ){
                    this.researchActivityTypeForm.minscore = this.researchActivityTypeForm.minscore.toFixed(2);
                    this.researchActivityTypeForm.maxscore = this.researchActivityTypeForm.maxscore.toFixed(2);
                    this.researchActivityTypeForm.put('/api/updateResearchActivityType/' + this.researchActivityTypeForm.id)
                        .then((response) => {
                            this.researchActivityTypeList[index]['minscore'] = response.data.minscore;
                            this.researchActivityTypeList[index]['maxscore'] = response.data.maxscore;
                            this.researchActivityTypeForm.reset();
                            this.editOffset = -1;
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        this.researchActivityTypeForm.minscore = Number(this.researchActivityTypeForm.minscore);
                        this.researchActivityTypeForm.maxscore = Number(this.researchActivityTypeForm.maxscore);
                    });
                }else {
                    this.errorSwal('کف یا سقف امتیاز نمی تواند خالی باشد!');
                }
            },
            updateRewardType(index) {
                if(this.isIntOrFloat(this.rewardTypeForm.minscore) && this.isIntOrFloat(this.rewardTypeForm.maxscore)  ){
                    this.rewardTypeForm.minscore = this.rewardTypeForm.minscore.toFixed(2);
                    this.rewardTypeForm.maxscore = this.rewardTypeForm.maxscore.toFixed(2);
                    this.rewardTypeForm.put('/api/updateRewardType/' + this.rewardTypeForm.id)
                        .then((response) => {
                            this.rewardTypeList[index]['minscore'] = response.data.minscore;
                            this.rewardTypeList[index]['maxscore'] = response.data.maxscore;
                            this.rewardTypeForm.reset();
                            this.editOffset = -1;
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        this.rewardTypeForm.minscore = Number(this.rewardTypeForm.minscore);
                        this.rewardTypeForm.maxscore = Number(this.rewardTypeForm.maxscore);
                    });
                }else {
                    this.errorSwal('کف یا سقف امتیاز نمی تواند خالی باشد!');
                }
            },
            updateGrantType(index) {
                if(this.isIntOrFloat(this.grantTypeForm.minscore) && this.isIntOrFloat(this.grantTypeForm.maxscore)  ){
                    this.grantTypeForm.minscore = this.grantTypeForm.minscore.toFixed(2);
                    this.grantTypeForm.maxscore = this.grantTypeForm.maxscore.toFixed(2);
                    this.grantTypeForm.put('/api/updateGrantType/' + this.grantTypeForm.id)
                        .then((response) => {
                            this.grantTypeList[index]['minscore'] = response.data.minscore;
                            this.grantTypeList[index]['maxscore'] = response.data.maxscore;
                            this.grantTypeForm.reset();
                            this.editOffset = -1;
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        this.grantTypeForm.minscore = Number(this.grantTypeForm.minscore);
                        this.grantTypeForm.maxscore = Number(this.grantTypeForm.maxscore);
                    });
                }else {
                    this.errorSwal('کف یا سقف امتیاز نمی تواند خالی باشد!');
                }
            },
            updateCourseType(index) {
                if(this.isIntOrFloat(this.courseTypeForm.minscore) && this.isIntOrFloat(this.courseTypeForm.maxscore)  ){
                    this.courseTypeForm.minscore = this.courseTypeForm.minscore.toFixed(2);
                    this.courseTypeForm.maxscore = this.courseTypeForm.maxscore.toFixed(2);
                    this.courseTypeForm.put('/api/updateCourseType/' + this.courseTypeForm.id)
                        .then((response) => {
                            this.courseTypeList[index]['minscore'] = response.data.minscore;
                            this.courseTypeList[index]['maxscore'] = response.data.maxscore;
                            this.courseTypeForm.reset();
                            this.editOffset = -1;
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        this.courseTypeForm.minscore = Number(this.courseTypeForm.minscore);
                        this.courseTypeForm.maxscore = Number(this.courseTypeForm.maxscore);
                    });
                }else {
                    this.errorSwal('کف یا سقف امتیاز نمی تواند خالی باشد!');
                }
            },
            updateBookletType(index) {
                if(this.isIntOrFloat(this.bookletTypeForm.minscore) && this.isIntOrFloat(this.bookletTypeForm.maxscore)  ){
                    this.bookletTypeForm.minscore = this.bookletTypeForm.minscore.toFixed(2);
                    this.bookletTypeForm.maxscore = this.bookletTypeForm.maxscore.toFixed(2);
                    this.bookletTypeForm.put('/api/updateBookletType/' + this.bookletTypeForm.id)
                        .then((response) => {
                            this.bookletTypeList[index]['minscore'] = response.data.minscore;
                            this.bookletTypeList[index]['maxscore'] = response.data.maxscore;
                            this.bookletTypeForm.reset();
                            this.editOffset = -1;
                        }).catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        this.bookletTypeForm.minscore = Number(this.bookletTypeForm.minscore);
                        this.bookletTypeForm.maxscore = Number(this.bookletTypeForm.maxscore);
                    });
                }else {
                    this.errorSwal('کف یا سقف امتیاز نمی تواند خالی باشد!');
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
                }else if(type == "rewardType"){
                    this.rewardTypeForm.errors.clear(field)
                }else if(type == "grantType"){
                    this.grantTypeForm.errors.clear(field)
                }else if(type == "courseType"){
                    this.courseTypeForm.errors.clear(field)
                }else if(type == "bookletType"){
                    this.bookletTypeForm.errors.clear(field)
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
        },
        component:{

        }
    }
</script>

<style scoped>

</style>
