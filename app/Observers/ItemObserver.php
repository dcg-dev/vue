<?php

namespace App\Observers;

use App\Models\Item;
use App\Models\OrderItem;
use App\Models\User;

class ItemObserver
{

    public function saved(Item $model)
    {
        if ($model->isDirty('status')) {
            if ($model->status == 2) {
                $model->creator->notifyItemReleased($model);
                \Setting::set('approved_items', \Setting::get('approved_items', 0) + 1);
            } else {
                if ($model->status == 3) {
                    $model->creator->notifyItemDeclined($model);
                }
                \Setting::set('approved_items', \Setting::get('approved_items', 0) - 1);
            }
            $model->creator->recalculateItems();
            $model->creator->save();
            \Setting::save();
        }
    }

    public function created(Item $model)
    {
        $model->creator->recalculateItems();
        $model->creator->save();
        \Setting::set('items', \Setting::get('items', 0) + 1);
        \Setting::save();
    }

    public function deleting(Item $model)
    {
        $model->creator->notifyItemDeleted($model);
        $model->creator->recalculateItems();
        $model->creator->save();
        \Setting::set('items', \Setting::get('items', 1) - 1);
        if ($model->status == 2) {
            \Setting::set('approved_items', \Setting::get('approved_items', 1) - 1);
        }
        \Setting::save();
    }

    public function deleted(Item $model)
    {
        $model->deleteAllFiles();
    }

    public function updated(Item $model)
    {
        try {
            //notify about purchased item has been updated
            if ($model->isDirty(['file'])) {
                $orderItems = OrderItem::where([
                    ['item_id', '=', $model->id],
                    ['stripe_status', '=', 'paid']
                ])->get();
                foreach ($orderItems as $orderItem) {
                    if ($user = $orderItem->order->customer) {
                        $user->notifyPurchasedItemUpdated($model);
                    }
                }
            }
            if ($model->isDirty(['creator_id']) && $model->getOriginal('creator_id')) {
                $oldCreator = User::find($model->getOriginal('creator_id'));
                if ($oldCreator) {
                    $oldCreator->recalculateItems();
                }
                $oldCreator->save();
                $model->creator->recalculateItems();
                $model->creator->save();
            }
        } catch (\Exception $ex) {

        }
    }

}
