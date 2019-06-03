<?php

namespace App\Http\Controllers\Admin\Api;

use Illuminate\Http\Request;
use App\Http\Requests\AdminSupportTicketUpdate;
use App\Models\SupportTicket;

trait TicketController {
    
    /**
     * Return all support tickets in json
     * 
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getTickets(Request $request) {
        return SupportTicket::filter($request->all())
                        ->paginate($request->get('per_page', 10));
    }
    
    /**
     * Delete support ticket
     *
     * @param SupportTicket $ticket
     * 
     * @return \Illuminate\Http\Response
     */
    public function deleteTicket(SupportTicket $ticket) {
        return [
            'status' => $ticket->delete()
        ];
    }
    
    /**
     * Return support ticket
     * 
     * @param SupportTicket $ticket
     *
     * @return SupportTicket
     */
    public function getTicket(SupportTicket $ticket) {
        $ticket->posts = $ticket->posts()->orderBy('created_at', 'asc')->get();
        $ticket->creator = $ticket->creator;
        return $ticket;
    }
    
    /**
     * Update the support ticket
     * 
     * @param SupportTicket $ticket
     * @param AdminSupportTicketUpdate $request
     * 
     * @return SupportTicket
     */
    public function updateTicket(SupportTicket $ticket, AdminSupportTicketUpdate $request) {
        $data = $request->only(['sujbect', 'description', 'is_solved']);
        $ticket->fill($data);
        $ticket->saveOrFail();
        return $ticket;
    }
}
