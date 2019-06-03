<template>
<div class="row">
    <div v-bind:class="itemClass" v-for="item in collection.getData()">
        <div class="block"> 
            <div class="img-container">
                <img class="img-responsive" v-bind:src="element(item).get('image')" alt="">
                <div class="img-options">
                    <div class="img-options-content">
                        <div class="push-20">
                            <a class="btn btn-lg btn-primary" v-bind:href="element(item).getUrl()">View</a>
                        </div>
                        <stars :rating="element(item).get('rating', 0)"></stars>
                        <span class="text-white" v-if="element(item).get('count_rating', false)">(<span v-text="element(item).get('count_rating', 0)"></span>)</span>
                    </div>
                </div> 
            </div>
            <div class="block-content">
                <div v-bind:class="itemTitleClass">
                    <div class="font-w600 text-success pull-right push-10-l">
                        <span v-if="element(item).isFree()">Free</span>
                        <span v-if="!element(item).isFree()">
                            $<span v-text="element(item).getPrice()"></span>
                        </span>
                    </div>
                    <a class="concat-title" v-bind:title="element(item).get('name')" v-bind:href="element(item).getUrl()" v-text="element(item).get('name')"></a>
                </div>
                <div class="push-20">
                    by <a class="text-muted" v-bind:href="element(item).get('creator').getUrl()" v-text="element(item).get('creator').getFullname()"></a>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
  export default {
    data: function() {
        return {
        };
    },
    props: {
        collection: {
            type: Object,
            required: true
        },
        child: false,
        itemClass: {
            type: String,
            default: 'col-sm-6 col-lg-3'
        },
        itemTitleClass: {
            type: String,
            default: 'h4 push-10'
        },
    },
    methods: {
        element: function(item) {
            return !this.child ? item : item.get(this.child);
        }
    }
}
</script>