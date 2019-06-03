<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProfileUpdate;
use App\Http\Requests\SettingsUpdate;
use App\Models\Comment;
use App\Models\Rating;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Helpers\DigitHelper;
use App\Helpers\PageHelper;
use Kryptonit3\Counter\Models\Page;

trait ProfileController
{

    /**
     * Return current user profile
     *
     * @return \Illuminate\Support\Facades\Auth
     */
    public function current()
    {
        return $this->user();
    }

    /**
     * Return updated user model
     * @param ProfileUpdate $request
     *
     * @return App\Models\User
     */
    public function update(ProfileUpdate $request)
    {
        $data = $request->only(['biography', 'show_skills', 'show_country', 'freelance', 'facebook_link', 'youtube_link', 'twitter_link', 'soundcloud_link']);
        $user = $this->user();
        $user->fill($data);
        $user->setBase64Avatar($request->get('avatar'));
        $user->saveOrFail();
        $user->syncSkills($request->get('skills', []));
        $user->skills = $user->skills()->get();
        return $user;
    }

    /**
     * Return updated user model
     * @param SettingsUpdate $request
     *
     * @return App\Models\User
     */
    public function updateSettings(SettingsUpdate $request)
    {
        $requestArray = ['email', 'firstname', 'lastname', 'gender',
            'country', 'state', 'city', 'address_1',
            'address_2', 'company', 'show_status', 'notification_comments',
            'notification_inbox', 'notification_release', 'notification_reviews',
            'notification_sale', 'paypal_email', 'facebook_link', 'youtube_link', 'twitter_link', 'soundcloud_link'];
        $user = $this->user();
        //check if user has Stripe subscription to update notification settings
        if ($user->hasStripeSubscription()) {
            array_push($requestArray, 'notification_comments', 'notification_inbox',
                'notification_reviews', 'notification_sale');
        }
        $data = $request->only($requestArray);
        $user->fill($data);
        if ($request->get('new_password')) {
            $user->is_empty_password = false;
            $user->password = Hash::make($request->get('new_password'));
        }
        $user->saveOrFail();
        return $user;
    }

    /**
     * Return updated user model
     * @param SettingsUpdate $request
     *
     * @return App\Models\User
     */
    public function updateProfile(ProfileUpdate $request)
    {
        $data = $request->intersect(['email', 'firstname', 'lastname', 'gender',
            'country', 'state', 'city', 'address_1',
            'address_2', 'company', 'show_status', 'notification_comments',
            'notification_inbox', 'notification_release', 'notification_reviews',
            'notification_sale', 'paypal_email', 'facebook_link', 'youtube_link', 'twitter_link', 'soundcloud_link']);
        $this->user()->fill($data);
        $this->user()->saveOrFail();
        return $this->user();
    }

    /**
     * Return unread profile notifications
     *
     * @return Illuminate\Notifications\Notifiable
     */
    public function getNotifications(Request $request)
    {
        $notifications = $this->user()->notifications()->paginate($request->get('per_page', 10));
        $notifications->markAsRead();
        $this->user()->recalculateNotifications();
        $this->user()->save();
        return $notifications;
    }

    /**
     * Flush unread notifications
     *
     * @return void
     */
    public function flushNotifications()
    {
        $this->user()->notifications()->delete();
        $this->user()->recalculateNotifications();
        $this->user()->save();
    }

    protected function getDate(Request $request)
    {
        $started_at = $request->has('started_at') ? Carbon::createFromTimestamp($request->get('started_at')) : Carbon::now();
        $ended_at = $request->has('ended_at') ? Carbon::createFromTimestamp($request->get('ended_at')) : Carbon::now();
        return [
            $started_at->setTime(0, 0, 0),
            $ended_at->setTime(23, 59, 59),
        ];
    }

    public function visitors(Request $request)
    {
        $count = 0;
        $count += $this->getVisitors(Page::firstOrCreate(['page' => PageHelper::pageId('user.view', $this->user()->username)])->visitors(), $request);
        $count += $this->getVisitors(Page::firstOrCreate(['page' => PageHelper::pageId('user.item', $this->user()->username)])->visitors(), $request);
        $count += $this->getVisitors(Page::firstOrCreate(['page' => PageHelper::pageId('user.collection', $this->user()->username)])->visitors(), $request);
        return $count;
    }

    protected function getVisitors($query, $request)
    {
        if ($request->has('started_at') || $request->has('ended_at')) {
            $query->whereBetween('created_at', $this->getDate($request));
        }
        return $query->count();
    }

    public function processedSales(Request $request)
    {
        $query = $this->getPaidOrderItems();
        if ($request->has('started_at') || $request->has('ended_at')) {
            $query->whereBetween('created_at', $this->getDate($request));
        }
        return $query->count();
    }

