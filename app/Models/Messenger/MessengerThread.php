<?php

namespace App\Models\Messenger;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * Class MessengerThread
 * @package App\Models\Messenger
 *
 * @property int $id
 * @property string $subject
 * @property int $created_by
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 */
class MessengerThread extends Model {

    use SoftDeletes;

    /**
     * The attributes that can be set with mass assignment.
     *
     * @var array
     */
    protected $fillable = ['subject', 'created_by'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

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
     * Messages relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages() {
        return $this->hasMany(MessengerMessage::class, 'thread_id', 'id');
    }

    /**
     * Participants relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants() {
        return $this->hasMany(MessengerParticipant::class, 'thread_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        return $this->belongsToMany(
            User::class,
            (new MessengerParticipant())->getTable(),
            'thread_id',
            'user_id');
    }

    /**
     * Return count of the messages from inbox
     *
     * @param $userId
     * @return mixed
     */
    public function getInboxCount($userId) {
        return $this->getByUserWithLatestMessage($userId)->inbox($userId)->noRead()->get()->count();
    }

    /**
     * Returns the latest threads by user.
     *
     * @param $userId
     * @return mixed
     */
    public function getByUserWithLatestMessage($userId) {
        $participantsTable = (new MessengerParticipant())->getTable();
        $messagesTable = (new MessengerMessage())->getTable();
        $threadsTable = (new MessengerThread())->getTable();

        // TODO
        $query = $this->select(
                $threadsTable . '.id',
                $threadsTable . '.subject',
                DB::raw("count({$messagesTable}.id) as count"),
                DB::raw("(SELECT max(body) FROM {$messagesTable} WHERE thread_id = {$threadsTable}.id group by thread_id, updated_at order by updated_at desc limit 1) as message"),
                DB::raw("CASE WHEN min({$participantsTable}.last_read) IS NULL OR max({$threadsTable}.updated_at) > min({$participantsTable}.last_read) THEN 1 ELSE 0 END as no_read"),
                $threadsTable . '.updated_at'
            )
            ->join($messagesTable, $threadsTable . '.id', '=', $messagesTable . '.thread_id')
            ->join($participantsTable, $threadsTable . '.id', '=', $participantsTable . '.thread_id')
            ->where($participantsTable . '.user_id', $userId)
            ->groupBy($threadsTable . '.id')
            ->orderBy($threadsTable . '.updated_at', 'desc')
            ->with('users');

        return $query;
    }

    /**
     * Mark a thread as read for a user.
     *
     * @param int $userId
     */
    public function markAsRead($userId) {
        try {
            $participant = $this->getParticipantFromUser($userId);
            $participant->last_read = new Carbon();
            $participant->save();
        } catch (ModelNotFoundException $e) {
            //
        }
    }

    /**
     * Finds the participant record from a user id.
     *
     * @param $userId
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function getParticipantFromUser($userId) {
        return $this->participants()->where('user_id', $userId)->firstOrFail();
    }

    /**
     * Add users to thread as participants.
     *
     * @param array|mixed $userId
     */
    public function addParticipant($userId) {
        $userIds = is_array($userId) ? $userId : (array) func_get_args();

        collect($userIds)->each(function ($userId) {
            $this->participants()->firstOrCreate([
                'user_id' => $userId,
                'thread_id' => $this->id,
            ]);
        });
    }

    /**
     * @param $query
     * @param $userId
     * @return mixed
     */
    public function scopeInbox($query, $userId) {
        $participantsTable = (new MessengerParticipant())->getTable();
        $threadsTable = (new MessengerThread())->getTable();

        return $query->where(function($query) use ($userId, $participantsTable, $threadsTable) {
            $query->where($this->getTable() . '.created_by', '!=', $userId);
//                ->orWhere(DB::raw("(SELECT count({$participantsTable}.id) FROM {$participantsTable} WHERE {$participantsTable}.thread_id = {$threadsTable}.id)"), '>', 1);
            })
            ->whereNull((new MessengerParticipant())->getTable() . '.deleted_at')
            ->where($participantsTable . '.is_archive', false)
            ->where($participantsTable . '.is_star', false);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeTrashed($query) {
        return $query->whereNotNull((new MessengerParticipant())->getTable() . '.deleted_at');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeArchive($query) {
        $participantsTable = (new MessengerParticipant())->getTable();

        return $query->where($participantsTable . '.is_archive', true)
                     ->whereNull($participantsTable . '.deleted_at');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeStarred($query) {
        $participantsTable = (new MessengerParticipant())->getTable();

        return $query->where($participantsTable . '.is_star', true)
                     ->whereNull($participantsTable . '.deleted_at');
    }

    /**
     * @param $query
     * @param $userId
     * @return mixed
     */
    public function scopeSent($query, $userId) {
        $participantsTable = (new MessengerParticipant())->getTable();

        return $query->where($this->getTable() . '.created_by', $userId)
                     ->where($participantsTable . '.is_archive', false)
                     ->where($participantsTable . '.is_star', false)
                     ->whereNull($participantsTable . '.deleted_at');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNoRead($query) {
        $participantsTable = (new MessengerParticipant())->getTable();
        $threadsTable = (new MessengerThread())->getTable();
        $messageTable = (new MessengerMessage())->getTable();

        return $query->where(function ($query) use ($threadsTable, $participantsTable) {
            $query->whereNull($participantsTable . '.last_read')
                  ->orWhereRaw("{$threadsTable}.updated_at > {$participantsTable}.last_read");
        });
    }

    /**
     * Return the messages by thread for user.
     *
     * @param $threadId
     * @param $userId
     * @return string
     */
    public function getMessages($threadId, $userId) {
        return MessengerMessage::getMessagesByThread($threadId, $userId);
    }

    /**
     * Restores all participants within a thread that has a new message.
     */
    public function activateAllParticipants() {
        $participants = $this->participants()->withTrashed()->get();
        foreach ($participants as $participant) {
            $participant->restore();
        }
    }
}
