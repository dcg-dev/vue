<?php

namespace App\Models;

use EloquentFilter\Filterable;
use App\Models\Model;
use App\Models\User;
use App\Models\AffiliateSale;

class AffiliateRequest extends Model {
    
    use Filterable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'affiliate_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'order_item_id', 'amount',
        'is_paid', 'closed_at', 'message'
    ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'is_paid' => 'boolean',
        'deleted_at' => 'timestamp',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'closed_at' => 'timestamp',
        'message' => 'string'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'closed_at'];
    
    /**
     * Requests contains a list of affiliate sales
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function affiliate_sales() {
        return $this->hasMany(AffiliateSale::class, 'request_id');
    }
    
    /**
     * Returns the creator of this item
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
    
}
