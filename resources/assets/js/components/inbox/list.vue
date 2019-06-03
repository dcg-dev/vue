<template>
    <!-- Message List -->
    <div class="block" :class="{'block-opt-refresh': loading, 'block-opt-fullscreen' : fullscreent}">
        <div class="block-header bg-gray-lighter">
            <ul v-if="!threads.isEmpty()" class="block-options">
                <li>
                    <button class="js-tooltip" title="Previous 15 Messages" type="button"
                            v-on:click="go(threads.current_page - 1)" :disabled="threads.isFirstPage()"><i
                            class="si si-arrow-left"></i></button>
                </li>
                <li>
                    <button class="js-tooltip" title="Next 15 Messages" type="button"
                            v-on:click="go(threads.current_page + 1)" :disabled="threads.isLastPage()"><i
                            class="si si-arrow-right"></i></button>
                </li>
                <li>
                    <button type="button" v-on:click="refresh()"><i class="si si-refresh"></i></button>
                </li>
                <li>
                    <button type="button" v-on:click="fullscreent = !fullscreent"><i
                            :class="fullscreent ? 'si si-size-actual' : 'si si-size-fullscreen'"></i></button>
                </li>
            </ul>
            <div v-if="!threads.isEmpty()" class="block-title text-normal">
                <strong v-text="threads.from"></strong>-<strong v-text="threads.to"></strong> <span class="font-w400">from</span>
                <strong v-text="threads.total"></strong>
            </div>
        </div>
        <div class="block-content">
            <div v-if="!threads.isEmpty()">
                <!-- Messages Options -->
                <div class="push">
                    <button class="btn btn-default pull-right" type="button" v-on:click="deleteThreads()"
                            :disabled="threadsChecked.length == 0"><i
                            class="fa fa-times text-danger push-5-l push-5-r"></i> <span class="hidden-xs">Delete</span>
                    </button>
                    <div v-if="current != 'trash'" class="btn-group">
                        <button v-if="current != 'archive'" class="btn btn-default" type="button"
                                v-on:click="setArchive(true)" :disabled="threadsChecked.length == 0"><i
                                class="fa fa-archive text-primary push-5-l push-5-r"></i> <span class="hidden-xs">Archive</span>
                        </button>
                        <button v-if="current == 'archive'" class="btn btn-default" type="button"
                                v-on:click="setArchive(false)" :disabled="threadsChecked.length == 0"><i
                                class="fa fa-archive text-primary push-5-l push-5-r"></i> <span class="hidden-xs">Unarchive</span>
                        </button>
                        <button v-if="current != 'star'" class="btn btn-default" type="button"
                                v-on:click="setStar(true)" :disabled="threadsChecked.length == 0"><i
                                class="fa fa-star text-warning push-5-l push-5-r"></i> <span
                                class="hidden-xs">Star</span></button>
                        <button v-if="current == 'star'" class="btn btn-default" type="button"
                                v-on:click="setStar(false)" :disabled="threadsChecked.length == 0"><i
                                class="fa fa-star text-warning push-5-l push-5-r"></i> <span
                                class="hidden-xs">Unstar</span></button>
                    </div>
                    <div v-if="current == 'trash'" class="btn-group">
                        <button class="btn btn-default pull-right" type="button" v-on:click="restore()"
                                :disabled="threadsChecked.length == 0"><i
                                class="fa fa-history text-success push-5-l push-5-r" aria-hidden="true"></i> <span
                                class="hidden-xs">Restore</span></button>
                    </div>
                </div>
                <!-- END Messages Options -->

                <!-- Messages & Checkable Table (.js-table-checkable class is initialized in App() -> uiHelperTableToolsCheckable()) -->
                <div class="pull-r-l">
                    <table class="js-table-checkable table table-hover table-vcenter">
                        <tbody>
                        <tr v-for="thread in threads.getData()">
                            <td class="text-center" style="width: 70px;">
                                <label class="css-input css-checkbox css-checkbox-primary">
                                    <input name="threadsChecked[]" type="checkbox" v-model="threadsChecked"
                                           v-bind:value="thread.get('id')"><span></span>
                                </label>
                            </td>
                            <td v-on:click="showView(thread)" class="hidden-xs font-w600"
                                :class="{'font-w600': thread.get('no_read'), 'text-black': thread.get('no_read')}"
                                style="width: 240px;"
                                v-text="thread.getUser(user) + (thread.get('count') > 1 ? ' (' + thread.get('count') + ')' : '')"></td>
                            <td v-on:click="showView(thread)">
                                <a :class="{'font-w600': thread.get('no_read'), 'text-black': thread.get('no_read')}"
                                   v-text="thread.get('subject')"></a>
                                <div class="text-muted push-5-t" :class="{'text-black': thread.get('no_read')}"
                                     v-html="thread.getTruncateMessage(100)"></div>
                            </td>
                            <td v-on:click="showView(thread)" class="visible-lg text-muted"
                                :class="{'text-black': thread.get('no_read')}" style="width: 140px;">
                                <em v-text="thread.get('updated_at').fromNow()"></em>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div v-if="threads.isEmpty()" class="text-center panel">
                No messages
            </div>
        </div>
        <inbox-view ref="view" v-on:refresh="refresh"></inbox-view>
    </div>
    <!-- END Message List -->
