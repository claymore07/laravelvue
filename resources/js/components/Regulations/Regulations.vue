<template>
    <div class="container-fluid">
        <div class="col-md-12 mt-3" v-if="$gate.isAdminOrAuthor()">
            <div class="card card-4">
                <div class="card-header  " style="direction: rtl">
                    <div class="justify-content-around d-lg-flex text-right">
                        <div class="col-lg-7 m-3">
                            <h4 class=" text-right"> <i class="fal fa-info-circle ml-2"></i>فهرست عناوین بخشنامه ای</h4>
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
                            <td>  مقالات</td>
                            <td>
                                <a class="mr-2" href="#"  @click="prepareEditModal('papers',1)">
                                    <i class="fa fa-edit blue"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{2|faDigit}}</td>
                            <td>  کتب</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareEditModal('books',2)"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{3|faDigit}}</td>
                            <td>   پایان نامه</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareEditModal('thesis',3)"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{4|faDigit}}</td>
                            <td>  کرسی های نظریه پردازی</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareEditModal('teds',4)"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{5|faDigit}}</td>
                            <td>   داوری</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareEditModal('referees',5)"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{6|faDigit}}</td>
                            <td>   طرح های پژوهشی و فناوری</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareEditModal('projects',6)"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{7|faDigit}}</td>
                            <td>   اختراعات و اکتشافات</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareEditModal('inventions',7)"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{8|faDigit}}</td>
                            <td> جوایز و افتخارات</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareEditModal('rewards',8)"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{9|faDigit}}</td>
                            <td>   گرنت</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareEditModal('grants',9)"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{10|faDigit}}</td>
                            <td>   دوره ها</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareEditModal('courses',10)"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{11|faDigit}}</td>
                            <td>  جزوه ها و اسلایدها</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareEditModal('booklets',11)"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td> {{12|faDigit}}</td>
                            <td>  فعالیت های اجرایی پژوهشی</td>
                            <td>
                                <a class="mr-2" href="#" >
                                    <i class="fa fa-edit blue" @click="prepareEditModal('researchActivity',12)"></i>
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
        <div v-if="$gate.isAdminOrAuthor()" class="modal  fade" id="reuglationEditModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i
                            class="fas fa-building fa-fw"></i> ویرایش بخشنامه {{title}}</h5>
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" >
                        <div class="text-right mt-1 mb-4" >
                            <label class="blue text-right">چکیده<i class="red mx-1">*</i>:</label><br>
                            <i v-show="form.errors.has('detail')" class="red far fa-exclamation-triangle"></i>
                            <span v-show="form.errors.has('detail')" class="red d-inline-block">{{ form.errors.get('detail') }}</span>
                            <tinymce @editorInit="e => e.setContent(form.detail)" @editorChange="removeError('detail')"
                                     :other_options="options" v-validate="'required'" name="detail" v-model="form.detail" id="d1"></tinymce>

                        </div>
                    </div><!-- modal-body -->
                    <div class="modal-footer">
                        <button @click="updateRegulation()" class="btn btn-lg btn-success ripple" >ثبت تغییرات</button>
                    </div>

                </div><!-- /modal-content -->
            </div><!-- /modal-dialog -->
        </div><!-- /checkList History show modal  -->

    </div>
</template>

<script>
    export default {
        name: "Regulations",
        data(){
          return {
              options: {// tinyMce toolbar options
                  height:'600px',
                  directionality : 'rtl',
                  language_url: '../js/fa_IR.js', //This url points to location of persian language file.
                  toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat',
                  toolbar2: ' cut copy paste | ltr rtl | | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor',
                  plugins:['advlist autolink lists link image charmap print preview hr anchor pagebreak', 'searchreplace wordcount visualblocks visualchars code fullscreen', 'insertdatetime media nonbreaking save table contextmenu directionality','template paste textcolor colorpicker textpattern imagetools toc help emoticons hr codesample'],
              },
              title:'',
              form: new Form({
                  id:'',
                  detail:'',
              })
          }
        },
        methods: {
            setTitle(type){
                if(type === 'papers'){
                    this.title = 'مقالات';
                }else if(type === 'books'){
                    this.title = 'کتب';
                }else  if(type === 'thesis'){
                    this.title = 'پایان نامه';
                }else  if(type === 'teds'){
                    this.title = 'کرسی های نظریه پردازی';
                }else  if(type === 'referees'){
                    this.title = 'داوری';
                }else  if(type === 'projects'){
                    this.title = 'طرح های پژوهشی';
                }else  if(type === 'inventions'){
                    this.title = 'اختراعات و ابداعات';
                }else  if(type === 'rewards'){
                    this.title = 'جوایز';
                }else  if(type === 'grants'){
                    this.title = 'گرنت و بودجه های جذب شده';
                }else  if(type === 'courses'){
                    this.title = 'دوره ها';
                }else  if(type === 'booklets'){
                    this.title = 'جزوات و اسلایدها';
                }else  if(type === 'researchActivity'){
                    this.title = 'فعالیت های اجرایی پژوهشی';
                }
            },
            removeError(field){
                this.form.errors.clear(field)
            },
            prepareEditModal(type, id) {
                let loader = Vue.$loading.show();
                axios.get(`/api/regulationDetail/${id}`).then((response)=>{
                    loader.hide();
                    this.setTitle(type);
                    this.form.fill(response.data.data);
                    $('#reuglationEditModal').modal('show');
                }).catch(()=>{
                    loader.hide();
                    this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                });
            },
            updateRegulation(){
                let loader = Vue.$loading.show();
                this.form.put(`/api/regulationDetail/${this.form.id}`)
                    .then(response => {
                        loader.hide();
                        this.form.reset();
                        this.successToast('بخشنامه مربوطه با موفقیت بروزرسانی شد');
                        $('#reuglationEditModal').modal('hide');
                    }).catch(()=>{
                        loader.hide();
                        this.errorSwal('خطایی رخ در شبکه یا سیستم رخ داده است. لطفا پس از مدتی مجددا تلاش کنید.');
                    });
            }
        }
    }
</script>

<style scoped>

</style>
