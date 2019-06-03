<?php

namespace App\Models;

use EloquentFilter\Filterable;

class PromoPlan extends Model {

    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'item_number', 'duration', 'duration_type', 'enabled'
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
        'price' => 'float',
        'item_number' => 'integer',
        'duration' => 'integer',
        'duration_type' => 'string',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'item_number' => 1
    ];
}
