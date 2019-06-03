<?php

namespace App\Http\Controllers\Api;

use App\Models\Followers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Feed;
use \Illuminate\Support\Collection;
use \Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

trait UserController
{

    /**
     * Returns the all active users
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $per_page = is_numeric($request->get('per_page', 20)) ? $request->get('per_page', 20) : \Setting::get($request->get('per_page', 20), 20);
        return User::filter($request->all())->paginate($per_page);
    }

    /**
     * Returns the current user
     *
     * @return User
     */
    public function current()
    {
        $user = $this->user();
        if ($user) {
            $user->card_name = Cache::remember("user:$user->id:card_name", 15, function () use ($user) {
                return ($user->stripe_id && $card = $user->cards()->last()) ? $card->name : null;
            });
            $user = $user->makeVisible('level')->toArray();
        }
        return [
            'status' => (bool)$user,
            'user' => $user,
        ];
    }

    /**
     * Returns the user
     *
     * @return User
     */
    public function overview(User $user)
    {
        $ratings = [];
        foreach ($user->items as $item) {
            foreach ($item->ratings as $rating) {
                $ratings[] = $rating;
            }
        }
        //unset items to prevent errors, where we should get 3 allowed items
        unset($user->items);
        $user->ratings = array_slice($ratings, 0, 3);
        $user->followers = $user->followers()->take(3)->get();
        $user->items = $user->items()
            ->where([['creator_id', '=', $user->id],
                ['status', '=', 2]])
            ->with(['categories' => function ($categoryQuery) {
                $categoryQuery->where('enabled', true);
            }])
            ->orderBy('created_at', 'desc')
            ->take(3)->get();
        $user->skills = $user->skills()->where('enabled', true)->get();
        //Insert line breaks where newlines (\n) occur in the string
        $user->biography = nl2br($user->biography);
        $user->isMaxPlan = $user->hasStripeSubscription() && $user->plan('main')->isMaxPrice();
        return $user;
    }

    /**
     * Returns user with followers
     *
     * @return User
     */
    public function getFollowers(User $user, Request $request)
    {
        return $user->followers()->select('users.*')->paginate($request->get('per_page', \Setting::get('pagination.user.followers', 16)));
    }

    /**
     * Returns user with following
     *
     * @return User
     */
    public function getFollowing(User $user, Request $request)
    {
        return $user->following()->select('users.*')->paginate($request->get('per_page', \Setting::get('pagination.user.following', 16)));
    }

    /**
     * Follow user action
     *
     * @return User
     */
    public function follow(User $user)
    {
        $currentUser = $this->user();
        $user->followers()->attach($currentUser->id);
        $user->recalculateFollowers();
        $user->save();
        $currentUser->recalculateFollowing();
        $currentUser->save();
        return $this->overview($user);
    }

    /**
     * Unfollow user action
     *
     * @return User
     */
    public function unfollow(User $user)
    {
        $currentUser = $this->user();
        $user->followers()->detach($currentUser->id);
        $user->recalculateFollowers();
        $user->save();
        $currentUser->recalculateFollowing();
        $currentUser->save();
        return $this->overview($user);
    }

    /**
     * Follow user action
     *
     * @return \App\Models\User
     */
    public function followToggle(User $user)
    {
        if ($user->id == $this->user()->id) {
            abort(403, 'You can not following for yourself!');
        }
        $has = $user->followers()->where('user_id', $this->user()->id)->count();
        if (!$has) {
            $user->followers()->attach($this->user()->id);
        } else {
            $user->followers()->detach($this->user()->id);
        }
        $user->recalculateFollowing();
        $user->recalculateFollowers();
        $user->save();
        $this->user()->recalculateFollowing();
        $this->user()->recalculateFollowers();
        $this->user()->save();
        return User::find($user->id);
    }

    /**
     * Follow user action
     *
     * @return User
     */
    public function followEmail(User $user)
    {
        $record = Followers::where('user_id', $this->user()->id)->where('follow_id', $user->id)->first();
        if ($record) {
            $record->mail = true;
            $record->saveOrFail();
            return User::find($user->id);
        }
        return $user;
    }

    /**
     * UnFollow user action
     *
     * @return User
     */
    public function unfollowEmail(User $user)
    {
        $record = Followers::where('user_id', $this->user()->id)->where('follow_id', $user->id)->first();
        if ($record) {
            $record->mail = false;
            $record->saveOrFail();
            return User::find($user->id);
        }
        return $user;
    }

    /**
     * Returns user with items
     *
     * @return User
     */
    public function getItems(User $user, Request $request)
    {
        return $user->items()
            ->filter($request->all())
            ->where([['creator_id', '=', $user->id],
                ['status', '=', 2]])
            ->with('creator')
            ->paginate(\Setting::get('pagination.items.user') ?: $request->get('per_page', 16));
    }

    /**
     * Returns user with items
     *
     * @return User
     */
    public function favourites(Request $request)
    {
        return $this->user()->favourites()->paginate(20);
    }

    /**
     * Returns user feed
     *
     * @return User
     */
    public function getFeed(Request $request)
    {
        $feed = new Feed($this->user()->id, $request);
        $feed->setPerPage($request->get('per_page', \Setting::get('pagination.user.feed', 9)));
        return $feed->all();
    }

    /**
     * Returns user feed category count items
     *
     * @return User
     */
    public function getFeedCount(Request $request)
    {
        $feed = new Feed($this->user()->id, $request);
        return $feed->count();
    }


    public function friends(User $user)
    {
        return $user->friends;
    }

    public function getCollections(User $user, Request $request)
    {
        return $user->collections()
            ->filter($request->all())
            ->paginate($request->get('per_page', \Setting::get('pagination.user.collections', 9)));
    }

    /**
     * Returns user item ratings
     *
     * @return array
     */
    public function userRatings(User $user, Request $request)
    {
        $ratings = new Collection();
        foreach ($user->items as $item) {
            foreach ($item->ratings as $rating) {
                $rating->itemSlug = $item->slug;
                $rating->itemName = $item->name;
                $ratings->push($rating);
            }
        }

        return new LengthAwarePaginator($ratings->forPage($request->get('page'), $request->get('per_page')), $ratings->count(),
            $request->get('per_page'), $request->get('page'), []);
    }


}
