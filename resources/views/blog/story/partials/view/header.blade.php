<div class="bg-image" :style="{ 'background-image': 'url(' + story.get('image') + ')' }">
    <div class="bg-modern-op">
        <section class="content content-full content-boxed overflow-hidden">
            <!-- Section Content -->
            <div class="push-150-t push-150 text-center">
                <span class="font-s48 text-white push-10 trashhand font-w700 animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown"
                      v-text="story.get('title')">
                </span>
                <h3 v-if="story.get('sub_title')" class="h3 font-w300 text-white-op animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown"
                    v-text="story.get('sub_title')">
                </h3>
            </div>
            <!-- END Section Content -->
        </section>
    </div>
</div>