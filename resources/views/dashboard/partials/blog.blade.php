<div class="bg-white" v-if="!stories.isEmpty()">
    <section class="content content-boxed">
        <h3 class="font-w300 text-light push-30-t m-b-md">From The Blog</h3>
        <stories-list :collection="stories"></stories-list>
    </section>
</div>