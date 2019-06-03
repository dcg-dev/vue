<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Story;

class StoryController extends Controller {
    
    use Api\StoryController,
        Api\StripeController;
            
    /**
     * Show the story
     *
     * @return \Illuminate\Http\Response
     */
    public function view(Story $story) {
        return view('blog.story.view', ['story' => $story]);
    }
    
    /**
     * Show form to continue creating story
     *
     * @return \Illuminate\Http\Response
     */
    public function publishView(Story $story) {
        //allowed only for creator and only if story wasn't published
        return ($story->creator_id && $story->creator_id == $this->user()->id && !$story->is_published) ? 
                view('blog.story.publish', ['story' => $story]) :
                view('errors.403');
    }
}
