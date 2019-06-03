<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;

class CommentPolicy extends Policy {

    /**
     * Determine if the given item can be work by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Item  $item
     * @return bool
     */
    public function replied(User $user, Comment $item) {
        return $user->id !== $item->sender_id;
    }
    
    /**
     * Determine if the given item can be work by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Item  $item
     * @return bool
     */
    public function liked(User $user, Comment $item) {
        return $user->id !== $item->sender_id;
    }

}
