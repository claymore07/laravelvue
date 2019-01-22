<template>
    <select class="input-lg">
        <slot></slot>
    </select>
</template>

<script>
    import Select2 from 'select2'
    export default {
        name: "Select2",
        props: ['options', 'value'],
        data(){
          return{
              msg:'hello vue'
          }
        },
        mounted() {
            var vm = this
            $(this.$el)
            // init select2
                .select2({ data: this.options, dropdownParent: $('#addNew')})
                .val(this.value)
                .trigger('change')
                // emit event on change.
                .on('change', function () {
                    vm.$emit('input', this.value)
                })
        },
        watch: {
            value: function (value) {
                // update value
                $(this.$el)
                    .val(value)
                    .trigger('change')
            },
            options: function (options) {
                // update options
                $(this.$el).empty().select2({ data: options })
            }
        },
        destroyed() {
            $(this.$el).off().select2('destroy')
        }
    }
</script>

<style scoped>

</style>
