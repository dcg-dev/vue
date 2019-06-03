<?php

namespace App\Policies;

use Illuminate\Support\Facades\Request;
use App\Models\User;
use App\Models\Collection;

class CollectionPolicy extends Policy {

    /**
     * Determine if the given item can be work by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Item  $item
     * @return bool
     */
    public function work(User $user, Collection $item) {
        return $user->id === $item->creator_id;
    }

    public function attach(User $user, Collection $item) {
        return !$item->items()->where('item_id', Request::input('item'))->count();
    }

    public function detach(User $user, Collection $item) {
        return $item->items()->where('item_id', Request::input('item'))->count();
    }

}
