<?php

namespace App\Http\Controllers\Admin\Api;

use Illuminate\Http\Request;
use App\Models\AffiliateRequest;
use App\Models\AffiliateSale;
use Carbon\Carbon;
use App\Http\Requests\AffiliateRequestUpdate;
use App\Http\Requests\AffiliateSaleUpdate;

trait AffiliateController {

    /**
     * Return all affiliate requests in json
     * 
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getRequests(Request $request) {
        return AffiliateRequest::filter($request->all())
                        ->with('user')
                        ->paginate($request->get('per_page', 10));
    }
    
    /**
     * Return all affiliate sales in json
     *
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function getSales(Request $request) {
        return AffiliateSale::filter($request->all())
                        ->with('user')
                        ->paginate($request->get('per_page', 10));
    }
    
    /**
     * Close the request
     *
     * @param AffiliateRequest $affiliateRequest
     * 
     * @return AffiliateRequest
     */
    public function closeRequest(AffiliateRequest $affiliateRequest) {
        $affiliateRequest->is_closed = true;
        $affiliateRequest->closed_at = Carbon::now();
        $affiliateRequest->save();
        
        $affiliateRequest->affiliate_sales()->update(['is_paid' => true]);
        return $affiliateRequest;
    }
    
    /**
     * Return affiliate request
     * 
     * @param AffiliateRequest $affiliateRequest
     *
     * @return AffiliateRequest
     */
    public function getRequest(AffiliateRequest $affiliateRequest) {
        $affiliateRequest->user = $affiliateRequest->user;
        $affiliateRequest->affiliate_sales = $affiliateRequest->affiliate_sales;
        return $affiliateRequest;
    }
    
    /**
     * Return affiliate sale
     * 
     * @param AffiliateSale $sale
     *
     * @return AffiliateSale
     */
    public function getSale(AffiliateSale $sale) {
        $sale->user = $sale->user;
        return $sale;
    }
    
    /**
     * Update the affiliate request
     * 
     * @param AffiliateRequest $affiliateRequest
     * @param AffiliateRequestUpdate $updateRequest
     * 
     * @return AffiliateRequest
     */
    public function updateRequest(AffiliateRequest $affiliateRequest, AffiliateRequestUpdate $updateRequest) {
        $affiliateRequest->is_closed = $updateRequest->get('is_closed');
        $affiliateRequest->closed_at = $updateRequest->get('is_closed') ? Carbon::now() : null;
        $affiliateRequest->message = $updateRequest->get('message');
        $affiliateRequest->saveOrFail();
        return $affiliateRequest;
    }
    
    /**
     * Update the affiliate sale
     * 
     * @param AffiliateSale $sale
     * @param AffiliateSaleUpdate $request
     * 
     * @return AffiliateSale
     */
    public function updateSale(AffiliateSale $sale, AffiliateSaleUpdate $request) {
        $sale->is_paid = $request->get('is_paid');
        $sale->saveOrFail();
        return $sale;
    }
}
