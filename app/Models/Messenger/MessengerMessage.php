<?php

namespace App\Models\Messenger;

use App\Models\User;
use App\Observers\MessengerMessageObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * Class MessengerMessage
 * @package App\Models\Messenger
 *
 * @property int $id
 * @property int $thread_id
 * @property int $user_id
 * @property string $body
 * @property boolean $is_read
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 */
class MessengerMessage extends Model {

    use SoftDeletes;

    /**
     * The attributes that can be set with mass assignment.
     *
     * @var array
     */
    protected $fillable = ['thread_id', 'user_id', 'body', 'is_read'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The relationships that should be touched on save.
     *
     * @var array
     */
    protected $touches = ['thread'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
    ];
    
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot() {
        parent::boot();
        static::observe(new MessengerMessageObserver());
    }

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

    /**
     * Return the messages by thread.
     *
     * @param $threadId
     * @param $userId
     */
    public static function getMessagesByThread($threadId, $userId) {
        $messagesTable = (new self)->getTable();
        $usersTable = (new User())->getTable();

        $query = self::select(
                $messagesTable . '.body',
                $messagesTable . '.updated_at',
                DB::raw("CASE WHEN {$usersTable}.firstname IS NOT NULL THEN {$usersTable}.firstname || ' ' || {$usersTable}.lastname ELSE {$usersTable}.username END AS user")
            )
            ->leftJoin($usersTable, (new User())->getQualifiedKeyName(), '=', $messagesTable . '.user_id')
            ->where($messagesTable . '.thread_id', $threadId)
            ->orderBy($messagesTable . '.updated_at');

        return $query;
    }
}
