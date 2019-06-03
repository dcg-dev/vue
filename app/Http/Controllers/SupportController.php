<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;

class SupportController extends Controller {
    
    use Api\FaqController,
        Api\TicketController;

    
    /**
     * Show the FAQ list
     *
     * @return \Illuminate\Http\Response
     */
    public function faqView() {
        return view('support.faq.view');
    }
    
    /**
     * Show the ticket list
     *
     * @return \Illuminate\Http\Response
     */
    public function ticketListView() {
        return view('support.ticket.list');
    }
    
    /**
     * Show the ticket
     *
     * @return \Illuminate\Http\Response
     */
    public function ticketView(SupportTicket $ticket) {
        $user = $this->user();
        return ($ticket->creator_id == $user->id || $user->isAdmin()) ? 
                view('support.ticket.view', ['ticket' => $ticket]) : 
                abort(403, 'You don\'t have permission to view this ticket.');
    }
    
}
