<template>
    <div v-if="items.length > 0">
        <table v-for="message in items" class="table table-striped table-borderless">
            <tbody>
            <tr>
                <td class="font-s13 text-muted">
                    <span v-text="message.user"></span> on {{ message.updated_at | formatDate }}
                </td>
            </tr>
            <tr>
                <td v-html="message.body"></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
  export default {
    data: function() {
        return {
        };
    },
    props: {
        items: {
            type: Array,
            required: true
        },
    },
    methods: {

    },
    filters: {
        formatDate: function (value) {
            if (value) {
                return moment.unix(value).format('MMMM DD, YYYY - hh:mm')
            }
        },
    }
}
</script>