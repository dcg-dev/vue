<?php

namespace App\Models;

use Carbon\Carbon;
use EloquentFilter\Filterable;
use Illuminate\Support\Facades\DB;

class PromoSubscription extends Model {

    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'plan_id', 'ends_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['ends_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'plan_id' => 'integer',
        'ends_at' => 'timestamp',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items() {
        return $this->belongsToMany(Item::class, (new PromoSubscriptionItem())->getTable(), 'subscription_id', 'item_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function plan() {
        return $this->hasOne(PromoPlan::class, 'id', 'plan_id');
    }

    /**
     * Returns a customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer() {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @param $itemId
     * @return mixed
     */
    public static function checkItem($itemId) {
        return self::with('items')
            ->whereHas('items', function ($query) use ($itemId) {
                $query->where('id', $itemId);
            })
            ->where('ends_at', '>', DB::raw('NOW()'))
            ->first();
    }
}
