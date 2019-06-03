<template>
    <table class="table table-hover no-margins">
        <thead>
        <tr>
            <th>User</th>
            <th>Plan</th>
            <th>Subscribed at</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="item in collection.getData()">
            <td>
                <a v-if="item.get('user_id')" :href="'/control/user/'+item.get('customer').get('username')+'/edit'">
                    {{item.get('customer').get('username')}}
                </a>
            </td>
            <td>
                {{item.get('stripe_plan')}}
            </td>
            <td>
                {{item.get('created_at') | time}}
            </td>
        </tr>
        <tr v-if="collection.isEmpty()">
            <td colspan="3" class="text-center">
                <strong>Subscriptions not yet.</strong>
            </td>
        </tr>
        </tbody>
    </table>
</template>
<script>
    export default {
        filters: {
            time: function (value) {
                return moment(value).format('MMM DD, YYYY HH:mm');
            }
        },
        data: function () {
            return {
                collection: new Subscriptions()
            };
        },
        created: function () {
            this.load();
        },
        methods: {
            load: function () {
                var self = this;
                this.collection.list({
                    order: 'created_at|desc'
                }).then(function () {
                    self.$forceUpdate();
                });
            }
        }
    }
</script>