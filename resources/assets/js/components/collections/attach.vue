<template>
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="vertical-alignment-helper"> 
        <div class="modal-dialog modal-dialog-popout vertical-align-center">
            <div class="modal-content">
                <div class="block block-themed block-transparent block-rounded remove-margin-b">
                    <div class="block-header bg-white">
                        <ul class="block-options">
                            <li>
                                <button data-dismiss="modal" type="button"><i class="si si-close fa-2x text-gray"></i></button>
                            </li>
                        </ul>
                        <h3 class="font-w600">Add item to collection</h3>
                    </div>
                    <div class="block-content">
                        <div class="row">
                            <div class="col-sm-12 push-20">
                                <div v-bind:class="'form-group'+(errors.collection ? ' has-error' : '')">
                                    <select class="form-control" v-model="collection">
                                        <option v-for="item in collections.getData()" v-bind:value="item.get('id')" v-text="item.get('name')"></option>
                                    </select>
                                    <span class="help-block" v-if="errors.collection">
                                        <div v-for="error in errors.collection"><strong v-text="error"></strong></div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-header">
                        <div class="row">
                            <div class="col-sm-6 text-left">
                                <button class="btn btn-default font-w400" type="button" v-on:click="newCollection">Create Collection</button>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button class="btn btn-default font-w400" type="button" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-success-modern push-right font-w400" type="button" v-on:click="submit"> Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <collection-create id="collection-create" v-on:create="create"></collection-create>
</div>
</template>
<script>
  export default {
    data: function() {
        return {
            collection: null,
            collections: new ItemCollections(),
            errors: [],
        };
    },
    props: {
        item: {
            type: Object,
            required: true
        },
    },
    mounted: function () {
        this.get();
    },
    methods: {
        newCollection: function() {
            $('#collection-create').modal('toggle');
        },
        create: function(collection) {
            var vm = this;
            $('#collection-create').modal('hide');
            this.get(function(){
                vm.collection = collection.get('id');
            });
        },
        clearForm: function() {
            this.collection = null;
        },
        toggle: function(event) {
            $(this.$el).modal('toggle');
        },
        get: function(callback) {
            if(!currentUser) {
                return false;
            }
            var vm = this;
            itemCollections().user(currentUser.get('username'), function(list){
                vm.collections = list;
                if(callback) {
                    callback();
                }
            }, function(){
                vm.collections = new ItemCollections();
            }, {
                per_page: 100
            });
        },
        submit: function() {
            this.errors = []; 
            var vm = this;
            var collection = this.collections.find(this.collection);
            if(!collection) {
                console.error('Item not found!');
                return false;
            }
            collection.attachItem(this.item.get('id'), function(response) {
                vm.errors = [];
                if (response.data.status) {
                    notify.success("The item was successfully added to the collection.", 'Collection');
                    vm.clearForm();
                    vm.toggle();
                    vm.$emit('attach', collection, vm.item);
                } else {
                    notify.info("The item has been already added to the collection.", 'Collection');
                }
            }, function(error) {
                if(error.response.status == 422) {
                    vm.errors = error.response.data;
                    toastr.error("Please correct the input data and try again.", 'Collection');
                }
            });
        },
    }
}
</script>