<?php

namespace App\Http\Controllers\Admin\Api;

use Illuminate\Http\Request;
use App\Http\Requests\StoryCreate;
use App\Http\Requests\StoryUpdate;
use App\Http\Requests\StoryImage;
use App\Models\Story;

trait StoryController {

    /**
     * Return all stories in json
     *
     * @return Story
     */
    public function all(Request $request) {
        return Story::orderBy('created_at', 'desc')->with('creator')->paginate($request->get('per_page', 20));
    }
    
    /**
     * Return story in request
     * 
     * @param Story
     *
     * @return Story
     */
    public function get(Story $story) {
        return $story;
    } 
    
    /**
     * Change approving status
     *
     * @return Story
     */
    public function approving(Story $story, Request $request) {
        $story->approved = $request->get('approved');
        $story->saveOrFail();
        return $story;
    }

    /**
     * Create new story
     * 
     * @param StoryCreate $request
     * 
     * @return Story
     */
    public function create(StoryCreate $request) {
        $data = $request->only(['title', 'sub_title', 'text', 'approved']);
        $story = new Story();
        $story->fill($data);
        $story->creator_id = $this->user()->id;
        $story->saveOrFail();
        return $story;
    }
    
    /**
     * Update the story
     * 
     * @param StoryUpdate $request
     * 
     * @return Story
     */
    public function update(Story $story, StoryUpdate $request) {
        $data = $request->only(['title', 'sub_title', 'slug', 'text', 'approved']);
        $story->fill($data);
        $story->saveOrFail();
        return $story;
    }
    
    /**
     * Update story image
     *
     * @param StoryCreate $request
     * 
     * @return Story
     */
    public function uploadImage(Story $story, StoryImage $request) {
        $story->setImage($request->file('image'));
        $story->saveOrFail();
        return $story;
    }
    
    /**
     * Delete the story
     *
     * @return array
     */
    public function delete(Story $story, Request $request) {
        return [
            'status' => $story->delete()
        ];
    }

}
