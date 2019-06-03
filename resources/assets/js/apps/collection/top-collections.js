if (document.getElementById('top-collections')) {
    window.topCollections = new Vue({
        el: '#top-collections',
        data: {
            collections: new ItemCollections(),
        },
        mounted: function () {
            this.refresh();
        },
        methods: {
            get: function() {
                itemCollections().all(function(list){
                     topCollections.collections = list;
                }, function(){
                    topCollections.collections = new ItemCollections();
                }, Object.assign(queryString.parse(location.search, {arrayFormat: 'index'}), {
                    'per_page': 9,
                    'relations': [
                        'creator'
                    ],
                    'order': [
                        'count_followers|desc'
                    ],
                }));
            },
            refresh: function() {
                this.get();
            },
        },
    });
}