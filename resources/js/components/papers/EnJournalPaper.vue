<template>
    <div>
    <div class="form-group my-5 text-right">
        <label class="blue">Your Name:</label>
       <input v-model="form.name" type="text" name="name" placeholder="نام کاربری"
               class="form-control" :class="{ 'is-invalid': form.errors.has('name') }"
               pattern="[A-Za-z]{6,}"
               data-error-pattern-mismatch="نام کاربری باید به زبان انگلیسی به طول بیش از 6 کاراکتر باشد!"
               data-error-generic="این فیلد باید تکمیل شود."
               required>
        <has-error :form="form" field="name"></has-error>
    </div>
    <div class="form-group my-5 text-right">
        <label class="blue">نام دانشکده:</label>
        <Select2 class="form-control select2-form-control" id="faculty_id"
                 :class="{ 'is-invalid': form.errors.has('faculty_id') }" v-model="form.faculty_id"
                 :options="faculties"
                 :settings="{theme: 'bootstrap4', placeholder: 'نام دانشکده', width: '100%' }">
        </Select2>
        <has-error :form="form" field="faculty_id"></has-error>
    </div>
        <div class="" style="direction: ltr; text-align: right"><date-picker locale="fa,en"></date-picker>
            </div>
        <tinymce id="d1"></tinymce>

    </div>
</template>

<script>
    import Select2 from 'v-select2-component'
    export default {
        name: "FarsiJournalPaper",
        props: ['form', 'faculties'],
        data(){
            return {
                'fomr': this.$parent.form
            }
        },
        mounted() {
            $('#Form').html5cvm({
                generic: 'این گزینه باید تکمیل شود!',
                typeMismatch: "نوع داده ورودی همخوانی ندارد."
            });
            $('#siba').simpleMask({'mask': '#############'});
            $('#phone').simpleMask({'mask': '###########'});
            // $('#personal_id1').simpleMask( { 'mask': '####'     } );
        },
        components: {
            Select2,
        }
    }
</script>

<style scoped>

</style>
