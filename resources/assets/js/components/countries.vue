<template>
    <select class="form-control input-lg" v-model="value" style="width:100%">
        <option value="">-- Select country --</option>
    </select>
</template>

<script>
    export default {
        props: {
            'value': {
                required: true
            },
            'without': {
                type: Array,
                default: function () {
                    return [];
                }
            }
        },
        watch: {
            'value': function (value) {
                $(this.$el).val(value).trigger('change');
            },
            'without': function () {
                $(this.$el).off().select2('destroy');
                $(this.$el).empty()
                this.init();
            }
        },
        mounted: function () {
            this.init();
        },
        methods: {
            init: function () {
                var that = this;
                $(this.$el).select2({
                    placeholder: 'Select country',
                    data: that.countries(),
                });
                $(this.$el).on('change', function () {
                    that.$emit('input', $(this).val());
                });
            },
            countries: function () {
                var results = [];
                if (this.without) {
                    for (var index in _countries) {
                        if (this.without.indexOf(_countries[index]) === -1) {
                            results.push(_countries[index]);
                        }
                    }
                }
                return results;
            },
        },
        destroyed: function () {
            $(this.$el).off().select2('destroy');
        }
    }
</script>