<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateRequest;
use App\Models\AffiliateSale;

class AffiliateController extends Controller {

    use Api\AffiliateController;
    
    /**
     * Show list of the affiliate requests.
     *
     * @return \Illuminate\Http\Response
     */
    public function requestList() {
        return view('admin.affiliate.request.list');
    }
    
    /**
     * Show list of the affiliate sales.
     *
     * @return \Illuminate\Http\Response
     */
    public function saleList() {
        return view('admin.affiliate.sale.list');
    }
    
    /**
     * Show configuration page
     *
     * @return \Illuminate\Http\Response
     */
    public function configuration() {
        return view('admin.affiliate.configuration');
    }
    
    /**
     * Show the form to edit affiliate request
     * 
     * @param AffiliateRequest
     *
     * @return \Illuminate\Http\Response
     */
    public function viewRequestEdit(AffiliateRequest $request) {
        return view('admin.affiliate.request.edit', ['request' => $request]);
    }
    
    /**
     * Show the form to edit affiliate sale
     * 
     * @param AffiliateSale
     *
     * @return \Illuminate\Http\Response
     */
    public function viewSaleEdit(AffiliateSale $sale) {
        return view('admin.affiliate.sale.edit', ['sale' => $sale]);
    }

}
