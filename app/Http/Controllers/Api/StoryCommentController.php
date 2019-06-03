<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\StoryCommented;
use App\Models\StoryComment;

trait StoryCommentController {

    /**
     * Likes the comment
     *
     * @return \Illuminate\Http\Response
     */
    public function like(StoryComment $comment) {
        if ($comment->sender->id == $this->user()->id) {
            abort(403, 'You can not like yourself!');
        }
        $comment->like();
        return StoryComment::find($comment->id);
    }

    public function replied(StoryComment $comment, StoryCommented $request) {
        if ($comment->sender->id == $this->user()->id) {
            abort(403, 'You can not reply for yourself!');
        }
        $comment->replies()->create([
            'message' => $request->get('message'),
            'sender_id' => $this->user()->id,
            'story_id' => $comment->story_id,
            'likes' => 0
        ]);
        return $comment->replies;
    }

}
