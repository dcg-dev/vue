<template>
    <form method="get" class="search-input" @submit.prevent="send">
        <div class="input-group input-group-lg col-md-6 col-md-offset-3">
            <input class="form-control" v-model="q" placeholder="Search..." type="search">
            <div class="input-group-btn" v-if="!categories.isEmpty()">
                <button data-toggle="dropdown" class="btn dropdown-toggle" type="button"
                        aria-expanded="false">
                    <span v-if="!category" class="text-muted">All</span>
                    <span v-if="category" class="text-muted">{{category.get('name')}}</span>
                    <span class="caret text-muted"></span>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#" @click.prevent="setCategory(null)">All</a>
                    </li>
                    <li v-for="item in categories.getData()">
                        <a href="#" @click.prevent="setCategory(item)">{{item.get('name')}}</a>
                    </li>
                </ul>
            </div>
            <div class="input-group-btn">
                <button class="btn btn-success-modern"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        data: function () {
            return {
                category: null,
                q: '',
                categories: new Categories()
            }
        },
        created: function () {
            this.load();
        },
        methods: {
            load: function () {
                var self = this;
                this.categories.search().then(function () {
                    self.$forceUpdate();
                });

            },
            setCategory: function (category) {
                this.category = category;
            },
            send: function () {
                var url = this.category ? '/category/' + this.category.get('slug') : '/items';
                if (this.q) {
                    url += '?q=' + this.q;
                }
                location.href = url;
            }
        }
    }
</script>
