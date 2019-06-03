<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\StoryCreate;
use App\Http\Requests\StoryImage;
use App\Http\Requests\StoryCommented;
use App\Http\Requests\StoryPublish;
use App\Http\Requests\StoryBook;
use App\Models\Story;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderStory;

trait StoryController {

    /**
     * Return all stories in json
     *
     * @return Story
     */
    public function all(Request $request) {
        return Story::filter($request->all())
                ->where('approved', true)
                ->with('creator')
                ->paginate($request->get('per_page', 20));
    }
    
    /**
     * Return story in request
     * 
     * @param Story
     *
     * @return Story | null
     */
    public function get(Story $story) {
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
        if ($this->user()->countAvailableStories()) {
            $data = $request->only(['title']);
            $story = new Story();
            $story->fill($data);
            $story->creator_id = $this->user()->id;
            $story->is_published = false;
            $story->approved = false;
            $story->saveOrFail();
            $this->removeAvailabilityFromOrder();
            return $story;
        } else {
            throw new \Exception("You don't have permission to create Blog Post. Contact administrator!");
        }
    }
    
    /**
     * Return random publisher
     * 
     * @param StoryCreate $request
     * 
     * @return User
     */
    public function publisher() {
        //only if user posted more than 1 story
        return User::where('count_story', '>=', 1)->inRandomOrder()->first();
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
        $story->approved = false;
        $story->saveOrFail();
        return $story;
    }
    
    /**
     * Likes the story
     *
     * @return Story
     */
    public function like(Story $story) {
        $story->like();
        return Story::find($story->id);
    }
    
    /**
     * Returns the story comments
     *
     * @return \Illuminate\Http\Response
     */
    public function comments(Story $story, Request $request) {
        return $story->comments()->filter($request->all())->paginate($request->get('per_page', 5));
    }
    
    /**
     * Returns the story comments when user made one
     *
     * @return \Illuminate\Http\Response
     */
    public function commented(Story $story, StoryCommented $request) {
        $story->comments()->create([
            'message' => $request->get('message'),
            'sender_id' => $this->user()->id,
            'likes' => 0
        ]);
        return $this->comments($story, $request);
    }
    
    /**
     * Publish story
     *
     * @return \Illuminate\Http\Response
     */
    public function publish(Story $story, StoryPublish $request) {
        $data = $request->only(['title', 'sub_title', 'text']);
        $story->fill($data);
        $story->is_published = true;
        $story->saveOrFail();
        return $story;
    }
    
    /**
     * Book Blog Story
     * 
     * @param StoryBook $request
     * 
     * @return Story
     */
    public function book(StoryBook $request) {
        $user = $this->user();
        if ($user->hasStripeSubscription()) {
            $this->checkStripeCustomer($user, $request->get('token'));
            $order = $this->createStoryOrder($user);
            $charge = $this->createStoryCharge($request->get('token'));
            $this->updateOrder($charge, $order);
        } else {
            throw new \Exception("You are not available to book new Blog Post. Upgrade your subscription!");
        }
        return ['status' => true];
    }
    
    /**
     * Create order for story
     * 
     * @param User $user
     *
     * @return Order
     */
    public function createStoryOrder(User $user) {
        if (!(bool)config('services.blog.price')) {
            throw new \Exception("Blog Post price was not determined. Contact administrator.");
        }
        return Order::create([
            'customer_id' => $user->id,
            'amount' => config('services.blog.price'),
            'payment_type' => 'stripe',
            'order_status' => 'pending'
        ]);
    }
    
    /**
     * Create order for story
     * 
     * @param mixed $charge
     * @param Order $order
     *
     * @return Order
     */
    public function updateOrder($charge, Order $order) {
        $order->order_status = $charge->paid ? 'paid' : $charge->status;
        $order->save();
        
        OrderStory::create([
            'order_id' => $order->id,
            'stripe_charge_id' => $charge->id,
            'price' => config('services.blog.price'),
            'stripe_status' => $charge->paid ? 'paid' : $charge->status,
            'is_available' => $charge->paid ? true : false
        ]);
    }
    
    /**
     * Set is_availability to false, if user create new Blog Story
     *
     * @return OrderStory
     */
    public function removeAvailabilityFromOrder() {
        $user = $this->user();
        $orderStory = OrderStory::where('is_available', true)->whereHas('order', function ($query) use ($user) {
                                                                $query->where('customer_id', $user->id);
                                                            })->first();
        $orderStory->is_available = false;
        $orderStory->save();
        return $orderStory;
    }
    
}
