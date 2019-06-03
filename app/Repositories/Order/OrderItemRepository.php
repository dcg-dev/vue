<?php

namespace App\Repositories\Order;

use App\Models\OrderItem;
use App\Repositories\Repository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * Class OrderItemRepository
 * @package App\Repositories\Order
 */
class OrderItemRepository extends Repository
{

    /**
     * Specify Model class name.
     *
     * @return mixed
     */
    public function model()
    {
        return OrderItem::class;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->model
            ->where(function ($query) {
                $query->where('status', $this->model->getStatusPaid())
                    ->orWhere('stripe_status', $this->model->getStatusPaid());
            })
            ->whereHas('item.creator', function ($query) {
                $query->where('id', Auth::user()->id);
            })
            ->with('item.creator.country_info')
            ->orderby('created_at', 'desc');
    }

    /**
     * Return items by today.
     *
     * @return mixed
     */
    public function countToday()
    {
        return $this->all()
            ->whereDay('created_at', date('d'))
            ->count();
    }

    /**
     * Return items by last week.
     *
     * @return mixed
     */
    public function countLastWeek()
    {
        return $this->all()
            ->whereDate('created_at', '>=', new Carbon("last week monday"))
            ->whereDate('created_at', '<=', new Carbon("last week sunday"))
            ->count();
    }

    /**
     * Return items by last month.
     *
     * @return mixed
     */
    public function countLastMonth()
    {
        return $this->all()
            ->whereMonth('created_at', (new Carbon('last month'))->month)
            ->count();
    }

    /**
     * Return all items.
     *
     * @return mixed
     */
    public function countAll()
    {
        return $this->all()->count();
    }

    /**
     * Return counts.
     *
     * @return array
     */
    public function counts()
    {
        return [
            'today' => $this->countToday(),
            'lastWeek' => $this->countLastWeek(),
            'lastMonth' => $this->countLastMonth(),
            'all' => $this->countAll(),
        ];
    }


    /**
     * Return purchased items.
     *
     * @return mixed
     */
    public function purchased()
    {
        $currentUser = Auth::user()->id;

        return $this->model->with(['license', 'item.creator', 'order.customer', 'item.ratings' => function ($query) use ($currentUser) {
            $query->where('creator_id', $currentUser);
        }, 'item' => function ($query) {
            $query->withTrashed();
        }])
            ->whereHas('order.customer', function ($query) use ($currentUser) {
                $query->where('id', $currentUser);
            })
            ->where(function ($query) {
                $query->where('status', $this->model->getStatusPaid())
                    ->orWhere('stripe_status', $this->model->getStatusPaid());
            });
    }

    /**
     * Return all transactions.
     *
     * @param $params
     * @return array
     */
    public function billing($params)
    {
        $currentUser = Auth::user()->id;

        $account = $this->getSubscriptionsInvoice();
        $promotional = $this->getPromoSubscriptions();
        $total = collect([]);
        $orders = $this->model->with(['order.customer', 'item.creator'])
            ->whereHas('order.customer', function ($query) use ($currentUser) {
                $query->where('id', $currentUser);
            })
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'order_id' => $item->order->id,
                    'item_id' => $item->item_id,
                    'updated_at' => $item->updated_at,
                    'description' => $item->item ? $item->item->name : null,
                    'price' => $item->price,
                    'user' => $item->item ? $item->item->creator->fullname : null,
                    'type' => 'account'
                ];
            });
        if ($orders) {
            $total = $total->merge($orders);
        }
        if ($account) {
            $total = $total->merge($account);
        }
        if ($promotional) {
            $total = $total->merge($promotional);
        }
        $total = $total->sortByDesc('updated_at');
        switch (array_get($params, 'type')) {
            case 'account':
                $data = $account;
                break;
            case 'promotional':
                $data = $promotional;
                break;
            default:
                $data = $total;
        }

        return [
            'data' => $data->sortByDesc('updated_at')->forPage(array_get($params, 'page'), 10)->values(),
            'account' => $account->count(),
            'promotional' => $promotional->count(),
            'total' => $total->count(),
        ];
    }

    /**
     * @return \Illuminate\Support\Collection|static
     */
    protected function getPromoSubscriptions()
    {
        $currentUser = Auth::user();
        $promo = $currentUser->promo()->with(['plan', 'items'])->get();

        return collect($promo)->map(function ($item) use ($currentUser) {
            return [
                'order_id' => $item->id,
                'updated_at' => $item->created_at,
                'description' => $item->plan->name . " (" . implode(', ', $item->items->pluck('name')->toArray()) . ")",
                'user' => $currentUser->fullname,
                'price' => str_replace('$', '', $item->plan->price),
                'type' => 'promotional',
            ];
        });
    }

    /**
     * @return \Illuminate\Support\Collection|static
     */
    protected function getSubscriptionsInvoice()
    {
        $currentUser = Auth::user();

        if (!$currentUser->hasStripeId() || !$currentUser->asStripeCustomer()) {
            return collect([]);
        }

        $invoices = $currentUser->invoices();
        $results = collect([]);
        foreach ($invoices as $item) {
            foreach ($item->lines->data as $line) {
                $results->push([
                    'order_id' => $item->id,
                    'updated_at' => $item->date()->timestamp,
                    'description' => $line->type == 'subscription' ? $line->metadata->description : $line->description,
                    'user' => $currentUser->fullname,
                    'price' => $line->amount,
                    'type' => 'account',
                ]);
            }
        }
        return $results;
    }
}