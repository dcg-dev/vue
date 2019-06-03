<?php

namespace App\Models;

use EloquentFilter\Filterable;
use App\Models\Model;
use App\Models\Order;

class OrderStory extends Model {
    
    use Filterable;

    const STATUS_PAID = 'paid';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_stories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'stripe_charge_id', 'price',
        'stripe_status', 'is_available'
    ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'order_id' => 'integer',
        'stripe_charge_id' => 'string',
        'stripe_status' => 'string',
        'is_available' => 'boolean',
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
     * Returns an order
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function order() {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    /**
     * Return status paid.
     *
     * @return string
     */
    public function getStatusPaid() {
        return self::STATUS_PAID;
    }
}
