<template>
    <div class="row content content-boxed">
        <!-- Ratings -->
        <div class="block block-opt-refresh-icon6 remove-padding" v-if="'undefined' !== typeof ratings && ratings.length > 0">
            <div class="block-header">
                <h3>All Item Ratings</h3>
            </div>
            <div class="block-content">
                <ul class="list list-simple">
                    <li v-for="rating in ratings">
                        <div class="push-5 clearfix">
                            <div class="text-warning pull-right">
                                <stars :rating="rating.rating"></stars>
                            </div>
                            <a class="font-w600" :href="'/user/' + rating.creator.slug">{{ rating.creator.username }}</a>
                            <span> on </span><i><a :href="'/item/' + rating.itemSlug">{{ rating.itemName }}</a></i>
                            <span class="text-muted">({{ rating.rating }}/5)</span>
                        </div>
                        <div class="font-s13">{{ rating.review }}</div>
                    </li>
                </ul>
                <!-- Pagination -->
                <div class="block-content text-center" v-if="pagination.total > pagination.to">
                    <nav>
                        <pagination  v-bind:pagination="pagination"
                             v-on:click.native="getRatings(pagination.current_page, pagination.per_page)"
                             :offset="this.offset">
                        </pagination>
                    </nav>
                </div>
                <!-- END Pagination -->
            </div>
        </div>
        <!-- END Ratings -->
        <div class="text-center empty-collection" v-else>
            <p>User doesn't have any ratings</p>
        </div>
    </div>
</template>

<script>
export default {
    data: function () { 
        return {
            id: null,
            ratings: [],
            pagination: {
                total: 0,
                per_page: 7,
                from: 1,
                to: 0,
                current_page: 1
            },
            offset: 7,
        };
    },
    mounted: function () {
        this.id = this.$el.dataset.id;
        this.getRatings(this.pagination.current_page, this.pagination.per_page);
    },
    methods: {
        getRatings: function (page, per_page) {
            axios.get('/api/user/' + this.id + '/ratings?page=' + page + '&per_page=' + per_page).then((response) => {
                //initialize ratings data with pagination
                this.ratings = response.data.data;
                this.pagination = response.data;
            }, (error) => {
                toastr.error("Ratings couldn't be retrieve.", 'Ratings');
            });
        },
    },
}
</script>