<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use EloquentFilter\Filterable;
use App\Models\Model;
use App\Models\Story;
use App\Models\User;
use App\Models\StoryCommentLike;
use App\Observers\StoryCommentObserver;

class StoryComment extends Model {

    use Filterable;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blog_story_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message', 'likes', 'story_id', 'reply_id', 'sender_id'
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
        'message' => 'string',
        'likes' => 'integer',
        'story_id' => 'integer',
        'reply_id' => 'integer',
        'sender_id' => 'integer',
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
        static::observe(new StoryCommentObserver());
    }

    public function toArray() {
        $this->replies;
        $this->sender = $this->sender()->select(['id', 'firstname', 'lastname', 'username', 'avatar'])->first();
        $data = parent::toArray();
        $data['iLiked'] = (bool) (Auth::user()) ? $this->likes()->where('creator_id', Auth::user()->id)->count() : 0;
        return $data;
    }

    /**
     * Returns the sender
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender() {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the item
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function story() {
        return $this->belongsTo(Story::class);
    }

    /**
     * Returns list of replies
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies() {
        return $this->hasMany(StoryComment::class, 'reply_id')->orderBy('created_at');
    }

    /**
     * Returns list of likes
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes() {
        return $this->hasMany(StoryCommentLike::class, 'comment_id');
    }

    /**
     * Liked the comment
     * 
     * @return \App\Models\StoryCommentLike
     */
    public function like() {
        $liked = $this->likes()->where('creator_id', Auth::user()->id)->first();
        return $liked ? $liked->delete() : $this->likes()->create([
                    'creator_id' => Auth::user()->id
        ]);
    }
    public function recalculateLikes() {
        $this->likes = $this->likes()->count();
    }
    
    public function recalculate() {
        $this->recalculateLikes();
    }
    

}
