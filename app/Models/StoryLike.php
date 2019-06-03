<?php

namespace App\Models;

use App\Observers\StoryLikeObserver;
use App\Models\Model;
use App\Models\Story;
use App\Models\User;

class StoryLike extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blog_story_likes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'story_id', 'creator_id'
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
        'comment_id' => 'integer',
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
        static::observe(new StoryLikeObserver());
    }

    /**
     * Returns list of users
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the comment
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function story() {
        return $this->belongsTo(Story::class);
    }

}
