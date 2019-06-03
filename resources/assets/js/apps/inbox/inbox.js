if (document.getElementById('inbox')) {
    window.inbox = new Vue({
        el: '#inbox',
        data: {
            button: null,
            loading: false,
            errors: [],
            threads: new Collection(),
            messages: [],
            form: {},
            currentSection: 'inbox',
            counters: {}
        },
        mounted: function () {
            if(location.pathname == '/profile/inbox/compose') {
                this.currentSection = 'compose';
            } else {
                var query = queryString.parse(location.search);
                if(query.page) {
                    this.currentSection = query.page;
                }
            }
            this.loadThreads();
            this.loadCounters();
            this.eventFormClose();
        },
        methods: {
            loadThreads: function () {
                this.loading = true;
                messages().all(function(list) {
                    inbox.threads = list;
                    inbox.loading = false;
                },function() {
                    inbox.threads = new Collection();
                    inbox.loading = false;
                }, queryString.parse(location.search));
            },
            loadDeleted: function () {
                this.loading = true;
                messages().deleted(function(list) {
                    inbox.threads = list;
                    inbox.loading = false;
                },function() {
                    inbox.threads = new Collection();
                    inbox.loading = false;
                }, queryString.parse(location.search));
            },
            loadSent: function () {
                this.loading = true;
                messages().sent(function(list) {
                    inbox.threads = list;
                    inbox.loading = false;
                },function() {
                    inbox.threads = new Collection();
                    inbox.loading = false;
                }, queryString.parse(location.search));
            },
            loadArchive: function () {
                this.loading = true;
                messages().archive(function(list) {
                    inbox.threads = list;
                    inbox.loading = false;
                },function() {
                    inbox.threads = new Collection();
                    inbox.loading = false;
                }, queryString.parse(location.search));
            },
            loadStarred: function () {
                this.loading = true;
                messages().starred(function(list) {
                    inbox.threads = list;
                    inbox.loading = false;
                },function() {
                    inbox.threads = new Collection();
                    inbox.loading = false;
                }, queryString.parse(location.search));
            },
            loadCounters: function () {
                axios.get('/api/inbox/thread/counters').then((response) => {
                    this.counters = response.data;
                }, (error) => {
                });
            },
            paginate: function (page) {
                this.setPage(page);
                this.loadPage();
            },
            refresh: function () {
                this.setPage(1);
                this.loadPage();
                this.loadCounters();
            },
            setPage: function(page) {
                var query = queryString.parse(location.search);
                query.page = page;
                history.pushState(null, null, location.origin + location.pathname + '?' +queryString.stringify(query,{arrayFormat: 'index'}));
            },
            eventFormClose: function () {
                $('#modal-compose').on('hidden.bs.modal', function (e) {
                    inbox.form = {};
                    inbox.errors = {};
                });
            },
            go: function (page) {
                if(location.pathname != '/profile/inbox') {
                    location.href = '/profile/inbox?page'+page;
                    return;
                }
                if (page == this.currentSection) {
                    return;
                }
                this.currentSection = page;
                this.loadPage();

            },
            loadPage: function() {
                switch (this.currentSection) {
                    case 'trash':
                        this.loadDeleted();
                        break;
                    case 'sent':
                        this.loadSent();
                        break;
                    case 'archive':
                        this.loadArchive();
                        break;
                    case 'starred':
                        this.loadStarred();
                        break;
                    default:
                        this.loadThreads();
                }
            }
        },
    });
}