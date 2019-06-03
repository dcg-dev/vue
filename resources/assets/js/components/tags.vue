<template>
    <select2 :params="params" @input="change" :options="options" :value="value"></select2>
</template>

<script>
    export default {
        props: ['value'],
        data: function () {
            return {
                options: [],
                params: {
                    tags: true,
                    tokenSeparators: [","],
                    maximumSelectionLength: 5,
                    createTag: function (tag) {
                        return {
                            id: tag.term,
                            text: tag.term,
                            isNew: true
                        };
                    },
                    ajax: {
                        url: "/api/tag/list",
                        dataType: 'json',
                        delay: 0,
                        casesensitive: false,
                        data: function (params) {
                            return {
                                q: params.term,
                                page: params.page
                            };
                        },
                        processResults: function (results, params) {
                            params.page = params.page || 0;
                            var data = results.data.map(function (item) {
                                return {
                                    id: item.name,
                                    text: item.name
                                };
                            });
                            return {
                                results: data,
                                pagination: {
                                    more: (data.length == 20)
                                }
                            };
                        },
                        cache: false
                    },
                    minimumInputLength: 2,
                    templateResult: function (item) {
                        return item.text;
                    },
                    templateSelection: function (item) {
                        return item.text;
                    },
                },
            }
        },
        created: function () {
            var self = this;
            if (this.value instanceof Array) {
                this.options = [];
                this.value.forEach(function (item) {
                    self.options.push({
                        id: item,
                        text: item,
                    });
                });
            }
        },
        methods: {
            change: function (value) {
//                $(this.$el).focus();
                this.$emit('input', value);
            }
        }
    }
</script>
