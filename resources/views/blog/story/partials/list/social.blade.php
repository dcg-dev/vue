<div class="block">
    <div class="block-header bg-gray-lighter">
        <h3 class="block-title">Social</h3>
    </div>
    <div class="block-content block-content-full">
        <div class="btn-group">
            <a class="btn btn-default" href="{{ Setting::get('twitter.link') ?: '#' }}" data-toggle="tooltip" title="" data-original-title="Follow us on Twitter"><i class="fa fa-fw fa-twitter"></i></a>
            <a class="btn btn-default" href="{{ Setting::get('facebook.link') ?: '#' }}" data-toggle="tooltip" title="" data-original-title="Like our Facebook page"><i class="fa fa-fw fa-facebook"></i></a>
            <a class="btn btn-default" href="{{ Setting::get('google.link') ?: '#' }}" data-toggle="tooltip" title="" data-original-title="Follow us on Google Plus"><i class="fa fa-fw fa-google-plus"></i></a>
            <a class="btn btn-default" href="{{ Setting::get('soundcloud.link') ?: '#' }}" data-toggle="tooltip" title="" data-original-title="Follow us on SoundCloud"><i class="fa fa-fw fa-soundcloud"></i></a>
            <a class="btn btn-default" href="{{ Setting::get('youtube.link') ?: '#' }}" data-toggle="tooltip" title="" data-original-title="Subscribe on Youtube"><i class="fa fa-fw fa-youtube"></i></a>
        </div>
    </div>
</div>