<div>
    <comment-form class="push-15" :item="story"></comment-form>
</div>
<div v-if="!story.get('comments').isEmpty()">
    <comment v-for="comment in story.get('comments').getData()" :comment="comment" :key="comment.get('id')" 
             v-on:like="like" :author="story.get('creator_id')"></comment>
    <collection-pagination :collection="story.get('comments')" :history="false" v-on:go="commentPage"></collection-pagination>
</div>
<div v-if="story.get('comments').isEmpty()" class="text-center">
    The story doesn't have any comments.
</div>
