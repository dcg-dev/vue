<?php

namespace App\Http\Controllers\Api;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Requests\AffiliateRequestPayout;
use App\Models\AffiliateSale;
use App\Models\AffiliateRequest;
use Carbon\Carbon;

trait AffiliateController
{

    /**
     * Return current user affiliate sales, where order item was paid
     *
     * @param Request $request
     *
     * @return AffiliateSale
     */
    public function my(Request $request)
    {
        $sales = $this->getPaidSales();

        // @TODO rewrite it
        if (!is_null($request->get('is_paid')) && $request->get('is_paid') != 'all') {
            $sales->where('is_paid', $request->get('is_paid') == 'true' ? true : false);
        }
        if (!is_null($request->get('date_filter')) && $request->get('date_filter') != 'all') {
            switch ($request->get('date_filter')) {
                case 'month':
                    $date = Carbon::now()->subDays(30);
                    break;
                case 'sixMonth':
                    $date = Carbon::now()->subMonth(6);
                    break;
                case 'year':
                    $date = Carbon::now()->subYears(1);
                    break;
                default:
                    $date = Carbon::now()->subDays(30);
                    break;
            }
            $sales->where('created_at', '>=', $date);
        }
        $data = $sales->paginate($request->get('per_page', 10));
        $data->map(function ($item) {
            if ($item->affiliable instanceof Subscription) {
                $item->affiliable->load('customer');
            } else {
                $item->affiliable->load('item');
            }
        });
        return $data;
    }

    /**
     * Return affiliate sales info
     *
     * @return array
     */
    public function info()
    {
        return [
            'open_amount' => $this->getPaidSales()->where('is_paid', false)->sum('amount'),
            'sales_today' => $this->getPaidSales()->whereDay('created_at', Carbon::now()->day)->count(),
            'total_referrals' => $this->getPaidSales()->count(),
            'total_earned' => $this->getPaidSales()->sum('amount'),
            'unpaid_amount' => $this->getPaidSales()->where('is_paid', false)->count(),
            'paid_amount' => $this->getPaidSales()->where('is_paid', true)->count(),
        ];
    }

    /**
     * Return paid sales
     *
     * @return mixed
     */
    public function getPaidSales()
    {
        return AffiliateSale::with('affiliable')
            ->where(function ($query) {
                $query->where('affiliable_type', \App\Models\OrderItem::class)
                    ->whereRaw("exists(select * from order_items where order_items.id = affiliate_sales.affiliable_id and (order_items.status = 'paid' or order_items.stripe_status = 'paid') )");
            })
            ->orWhere('affiliable_type', \App\Models\Subscription::class);
    }

    /**
     * Make payout request
     *
     * @param AffiliateRequestPayout $request
     *
     * @return AffiliateRequest
     */
    public function request(AffiliateRequestPayout $request)
    {
        $affiliateSales = $this->getPaidSales()->where('is_paid', false)->get();
        if (!$this->user()->affiliateRequests()->where('is_closed', false)->count() || count($affiliateSales)) {
            //create request
            $affiliateRequest = AffiliateRequest::create([
                'user_id' => $this->user()->id,
                'message' => $request->get('message')
            ]);
            //attach request on all unpaid affiliate sales
            foreach ($affiliateSales as $affiliateSale) {
                $affiliateSale->request_id = $affiliateRequest->id;
                $affiliateSale->save();
            }
            return $affiliateRequest;
        } else {
            throw new \Exception("Request was sent or you don't have unpaid Affiliate Sales");
        }
    }

}
