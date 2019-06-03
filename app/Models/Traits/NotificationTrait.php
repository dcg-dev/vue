<?php

namespace App\Models\Traits;

use App\Models\Followers;
use App\Models\Item;
use App\Models\Story;
use App\Notifications\ItemFollowerReleased;
use App\Notifications\ItemReleased;
use App\Notifications\ItemDeclined;
use App\Notifications\ItemDeleted;
use App\Notifications\NewItemReview;
use App\Notifications\NewItemComment;
use App\Notifications\NewPurchase;
use App\Notifications\NewSale;
use App\Notifications\PurchasedItemUpdated;
use App\Notifications\NewMessage;
use App\Notifications\StoryReleased;

trait NotificationTrait
{

    /**
     * Notify user about released story
     *
     * @param Story $story
     *
     * @return void
     */
    public function notifyStoryReleased(Story $story)
    {
        $this->notify(new StoryReleased($story));
        $this->recalculateNotifications();
        $this->save();
    }

    /**
     * Notify user about released item
     *
     * @param Item $item
     *
     * @return void
     */
    public function notifyItemReleased(Item $item)
    {
        if ($this->notification_release) {
            $this->notify(new ItemReleased($item));
            $this->recalculateNotifications();
            $this->save();
        }
        if (!$item->getOriginal('approved_at')) {
            $followers = Followers::with('follower')->where('follow_id', $this->id)->where('mail', true)->get();
            foreach ($followers as $follower) {
                $follower->follower->notifyFollowerItemReleased($item);
            }
        }
    }

    /**
     * Notify follower about released item
     *
     * @param Item $item
     *
     * @return void
     */
    public function notifyFollowerItemReleased(Item $item)
    {
        $this->notify(new ItemFollowerReleased($item));
        $this->recalculateNotifications();
        $this->save();
    }

    /**
     * Notify user about declined item
     *
     * @param Item $item
     *
     * @return void
     */
    public function notifyItemDeclined(Item $item)
    {
        if ($this->notification_release) {
            $this->notify(new ItemDeclined($item));
            $this->recalculateNotifications();
            $this->save();
        }
    }

    /**
     * Notify user about deleted item
     *
     * @param Item $item
     *
     * @return void
     */
    public function notifyItemDeleted(Item $item)
    {
        if ($this->notification_release) {
            $this->notify(new ItemDeleted($item));
            $this->recalculateNotifications();
            $this->save();
        }
    }

    /**
     * Notify user about new item review
     *
     * @param Item $item
     *
     * @return void
     */
    public function notifyNewItemReview(Item $item)
    {
        if ($this->notification_reviews) {
            $this->notify(new NewItemReview($item));
            $this->recalculateNotifications();
            $this->save();
        }
    }

    /**
     * Notify user about new item comment
     *
     * @param Item $item
     *
     * @return void
     */
    public function notifyNewItemComment(Item $item)
    {
        if ($this->notification_comments) {
            $this->notify(new NewItemComment($item));
            $this->recalculateNotifications();
            $this->save();
        }
    }

    /**
     * Notify user about new purchase
     *
     * @param Item $item
     *
     * @param float $price
     *
     * @return void
     */
    public function notifyNewPurchase(Item $item, $price)
    {
        $this->notify(new NewPurchase($item, $price));
        $this->recalculateNotifications();
        $this->save();
    }

    /**
     * Notify user about new purchase
     *
     * @param Item $item
     *
     * @param float $price
     *
     * @return void
     */
    public function notifyNewSale(Item $item, $price)
    {
        if ($this->notification_sale) {
            $this->notify(new NewSale($item, $price));
            $this->recalculateNotifications();
            $this->save();
        }
    }

    /**
     * Notify user about purchased item has been updated
     *
     * @param Item $item
     *
     * @return void
     */
    public function notifyPurchasedItemUpdated(Item $item)
    {
        $this->notify(new PurchasedItemUpdated($item));
        $this->recalculateNotifications();
        $this->save();
    }

    /**
     * Notify user about new purchase
     *
     * @param Item $item
     *
     * @param float $price
     *
     * @return void
     */
    public function notifyNewMessage()
    {
        if ($this->notification_inbox) {
            $this->notify(new NewMessage());
            $this->recalculateNotifications();
            $this->save();
        }
    }

}
