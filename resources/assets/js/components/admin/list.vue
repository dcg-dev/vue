<template>
<div>
    <div class="row m-b-sm" v-if="!collection.isEmpty()">
            <div class="col-md-6 m-t-sm">
                Showing <strong v-text="collection.from"></strong>–<strong v-text="collection.to"></strong> of <strong v-text="collection.total"></strong> results
            </div>
    </div>
    <div v-bind:class="loading ? 'ibox ibox-loading' : 'ibox'">
        <div class="ibox-content">
            <div class="ibox-loader">
                <span class="spinner-small"></span>
            </div>
            <slot :item="item"></slot>
        </div>
    </div>
</div>
</template>
<script>
  export default {
    props: {
        collection: {
            type: Object,
            required: true
        },
        loading: {
            type: Boolean,
            default: false
        },
    },
    methods : {

    }    
}
</script>