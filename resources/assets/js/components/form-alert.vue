<template>
    <div class="sweet-alert form-alert animated fadeIn">
        <div class="sa-icon sa-success">
            <span class="sa-line sa-tip"></span>
            <span class="sa-line sa-long"></span>
            <div class="sa-placeholder"></div>
            <div class="sa-fix"></div>
        </div>
        {{message}}
    </div>
</template>

<script>
    export default {
        props: {
            'message': {
                required: true
            }
        },
    }
</script>