    public function earnings(Request $request)
    {
        $query = $this->getPaidOrderItems();
        if ($request->has('started_at') || $request->has('ended_at')) {
            $query->whereBetween('created_at', $this->getDate($request));
        }
        return $query->sum('price');
    }

    public function averageSale(Request $request)
    {
        $query = $this->getPaidOrderItems();
        if ($request->has('started_at') || $request->has('ended_at')) {
            $query->whereBetween('created_at', $this->getDate($request));
        }
        return round($query->avg('price'), 2);
    }

    /**
     * Return dashboard info
     *
     * @return array
     */
    public function getDashboard()
    {
        $carbonCurrentWeek = [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
        ];
        $carbonLastWeek = [
            Carbon::now()->subWeek()->startOfWeek(),
            Carbon::now()->subWeek()->endOfWeek(),
        ];

        $currentWeekSales = $this->getPaidOrderItems()->whereBetween('created_at', $carbonCurrentWeek);
        $lastWeekSales = $this->getPaidOrderItems()->whereBetween('created_at', $carbonLastWeek);
        $currentWeekFollowers = $this->user()->followers()->whereBetween('followers.created_at', $carbonCurrentWeek);
        $lastWeekFollowers = $this->user()->followers()->whereBetween('followers.created_at', $carbonLastWeek);
        $topOrderItem = $this->getPaidOrderItems()->whereBetween('created_at', $carbonCurrentWeek)
            ->select('item_id', DB::raw('COUNT(order_items.item_id) as count'))
            ->groupBy('order_items.item_id')
            ->orderBy('order_items.count', 'desc')->first();
        $userPage = Page::firstOrCreate(['page' => PageHelper::pageId('user.view', $this->user()->username)]);

        return [
            'statistics' => [
                'earnings' => $this->getStatistics('earnings'),
                'sales' => $this->getStatistics('sales'),
            ],
            'earnings' => [
                'sales' => $currentWeekSales->sum('price'),
                'earnings' => DigitHelper::calculateGrowth($currentWeekSales->sum('price'), $lastWeekSales->sum('price')),
                'visitors' => DigitHelper::calculateGrowth($userPage->visitors()->whereBetween('created_at', $carbonCurrentWeek)->count(),
                    $userPage->visitors()->whereBetween('created_at', $carbonLastWeek)->count()),
                'followers' => DigitHelper::calculateGrowth($currentWeekFollowers->count(), $lastWeekFollowers->count()),
            ],
            'sales' => [
                'sales' => $currentWeekSales->count(),
                'top_item' => $topOrderItem ? $topOrderItem->item->name : '-',
                'comments' => DigitHelper::calculateGrowth(
                    $this->calculateComments(Comment::class, $carbonCurrentWeek),
                    $this->calculateComments(Comment::class, $carbonLastWeek)),
                'ratings' => DigitHelper::calculateGrowth(
                    $this->calculateComments(Rating::class, $carbonCurrentWeek),
                    $this->calculateComments(Rating::class, $carbonLastWeek)),
            ]
        ];
    }

    /**
     * Get paid order items
     *
     * @return mixed
     */
    public function getPaidOrderItems()
    {
        return OrderItem::
        where(function ($query) {
            $query->where('status', 'paid')
                ->orWhere('stripe_status', 'paid');
        })
            ->whereHas('item', function ($query) {
                $query->where('creator_id', $this->user()->id);
            });
    }

    /**
     * Calculate comments / ratings on items during for a week
     *
     * @param array $orderItemArray
     * @param string $type
     * @param array $dates
     *
     * @return void
     */
    public function calculateComments($type, $dates)
    {
        return $type::whereHas('item', function ($query) {
            $query->where('creator_id', $this->user()->id);
        })->whereBetween('created_at', $dates)->count();
    }

    /**
     * Get week statistics by day, depends on type (earnings/sales)
     *
     * @param string $type
     *
     * @return array
     */
    public function getStatistics($type)
    {
        $startCurrent = Carbon::now()->startOfWeek();
        $startLast = Carbon::now()->subWeek()->startOfWeek();

        return [
            'current_week' => [
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startCurrent)->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startCurrent)->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(1))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(1))->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(2))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(2))->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(3))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(3))->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(4))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(4))->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(5))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(5))->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(6))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startCurrent->copy()->addDay(6))->count()
            ],
            'last_week' => [
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startLast)->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startLast)->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(1))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(1))->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(2))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(2))->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(3))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(3))->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(4))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(4))->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(5))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(5))->count(),
                $type == 'earnings' ? $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(6))->sum('price') : $this->getPaidOrderItems()->whereDate('created_at', $startLast->copy()->addDay(6))->count()
            ]
        ];
    }
}
