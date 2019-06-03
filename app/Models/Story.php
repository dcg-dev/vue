<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\Model;
use App\Models\User;
use App\Models\StoryLike;
use App\Models\StoryComment;
use EloquentFilter\Filterable;
use App\Observers\StoryObserver;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Mews\Purifier\Facades\Purifier;

class Story extends Model
{

    use Sluggable,
        Filterable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'blog_stories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'creator_id', 'text', 'image',
        'approved', 'sub_title', 'count_likes'
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
        'title' => 'string',
        'sub_title' => 'string',
        'slug' => 'string',
        'creator_id' => 'int',
        'text' => 'string',
        'image' => 'string',
        'approved' => 'bool',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'count_likes' => 'int'
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
                'source' => 'title'
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
     * Get object as array
     *
     * @return array
     */
    public function toArray()
    {
        $data = parent::toArray();
        $data['creator'] = $this->creator;
        $data['is_liked'] = (bool)(Auth::user() ? $this->likes()->where('creator_id', Auth::user()->id)->count() : false);
        return $data;
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::observe(new StoryObserver());
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
     * Mutator for get image attribute
     *
     * @return string
     */
    public function getImageAttribute($value)
    {
        return $value ? Storage::disk('s3')->url("users/$this->creator_id/stories/$value") : asset('images/noimage.jpg');
    }

    /**
     * Mutator for directory
     *
     * @return string
     */
    public function getDirectoryAttribute()
    {
        $path = "users/$this->creator_id/stories";
        Storage::disk('s3')->makeDirectory($path, 0777, true);
        return $path;
    }

    /**
     * Create and save image
     * @param string $content
     * @return string
     */
    public function setImage($content)
    {
        $filename = $this->getFileName($content);
        return $this->imageCropAndSave($content, $filename);
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
     * Crops and save new image
     * @param type $content
     * @param type $filename
     * @return type
     */
    public function imageCropAndSave($content, $filename)
    {
        $fullpath = $this->getDirectoryAttribute() . "/$filename";
        $old = $this->getDirectoryAttribute(false) . "/" . $this->attributes['image'];
        if (Storage::disk('s3')->exists($old) && is_file($old)) {
            Storage::disk('s3')->delete($old);
        }
        $image = Image::make($content)->fit(1024, 768)->stream();
        if (Storage::disk('s3')->put($fullpath, $image->__toString())) {
            $this->image = $filename;
            return $filename;
        }
        return null;
    }

    /**
     * Returns list of likes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(StoryLike::class);
    }

    /**
     * Liked the story
     *
     * @return \App\Models\Like
     */
    public function like()
    {
        $liked = $this->likes()->where('creator_id', Auth::user()->id)->first();
        return $liked ? $liked->delete() : $this->likes()->create(['creator_id' => Auth::user()->id]);
    }

    /**
     * Clean story text
     *
     * @param  string $value
     * @return void
     */
    public function setTextAttribute($value)
    {
        $this->attributes['text'] = Purifier::clean($value);
    }

    /**
     * Returns list of formats
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(StoryComment::class, 'story_id')->whereNull('reply_id')->orderBy('created_at', 'desc');
    }

    public function recalculateLikes()
    {
        $this->count_likes = $this->likes()->count();
    }

    public function recalculateComments()
    {
        $this->count_comments = $this->comments()->count();
    }

    public function recalculate()
    {
        $this->recalculateLikes();
        $this->recalculateComments();
    }

}
