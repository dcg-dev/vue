<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\ItemCommented;
use App\Models\Comment;

trait CommentController {

    /**
     * Likes the comment
     *
     * @return \Illuminate\Http\Response
     */
    public function like(Comment $comment) {
        if($comment->sender->id == $this->user()->id) {
            abort(403, 'You can not liked for yourself!');
        }
        $comment->like();
        return Comment::find($comment->id);
    }
    
    public function replied(Comment $comment, ItemCommented $request) {
        if($comment->sender->id == $this->user()->id) {
            abort(403, 'You can not replied for yourself!');
        }
        $comment->replies()->create([
            'message' => $request->get('message'),
            'sender_id' => $this->user()->id,
            'item_id' => $comment->item_id,
            'likes' => 0
        ]);
        return $comment->replies;
    }

}
