<template>  
    <div class="block">
        <div class="block-content block-content-full clearfix">
            <div class="text-center push-5-t">
                <div class="push-10-t" v-if="user">
                    <a class="btn btn-md btn-default btn-outline text-left" href="#" data-toggle="modal" data-target="#modal-popout" type="button" v-on:click="attach"><i class="fa fa-plus"></i> Add To Collection</a>
                    <a v-bind:class="'btn btn-md text-right'+(item.isFavourite() ? ' btn-danger' : ' btn-default btn-outline')" href="#" v-on:click.prevent="item.toFavourite()"><i class="si si-heart"></i>  Favourites</a>
                    <collection-attach id="collection-attach" v-bind:item="item"></collection-attach>
                </div>
                <div class="push-10-t" v-if="!user">
                    <a class="btn btn-md btn-default btn-outline text-left" href="#"  v-on:click.prevent="guestMessage"><i class="fa fa-plus"></i> Add To Collection</a>
                    <a class="btn btn-md text-right btn-default btn-outline" href="#" v-on:click.prevent="guestMessage"><i class="si si-heart"></i>  Favourites</a>
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
            },
            user: {
                required: true
            }
        },
        mounted: function () {
        },
        methods: {
            guestMessage: function () {
                this.$parent.guestMessage();
            },
            attach: function () {
                this.$parent.attach();
            }
        }
    }
</script>