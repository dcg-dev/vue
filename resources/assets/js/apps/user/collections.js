if (document.getElementById('user-collections')) {
    window.userCollections = new Vue({
        el: '#user-collections',
        data: {
            id: null,
            currentUser: false,
            collections: new ItemCollections(),
        },
        mounted: function () {
            this.id = this.$el.dataset.id;
            this.currentUser = currentUser;
            this.refresh();
        },
        computed: {
            isAuthor: function() {
                return this.currentUser && this.currentUser.get('username') == this.id; 
            }
        },
        methods: {
            get: function() {
                itemCollections().user(this.id, function(list){
                     userCollections.collections = list;
                }, function(){
                    userCollections.collections = new ItemCollections();
                }, queryString.parse(location.search));
            },
            modal: function() {
                $('#modal-collection').modal('toggle');
            },
            refresh: function() {
                this.get();
            },
        },
    });
}