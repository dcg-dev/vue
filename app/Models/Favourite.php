<?php

namespace App\Models;

use EloquentFilter\Filterable;
use App\Models\Model;
use App\Models\Item;
use App\Models\User;
use App\Observers\FavouriteObserver;

class Favourite extends Model {

    use Filterable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'item_favourites';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_id', 'creator_id'
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
        'item_id' => 'integer',
        'creator_id' => 'integer',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot() {
        parent::boot();
        static::observe(new FavouriteObserver());
    }

    public function toArray() {
        $this->creator = $this->creator()->select(['id', 'firstname', 'lastname', 'username', 'avatar'])->first();
        $data = parent::toArray();
        return $data;
    }

    /**
     * Returns the creator
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator() {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the item
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item() {
        return $this->belongsTo(Item::class);
    }

}
