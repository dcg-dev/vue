<?php

namespace App\Models\Traits;

use App\Models\Item;
use App\Models\Messenger\MessengerThread;
use App\Notifications\ItemReleased;
use App\Notifications\ItemDeclined;
use App\Notifications\ItemDeleted;
use App\Notifications\NewItemReview;
use App\Notifications\NewItemComment;

/**
 * Trait MessengerTrait
 * @package App\Models\Traits
 */
trait MessengerTrait {

    /**
     * Return count of the messages from inbox
     * 
     * @return integer
     */
    public function inboxCount() {
        return (new MessengerThread())->getInboxCount($this->id);
    }
}
