<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-popout">
            <div class="modal-content">
                <div class="block block-themed block-transparent block-rounded remove-margin-b">
                    <div class="block-header bg-white">
                        <ul class="block-options">
                            <li>
                                <button data-dismiss="modal" type="button"><i class="si si-close fa-2x text-gray"></i></button>
                            </li>
                        </ul>
                        <h3 class="font-w600">Request Payout</h3>
                    </div>
                    <div class="block-content">
                        <div class="row">
                            <div class="col-sm-12 push-20">
                                <label>Message</label>
                                <div v-bind:class="'form-group' + (errors.title ? ' has-error' : '')">
                                    <textarea class="form-control" v-model="message" placeholder="Please state your Paypal, Bank Account where you want to receive the payout."></textarea>
                                    <span class="help-block" v-if="errors.message">
                                        <div v-for="error in errors.message"><strong v-text="error"></strong></div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-header">
                        <div class="row">
                            <div class="col-sm-6 text-left">
                                <button class="btn btn-lg btn-default font-w400" type="button" data-dismiss="modal">Cancel</button>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button class="btn btn-lg btn-success-modern push-right font-w400" type="button" data-style="expand-right" v-on:click="makeRequest($event)">Make Request</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        data(){
            return {
                message: null,
                errors: {},
                button: null
            }
        },
        props: {
            user: {
                required: true
            },
        },
        mounted: function () {
        },
        methods: {
            makeRequest: function(event) {
                var that = this;
                that.errors = [];
                that.user.makeAffiliateRequest({message: this.message}, function () {
                    notify.success('Payout request has been sent successfully!', 'AffiliateSales');
                    that.$emit('maderequest');
                }, function (error) {
                    if(error.response.status == 422) {
                        that.errors = error.response.data;
                        toastr.error(error, 'AffiliateSales');
                    }
                });
            },
        }
    }
</script>
