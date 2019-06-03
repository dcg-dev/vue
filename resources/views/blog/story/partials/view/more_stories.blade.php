<section class="content content-boxed">
    <!-- Section Content -->
    <div class="row push-30-t push-30" v-if="lastStories && lastStories.length > 0">
        <div class="col-sm-4" v-for="lastStory in lastStories">
            <a class="block block-link-hover2" v-bind:href="lastStory.getUrl()">
                <div class="block-content bg-image" :style="{ 'background-image': 'url(' + lastStory.get('image') + ')' }">
                    <h4 class="text-white push-50-t push concat-title" v-text="lastStory.get('title')"></h4>
                </div>
                <div class="block-content block-content-full font-s12"> 
                    <span class="text-primary" v-text="lastStory.get('creator').getFullname()"></span>
                    <span v-text="' on ' + (lastStory.get('creator') ? lastStory.get('creator').get('created_at').format('MMMM DD, YYYY') : '')"></span>
                </div>
            </a>
        </div>
    </div>
    <!-- END Section Content -->
</section>
