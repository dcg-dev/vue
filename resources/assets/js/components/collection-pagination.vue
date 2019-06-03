<template>
    <nav class="text-center">
        <ul class="pagination" v-if="collection.hasPages()">
            <li v-if="!collection.isFirstPage()">
                <a href="#" v-on:click.prevent="go(1)"><i class="fa fa-angle-double-left"></i></a>
            </li>
            <li v-if="!collection.isFirstPage()">
                <a href="#" v-on:click.prevent="go(collection.current_page-1)"><i class="fa fa-angle-left"></i></a>
            </li>
            <li v-for="page in pages" v-bind:class="collection.current_page == page ? 'active' : ''">
                <a href="#" v-text="page" v-on:click.prevent="go(page)"></a>
            </li>
            <li v-if="!collection.isLastPage()">
                <a href="#" v-on:click.prevent="go(collection.current_page+1)"><i class="fa fa-angle-right"></i></a>
            </li>
            <li v-if="!collection.isLastPage()">
                <a href="#" v-on:click.prevent="go(collection.last_page)"><i class="fa fa-angle-double-right"></i></a>
            </li>
        </ul>
    </nav>
</template>
<script>
  export default {
    props: {
        collection: {
            type: Object,
            required: true
        },
        history: {
            type: Boolean,
            default: true
        }
    },
    computed: {
        pages: function() {
            if(!this.collection.current_page) {
                return [];
            }
            var step = 2;
            var pages = [];
            var max = this.collection.current_page + step;
            var min = this.collection.current_page - step;
            if(min < 1) {
                min = 1;
            }
            if(max > this.collection.last_page) {
                max = this.collection.last_page;
            }
            for(var i=min; i <=max; i++) {
                pages.push(i);
            }
            return pages;
        },
    },
    methods : {
        go: function(page) {
            if(this.history) {
                var query = queryString.parse(location.search);
                query.page = page;
                history.pushState(null, null, location.origin + location.pathname + '?' +queryString.stringify(query,{arrayFormat: 'index'}));
            }
            this.$emit('go', Number(page));
        }
    }    
}
</script>