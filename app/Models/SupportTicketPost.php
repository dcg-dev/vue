<?php

namespace App\Models;

use App\Models\User;
use App\Models\SupportTicket;
use EloquentFilter\Filterable;
use Mews\Purifier\Facades\Purifier;

class SupportTicketPost extends Model {

    use Filterable;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'support_ticket_posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'ticket_id', 'text'
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
        'user_id' => 'integer',
        'ticket_id' => 'integer',
        'text' => 'string',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];
    
    public function toArray() {
        $data = parent::toArray();
        $data['user'] = $this->user;
        return $data;
    }
    
    /**
     * Clean a text
     * 
     * @param  string  $value
     * @return void
     */
    public function setTextAttribute($value) {
        $this->attributes['text'] = Purifier::clean($value);
    }

    /**
     * Returns user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    /**
     * Returns support ticket
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket() {
        return $this->belongsTo(SupportTicket::class, 'ticket_id', 'id');
    }

}
