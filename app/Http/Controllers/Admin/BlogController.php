<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BlogController extends Controller {
    
    /**
     * Show the stories list
     *
     * @return \Illuminate\Http\Response
     */
    public function stories() {
        return view('admin.blog.story.list');
    }

}
