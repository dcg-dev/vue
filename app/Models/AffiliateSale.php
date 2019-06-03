<?php

namespace App\Models;

use EloquentFilter\Filterable;
use App\Models\Model;
use App\Models\OrderItem;
use App\Models\AffiliateRequest;

class AffiliateSale extends Model
{

    use Filterable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'affiliate_sales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'affiliable_id', 'affiliable_type', 'amount',
        'is_paid'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'affiliable_id' => 'integer',
        'affiliable_type' => 'string',
        'amount' => 'float',
        'is_paid' => 'boolean',
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


    protected function filters(Builder &$query)
    {
        $params = $this->request->all();
        if ($params) {
            foreach ($params as $key => $value) {
                if (method_exists($this, $key)) {
                    $this->{$key}($value, $query);
                }
            }
        }
    }

    /**
     * Returns the creator of this item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the owning commentable models.
     */
    public function affiliable()
    {
        return $this->morphTo();
    }

}
