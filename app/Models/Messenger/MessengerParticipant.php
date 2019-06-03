<?php

namespace App\Models\Messenger;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MessengerParticipant
 * @package App\Models\Messenger
 *
 * @property int $id
 * @property int $thread_id
 * @property int $user_id
 * @property boolean $is_archive
 * @property boolean $is_star
 * @property boolean $is_draft
 * @property int $last_read
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 */
class MessengerParticipant extends Model {

    use SoftDeletes;

    /**
     * The attributes that can be set with mass assignment.
     *
     * @var array
     */
    protected $fillable = ['thread_id', 'user_id', 'last_read'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'last_read'];

    /**
     * Thread relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread() {
        return $this->belongsTo(MessengerThread::class, 'thread_id', 'id');
    }
    /**
     * User relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
