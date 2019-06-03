<template>
    <select>
        <slot></slot>
    </select>
</template>

<script>
    export default {
        props: ['options', 'value', 'params'],
        mounted: function () {
            var vm = this;
            var params = !this.params ? {} : this.params;
            params.val = this.value;
            if(this.options) {
                params.data = this.options;
            }
            $(this.$el).val(this.value);
            $(this.$el).select2(params);
            $(this.$el).on('change', function () {
                vm.$emit('input', $(this).val()) 
            })
            $(this.$el).val(this.value).trigger('change');
        },
        watch: {
            value: function (value) {
                $(this.$el).val(value);
            },
            options: function (options) {
                var params = !this.params ? {} : this.params;
                if(this.options) {
                    params.data = this.options;
                }
                $(this.$el).select2(params);
            }
        },
        destroyed: function () {
            $(this.$el).off().select2('destroy')
        }
    }
</script>
