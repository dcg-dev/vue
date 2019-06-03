<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Auth;
use Mews\Purifier\Facades\Purifier;
use EloquentFilter\Filterable;
use App\Models\Model;
use App\Models\User;
use App\Observers\CollectionObserver;

class Collection extends Model {

    use Sluggable,
        Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'creator_id', 'description',
        'private', 'count_items', 'count_followers'
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
        'slug' => 'string',
        'description' => 'string',
        'private' => 'bool',
        'count_items' => 'int',
        'count_followers' => 'int',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable() {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function toArray() {
        $data = parent::toArray();
        $data['image'] = $this->image;
        $data['iFollow'] = (bool) (Auth::user()) ? $this->followers()->where('user_id', Auth::user()->id)->count() : 0;
        return $data;
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName() {
        return 'slug';
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot() {
        parent::boot();
        static::observe(new CollectionObserver());
    }

    /**
     * Returns the creator of this item
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator() {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns list of tags
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items() {
        return $this->belongsToMany(Item::class, 'collection_items', 'collection_id', 'item_id');
    }

    /**
     * This function allows us to get a list of users following us
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers() {
        return $this->belongsToMany(User::class, 'collection_followers', 'collection_id', 'user_id');
    }

    /**
     * Set the clean item description
     * 
     * @param  string  $value
     * @return void
     */
    public function setDescriptionAttribute($value) {
        $this->attributes['description'] = Purifier::clean($value);
    }

    /**
     * Mutator for get avatar attribute
     * 
     * @return string
     */
    public function getImageAttribute() {
        $image = $this->items()->select(['image', 'creator_id'])->orderBy('items.created_at', 'asc')->first();
        return $image ? $image->image : asset('images/noimage.jpg');
    }
    
    public function recalculateItems() {
        $this->count_items = $this->items()->where('status', 2)->count();
    }
    public function recalculateFollowers() {
        $this->count_followers = $this->followers()->count();
    }

    public function recalculate() {
        $this->recalculateItems();
        $this->recalculateFollowers();
    }

}
