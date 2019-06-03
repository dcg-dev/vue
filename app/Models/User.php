<?php

namespace App\Models;

use App\Models\Traits\SubscriptionTrait;
use App\Models\Traits\MessengerTrait;
use App\Scopes\ActivatedScope;
use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use App\Models\Skill;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Passwords\CanResetPassword;
use EloquentFilter\Filterable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Billable;
use App\Notifications\ActivationNotification;
use App\Observers\UserObserver;
use App\Models\Model;
use App\Models\Notification;
use App\Models\Plan;
use App\Models\AffiliateRequest;
use App\Models\Traits\NotificationTrait;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{

    use Notifiable,
        Authenticatable,
        Authorizable,
        CanResetPassword,
        Sluggable,
        Filterable,
        SoftDeletes,
        Billable,
        NotificationTrait,
        MessengerTrait,
        SubscriptionTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'avatar',
        'role', 'biography', 'show_skills', 'show_country', 'freelance',
        'count_followers', 'count_following', 'count_items', 'count_collections',
        'count_sales', 'count_story', 'rating', 'gender', 'country', 'state', 'city',
        'address_1', 'address_2', 'company', 'show_status', 'notification_comments',
        'notification_inbox', 'notification_release', 'notification_reviews',
        'notification_sale', 'username', 'facebook_link', 'youtube_link',
        'twitter_link', 'soundcloud_link', 'count_story', 'is_empty_password', 'activated',
        'count_notifications', 'referred_by', 'stripe_account_id', 'paypal_email', 'last_visited_at', 'banned_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'last_visited_at', 'banned_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'firstname' => 'string',
        'lastname' => 'string',
        'username' => 'string',
        'email' => 'string',
        'password' => 'string',
        'avatar' => 'string',
        'role' => 'string',
        'biography' => 'string',
        'show_skills' => 'bool',
        'show_country' => 'bool',
        'freelance' => 'bool',
        'count_followers' => 'int',
        'count_following' => 'int',
        'count_items' => 'int',
        'count_collections' => 'int',
        'count_sales' => 'int',
        'count_story' => 'int',
        'rating' => 'float',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
        'last_visited_at' => 'timestamp',
        'banned_at' => 'timestamp',
        'gender' => 'string',
        'country' => 'string',
        'state' => 'string',
        'city' => 'string',
        'address_1' => 'string',
        'address_2' => 'string',
        'company' => 'string',
        'show_status' => 'bool',
        'notification_comments' => 'bool',
        'notification_inbox' => 'bool',
        'notification_release' => 'bool',
        'notification_reviews' => 'bool',
        'notification_sale' => 'bool',
        'activated' => 'bool',
        'facebook_link' => 'string',
        'youtube_link' => 'string',
        'twitter_link' => 'string',
        'soundcloud_link' => 'string',
        'followed' => 'bool',
        'is_empty_password' => 'bool',
        'count_notifications' => 'int',
        'referred_by' => 'string',
        'stripe_account_id' => 'string',
        'paypal_email' => 'string',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', ' activation_token'
    ];

    /**
     * The attributes that should be appended for arrays.
     *
     * @var array
     */
    protected $appends = [
        'followed', 'level', 'online'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'username' => [
                'source' => ['fullname']
            ]
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ActivatedScope());
        static::observe(new UserObserver());
    }

    public function toArray()
    {
        $data = parent::toArray();
        $following = Auth::user() ? Followers::where('user_id', Auth::user()->id)->where('follow_id', $this->id)->first() : false;
        $data['skillIds'] = $this->skills()->pluck('skills.id')->all();
        $data['iFollow'] = (bool)$following;
        $data['iFollowMail'] = (bool)$following && $following->mail;
        $data['hasStripe'] = $this->hasStripeSubscription();
        $data['hasAffiliateRequest'] = $this->affiliateRequests()->where('is_closed', 0)->count() ? true : false;
        $data['availableStories'] = $this->countAvailableStories();
        return $data;
    }

    /**
     * Count how much stories user can create
     *
     * @return boolean
     */
    public function countAvailableStories()
    {
        return $this->orders()
            ->whereHas('story', function ($query) {
                $query->where('is_available', true);
            })
            ->count();
    }

    /**
     * Returns true if user can be paid by Stripe gateway
     *
     * @return boolean
     */
    public function hasStripeSubscription()
    {
        $freePlan = Plan::getFree();
        return $this->isAdmin() || ((!$this->stripe_id || !$freePlan) ? false : ($this->subscribed('main') && $this->subscription('main')->stripe_plan != $freePlan->stripe_id));
    }

    /**
     * Returns true if user is Administrator
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    /**
     * Mutator for fullname attribute
     *
     * @return string
     */
    public function getFullnameAttribute()
    {
        return "$this->firstname $this->lastname";
    }

    /**
     * Mutator for get avatar attribute
     *
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        return $value ? Storage::disk('s3')->url("users/$this->id/images/$value") : asset('images/avatar.jpg');
    }

    /**
     * Return true if user has avatar
     * @return boolean
     */
    public function hasAvatar()
    {
        return (bool)array_get($this->attributes, 'avatar');
    }

    /**
     * Mutator for directory
     *
     * @return string
     */
    public function getDirectoryAttribute()
    {
        $path = "users/$this->id/images";
        Storage::disk('s3')->makeDirectory($path, 0777, true);
        return $path;
    }

    /**
     * Create and save new avatar
     * @param string $content
     * @return string
     */
    public function setAvatar($content)
    {
        $filename = $this->getFileName($content);
        return $this->avatarCropAndSave($content, $filename);
    }

    /**
     * Created and save new avatar
     * @param string $url
     * @return string
     */
    public function setAvatarByUrl($url)
    {
        $content = file_get_contents($url);
        $filename = $this->getFileName($url);
        return $this->avatarCropAndSave($content, $filename);
    }

    /**
     * Create and save new avatar from base64 string
     * @param string $content
     * @return string
     */
    public function setBase64Avatar($content)
    {
        //check if new avatar was uploaded, it would be base64 coded string
        if ($this->isBase64Image($content)) {
            $filename = $this->getFileName($content);
            return $this->avatarCropAndSave($content, $filename);
        } else {
            return;
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function promo()
    {
        return $this->hasMany(PromoSubscription::class);
    }

    /**
     * Check if string is base64 coded
     * @param string $string
     *
     * @return boolean
     */
    function isBase64Image($string)
    {
        // If its not base64 end processing and return false
        return (bool)strstr($string, "data:image");
    }

    /**
     * Return file name based on content
     * @param string $content
     * @return string
     */
    public function getFileName($content)
    {
        $extension = array_get([
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
        ], image_type_to_mime_type(exif_imagetype($content)), 'jpg');
        $rand = str_random(8);
        return "$this->id-$rand.$extension";
    }

    /**
     * Crops and save new avatar
     * @param type $content
     * @param type $filename
     * @return type
     */
    public function avatarCropAndSave($content, $filename)
    {
        $fullpath = $this->getDirectoryAttribute() . "/$filename";
        $old = $this->getDirectoryAttribute() . "/" . $this->attributes['avatar'];
        if (Storage::disk('s3')->exists($old)) {
            Storage::disk('s3')->delete($old);
        }
        $image = Image::make($content)->fit(128)->stream();
        if (Storage::disk('s3')->put($fullpath, $image->__toString())) {
            $this->avatar = $filename;
            return $filename;
        }
        return null;
    }

    /**
     * Returns list of items
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(Item::class, 'creator_id');
    }

    /**
     * Returns list of items
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stories()
    {
        return $this->hasMany(Story::class, 'creator_id');
    }

    /**
     * Returns list of skills
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skills', 'user_id', 'skill_id');
    }

    /**
     * Sync the intermediate tables with a list of IDs or collection of skills.
     *
     * @param  \Illuminate\Database\Eloquent\Collection|array $skills
     * @param array
     */
    public function syncSkills($skills = [])
    {
        $this->skills()->sync($skills);
    }

    /**
     * This function allows us to get a list of users following us
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(self::class, 'followers', 'follow_id', 'user_id')->withTimestamps()->groupBy('followers.created_at', 'followers.updated_at', 'users.id', 'followers.follow_id', 'followers.user_id')->orderBy('followers.created_at', 'desc');
    }

    /**
     * Get all users we are following
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function following()
    {
        return $this->belongsToMany(self::class, 'followers', 'user_id', 'follow_id')->withTimestamps()->groupBy('followers.created_at', 'followers.updated_at', 'users.id', 'followers.follow_id', 'followers.user_id')->orderBy('followers.created_at', 'desc');
    }

    /**
     * Returns list of skills
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function friends()
    {
        return $this->following()
            ->where('user_id', $this->id);
    }

    /**
     * Returns list of tags
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favourites()
    {
        return $this->hasMany(Favourite::class, 'creator_id')->with('item.creator');
    }

    /**
     * Returns list of collections
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function collections()
    {
        return $this->hasMany(Collection::class, 'creator_id')->with('creator');
    }

    /**
     * Return country info
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function country_info()
    {
        return $this->hasOne(Country::class, 'name', 'country');
    }

    /**
     * Get the entity's notifications.
     */
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->groupBy('notifications.created_at', 'notifications.id')->orderBy('notifications.created_at', 'desc');
    }

    /**
     * Get the entity's read notifications.
     */
    public function readNotifications()
    {
        return $this->notifications()->whereNotNull('read_at');
    }

    /**
     * Get the entity's unread notifications.
     */
    public function unreadNotifications()
    {
        return $this->notifications()->whereNull('read_at');
    }

    /**
     * Get all of the subscriptions for the Stripe model.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, $this->getForeignKey())->orderBy('created_at', 'desc');
    }

    public function orderItems()
    {
        return $this->hasManyThrough(OrderItem::class, Item::class, 'creator_id', 'item_id');
    }

    /**
     * Get a subscription instance by name.
     *
     * @param  string $subscription
     * @return \Laravel\Cashier\Subscription|null
     */
    public function subscription($subscription = 'default')
    {
        return $this->subscriptions->sortByDesc(function ($value) {
            return $value->created_at;
        })
            ->first(function ($value) use ($subscription) {
                return $value->name === $subscription;
            });
    }

    /**
     * Get user plan
     *
     * @param  string $type
     * @return Plan
     */
    public function plan($type = 'default')
    {
        return $this->subscription($type)->plan;
    }

    /**
     * Get user plan
     *
     * @param  string $type
     * @return Plan
     */
    public function getLevelAttribute()
    {
        return Cache::remember("user:$this->id:level", 86400, function () {
            $subscription = $this->subscription('main');
            return $subscription ? $subscription->plan->index : 0;
        });
    }

    /**
     * Mutator for can_follow, return whether user can follow to another one
     *
     * @return boolean
     */
    public function getFollowedAttribute()
    {
        return (bool)(!Auth::user() ? false : $this->followers()->where([['user_id', '=', Auth::user()->id],
            ['follow_id', '=', $this->id],])->count());
    }

    public function recalculateCollections()
    {
        $this->count_collections = $this->collections->count();
    }

    public function recalculateFollowers()
    {
        $this->count_followers = $this->followers->count();
    }

    public function recalculateFollowing()
    {
        $this->count_following = $this->following->count();
    }

    public function recalculateItems()
    {
        $this->count_items = $this->items()->where('status', 2)->get()->count();
    }

    public function recalculateStories()
    {
        $this->count_story = $this->stories->count();
    }

    public function recalculateRatings()
    {
        $ratingItems = $this->items()->where('count_rating', '>', 0)->get();
        $avg = $ratingItems->avg('rating');
        $this->rating = $avg ? $avg : 0;

        $this->count_rating = $ratingItems->count();
    }

    public function recalculateNotifications()
    {
        $this->count_notifications = $this->unreadNotifications->count();
    }

    public function recalculateTotalSales()
    {
        $this->count_sales = $this->orderItems()
            ->where(function ($query) {
                $query->where('order_items.status', OrderItem::STATUS_PAID)
                    ->orWhere('order_items.stripe_status', OrderItem::STATUS_PAID);
            })
            ->count();
    }

    public function recalculate()
    {
        $this->recalculateCollections();
        $this->recalculateFollowers();
        $this->recalculateFollowing();
        $this->recalculateItems();
        $this->recalculateStories();
        $this->recalculateRatings();
        $this->recalculateNotifications();
        $this->recalculateTotalSales();
    }

    /**
     * Requests contains a list of affiliate sales
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function affiliateRequests()
    {
        return $this->hasMany(AffiliateRequest::class);
    }

    /**
     * Get all of the orders
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id')->orderBy('created_at', 'desc');
    }

    /**
     * Generate and returns activation token
     *
     * @return string
     */
    public function generateActivationToken()
    {
        $this->activated = false;
        $this->activation_token = \Illuminate\Support\Str::random(60);
        return $this->activation_token;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendActivationNotification($token)
    {
        $this->notify(new ActivationNotification($token));
    }

    public function getActivatedColumn()
    {
        return 'activated';
    }

    public function getOnlineAttribute()
    {
        $last = $this->last_visited_at;
        if ($last) {
            if (is_numeric($last)) {
                $last = Carbon::createFromTimestamp($last);
            }
            return $this->show_status && $last->diffInMinutes() < 5;
        }
        return false;
    }

    public function online()
    {
        $this->last_visited_at = Carbon::now();
        $this->save();
    }

}
