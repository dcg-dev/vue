<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\Model;
use App\Models\Item;
use App\Observers\CategoryObserver;

class Category extends Model
{

    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'enabled', 'index', 'procreator_id'
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
        'procreator_id' => 'int',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
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
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::observe(new CategoryObserver());
    }

    /**
     * Returns the parent category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function procreator()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Returns the child categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childs()
    {
        return $this->hasMany(Category::class, 'procreator_id')->orderBy('index');
    }

    /**
     * Returns list of items
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_categories', 'category_id', 'item_id');
    }

    /**
     * Increments to the page index
     *
     * @return \App\Models\Category
     */
    public function incrementIndex()
    {
        $index = 0;
        $last = self::where('procreator_id', $this->procreator_id)->orderBy('index', true)->first();
        if ($last) {
            $index = $last->index;
        }
        $this->index = $index + 1;
        return $this;
    }

    public function recalculate()
    {
        $index = 1;
        foreach ($this->childs as $category) {
            $category->index = $index;
            $category->save();
            $index++;
        }

    }

}
