<template>
<div>
    <div class="form-inline clearfix">
        <select class="form-control push pull-right" size="1" v-model="per_page">
            <option value="0" disabled selected>Show</option>
            <option value="9">9</option>
            <option value="18">18</option>
            <option value="36">36</option>
            <option value="72">72</option>
        </select>
        <select class="form-control push" size="1" v-model="order">
            <option value="0" disabled selected>Sort by</option>
            <option value="latest">Latest</option>
            <option value="popular">Popularity</option>
            <option value="name|asc">Name (A to Z)</option>
            <option value="name|desc">Name (Z to A)</option>
            <option value="price|asc">Price (Lowest to Highest)</option>
            <option value="price|desc">Price (Highest to Lowest)</option>
            <option value="count_sales|asc">Sales (Lowest to Highest)</option> 
            <option value="count_sales|desc">Sales (Highest to Lowest)</option>
        </select>
    </div>
    <div v-if="!collection.isEmpty()">
        <items v-bind:collection="collection" v-bind:item-class="'col-sm-6 col-lg-4'" v-bind:child="child"></items>
    </div>
    <div v-if="collection.isEmpty()" class="m-b-lg big-padding text-center">
        <div v-text="emptyText"></div>
    </div>
    <collection-pagination :collection="collection" v-on:go="refresh"></collection-pagination>
</div>
</template>
<script>
  export default {
    data: function() {
        return {
            'per_page': 0,
            'order': 0,
        };
    },
    watch: {
        'order': function(value) {
            var query = queryString.parse(location.search,{arrayFormat: 'index'});
            query.order = [value];
            history.pushState(null, null, location.origin + location.pathname + '?' +queryString.stringify(query,{arrayFormat: 'index'}));
            this.$emit('order', [value]);
            this.refresh();
        },
        'per_page': function(value) {
            var query = queryString.parse(location.search,{arrayFormat: 'index'});
            query.page = 1;
            query.per_page = value;
            history.pushState(null, null, location.origin + location.pathname + '?' +queryString.stringify(query,{arrayFormat: 'index'}));
            this.$emit('per_page', value);
            this.refresh();
        }
    },
    props: {
        collection: {
            type: Object,
            required: true
        },
        emptyText: {
            type: String,
            default: 'Not items yet.'
        },
        child: false,
    },
    methods: {
        element: function(item) {
            return !this.child ? item : item.get(this.child);
        },
        refresh: function() {
            this.$emit('refresh');
        }
    }
}
</script>