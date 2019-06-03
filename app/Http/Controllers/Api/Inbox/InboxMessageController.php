<?php

namespace App\Http\Controllers\Api\Inbox;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessengerMessageCreate;
use App\Repositories\Messenger\MessengerMessageRepository;

/**
 * Class InboxMessageController
 * @package App\Http\Controllers\Api\Inbox
 */
class InboxMessageController extends Controller {

    /**
     * @var \App\Repositories\Messenger\MessengerMessageRepository
     */
    protected $message;

    /**
     * InboxMessageController constructor.
     * @param \App\Repositories\Messenger\MessengerMessageRepository $message
     */
    public function __construct(MessengerMessageRepository $message) {
        $this->message = $message;
    }

    /**
     * Stores a new message.
     *
     * @param \App\Http\Requests\MessengerMessageCreate $request
     * @return mixed
     */
    public function store(MessengerMessageCreate $request) {
        return $this->message->store($request->all());
    }
}
