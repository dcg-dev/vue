<template>
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document" v-if="model">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" v-text="(!model.isNew()) ? 'Edit '+model.get('name') : 'Add country'"></h4>
                </div>
                <div class="modal-body">
                    <div v-if="model.isNew()" v-bind:class="'form-group'+(errors.name ? ' has-error' : '')">
                        <label>Country</label>
                        <countries v-model="model.attributes.name" :without="exists"></countries>
                        <span class="help-block" v-if="errors.name">
                            <div v-for="error in errors.name"><strong v-text="error"></strong></div>
                        </span>
                    </div>
                    <div v-bind:class="errors.vat ? 'form-group has-error' : 'form-group'">
                        <label>Vat</label>
                        <input type="number" class="form-control" v-model="model.attributes.vat">
                        <span class="help-block" v-if="errors.vat">
                                    <div v-for="error in errors.vat">
                                        <strong v-text="error"></strong>
                                    </div>
                                </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="ladda-button btn btn-primary" data-style="expand-right"
                            v-on:click="save($event)">Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['model'],
        watch: {
            'value': function (value) {
                this.$emit('input', value);
            }
        },
        data: function () {
            return {
                errors: [],
            };
        },
        computed: {
            exists: function() {
                return this.$parent.countries.pluck('name');
            }
        },
        mounted: function () {
            var vm = this;
//            setTimeout(function(){
//                vm.exists = vm.$parent.countries.pluck('name');
//            }, 500);
            $(this.$el).on('show.bs.modal, hide.bs.modal', function () {
                vm.errors = [];
            });
        },
        methods: {
            save: function (event) {
                var button = $(event.target).ladda();
                this.errors = [];
                var vm = this;
                button.ladda('start');
                this.model.save(function (country) {
                    button.ladda('stop');
                    vm.$emit('success', country);
                }, function (error) {
                    if (error.response.status == 422) {
                        vm.errors = error.response.data;
                    }
                    vm.$emit('error', error);
                    button.ladda('stop');
                });
            }
        }
    }
</script>
