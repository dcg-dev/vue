<?php

namespace App\Observers;

use App\Models\OrderItem;
use App\Models\AffiliateSale;
use App\Models\User;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class OrderItemObserver
{

    public function creating(OrderItem $model)
    {
        if (!$model->country) {
            $model->country = $model->item->creator->country;
        }
        if (!$model->vat) {
            $model->vat = $model->item->creator->country_info->vat;
        }
    }

    public function updated(OrderItem $model)
    {
        try {
            if ($model->isDirty('stripe_status') && $model->stripe_status == OrderItem::STATUS_PAID) {
                //notify merchant about sale
                $item = Item::findOrFail($model->item_id);
                Auth::user()->notifyNewPurchase($item, $model->price);
                $item->creator->notifyNewSale($item, $model->price);
                $item->creator->count_sales++;
                $item->creator->save();
                $item->recalculateTotalSales();
                $item->save();

                //make affiliate sales field for referral
                if ((bool)$model->commission_amount && $reciever = User::where('username', Auth::user()->referred_by)->first()) {
                    AffiliateSale::create([
                        'user_id' => $reciever->id,
                        'affiliable_id' => $model->id,
                        'affiliable_type' => OrderItem::class,
                        'amount' => round($model->commission_amount * config('services.referral.percent.items') / 100, 2)
                    ]);
                }
            }
        } catch (\Exception $ex) {

        }
    }

}
