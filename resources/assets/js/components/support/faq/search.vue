<template>   
    <div class="bg-gray-lighter">
        <section class="content content-full content-boxed">
            <!-- Section Content -->
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="input-group input-group-lg">
                        <input class="form-control" type="text" placeholder="Search for answers.." v-model="search" v-on:keyup.enter="getTopics">
                        <div class="input-group-btn">
                            <button class="btn btn-default" v-on:click="getTopics"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Section Content -->
        </section>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                search: null,
            }
        },
        props: {
        },
        mounted: function () {
        },
        methods: {
            getTopics: function () {
                this.$emit('gettopics', this.search);
            }
        }
    }
</script>