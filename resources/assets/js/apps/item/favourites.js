if (document.getElementById('item-favourites')) {
    window.itemFavourites = new Vue({
        el: '#item-favourites',
        data: {
            collection: new Favourites(),
            loading: false,
        },
        mounted: function () {
            this.get();
        },
        methods: {
            get: function() { 
                currentUser.favourites(function(list){
                    itemFavourites.collection = list; 
                }, null, queryString.parse(location.search)); 
            },
            paginate: function() {
                this.get();
            }
        },
    });
}