<template>
<form class="'form-horizontal block'+loading ? 'block-opt-refresh' : ''" method="post" v-on:submit.prevent="submit">
<div v-bind:class="errors.message ? ' has-error' : ''">
    <input class="form-control" v-model="message" placeholder="Write a comment.." type="text" min=3 max=255>
    <span class="help-block" v-if="errors.message">
        <div v-for="error in errors.message">
            <strong v-text="error"></strong>
        </div>
    </span>
</div>
</form>
</template>
<script>
  export default {
    props: {
        item: {
            type: Object,
            required: true
        },
    },
    data: function() {
        return {
            'message': null,
            'errors': [],
            'loading': false
        };
    },
    methods : {
        submit: function() {
            if(!currentUser) {
                this.message = null;
                notify.guest("Please login to comment it.");
                return;
            }
            var data = { 
                'message': this.message,
            };
            var vm = this;
            vm.loading = true;
            this.item.commented(data, function(comments, response) {
                vm.message = null;
                vm.errors = [];
                vm.loading = false;
            }, function(error) {
                vm.loading = false;
                if(error.response.status == 422) {
                    vm.errors = error.response.data;
                }
            });
        }
    }   
}
</script>