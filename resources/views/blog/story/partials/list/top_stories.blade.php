<div class="block" v-if="!topStories.isEmpty()">
    <div class="block-header bg-gray-lighter">
        <h3 class="block-title">Most Popular Stories</h3>
    </div>
    <div class="block-content">
        <ul class="list list-simple">
            <li  v-for="topStory in topStories.getData()">
                <div class="push-5 clearfix">
                    <span class="font-s13 text-muted push-10-l pull-right" 
                          v-text="topStory.get('created_at') ? topStory.get('created_at').format('MMMM DD, YYYY') : ''"></span>
                    <a class="font-w600" v-bind:href="topStory.get('creator').getUrl()"
                       v-text="topStory.get('creator').getFullname()"></a>
                </div>
                <a class="font-s13" v-bind:href="topStory.getUrl()" v-text="topStory.get('title')"></a>
            </li>
        </ul>
    </div>
</div>