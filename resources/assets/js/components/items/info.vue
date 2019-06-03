<template>
    <div class="block">
        <div class="block-content">
            <div class="row items-push">
                <div class="col-sm-12">
                    <div class="row js-gallery">
                        <div class="col-xs-12 push-10">
                            <div class="item-image">
                                <img class="img-responsive" v-bind:src="item.get('image')" alt="">
                                <a href="/profile/promotions" class="btn btn-success-modern btn-sm item-promote" v-if="canPromote">
                                    <i class="si si-rocket"></i>
                                    Promote
                                </a>
                            </div>
                            <player v-if="item.get('demo')" id="demo-player" v-bind:sound="item.get('demo')" v-bind:name="item.get('name')" v-bind:artist="item.get('creator').getFullname()"></player>
                        </div>

                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="block">
                        <ul class="nav nav-tabs nav-tabs-alt" data-toggle="tabs">
                            <li class="active" v-if="item.get('description', false)">
                                <a href="#ecom-product-info" v-on:click.prevent="tabShow($event)">Info</a>
                            </li>
                            <li>
                                <a href="#ecom-product-comments" v-on:click.prevent="tabShow($event)">Comments</a>
                            </li>
                            <li>
                                <a href="#ecom-product-reviews" v-on:click.prevent="tabShow($event)">Reviews</a>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            <div class="tab-pane pull-r-l active" id="ecom-product-info" v-if="item.get('description', false)" v-html="item.get('description')"></div>
                            <div class="tab-pane pull-r-l" id="ecom-product-comments">
                                <comment-form class="push-15" :item="item"></comment-form>
                                <div v-if="!item.get('comments').isEmpty()">
                                    <comment v-for="comment in item.get('comments').getData()" :comment="comment" :author="item.get('creator_id')" :key="comment.get('id')" v-on:like="like"></comment>
                                    <collection-pagination :collection="item.get('comments')" :history="false" v-on:go="commentPage"></collection-pagination>
                                </div>
                                <div v-if="item.get('comments').isEmpty()" class="text-center">
                                    The item doesn't have any comments.
                                </div>
                            </div>
                            <div class="tab-pane pull-r-l" id="ecom-product-reviews">
                                <div class="block block-rounded">
                                    <div class="block-content bg-gray-lighter text-center">
                                        <stars class="h2 text-warning push-10" :rating="item.get('rating',0)"></stars>
                                        <p>
                                            <strong v-text="item.get('rating', 0)"></strong>/5 out of <strong v-text="item.get('count_rating', 0)"></strong> Ratings
                                        </p>
                                    </div>
                                </div>
                                <div v-if="!item.get('ratings').isEmpty()">
                                    <rating-overview v-for="rating in item.get('ratings').getData()" :rating="rating" :key="rating.get('id')"></rating-overview>
                                </div>
                                <div v-if="item.get('ratings').isEmpty()" class="text-center">
                                    The item doesn't have any reviews.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
            item: {
                required: true
            }
        },
        computed: {
          canPromote: function () {
              return currentUser && currentUser.get('id') == this.item.get('creator_id');
          }
        },
        methods: {
            tabShow: function (event) {
                this.$parent.tabShow(event);
            },
            like: function(comment) {
                this.$parent.like(comment);
            }, 
            commentPage: function(page) {
                this.$parent.commentPage(page);
            },
        }
    }
</script>