</template>
<script>
    export default {
        data: function () {
            return {
                loading: false,
                threadsChecked: [],
                messageTitle: '',
                messageLoading: false,
                thread: new Model(),
                openView: false,
                fullscreent: false,
            };
        },
        props: {
            threads: {
                type: Object,
                required: true
            },
            loading: {
                type: Boolean
            },
            current: {
                type: String,
                required: true
            },
            user: {
                type: Number,
                required: true
            }
        },
        watch: {
            'fullscreent': function (value) {
                if(value) {
                    jQuery(this.$el).scrollLock('enable');
                } else {
                    jQuery(this.$el).scrollLock('disable');
                }
                console.log(value);
            }
        },
        computed: {
            currentUser: function () {
                return window.currentUser;
            }
        },
        methods: {
            deleteThreads: function () {
                if (this.current == 'trash') {
                    var _this = this;
                    swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this message!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: true
                    }, function () {
                        axios.post('/api/inbox/thread/force-delete', {ids: _this.threadsChecked}).then((response) => {
                            _this.refresh();
                            _this.threadsChecked = [];
                            _this.$emit('refresh');
                        }, (error) => {
                            toastr.error("An error occurred!", 'Inbox');
                        });
                    });
                } else {
                    axios.post('/api/inbox/thread/bulk-destroy', {ids: this.threadsChecked}).then((response) => {
                        this.refresh();
                        this.threadsChecked = [];
                        this.$emit('refresh');
                    }, (error) => {
                        toastr.error("An error occurred!", 'Inbox');
                    });
                }
            },
            restore: function () {
                axios.post('/api/inbox/thread/bulk-restore', {ids: this.threadsChecked}).then((response) => {
                    this.refresh();
                    this.threadsChecked = [];
                    this.$emit('refresh');
                }, (error) => {
                    toastr.error("An error occurred!", 'Inbox');
                });
            },
            refresh: function () {
                this.$emit('refresh');
            },
            go: function (page) {
                this.$emit('go', page);
            },
            showView: function (thread) {
                thread.set('no_read', 0);
                this.thread = thread;
                this.$refs.view.show(thread.get('id'), thread.get('subject'));
            },
            setArchive: function (value) {
                axios.post('/api/inbox/thread/bulk-archive', {
                    ids: this.threadsChecked,
                    value: value
                }).then((response) => {
                    this.refresh();
                    this.threadsChecked = [];
                    this.$emit('refresh');
                }, (error) => {
                    toastr.error("An error occurred!", 'Inbox');
                });
            },
            setStar: function (value) {
                axios.post('/api/inbox/thread/bulk-star', {ids: this.threadsChecked, value: value}).then((response) => {
                    this.refresh();
                    this.threadsChecked = [];
                    this.$emit('refresh');
                }, (error) => {
                    toastr.error("An error occurred!", 'Inbox');
                });
            }
        },
        filters: {
            formatDate: function (value) {
                if (value) {
                    return moment.unix(value).format('MMMM DD, YYYY - hh:mm')
                }
            },
        }
    }
</script>