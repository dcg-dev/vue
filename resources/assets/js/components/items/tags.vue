<template>
    <div class="block" v-if="!item.get('tags').isEmpty()">
        <div class="block-content block-content-full clearfix remove-margin-t">
            <i class="fa fa-fw fa-tags"></i>
            <a class="label label-default m-r" v-for="tag in item.get('tags').getData()"
               v-bind:href="route + '?tags[0]=' + tag.get('id')">{{ tag.get('name') | lowercase}}</a>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {}
        },
        props: {
            item: {
                required: true
            },
            route: {
                type: String,
                required: true
            }
        },
        mounted: function () {
        },
        methods: {}
    }
</script>