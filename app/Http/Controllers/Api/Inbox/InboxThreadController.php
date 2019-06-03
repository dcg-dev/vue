<?php

namespace App\Http\Controllers\Api\Inbox;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessengerThreadBulkArchive;
use App\Http\Requests\MessengerThreadBulkDestroy;
use App\Http\Requests\MessengerThreadBulkRestore;
use App\Http\Requests\MessengerThreadBulkStar;
use App\Http\Requests\MessengerThreadCreate;
use App\Repositories\Messenger\MessengerThreadRepository;

/**
 * Class InboxThreadController
 * @package App\Http\Controllers\Api\Inbox
 */
class InboxThreadController extends Controller {

    /**
     * @var \App\Repositories\Messenger\MessengerThreadRepository
     */
    protected $thread;

    /**
     * InboxThreadController constructor.
     * @param \App\Repositories\Messenger\MessengerThreadRepository $thread
     */
    public function __construct(MessengerThreadRepository $thread) {
        $this->thread = $thread;
    }

    /**
     * Show all of the message threads to the user.
     *
     * @return mixed
     */
    public function index() {
        return $this->thread->getInbox()->paginate();
    }


    /**
     * Show sent of the message threads to the user.
     *
     * @return mixed
     */
    public function sent() {
        return $this->thread->getSent()->paginate();
    }

    /**
     * Shows a message thread.
     *
     * @param $id
     * @return mixed
     */
    public function messages($id) {
        return $this->thread->getMessagesByThread($id);
    }

    /**
     * Shows a message thread.
     *
     * @param $id
     * @return mixed
     */
    public function show($id) {
        return $this->thread->show($id);
    }

    /**
     * Stores a new message thread.
     *
     * @param \App\Http\Requests\MessengerThreadCreate $request
     * @return mixed
     */
    public function store(MessengerThreadCreate $request) {
        return $this->thread->store($request->all());
    }

    /**
     * Destroy thread.
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        return $this->thread->destroy($id);
    }

    /**
     * Bulk destroy threads.
     *
     * @param \App\Http\Requests\MessengerThreadBulkDestroy $request
     * @return mixed
     */
    public function bulkDestroy(MessengerThreadBulkDestroy $request) {
        return $this->thread->destroy($request->get('ids'));
    }

    /**
     * Bulk restore threads.
     *
     * @param \App\Http\Requests\MessengerThreadBulkRestore $request
     * @return mixed
     */
    public function bulkRestore(MessengerThreadBulkRestore $request) {
        return $this->thread->restore($request->get('ids'));
    }

    /**
     * Show archive of the message threads to the user.
     *
     * @return mixed
     */
    public function archive() {
        return $this->thread->getArchive()->paginate();
    }

    /**
     * Bulk set(unset) archive.
     *
     * @param \App\Http\Requests\MessengerThreadBulkArchive $request
     * @return mixed
     */
    public function bulkArchive(MessengerThreadBulkArchive $request) {
        return $this->thread->bulkArchive($request->get('ids'), $request->get('value'));
    }

    /**
     * Show starred of the message threads to the user.
     *
     * @return mixed
     */
    public function starred() {
        return $this->thread->getStarred()->paginate();
    }

    /**
     * Bulk set(unset) star.
     *
     * @param \App\Http\Requests\MessengerThreadBulkStar $request
     * @return mixed
     */
    public function bulkStar(MessengerThreadBulkStar $request) {
        return $this->thread->bulkStar($request->get('ids'), $request->get('value'));
    }

    /**
     * Destroy thread.
     *
     * @param \App\Http\Requests\MessengerThreadBulkDestroy $request
     * @return mixed
     */
    public function forceDelete(MessengerThreadBulkDestroy $request) {
        return $this->thread->forceDelete($request->get('ids'));
    }

    /**
     * Get the list of deleted threads.
     *
     * @return mixed
     */
    public function deleted() {
        return $this->thread->getTrashed()->paginate();
    }

    /**
     * Get the counters by category.
     *
     * @return mixed
     */
    public function counters() {
        return $this->thread->getCounters();
    }
}
