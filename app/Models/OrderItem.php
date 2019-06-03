<?php

namespace App\Models;

use EloquentFilter\Filterable;
use App\Models\Model;
use App\Models\Order;
use App\Models\Item;
use App\Observers\OrderItemObserver;

class OrderItem extends Model
{

    use Filterable;

    const STATUS_PAID = 'paid';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'item_id', 'license_id', 'stripe_charge_id',
        'price', 'stripe_status', 'status', 'commission_amount',
        'country', 'vat'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'order_id' => 'integer',
        'item_id' => 'integer',
        'license_id' => 'integer',
        'stripe_charge_id' => 'string',
        'country' => 'string',
        'stripe_status' => 'string',
        'status' => 'string',
        'commission_amount' => 'float',
        'vat' => 'float',
        'deleted_at' => 'timestamp',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::observe(new OrderItemObserver());
    }

    /**
     * Returns an order
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    /**
     * Returns an item
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Returns a license
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function license()
    {
        return $this->hasOne(License::class, 'id', 'license_id');
    }

    /**
     * Return status paid.
     *
     * @return string
     */
    public function getStatusPaid()
    {
        return self::STATUS_PAID;
    }

    public function toArray()
    {
        $this->load('item');
        return parent::toArray();
    }
}
