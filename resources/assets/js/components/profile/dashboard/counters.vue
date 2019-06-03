<template>
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="text-muted">
                <small class="dropdown cursor-pointer">
                    <div class="dropdown-toggle" data-toggle="dropdown">
                        <i class="si si-calendar"></i>
                        {{view | capitalize}}
                        <span class="caret"></span>
                    </div>
                    <ul class="dropdown-menu dropdown-counter">
                        <li><a href="#" @click.prevent="view = 'today'">Today</a></li>
                        <li><a href="#" @click.prevent="view = 'week'">Week</a></li>
                        <li><a href="#" @click.prevent="view = 'month'">Month</a></li>
                        <li><a href="#" @click.prevent="view = 'year'">Year</a></li>
                        <li><a href="#" @click.prevent="view = 'all'">All</a></li>
                    </ul>
                </small>
            </div>
            <div class="font-s17 font-w600 text-capitalize">{{label}}</div>
            <a class="h2 font-w300 text-primary">
                {{count}}
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            url: {
                required: true
            },
            label: {
                type: String,
                required: true
            }
        },
        data: function () {
            return {
                view: 'today',
                count: 0
            };
        },
        watch: {
            view: function () {
                this.load();
            }
        },
        created: function () {
            this.load();
        },
        methods: {
            load: function () {
                var self = this;
                var promise = axios.get(this.url + this.getDate());
                promise.then(function (response) {
                    self.count = parseInt(response.data);
                });
                promise.catch(function () {
                    self.count = 0;
                });
            },
            getDate: function () {
                if (this.view == 'all') {
                    return '';
                }
                var started_at = moment();
                var ended_at = moment();
                switch (this.view) {
                    case 'week':
                        started_at = started_at.startOf('week');
                        ended_at = ended_at.endOf('week');
                        break;
                    case 'month':
                        started_at = started_at.startOf('month');
                        ended_at = ended_at.endOf('month');
                        break;
                    case 'year':
                        started_at = started_at.startOf('year');
                        ended_at = ended_at.endOf('year');
                        break;
                }
                return '?started_at=' + started_at.unix() + '&ended_at=' + ended_at.unix();
            }
        }
    }
</script>