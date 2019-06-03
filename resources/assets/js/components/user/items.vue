<template>
    <!-- Main Content -->
    <div>
        <div class="row content content-boxed" v-if="'undefined' !== typeof items && items.length > 0" style="padding-top: 0px">
            <div class="form-inline text-right clearfix col-sm-12">
                <select class="form-control push" size="1" v-model="filters.order"
                        @change="getItems(pagination.current_page, pagination.per_page)">
                    <option value="created_at|desc" disabled selected>Sort by</option>
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
            <!-- Products -->
            <div class="col-sm-6 col-lg-3" v-for="item in items">
                <div class="block">
                    <div class="img-container">
                        <img class="img-responsive" :src="item.image" :alt="item.name">
                        <div class="img-options">
                            <div class="img-options-content">
                                <div class="push-20">
                                    <a class="btn btn-lg btn-primary" :href="'/item/' + item.slug">View</a>
                                </div>
                                <div>
                                    <stars :rating="item.rating"></stars>
                                    <span class="text-white">({{ item.count_rating }})</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="push-10">
                            <div class="h4 font-w600 text-success pull-right push-10-l">
                                {{ !item.price ? 'Free' : '$' + item.price}}
                            </div>
                            <a class="h4 concat-title" :href="'/item/' + item.slug">{{ item.name }}</a>
                        </div>
                        <p class="text-muted">by <a :href="'/user/' + item.creator.username">{{ item.creator.username
                            }}</a></p>
                    </div>
                </div>
            </div>
            <!-- END Products -->
        </div>


        <div class="row content-boxed empty-collection" v-else>
            <div class="text-center">
                <span>User doesn't have any items</span>
            </div>
        </div>
        <!-- Disabled and Active States -->
        <div class="block-content text-center" v-if="pagination.total > pagination.to">
            <nav>
                <pagination v-bind:pagination="pagination"
                            v-on:click.native="getItems(pagination.current_page, pagination.per_page)"
                            :offset="this.offset">
                </pagination>
            </nav>
        </div>
        <!-- END Disabled and Active States -->
    </div>
    <!-- END Main Content -->
</template>

<script>
    export default {
        data: function () {
            return {
                id: null,
                errors: [],
                items: [],
                filters: {
                    order: 'created_at|desc',
                },
                pagination: {
                    total: 0,
                    per_page: 16,
                    from: 1,
                    to: 0,
                    current_page: 1
                },
                offset: 16,
            };
        },
        mounted: function () {
            this.id = this.$el.dataset.id;
            this.getItems(this.pagination.current_page, this.pagination.per_page);
        },
        methods: {
            getItems: function (page, per_page) {
                this.errors = [];
                var url = '/api/user/' + this.id + '/items';
                url += '?' + queryString.stringify(this.filters, {arrayFormat: 'index'});
                url += '&page=' + page + '&per_page=' + per_page;
                axios.get(url).then((response) => {
                    this.items = response.data.data;
                    this.pagination = response.data;
                }, (error) => {
                    this.errors = error.response.data;
                    toastr.error("Items couldn't be retrieve.", 'Items');
                });
            },
        },
    }
</script>