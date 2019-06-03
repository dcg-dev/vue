<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Mews\Purifier\Facades\Purifier;
use EloquentFilter\Filterable;
use App\Observers\ItemObserver;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class Item extends Model
{

    use Sluggable,
        Filterable,
        SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'creator_id', 'description',
        'image', 'demo', 'file', 'price', 'loopable',
        'includes_stems', 'rating', 'status', 'count_sales',
        'count_rating', 'total_sales', 'decline_reason',
        'count_comments', 'featured', 'need_follow', 'approved_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'approved_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'slug' => 'string',
        'description' => 'string',
        'decline_reason' => 'string',
        'image' => 'string',
        'demo' => 'string',
        'file' => 'string',
        'creator_id' => 'int',
        'count_sales' => 'int',
        'count_rating' => 'int',
        'count_comments' => 'int',
        'price' => 'float',
        'rating' => 'float',
        'total_sales' => 'float',
        'loopable' => 'bool',
        'featured' => 'bool',
        'includes_stems' => 'bool',
        'need_follow' => 'bool',
        'status' => 'integer',
        'approved_at' => 'timestamp',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $appends = [
        'files'
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

    public function toArray()
    {
        $data = parent::toArray();
        $data['categoriesIds'] = $this->categories()->pluck('categories.id')->all();
        $data['tagsIds'] = $this->tags()->pluck('tags.name')->all();
        $data['formatsIds'] = $this->formats()->pluck('formats.id')->all();
        $data['licensesIds'] = $this->licenses()->pluck('licenses.id')->all();
        $data['hasImage'] = $this->hasImage;
        $data['filesize'] = 0;
        $data['isFavourite'] = (bool)(Auth::user()) ? $this->favourites()->where('creator_id', Auth::user()->id)->count() : 0;
        if ($this->file) {
            $data['filesize'] = Storage::disk('s3')->size($this->getProductPath());
        }
        $data['inCart'] = Cart::get($this->id) ? true : false;
        return $data;
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
        static::observe(new ItemObserver());
    }

    /**
     * Returns the creator of this item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns list of tags
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'item_tags', 'item_id', 'tag_id')->where('enabled', true);
    }

    /**
     * Returns list of categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'item_categories', 'item_id', 'category_id')->where('enabled', true);
    }

    /**
     * Returns list of formats
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function formats()
    {
        return $this->belongsToMany(Format::class, 'item_formats', 'item_id', 'format_id')->where('enabled', true);
    }

    /**
     * Returns list of formats
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->allComments()->whereNull('reply_id');
    }

    /**
     * Returns list of formats
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allComments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Returns list of ratings
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Returns list of tags
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favourites()
    {
        return $this->hasMany(Favourite::class)->with('creator');
    }

    /**
     * Returns of order items
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function order_items()
    {
        return $this->hasMany(OrderItem::class, 'item_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function promo()
    {
        return $this->belongsToMany(PromoSubscription::class, (new PromoSubscriptionItem())->getTable(), 'item_id', 'subscription_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function active_promo()
    {
        return $this->promo()->where('ends_at', '>', DB::raw('NOW()'));
    }

    public function favourite()
    {
        $inFavourite = $this->favourites()->where('creator_id', Auth::user()->id)->first();
        return $inFavourite ? $inFavourite->delete() : $this->favourites()->create([
            'creator_id' => Auth::user()->id
        ]);
    }

    /**
     * Returns list of licenses
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function licenses()
    {
        return $this->belongsToMany(License::class, 'item_licenses', 'item_id', 'license_id')->orderBy('index')->where('enabled', true);
    }

    /**
     * Set the clean item description
     *
     * @param  string $value
     * @return void
     */
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = Purifier::clean($value);
    }

    /**
     * Sync the intermediate tables with a list of IDs or collection of categories.
     *
     * @param  \Illuminate\Database\Eloquent\Collection|array $ids
     * @param array
     */
    public function syncCategories($ids = [])
    {
        if ($ids instanceof \Illuminate\Database\Eloquent\Collection) {
            $ids = $ids->pluck('id')->toArray();
        }
        return $this->categories()->sync($ids);
    }

    /**
     * Sync the intermediate tables with a list of IDs or collection of item formats.
     *
     * @param  \Illuminate\Database\Eloquent\Collection|array $ids
     * @param array
     */
    public function syncFormats($ids = [])
    {
        if ($ids instanceof \Illuminate\Database\Eloquent\Collection) {
            $ids = $ids->pluck('id')->toArray();
        }
        return $this->formats()->sync($ids);
    }

    /**
     * Sync the intermediate tables with a list of IDs or collection of item licenses.
     *
     * @param  \Illuminate\Database\Eloquent\Collection|array $ids
     * @param array
     */
    public function syncLicenses($ids = [])
    {
        if ($ids instanceof \Illuminate\Database\Eloquent\Collection) {
            $ids = $ids->pluck('id')->toArray();
        }
        return $this->licenses()->sync($ids);
    }

    /**
     * Sync the intermediate tables with a list of IDs or collection of tags.
     *
     * @param  \Illuminate\Database\Eloquent\Collection|array $tags
     * @param array
     */
    public function syncTags($tags = [])
    {
        $ids = [];
        if ($tags instanceof \Illuminate\Database\Eloquent\Collection) {
            $ids = $tags->pluck('id')->toArray();
        } else {
            if (count($tags)) {
                foreach ($tags as $name) {
                    $ids[] = Tag::where('name', 'ilike', $name)->firstOrCreate(['name' => $name])->id;
                }
            }
        }
        $this->tags()->sync($ids);
    }

    /**
     * Mutator for get avatar attribute
     *
     * @return string
     */
    public function getImageAttribute($value)
    {
        return $value ? Storage::disk('s3')->url("users/$this->creator_id/items/$value") : asset('images/noimage.jpg');
    }

    /**
     * Mutator for has avatar
     *
     * @return string
     */
    public function getHasImageAttribute()
    {
        return (bool)array_get($this->attributes, 'image', false);
    }

    /**
     * Mutator for get demo url
     *
     * @return string
     */
    public function getDemoAttribute($value)
    {
        return array_get($this->attributes, 'demo') ? route('item.download.demo', ['item' => $this->slug]) : null;
    }

    /**
     * Mutator for get product file url
     *
     * @return string
     */
    public function getFileAttribute($value)
    {
        return array_get($this->attributes, 'file') ? route('item.download.product', ['item' => $this->slug]) : null;
    }

    /**
     * Mutator for get product file
     *
     * @return string
     */
    public function getFileNameAttribute()
    {
        return $this->file;
    }

    /**
     * Mutator for get product demo
     *
     * @return string
     */
    public function getDemoNameAttribute()
    {
        return $this->demo;
    }

    /**
     * Returns demo file path
     *
     * @return string
     */
    public function getDemoPath()
    {
        return array_get($this->attributes, 'demo') ? $this->getDirectoryAttribute() . "/" . array_get($this->attributes, 'demo') : false;
    }

    /**
     * Returns demo file path
     *
     * @return string
     */
    public function getProductPath()
    {
        return array_get($this->attributes, 'file') ? $this->getDirectoryAttribute() . "/" . array_get($this->attributes, 'file') : false;
    }

    /**
     * Mutator for directory
     *
     * @return string
     */
    public function getDirectoryAttribute()
    {
        $path = "users/$this->creator_id/items";
        Storage::disk('s3')->makeDirectory($path, 0777, true);
        return $path;
    }

    /**
     * Create and save new avatar from base64 string
     * @param string $content
     * @return string
     */
    public function setThumbnail($content)
    {
        $filename = $this->getFileName($content);
        return $this->avatarCropAndSave($content, $filename);
    }

    /**
     * Create and save file
     * @param string $content
     * @return string|bool
     */
    public function setFile($content, $attribute)
    {
        $extension = pathinfo($content->getClientOriginalName())['extension'];
        $rand = str_random(8);
        $filename = "$this->id-$rand.$extension";
        $old = $this->getDirectoryAttribute(false) . "/" . $this->attributes[$attribute];
        if (Storage::disk('s3')->exists($old) && is_file($old)) {
            Storage::disk('s3')->delete($old);
        }
        if (Storage::disk('s3')->putFileAs($this->getDirectoryAttribute(false), $content, $filename)) {
            $this->{$attribute} = $filename;
            return $filename;
        }
        return false;
    }

    /**
     * Return file name based on content
     * @param string $content
     * @return string
     */
    public function getFileName($content)
    {
        $extension = array_get([
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
        ], image_type_to_mime_type(exif_imagetype($content)), 'jpg');
        $rand = str_random(8);
        return "$this->id-$rand.$extension";
    }

    /**
     * Crops and save new avatar
     * @param type $content
     * @param type $filename
     * @return type
     */
    public function avatarCropAndSave($content, $filename)
    {
        $fullpath = $this->getDirectoryAttribute() . "/$filename";
        $old = $this->getDirectoryAttribute(false) . "/" . $this->attributes['image'];
        if (Storage::disk('s3')->exists($old) && is_file($old)) {
            Storage::disk('s3')->delete($old);
        }
        $image = Image::make($content)->fit(1000, 750)->stream();
        if (Storage::disk('s3')->put($fullpath, $image->__toString())) {
            $this->image = $filename;
            return $filename;
        }
        return null;
    }

    public function recalculateRatings()
    {
        $this->count_rating = $this->ratings()->count();
        $avg = $this->ratings()->avg('rating');
        $this->rating = $avg ? $avg : 0;
    }

    public function recalculateComments()
    {
        $this->count_comments = $this->allComments()->count();
    }

    public function recalculateTotalSales()
    {
        $this->total_sales = $this->order_items()->where('status', OrderItem::STATUS_PAID)->get()->pluck('price')->sum();
    }

    public function recalculate()
    {
        $this->recalculateRatings();
        $this->recalculateComments();
        $this->recalculateTotalSales();
    }

    public function deleteAllFiles()
    {
        $path = $this->getDirectoryAttribute(false) . '/';
        $image = $path . $this->attributes['image'];
        $demo = $path . $this->attributes['demo'];
        $file = $path . $this->attributes['file'];
        if (Storage::disk('s3')->exists($image) && is_file($image)) {
            Storage::disk('s3')->delete($image);
        }
        if (Storage::disk('s3')->exists($demo) && is_file($demo)) {
            Storage::disk('s3')->delete($demo);
        }
        if (Storage::disk('s3')->exists($file) && is_file($file)) {
            Storage::disk('s3')->delete($file);
        }
    }

    public function setFeaturedAttribute($value)
    {
        $this->attributes['featured'] = (bool)$value;
    }

    public function getFilesAttribute()
    {
        $attributes = collect($this->attributes);
        return [
            'image' => $attributes->get('image'),
            'demo' => $attributes->get('demo'),
            'file' => $attributes->get('file'),
        ];
    }
}
