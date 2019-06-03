<template>
    <div class="dropdown cursor-pointer">
        <div class="dropdown-toggle" data-toggle="dropdown">
            {{value | capitalize}}
            <span class="caret"></span>
        </div>
        <ul class="dropdown-menu dropdown-counter">
            <li><a href="#" @click.prevent="set('today')">Today</a></li>
            <li><a href="#" @click.prevent="set('week')">Week</a></li>
            <li><a href="#" @click.prevent="set('month')">Month</a></li>
            <li><a href="#" @click.prevent="set('year')">Year</a></li>
            <li><a href="#" @click.prevent="set('all')">All</a></li>
        </ul>
    </div>
</template>

<script>
    export default {
        filters: {
            capitalize: function (string) {
                return string ? string.charAt(0).toUpperCase() + string.slice(1) : '';
            }
        },
        props: {
            value: {
                required: true
            }
        },
        methods: {
            set: function (type) {
                this.$emit('input', type);
            }
        }
    }
</script>
