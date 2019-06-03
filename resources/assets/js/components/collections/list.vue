<template>
    <div class="row">
        <div v-bind:class="itemClass" v-for="item in collection.getData()">
            <div class="block block-link-hover3">
                <a v-bind:href="element(item).getUrl()">
                    <div class="bg-img block-content block-content-full text-center ribbon ribbon-bookmark ribbon-crystal"
                         v-bind:style="'background-image:url('+element(item).get('image')+'); background-size: cover;'">
                        <div class="ribbon-box font-w600">{{element(item).get('count_items', 0)}} items</div>
                        <div class="item item-2x item-circle bg-black-op bg-crystal-op push-20-t push-20">
                            <i class="fa fa-archive text-white-op"></i>
                        </div>
                        <div class="text-white-op">
                            <em v-text="'by '+element(item).get('creator').getFullname()"></em>
                        </div>
                    </div>
                </a>
                <div class="block-content block-content-full text-center">
                    <h4>
                        <inline-editor :value="element(item).get('name')"
                                       :editable="currentUser && currentUser.get('id') == element(item).get('creator_id')"
                                       @input="change(element(item),$event)"></inline-editor>
                    </h4>
                    <div class="mheight-50 text-gray-dark"><span
                            v-text="element(item).get('count_followers', 0)"></span> followers
                    </div>
                    <div class="row">
                        <div class="col-sm-6 font-s12 text-gray-dark font-w600 text-left">
                            <button class="btn btn-xs btn-default btn-outline" v-if="!currentUser"
                                    v-on:click.prevent="guestMessage"><i class="fa fa-plus push-5-r"></i>Follow
                            </button>
                            <div v-if="currentUser">
                                <button class="btn btn-xs btn-default btn-outline" v-if="!element(item).iFollow()"
                                        v-on:click.prevent="element(item).follow()"><i class="fa fa-plus push-5-r"></i>Follow
                                </button>
                                <button class="btn btn-xs btn-info" v-if="element(item).iFollow()"
                                        v-on:click.prevent="element(item).follow()"><i class="fa fa-plus push-5-r"></i>Unfollow
                                </button>
                            </div>
                        </div>
                        <a href="#" class="col-sm-6 h4 text-danger font-w600 text-right"
                           v-if="currentUser && currentUser.get('id') == element(item).get('creator_id')"
                           v-on:click.prevent="remove(element(item))">
                            <i class="si si-close push-5-r"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {};
        },
        props: {
            collection: {
                type: Object,
                required: true
            },
            child: false,
            itemClass: {
                type: String,
                default: 'col-sm-6 col-lg-4'
            },
        },
        computed: {
            'currentUser': function () {
                return window.currentUser;
            }
        },
        methods: {
            element: function (item) {
                return !this.child ? item : item.get(this.child);
            },
            guestMessage: function () {
                notify.guest("Please login to commit this action.");
            },
            change: function (item,name) {
                var promise = axios.post('/api/collection/' + item.get('slug') + '/save', {
                    name: name,
                });
                promise.then(function (response) {
                    item.setAttributes(response.data);
                });
            },
            remove: function (item) {
                if (this.currentUser.get('id') != item.get('creator_id')) {
                    return false;
                }
                var vm = this;
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this collection!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: true
                }, function () {
                    item.delete(function () {
                        vm.$emit('delete');
                    });
                });
            },
        }
    }
</script>