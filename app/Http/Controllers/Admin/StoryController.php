<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Story;

class StoryController extends Controller {

    use Api\StoryController;
    
    /**
     * Show the form to create new story
     *
     * @return \Illuminate\Http\Response
     */
    public function viewCreate() {
        return view('admin.blog.story.create');
    }
    
    /**
     * Show the form to edit story
     * 
     * @param Story
     *
     * @return \Illuminate\Http\Response
     */
    public function viewEdit(Story $story) {
        return view('admin.blog.story.edit', ['story' => $story]);
    }

}
