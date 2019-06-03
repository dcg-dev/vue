<template>
    <div class="block text-center">
        <div class="block-content block-content-full clearfix">
            <div class="row remove-padding push-15-t remove-margin-b">
                <div class="col-sm-6">
                    <i class="h3 si si-wallet text-muted"></i>
                    <p class="push-10-t h4 font-w600"><span v-text="item.get('count_sales', 0)"></span> Sales</p>
                </div>
                <div class="col-sm-6">
                    <i class="h3 si si-bubble text-muted"></i>
                    <p class="push-10-t"><a href="#ecom-product-comments" data-toggle="tab" class="h4 font-w600"
                                            @click.prevent="tabShow($event)"><span
                            v-text="item.get('count_comments', 0)"></span> Comments</a></p>
                </div>
            </div>
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
            }
        },
        mounted: function () {
        },
        methods: {
            tabShow: function (event) {
                $('.nav-tabs li').each(function () {
                    $(this).removeClass('active');
                });
                $('.nav-tabs a[href="#ecom-product-comments"]').first().parent().addClass('active');
                $(event.target).tab('show');
            }
        }
    }
</script>