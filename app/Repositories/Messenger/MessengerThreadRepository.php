<?php

namespace App\Repositories\Messenger;

use App\Models\Messenger\MessengerMessage;
use App\Models\Messenger\MessengerParticipant;
use App\Models\Messenger\MessengerThread;
use App\Repositories\Repository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

/**
 * Class InboxThreadRepository
 * @package App\Repositories\Messenger
 */
class MessengerThreadRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return MessengerThread::class;
    }

    /**
     * Show inbox of the message threads to the user.
     *
     * @return mixed
     */
    public function getInbox()
    {
        return $this->model->getByUserWithLatestMessage(Auth::user()->id)->inbox(Auth::user()->id);
    }

    /**
     * Show trashed the message threads to the user.
     *
     * @return mixed
     */
    public function getTrashed()
    {
        return $this->model->getByUserWithLatestMessage(Auth::user()->id)->trashed();
    }

    /**
     * Show trashed the message threads to the user.
     *
     * @return mixed
     */
    public function getSent()
    {
        return $this->model->getByUserWithLatestMessage(Auth::user()->id)->sent(Auth::user()->id);
    }

    /**
     * Show starred the message threads to the user.
     *
     * @return mixed
     */
    public function getStarred()
    {
        return $this->model->getByUserWithLatestMessage(Auth::user()->id)->starred();
    }

    /**
     * Show starred the message threads to the user.
     *
     * @return mixed
     */
    public function getArchive()
    {
        return $this->model->getByUserWithLatestMessage(Auth::user()->id)->archive();
    }

    /**
     * Show the messages
     *
     * @param $id
     * @return mixed
     */
    public function getMessagesByThread($id)
    {
        try {
            $thread = $this->model->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('The thread with ID: ' . $id . ' was not found.');
        }

        $currentUserId = Auth::user()->id;

        $thread->markAsRead($currentUserId);

        return $this->model->getMessages($id, Auth::user()->id)->get();
    }

    /**
     * Shows a message thread.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        try {
            $thread = $this->model->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('The thread with ID: ' . $id . ' was not found.');
        }

        $currentUserId = Auth::user()->id;

        $thread->markAsRead($currentUserId);

        return $thread;
    }

    /**
     * Stores a new message thread.
     *
     * @param $data
     * @return mixed
     */
    public function store($data)
    {
        $currentUserId = Auth::user()->id;

        $thread = MessengerThread::create([
            'subject' => $data['subject'],
            'created_by' => $currentUserId
        ]);

        // Sender
        MessengerParticipant::create([
            'thread_id' => $thread->id,
            'user_id' => $currentUserId,
            'last_read' => new Carbon(),
        ]);

        // Recipients
        if (isset($data['recipients'])) {
            $thread->addParticipant($data['recipients']);
        }

        // Message
        MessengerMessage::create([
            'thread_id' => $thread->id,
            'user_id' => $currentUserId,
            'body' => $data['message'],
        ]);


    }

    /**
     * Destroy participants by thread ids.
     *
     * @param $ids
     * @return mixed
     */
    public function destroy($ids)
    {
        $participantIds = MessengerParticipant::query()
            ->whereIn('thread_id', $ids)
            ->where('user_id', Auth::user()->id)
            ->pluck('id');

        return MessengerParticipant::destroy($participantIds);
    }

    /**
     * Force delete threads by ids.
     *
     * @param $ids
     * @return mixed
     */
    public function forceDelete($ids)
    {
        return MessengerParticipant::query()
            ->whereIn('thread_id', $ids)
            ->where('user_id', Auth::user()->id)
            ->forceDelete();
    }

    /**
     * Restore participants by thread ids.
     *
     * @param $ids
     * @return mixed
     */
    public function restore($ids)
    {
        return MessengerParticipant::query()
            ->whereIn('thread_id', $ids)
            ->where('user_id', Auth::user()->id)
            ->restore();
    }

    /**
     * Bulk set(unset) archive.
     *
     * @param $ids
     * @param boolean $value
     * @return mixed
     */
    public function bulkArchive($ids, $value)
    {
        MessengerParticipant::query()
            ->whereIn('thread_id', $ids)
            ->where('user_id', Auth::user()->id)
            ->update(['is_archive' => $value]);
    }

    /**
     * Bulk set(unset) star.
     *
     * @param $ids
     * @param boolean $value
     * @return mixed
     */
    public function bulkStar($ids, $value)
    {
        MessengerParticipant::query()
            ->whereIn('thread_id', $ids)
            ->where('user_id', Auth::user()->id)
            ->update(['is_star' => $value]);
    }

    /**
     * @return array
     */
    public function getCounters()
    {
        return [
            'inbox' => $this->getInbox()->noRead()->get()->count(),
            'sent' => $this->getSent()->noRead()->get()->count(),
            'starred' => $this->getStarred()->noRead()->get()->count(),
            'archive' => $this->getArchive()->noRead()->get()->count(),
            'draft' => 0,
            'trash' => $this->getTrashed()->noRead()->get()->count(),
        ];
    }
}