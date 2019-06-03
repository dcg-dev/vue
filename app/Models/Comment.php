<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use EloquentFilter\Filterable;
use App\Models\Model;
use App\Models\Item;
use App\Models\User;
use App\Models\Like;
use App\Observers\CommentObserver;

class Comment extends Model {

    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message', 'likes', 'item_id', 'reply_id', 'sender_id'
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
        'item_id' => 'integer',
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
        static::observe(new CommentObserver());
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
    public function item() {
        return $this->belongsTo(Item::class);
    }

    /**
     * Returns list of replies
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies() {
        return $this->hasMany(Comment::class, 'reply_id')->orderBy('created_at');
    }

    /**
     * Returns list of likes
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes() {
        return $this->hasMany(Like::class);
    }

    /**
     * Liked the comment
     * 
     * @return \App\Models\Like
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
