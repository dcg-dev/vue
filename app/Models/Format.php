<?php

namespace App\Models;

use App\Observers\FormatObserver;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\Model;
use App\Models\Item;

class Format extends Model {

    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'enabled', 'index'
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
        'enabled' => 'bool',
        'index' => 'int',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
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
        static::observe(new FormatObserver());
    }

    /**
     * Returns list of items
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items() {
        return $this->belongsToMany(Item::class, 'item_formats', 'format_id', 'item_id');
    }

    /**
     * Increments to the page index
     *
     * @return \App\Models\License
     */
    public function incrementIndex() {
        $index = 0;
        $last = self::orderBy('index', true)->first();
        if ($last) {
            $index = $last->index;
        }
        $this->index = $index + 1;
        return $this;
    }

    /**
     * Fixed index
     */
    public function resetIndex() {
        self::where('index', '>', $this->index)->decrement('index');
    }

}
