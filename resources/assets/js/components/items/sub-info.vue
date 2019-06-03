<template>
    <div class="block">
        <div class="block-content block-content-full clearfix remove-margin-t">
            <table class="table table-striped table-borderless" v-if="!item.get('formats').isEmpty()">
                <thead>
                <tr>
                    <th colspan="2">Included Formats</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="format in item.get('formats').getData()">
                    <td style="width: 40%;" v-text="format.get('name')"></td>
                    <td>
                        <i class="fa fa-check text-success"></i>
                    </td>
                </tr>
                </tbody>
            </table>
            <table class="table table-striped table-borderless remove-margin-b">
                <thead>
                <tr>
                    <th colspan="2">Info</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="width: 30%;">Released</td>
                    <td v-text="item.get('created_at').format('MMMM DD, YYYY')"></td>
                </tr>
                <tr>
                    <td><i class="fa fa-hd text-muted"></i>File Size</td>
                    <td v-text="item.get('filesize').humanize()"></td>
                </tr>
                <tr>
                    <td>Stem Files</td>
                    <td>
                        <i class="fa fa-check text-success" v-if="item.get('includes_stems')"></i>
                        <i class="fa fa-times text-danger" v-if="!item.get('includes_stems')"></i>
                    </td>
                </tr>
                <tr>
                    <td>Loopable</td>
                    <td>
                        <i class="fa fa-check text-success" v-if="item.get('loopable')"></i>
                        <i class="fa fa-times text-danger" v-if="!item.get('loopable')"></i>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {}
        },
        props: {
            item: {
                required: true
            },
        },
        mounted: function () {
        },
        methods: {}
    }
</script>