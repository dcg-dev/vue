<?php

namespace App\Models;

use App\Observers\PlanObserver;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\Model;
use EloquentFilter\Filterable;

class Plan extends Model
{

    use Sluggable,
        Filterable;

    /**
     * @var integer
     */
    const MAX_NUMBER_PLANS = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'stripe_id', 'products', 'index', 'commission',
        'price', 'paypal', 'card', 'social_accounts', 'builder',
        'notifications', 'support', 'badge', 'enabled'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'stripe_id' => 'string',
        'products' => 'int',
        'index' => 'int',
        'commission' => 'float',
        'price' => 'float',
        'paypal' => 'bool',
        'card' => 'bool',
        'social_accounts' => 'bool',
        'builder' => 'bool',
        'notifications' => 'bool',
        'support' => 'bool',
        'enabled' => 'bool',
        'badge' => 'string',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'stripe_id' => [
                'source' => 'name'
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
        return 'stripe_id';
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::observe(new PlanObserver());
    }

    public function subscriptions()
    {
        return $this
            ->hasMany(Subscription::class, 'stripe_plan', 'stripe_id')
            ->where(function ($query) {
                $query->where('ends_at', '>=', Carbon::now())
                    ->orWhereNull('ends_at');
            })
            ->groupBy('user_id');
    }

    /**
     * Increments to the page index
     *
     * @return \App\Models\Category
     */
    public function incrementIndex()
    {
        $index = 0;
        $last = self::orderBy('index', true)->first();
        if ($last) {
            $index = $last->index;
        }
        $this->index = $index + 1;
        return $this;
    }

    /**
     * Return free plan
     *
     * @return Plan
     */
    public static function getFree()
    {
        return self::where('price', 0)->orWhere('price', null)->orderBy('index')->first();
    }

    /**
     * Return free plan
     *
     * @return boolean
     */
    public function isMaxPrice()
    {
        return self::orderBy('price', 'desc')->first()->stripe_id === $this->stripe_id;
    }

    /**
     * @return mixed
     */
    public static function getCount()
    {
        return self::where('enabled', true)->get()->count();
    }

    /**
     * @return bool
     */
    public static function canCreate()
    {
        return self::getCount() < self::MAX_NUMBER_PLANS;
    }

}
