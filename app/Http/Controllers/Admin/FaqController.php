<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class FaqController extends Controller {
    
    use Api\FaqController;
    
    /**
     * Show the categories list
     *
     * @return \Illuminate\Http\Response
     */
    public function categories() {
        return view('admin.support.faq.category.list');
    }

    /**
     * Show the topics list
     *
     * @return \Illuminate\Http\Response
     */
    public function topics() {
        return view('admin.support.faq.topic.list');
    }
    
}
