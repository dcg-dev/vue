<a class="block block-link-hover3" v-bind:href="publisher.getUrl()" v-if="publisher">
    <div class="block-header bg-gray-lighter">
        <h3 class="block-title">About</h3>
    </div>
    <div class="block-content block-content-full text-center">
        <div>
            <img class="img-avatar img-avatar96" v-bind:src="publisher.get('avatar')" alt="">
        </div>
        <div class="h5 push-15-t push-5" v-text="publisher.getFullname()"></div>
        <div class="font-s13 text-muted">Publisher</div>
    </div>
    <div class="block-content border-t">
        <div class="row items-push text-center">
            <div class="col-xs-6">
                <div class="push-5"><i class="si si-pencil fa-2x"></i></div>
                <div class="h5 font-w300 text-muted" v-text="publisher.get('count_story')"></div>
            </div>
            <div class="col-xs-6">
                <div class="push-5"><i class="si si-users fa-2x"></i></div>
                <div class="h5 font-w300 text-muted" v-text="publisher.get('count_followers') + ' Followers'"></div>
            </div>
        </div>
    </div>
</a>