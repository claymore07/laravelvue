<template>
    <div>
        <div class="container-fluid text-rtl text-right my-5">
            <div class="card card-4 my-5">
                <div class="card-header justify-content-around d-flex " style="direction: rtl">
                    <div class="col">
                        <h3 class=" text-right"><i class="fal fa-scroll-old fa-fw"></i> اطلاعات پروپوزال پژوهشی</h3>
                    </div>
                    <div class="card-tools">
                        <button class="btn btn-success" @click="goback"><i style="font-size: 16px" class="fal fa-undo"></i> بازگشت</button>
                    </div><!-- /card-tools -->
                </div><!-- /.card-header -->
                <div class="card-body  px-0">
                    <table class="table table-hover table-striped">
                        <thead class="thead-dark">
                        <tr>
                            <th class="font-18"><i class="fal fa-project-diagram fa-fw"></i> اطلاعات پروپوزال پژوهشی</th>

                        </tr>
                        </thead>
                        <tbody v-if="proposal.id">
                        <tr>
                            <td class="font-16">
                                <span class="blue">عنوان فارسی :</span>
                                <span class="mr-3">{{proposal.title}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">عنوان انگلیسی :</span>
                                <span class="mr-3">{{proposal.en_title}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue ">نویسندگان:</span>
                                <span v-for="author of proposal.Authors" class="mr-3 ">
                                        <span >{{author.name}}،</span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="font-16">
                                <span class="blue">نوع پروپوزال :</span>
                                <span class="mr-3">{{proposal.proposal_type}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">نوع کاربرد پروپوزال :</span>
                                <span class="mr-3">{{proposal.proposal_usage}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">دانشکده :</span>
                                <span class="mr-3">{{proposal.faculty}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">محل اجرا :</span>
                                <span class="mr-3">{{proposal.project_location}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">مدت زمان مورد نیاز :</span>
                                <span class="mr-3">{{proposal.duration}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">ارزش تخمینی پروژه:</span>
                                <span  class="mr-3 persian-num">{{proposal.value | currency}} ریال </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue">بودجه طرح پژوهشی:</span>
                                <span  class="mr-3 persian-num">{{proposal.budget | currency}} ریال </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue ">کلمات کلید:</span>
                                <span v-for="tag of proposal.tags" class="mr-3 "> {{tag.name}}، </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16">
                                <span class="blue ">فایل های ضمیمه:</span>
                                <span v-for="(file, index) of proposal.files" class="mr-3 ">
                                    <div v-if="checkFileType(file)" class="btn-group text-ltr" role="group" aria-label="Basic example">
                                         <a  class="btn btn-lg btn-info" :href="'../files/proposals/'+file.name"><i class="fal fa-download fa-fw"></i>  </a>
                                         <a  class="btn btn-lg btn-info" :href="'../files/proposals/'+file.name">ضمیمه {{index+1|faDigit}}  <i class="fal fa-file-archive fa-fw"></i></a>
                                    </div>
                                    <div v-else class="btn-group text-ltr" role="group" aria-label="Basic example">
                                      <a  :href="'../files/proposals/'+file.name" class="btn btn-lg btn-info"><i class="fal fa-download"></i></a>
                                      <button @click="pdfModal(file.name)" type="button" class="btn btn-lg btn-info">ضمیمه {{index+1|faDigit}} <i class="fal fa-file-pdf fa-fw"></i></button>

                                    </div>
                            </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16" >
                                <span class="blue ">چکیده :</span><br>
                                <div v-html="proposal.abstract"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16" >
                                <span class="blue ">مقدمه :</span><br>
                                <div v-html="proposal.introduction"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16" >
                                <span class="blue ">بیان مسئله :</span><br>
                                <div v-html="proposal.problem"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16" >
                                <span class="blue ">نوآوری :</span><br>
                                <div v-html="proposal.innovation"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-16" >
                                <span class="blue ">نیازمندی ها :</span><br>
                                <div v-html="proposal.requirements"></div>
                            </td>
                        </tr>



                        <tr>
                            <td class="font-16">
                                <span class="blue ">وضعیت بررسی:</span>
                                <span v-if="proposal.status == '0'"  class="teal"><i class="fal fa-question"></i>  {{'بررسی نشده' }}</span>
                                <span v-else-if="proposal.status == '1'"  class="green"><i class="fal fa-check"></i>  {{'تایید شده' }}</span>
                                <span v-else-if="proposal.status == '2'"  class="green"><i class="fal fa-search"></i>  {{'تایید شده با اصلاحات' }}</span>
                                <span v-else  class="red"><i class="fal fa-times"></i>  {{'عدم تایید قطعی' }}</span>

                            </td>
                        </tr>

                        <tr v-if="proposal.status != 0">
                            <td class="font-16">
                                <span class="blue ">نظر شما :</span><br>
                                <div v-html="proposal.comment">

                                </div>
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
                                        <option value="1" ><i class="fa-check"></i>تایید </option>
                                        <option value="2" >تایید با اصلاحات</option>
                                        <option value="3" >عدم تایید </option>
                                    </select>
                                    <i v-show="checkListForm.errors.has('status')" class="red far fa-exclamation-triangle"></i>
                                    <span v-show="checkListForm.errors.has('status')" class="red d-inline-block">{{ checkListForm.errors.get('status') }}</span>
                                </form>
                            </td>
                        </tr>
                        <tr  v-show="checkList">
                            <td colspan="2">
                                <form  data-vv-scope="checkListForm">
                                    <label for="id00" class="blue mt-3">توضیحات: </label>
                                    <i v-show="checkListForm.errors.has('comment')" class="red far fa-exclamation-triangle"></i>
                                    <span v-show="checkListForm.errors.has('comment')" class="red d-inline-block">{{ checkListForm.errors.get('comment') }}</span>
                                    <tinymce dir="rtl" @editorInit="e => e.setContent(checkListForm.comment)" v-model="checkListForm.comment" :other_options="options" name="comment" id="id00"></tinymce>
                                </form>
                            </td>
                        </tr>

                        <!-- /conference detail part -->
                        </tbody><!-- /tbody -->
                    </table><!-- /table -->
                </div><!-- /card-body -->

            </div><!-- /card -->
            <div class="row align-content-center">
                <div class="fixed-bottom mx-auto d-md-flex bg-white   justify-content-center py-2">
                    <button v-if="checkList" @click="checkListSubmit" class="btn btn-lg btn-success mx-5"><i class="fal fa-check fa-fw"></i>ثبت نتبجه بررسی</button>
                    <button v-if="proposal.status == 0" @click="toggleCheckList"  class="btn btn-lg mx-1 btn-warning">ارسال نظر</button>
                </div>
            </div>
        </div><!-- /container -->

        <!--pdf show modal -->
        <div class="modal  fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i
                            class="far fa-file-alt fa-fw"></i> مشاهده ضمیمه پروپوزال پژوهشی</h5>
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
    </div>
</template>

<script>
    export default {
        name: "ReviewItem",
        data(){
            return {
                options: { // tinyMce toolbar options
                    directionality : 'rtl',
                    language_url: '../js/fa_IR.js', //This url points to location of persian language file.
                    toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat',
                    toolbar2: ' cut copy paste | ltr rtl | | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor',
                    plugins:['advlist autolink lists link image charmap print preview hr anchor pagebreak', 'searchreplace wordcount visualblocks visualchars code fullscreen', 'insertdatetime media nonbreaking save table contextmenu directionality','template paste textcolor colorpicker textpattern imagetools toc help emoticons hr codesample'],
                },
                proposal:{},
                pdfFileName:'',     // will be used to display pdf files in modal

                checkList:false,
                checkListForm: new Form({
                    id:'',
                    research_proposal_id:'',
                    status:null,
                    comment:'',
                }),


            }
        },
        methods:{

            checkListSubmit(){
                this.$Progress.start();
                this.checkListForm.id =this.id;
                this.checkListForm.research_proposal_id =this.proposal.id;
                this.checkListForm.post('/api/ReviewerComment/'+this.id)
                    .then((response) => {
                        this.proposal.status = this.checkListForm.status;

                        this.successToast('نتایج بررسی با موفقیت ثبت شد.');
                        this.toggleCheckList();
                        this.$Progress.finish();

                    })
                    .catch(() => {
                        this.errorSwal('خطایی رخ داد، لطفا ورودی ها را مجدد بررسی کنید!');
                        this.$Progress.fail();
                    })
            },
            toggleCheckList(){
                this.checkList = !this.checkList;
            },
            checkListHistory(){
                $('#checkListHistoryShow').modal('show');
            },
            goback(){
                this.$router.go(-1);
            },

            pdfModal(name){
                this.pdfFileName = '../files/proposals/'+name+'#page=1';
                $('#pdfModal').modal('show');
            },
            // checks the file type on render to see if it is pdf or zip
            checkFileType(file){
                var fileName = file.name.split(".");
                return fileName[1] == 'zip' || fileName[1] == 'rar'? true:false;
            },
            // on page load gets thesis data based on the received it
            getProposalData(id){
                axios.get(`/api/showProposalToReview/${id}`)
                    .then(response => {
                        this.proposal = response.data.data;
                        this.checkListForm.comment = this.proposal.comment;
                        //this.term_form.term_id = this.proposal.term_id;

                    })
                    .catch((e)=>{
                            console.log(e);
                        }
                    );
            },
            createProject(){

            }
        },
        created(){
            this.$parent.pageName = 'آرشیو پروپوزال های پژوهشی';

            this.id = this.$route.params.id;

            this.getProposalData(this.id);
        },
        components:{
        }
    }
</script>

<style scoped>

</style>

