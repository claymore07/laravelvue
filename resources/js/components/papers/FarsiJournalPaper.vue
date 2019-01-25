<template>
    <div>
        <form  @submit.prevent="createPaper()" @keydown="form.onKeydown($event)" action="" id="Form1">
    <div class="form-group my-5 text-right">
        <label class="blue">نام کاربری:</label>
        <input lang="fa-IR" type="text"  name="fa_title" placeholder="عنوان مقاله"
               class="form-control" v-model.lazy="forms.fa_title"
               @keyup="farsiTypeInputSetter($event.target.value)"
               pattern="[^A-Za-z0-9.-_+*/×-]{1,30}"
               data-error-pattern-mismatch="نام باید فارسی باشد!"

               :class="{ 'is-invalid': forms.errors.has('fa_title') } " @input="() => {}"  required>
    </div>
    <div class="form-group my-5 text-right">
        <label class="blue">نام دانشکده:</label>
        <!--<Select2 class="form-control select2-form-control" id="faculty_id"
                 :class="{ 'is-invalid': form.errors.has('faculty_id') }" v-model="form.faculty_id"
                 :options="faculties"
                 :settings="{theme: 'bootstrap4', placeholder: 'نام دانشکده', width: '100%' }">
        </Select2>
        <has-error :form="form" field="faculty_id"></has-error>-->
    </div>
        <div class="" style="direction: ltr; text-align: right"><date-picker locale="fa,en"></date-picker>
            </div>
        <tinymce id="d1"></tinymce>
        </form>
    </div>

</template>

<script>
    import Select2 from 'v-select2-component'
    export default {
        name: "FarsiJournalPaper",
        props: ['form', 'excerpts'],
        data(){
            return {
                forms: new Form({
                    lang:'',
                    fa_title: '',
                    fa_text: '',
                    en_title: '',
                    en_text: '',
                    doi:'',
                    link:'',
                    license:'',
                    license_to:'',
                    publish_date: '',
                    accept_date: '',
                    en_text: '',
                    excrept_id: '',

                })
            }
        },
        methods:{
            farsiTypeInputSetter(e) {
                  this.forms.fa_title = e;
            },
            createPaper(){
                return this.form.post('api/user')
                    .then(() => {
                        // Fire.$emit('AfterCreate');
                        //$('#addNew').modal('hide');
                        toast({
                            type: 'success',
                            position: 'top-start',
                            title: 'User Created in successfully'
                        });
                        // this.$Progress.finish();
                        this.form.reset();

                        return true;
                    })
                    .catch(() => {
                        // this.$Progress.fail();
                        return true;
                    })
            }
        },
        mounted() {
            console.log('fuck');
            $('#Form1').html5cvm({
                generic: 'این گزینه باید تکمیل شود!',
                typeMismatch: "نوع داده ورودی همخوانی ندارد."
            });
            $('#siba').simpleMask({'mask': '#############'});
            $('#phone').simpleMask({'mask': '###########'});
            // $('#personal_id1').simpleMask( { 'mask': '####'     } );
        },
        components: {
            Select2,
        },
        destroyed(){
            console.log('ssss');
        }
    }
</script>

<style scoped>

</style>
