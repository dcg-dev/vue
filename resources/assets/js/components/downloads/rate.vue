<template>
    <div class="modal fade in" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog modal-dialog-popout vertical-align-center">
                <div class="modal-content">
                    <div class="block block-themed block-transparent block-rounded remove-margin-b">
                        <div class="block-header bg-white">
                            <ul class="block-options">
                                <li>
                                    <button data-dismiss="modal" type="button"><i class="si si-close fa-2x text-gray"></i></button>
                                </li>
                            </ul>
                            <h3 class="font-w600 push-15-l">Rate Item</h3>
                        </div>
                        <div class="row block block-content">
                            <div class="col-sm-12 push-20">
                                <star-rating v-model="form.rating" :rating="form.rating" :read-only="ratings.length > 0" :star-size="star.size" :active-color="star.activeColor" :show-rating="star.showRating"></star-rating>
                            </div>
                            <div class="col-sm-12 push-20">
                                <textarea class="form-control" v-model="form.review" rows="6" placeholder="Your review.." :disabled="ratings.length > 0"></textarea>
                                <div class="help-block" v-if="errors.review">
                                    <div v-for="error in errors.review"><strong v-text="error"></strong></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="col-sm-6 text-left">
                                <button class="btn btn-lg btn-default font-w400" type="button" data-dismiss="modal">Cancel</button>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button class="btn btn-lg btn-success-modern push-right font-w400" v-on:click.prevent="submit($event)" :disabled="ratings.length > 0 || !isValid"> Submit Review</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import StarRating from 'vue-star-rating';

    export default{
        data(){
            return{
                star: {
                    size: 30,
                    activeColor: '#f3b760',
                    showRating: false
                },
                form: {
                    rating: 0,
                    review: ''
                },
                ratings: [],
                errors: {},
                item: new Model()
            }
        },
        props: {
        },
        components: {
            StarRating
        },
        computed: {
            isValid: function () {
                var vm = this;
                return Object.keys(this.form).every(function (key) {
                    return vm.form[key] != null;
                })
            }
        },
        mounted: function () {

        },
        methods: {
            setItem: function (item) {
                this.item = item;
                this.form.item_id = item.get('item').get('id');
                this.ratings = item.get('item').get('ratings').data;

                if (this.ratings.length > 0) {
                    this.form.rating = this.ratings[0].attributes.rating;
                    this.form.review = this.ratings[0].attributes.review;
                }
            },
            submit: function (event) {
                this.errors = [];
                var vm = this;
                this.item.addRating(this.form, function() {
                    vm.$emit('submitted');
                    vm.ratings = [];
                    vm.from = {
                        rating: 0,
                        review: ''
                    };
                    toastr.success("Review sent successfully!", 'Rate');
                }, function() {
                    if (error.response.status == 422) {
                        vm.errors = error.response.data;
                        toastr.error("An error occurred!", 'Rate');
                    }
                });
            }
        }
    }
</script>
