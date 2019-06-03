<template>
    <div>
        <div class="block-content" v-if="'undefined' !== typeof form.ratings && form.ratings.length > 0">
            <ul class="list list-simple">
                <li v-for="rating in form.ratings">
                    <div class="push-5 clearfix">
                        <div class="text-warning pull-right">
                            <stars :rating="rating.rating"></stars>
                        </div>
                        <a class="font-w600" v-bind:href="'/user/' + rating.creator.username"
                           v-text="rating.creator.username"></a>
                        <span class="text-muted" v-text="'(' + rating.rating + '/5)'"></span>
                    </div>
                    <div class="font-s13" v-text="rating.review"></div>
                </li>
            </ul>
            <div class="text-center push">
                <small><a v-bind:href="route">Read More..</a></small>
            </div>
        </div>
        <div class="block-content empty-collection" v-else>
            <div class="text-center push">
                <small>User doesn't have any ratings</small>
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
        }
    }
</script>
