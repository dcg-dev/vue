<?php

namespace App\Http\Controllers;

use App\Repositories\Messenger\MessengerThreadRepository;
use Illuminate\Http\Request;

/**
 * Class InboxController
 * @package App\Http\Controllers
 */
class InboxController extends Controller {

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('inbox.index');
    }
}
