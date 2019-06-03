<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Item;

class ItemPolicy extends Policy {

    /**
     * Determine if the given item can be updated by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Item  $item
     * @return bool
     */
    public function update(User $user, Item $item) {
        return $user->id === $item->creator_id;
    }
    
    public function view(User $user, Item $item) {
        return $item->status == 2 || $user->id === $item->creator_id;
    }

}
