<template>
    <div>
        <div class="block-content" v-if="'undefined' !== typeof form.items && form.items.length > 0">
            <ul class="list list-simple list-li-clearfix">
                <li v-for="item in form.items">
                    <a class="pull-left push-10-r img-rounded" v-bind:href="'/item/' + item.slug">
                       <img v-bind:src="item.image" v-bind:alt="item.name" border="0" width="62" height="62" class="img-rounded">
                    </a>
                    <h5 class="push-10-t" v-text="item.name"></h5>
                    <div class="font-s13" v-text="joinNameCategories(item.categories)"></div>
                </li>
            </ul>
            <div class="text-center push">
                <small><a v-bind:href="route">View More..</a></small>
            </div>
        </div>
        <div class="block-content empty-collection" v-else>
            <div class="text-center push">
                <small>User doesn't have any items</small>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {}
        },
        props: {
            form: {
                required: true
            },
            route: {
                type: String,
                required: true
            }
        },
        mounted: function () {
        },
        methods: {
            joinNameCategories: function(categories) {
               return categories[0] ? categories[0].name : '';
            }
        }
    }
</script>