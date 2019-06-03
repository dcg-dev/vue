<template>
    <select2 :params="params" v-model="value">
        <option v-if="user" :value="user.attributes.id" v-text="user.attributes.username"></option>
    </select2>
</template>

<script>
    export default {
        props: ['value', 'user'],
        watch: {
            'value': function(value) {
                this.$emit('input', value);
            }
        },
        mounted: function () {
            this.$nextTick(function () {
            });
        },
        data: function() {
            return {
                params: {
                    tags: true,
                    tokenSeparators: [","],
                    maximumSelectionLength: 5,
                    createTag: function (tag) {
                        // Don't offset to create a tag if there is no @ symbol
                        if (tag.term.indexOf('@') === -1) {
                            // Return null to disable tag creation
                            return null;
                        }

                        return {
                            id: tag.term,
                            text: tag.term
                        }
                    },
                    ajax: {
                        url: "/api/user/list",
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
                                    id : item.id,
                                    text : item.username,
                                    name : item.username
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
                        return item.name || item.text;
                    },
                    templateSelection: function(item) {
                        return item.name || item.text;
                    },
                },
            }
        }
    }
</script>
