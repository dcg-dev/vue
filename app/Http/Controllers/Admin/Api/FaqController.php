<?php

namespace App\Http\Controllers\Admin\Api;

use Illuminate\Http\Request;
use App\Http\Requests\FaqCategoryCreate;
use App\Http\Requests\FaqTopicCreate;
use App\Http\Requests\FaqCategoryUpdate;
use App\Http\Requests\FaqTopicUpdate;
use App\Models\FaqCategory;
use App\Models\FaqTopic;

trait FaqController {

    /**
     * Return all faq categories in json withoud pagination
     *
     * @return \Illuminate\Http\Response
     */
    public function allCategories() {
        return FaqCategory::all();
    }
    
    /**
     * Return all faq categories in json
     * 
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getCategories(Request $request) {
        return FaqCategory::filter($request->all())
                        ->paginate($request->get('per_page', 10));
    }
    
    /**
     * Return all faq topics in json
     *
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function getTopics(Request $request) {
        return FaqTopic::filter($request->all())
                        ->with('category')
                        ->paginate($request->get('per_page', 10));
    }
    
    /**
     * Delete faq category
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteCategory(FaqCategory $category) {
        return [
            'status' => $category->delete()
        ];
    }
    
    /**
     * Delete faq topic
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteTopic(FaqTopic $topic) {
        return [
            'status' => $topic->delete()
        ];
    }
    
    /**
     * Return faq category
     * 
     * @param FaqCategory $category
     *
     * @return FaqCategory
     */
    public function getCategory(FaqCategory $category) {
        return $category;
    }
    
    /**
     * Return faq topic
     * 
     * @param FaqTopic $topic
     *
     * @return FaqTopic
     */
    public function getTopic(FaqTopic $topic) {
        return $topic;
    }
    
    /**
     * Create new faq category
     * 
     * @param FaqCategoryCreate $request
     * 
     * @return FaqCategory
     */
    public function createCategory(FaqCategoryCreate $request) {
        $data = $request->only(['name']);
        $category = new FaqCategory();
        $category->fill($data);
        $category->saveOrFail();
        return $category;
    }
    
    /**
     * Create new faq topic
     * 
     * @param FaqCategoryCreate $request
     * 
     * @return FaqTopic
     */
    public function createTopic(FaqTopicCreate $request) {
        $data = $request->only(['faq_category_id', 'question', 'answer', 'types']);
        $topic = new FaqTopic();
        $topic->fill($data);
        $topic->saveOrFail();
        return $topic;
    }
    
    /**
     * Update the faq category
     * 
     * @param FaqCategory $category
     * @param FaqCategoryUpdate $request
     * 
     * @return FaqCategory
     */
    public function updateCategory(FaqCategory $category, FaqCategoryUpdate $request) {
        $category->name = $request->get('name');
        $category->saveOrFail();
        return $category;
    }
    
    /**
     * Update the faq topic
     * 
     * @param FaqTopic $topic
     * @param FaqTopicUpdate $request
     * 
     * @return FaqTopic
     */
    public function updateTopic(FaqTopic $topic, FaqTopicUpdate $request) {
        $data = $request->only(['faq_category_id', 'question', 'answer', 'types']);
        $topic->fill($data);
        $topic->saveOrFail();
        return $topic;
    }
}
