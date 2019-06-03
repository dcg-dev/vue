<?php

namespace App\Models;

use App\Models\Model;
use App\Models\SupportTicketPost;
use EloquentFilter\Filterable;
use Mews\Purifier\Facades\Purifier;

class SupportTicket extends Model {

    use Filterable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'support_tickets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'creator_id', 'subject', 'description', 'is_solved'
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
        'creator_id' => 'integer',
        'subject' => 'string',
        'description' => 'string',
        'is_solved' => 'boolean',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];
    
    public function toArray() {
        $data = parent::toArray();
        $data['countPosts'] = $this->count_posts;
        $data['lastPost'] = $this->last_post;
        return $data;
    }

    /**
     * Clean a description
     * 
     * @param  string  $value
     * @return void
     */
    public function setDescriptionAttribute($value) {
        $this->attributes['description'] = Purifier::clean($value);
    }
    
    /**
     * Count how much posts inside the ticket
     * 
     * @return integer
     */
    public function getCountPostsAttribute() {
        return $this->posts()->where('ticket_id', $this->id)->orderBy('created_at', 'desc')->count();
    }
    
    /**
     * Returns the last ticket post
     * 
     * @return self
     */
    public function getLastPostAttribute() {
        return $this->posts()->orderBy('created_at', 'desc')->first();
    }

    /**
     * Returns list of posts
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts() {
        return $this->hasMany(SupportTicketPost::class, 'ticket_id');
    }
    
    /**
     * Returns the creator of this ticket
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator() {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
