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
 * Class MessengerMessageRepository
 * @package App\Repositories\Messenger
 */
class MessengerMessageRepository extends Repository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model() {
        return MessengerMessage::class;
    }

    /**
     * Stores a new message.
     *
     * @param $data
     * @return mixed
     */
    public function store($data) {
        try {
            $thread = MessengerThread::findOrFail($data['thread']);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('The thread with ID: ' . $data['thread'] . ' was not found.');
        }

        $currentUserId = Auth::user()->id;

        $thread->activateAllParticipants();

        // Message
        MessengerMessage::create([
            'thread_id' => $thread->id,
            'user_id'   => $currentUserId,
            'body'      => $data['message'],
        ]);

        // Add replier as a participant
        $participant = MessengerParticipant::firstOrCreate([
            'thread_id' => $thread->id,
            'user_id'   => $currentUserId,
        ]);

        $participant->last_read = new Carbon();
        $participant->save();

        // Recipients
        if (array_has($data, 'recipients')) {
            $thread->addParticipant(Input::get('recipients'));
        }
    }
}