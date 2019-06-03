<template>
    <select2 :params="params" v-model="value"></select2>
</template>

<script>
    export default {
        props: ['value'],
        watch: {
            'value': function(value) {
                this.$emit('input', value);
            }
        },
        data: function() {
            return {
                params: {
                    tags: true,
                    tokenSeparators: [","],
                    maximumSelectionLength: 5,
                    createTag: function (tag) {
                        return {
                            id: tag.term,
                            text: tag.term,
                            isNew : true
                        };
                    },
                    ajax: {
                        url: "/api/skill/list",
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
                            var data = results.data.map(function(item) {
                                return {
                                    id : item.name,
                                    text : item.name
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
                    templateResult: function(item) {
                        return item.text;
                    },
                    templateSelection: function(item) {
                        return item.text;
                    },
                },
            }
        }
    }
</script>
