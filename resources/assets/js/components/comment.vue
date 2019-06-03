<template>
<div class="media">
    <div class="media-left">
        <a v-bind:href="comment.get('sender').getUrl()">
            <img class="img-avatar img-avatar32" v-bind:src="comment.get('sender').getAvatar()" alt="">
        </a>
    </div>
    <div class="media-body font-s13">
        <a class="font-w600" v-bind:href="comment.get('sender').getUrl()" v-text="comment.get('sender').getFullname()"></a>
        <label class="label label-success text-white font-w600 font-s8 text-danger" v-if="isEntityAuthor">Author</label>
        <div  v-text="comment.get('message')"></div>
        <div class="font-s12">
            <span v-if="isGuest || currentUser"> 
                <a href="#" v-if="isGuest || (!isAuthor && !comment.get('iLiked',false))" v-on:click.prevent="like(comment)">
                    <i class="fa fa-heart-o"></i>
                    Like it! 
                    (<span v-text="comment.get('likes',0)"></span>)
                </a>
                <a href="#" class="text-danger" v-if="!isAuthor && comment.get('iLiked',false)" v-on:click.prevent="like(comment)">
                    <i class="fa fa-heart"></i>
                    <span v-text="comment.get('likes',0)"></span> 
                    <span v-text="comment.get('likes',0) == 1 ? 'like' : 'likes'"></span>
                </a>
            </span>
            <span class="text-muted" v-if="isAuthor" v-text="comment.get('likes',0)+' likes'">
                <i class="fa fa-heart-o"></i>
                <span v-text="comment.get('likes',0)"></span>
                <span v-text="comment.get('likes',0) == 1 ? 'like' : 'likes'"></span>
            </span> 
            <span v-if="isGuest || currentUser">
                 - 
                <a href="#" v-if="!isAuthor" v-on:click.prevent="replied">Reply - </a>
                <span class="text-muted"><em v-text="comment.get('created_at').fromNow()"></em></span>
                <comment-reply-form v-if="!isAuthor && replies" class="push-10-t" :comment="comment"></comment-reply-form>
            </span>
        </div>
        <div class="media">
            <div v-if="!comment.get('replies').isEmpty()">
                <comment v-for="reply in comment.get('replies').getData()" :comment="reply" :author="author" :key="reply.get('id')" v-on:like="like"></comment>
            </div>  
        </div>
    </div> 
</div>
</template>
<script>
  export default {
    props: {
        comment: {
            type: Object,
            required: true
        },
        author: {
            type: Number,
            required: true
        }
    },
    data: function() {
        return {
            'replies': false
        };
    },
    computed: {
        'isAuthor': function() {
            return this.currentUser && this.currentUser.get('id') == this.comment.get('sender').get('id');
        },
        'isEntityAuthor': function() {
            return this.comment.get('sender').get('id') == this.author;
        },
        'isGuest': function() {
            return !window.currentUser;
        },
        'currentUser': function() {
            return window.currentUser;
        }
    },
    methods : {
        like: function(comment) {
            if (this.isGuest) {
                notify.guest("Please login to like it.");
            } else {
                this.$emit('like', comment);
            }
        },
        replied: function() {
            this.replies = !this.replies;
        }
    }   
}
</script>