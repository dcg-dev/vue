<template>
    <select2 :options="categories" @input="change" :value="value" v-if="categories.length"></select2>
</template>

<script>
    export default {
        props: ['value'],
        data: function() {
            return {
                categories: []
            };
        },
        mounted: function () {
            this.getCategories();
        },
        methods: {
            getCategories: function() {
                axios.get('/api/category/list/select').then((response) => {
                    if (response.data) {
                        this.categories = response.data;
                    }
                }, (error) => {
                    toastr.error("An error occurred while retrieving the category list, please try again later or contact the administrator!", 'Authentication');
                });
            },
            change: function (value) {
                this.$emit('input', value);
            }
        }
    }
</script>
