<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;

class TicketController extends Controller {
    
    use Api\TicketController;
    
    /**
     * Show the tickets list
     *
     * @return \Illuminate\Http\Response
     */
    public function viewList() {
        return view('admin.support.ticket.list');
    }
    
    /**
     * Show the form to create new ticket
     *
     * @return \Illuminate\Http\Response
     */
    public function viewCreate() {
        return view('admin.support.ticket.create');
    }
    
    /**
     * Show the form to edit the ticket
     * 
     * @param SupportTicket $ticket
     *
     * @return \Illuminate\Http\Response
     */
    public function viewEdit(SupportTicket $ticket) {
        return view('admin.support.ticket.edit', ['ticket' => $ticket]);
    }
    
}
