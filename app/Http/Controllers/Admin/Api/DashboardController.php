<?php

namespace App\Http\Controllers\Admin\Api;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Stripe\Invoice;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

trait DashboardController
{
    /**
     * Return dashboard info
     *
     * @return array
     */
    public function getDashboard()
    {
        return [
            'users' => [
                'today' => User::query()->whereDate('created_at', '>=', Carbon::today())->count(),
                'total' => User::count(),
            ],
            'commision' => [
                'average' => $this->getAvgCommision(),
            ],
            'items' => [
                'today' => Item::query()->whereDate('created_at', '>=', Carbon::today())->count(),
                'total' => Item::count(),
                'top' => OrderItem::with('item')
                    ->select(
                        'item_id',
                        DB::raw("count(item_id) as count")
                    )
                    ->groupBy(['item_id'])
                    ->orderBy('count', 'desc')
                    ->take(10)
                    ->get()
            ],
            'earnings' => [
                'total' => $this->getEarnings('total'),
                'year' => $this->getEarnings('year'),
                'month' => $this->getEarnings('month'),
                'today' => $this->getEarnings('today'),
            ],
            'processed_sales' => [
                'today' => $this->getPaidOrderItems()->whereDate('created_at', '>=', Carbon::today())->count(),
                'total' => $this->getPaidOrderItems()->count()
            ],
            'statistics' => [
                'earnings' => $this->getStatistics('earnings'),
                'sales' => $this->getStatistics('sales'),
            ],
            'orders' => Order::with('customer', 'items')->orderBy('created_at', 'desc')->take(10)->get(),
            'plans' => $this->getPlans(),
        ];
    }

    /**
     * @param $group
     * @param $type
     * @return array
     */
    public function getCurrent($group, $type)
    {
        switch ($group) {
            case 'users':
                return $this->getCurrentByModel($type, User::query());
            case 'items':
                return $this->getCurrentByModel($type, Item::query());
            case 'processed_sales':
                return $this->getCurrentByModel($type, $this->getPaidOrderItems());
            default:
                throw new BadRequestHttpException(sprintf('%s type not supported'));
        }
    }

    protected function getAvgCommision()
    {
        return (int)Subscription::with('plan')->get()->pluck('plan.commission')->avg();
    }

    /**
     * Get week statistics by day, depends on type (earnings/sales)
     *
     * @param string $type
     *
     * @return array
     */
    public function getStatistics($type)
    {
        $startCurrent = Carbon::now()->startOfWeek();
        $startLast = Carbon::now()->subWeek()->startOfWeek();

        return [
            'current_week' => [
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startCurrent)->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startCurrent)->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(1))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(1))->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(2))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(2))->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(3))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(3))->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(4))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(4))->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(5))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(5))->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(6))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(6))->count()
            ],
            'last_week' => [
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startLast)->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startLast)->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(1))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(1))->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(2))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(2))->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(3))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(3))->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(4))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(4))->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(5))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(5))->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(6))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(6))->count()
            ]
        ];
    }

    /**
     * @param $type
     * @param \Illuminate\Database\Eloquent\Builder $model
     * @return array
     */
    private function getCurrentByModel($type, Builder $model)
    {
        $result = [];
        $result['total'] = $model->count();
        switch ($type) {
            case 'today':
                $result['today'] = $model->whereDate('created_at', '>=', Carbon::today())->count();
                break;
            case 'week':
                $startCurrent = Carbon::now()->startOfWeek();
                $startLast = Carbon::now()->endOfMonth();
                $result['today'] = $model
                    ->whereDate('created_at', '>=', $startCurrent)
                    ->whereDate('created_at', '<', $startLast)
                    ->count();
                break;
            case 'month':
                $startCurrent = Carbon::now()->startOfMonth();
                $startLast = Carbon::now()->endOfMonth();
                $result['today'] = $model
                    ->whereDate('created_at', '>=', $startCurrent)
                    ->whereDate('created_at', '<=', $startLast)
                    ->count();
                break;
            case 'year':
                $result['today'] = $model->whereYear('created_at', Carbon::now()->year)->count();
                break;
            default:
                $result['today'] = $model->count();
        }


        return $result;
    }

    /**
     * Get paid order items
     *
     * @return mixed
     */
    private function getPaidOrderItems()
    {
        return OrderItem::where(function ($query) {
            $query->where('status', 'paid')
                ->orWhere('stripe_status', 'paid');
        });
    }

    private function getPlans()
    {
        return Plan::withCount('subscriptions')
            ->orderBy('index')
            ->get();
    }

    private function getEarnings($date)
    {
        $orderItems = DB::table('order_items')
            ->where(function ($query) {
                $query->where('status', 'paid')
                    ->orWhere('stripe_status', 'paid');
            })
            ->select([
                'created_at',
                'commission_amount'
            ]);
        $blog = DB::table('order_stories')
            ->where('stripe_status', 'paid')
            ->select([
                'created_at',
                'price'
            ]);
        $promo = DB::table('promo_subscriptions')
            ->join('promo_plans', 'promo_plans.id', '=', 'promo_subscriptions.plan_id')
            ->select([
                'promo_subscriptions.created_at as created_at',
                'promo_plans.price as price'
            ]);


        switch ($date) {
            case 'today':
                $total = $orderItems->whereDate('created_at', '>=', Carbon::today())->sum('commission_amount');
                $total += $blog->whereDate('created_at', '>=', Carbon::today())->sum('price');
                $total += $promo->whereDate('promo_subscriptions.created_at', '>=', Carbon::today())->sum('price');
                return $total;
                break;
            case 'year':
                $total = $orderItems->whereYear('created_at', Carbon::now()->year)->sum('commission_amount');
                $total += $blog->whereYear('created_at', Carbon::now()->year)->sum('price');
                $total += $promo->whereYear('promo_subscriptions.created_at', Carbon::now()->year)->sum('price');
                return $total;
                break;
            case 'month':
                $total = $orderItems->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('commission_amount');
                $total += $blog->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('price');
                $total += $promo->whereBetween('promo_subscriptions.created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('price');
                return $total;
                break;
            default:
                $total = $orderItems->sum('commission_amount');
                $total += $blog->sum('price');
                $total += $promo->sum('price');
                return $total;
        }
    }
}