<template>
    <select2 :params="params" v-model="value"></select2>
</template>

<script>
    export default {
        props: {
            'value': {
                required: true
            },
            'query': {
                type: Object,
                default: {}
            },
        },
        watch: {
            'value': function (value) {
                this.$emit('input', value);
            }
        },
        data: function () {
            var vm = this;
            return {
                params: {
                    tags: false,
                    tokenSeparators: [","],
                    maximumSelectionLength: 5,
                    createTag: function (tag) {
                        console.log(tag);
                        return tag.id
                    },
                    ajax: {
                        url: "/api/item/list/my",
                        dataType: 'json',
                        delay: 0,
                        casesensitive: false,
                        data: function (params) {
                            return Object.assign({
                                q: params.term,
                                page: params.page,
                                per_page: 20
                            }, vm.query);
                        },
                        processResults: function (results, params) {
                            params.page = params.page || 0;
                            var data = results.data.map(function (item) {
                                return {
                                    id: item.id,
                                    text: item.name,
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
        }
    }
</script>
