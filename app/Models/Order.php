<?php

namespace App\Models;

use EloquentFilter\Filterable;
use App\Models\Model;
use App\Models\OrderItem;
use App\Models\OrderStory;
use App\Models\User;
use Ramsey\Uuid\Uuid;

class Order extends Model {
    
    use Filterable;

    const STATUS_PAID = 'paid';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 'amount', 'stripe_customer_id',
        'payment_type', 'order_status', 'stripe_charge_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
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
    }
    
    /**
     * Returns list of order items
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items() {
        return $this->hasMany(OrderItem::class, 'order_id')->orderBy('created_at');
    }
    
    /**
     * Returns an order
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function story() {
        return $this->hasOne(OrderStory::class, 'order_id');
    }
    
    /**
     * Returns a customer
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer() {
        return $this->belongsTo(User::class, 'customer_id');
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
