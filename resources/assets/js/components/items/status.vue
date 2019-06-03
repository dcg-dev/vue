<template>
<span class="label label-warning" v-if="status == 0">Draft</span>
<span class="label label-info" v-else-if="status == 1">Under Review</span>
<span class="label label-success" v-else-if="status == 2">Approved</span>
<span class="label label-danger" v-else-if="status == 3">Declined</span>
</template>
<script>
    export default {
        props: ['status'],
    }
</script>
