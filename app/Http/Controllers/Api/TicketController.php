<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportTicketPost;
use App\Http\Requests\SupportTicketCreate;
use App\Http\Requests\SupportTicketReply;

trait TicketController {

    /**
     * Return my support in json without pagination
     *
     * @return \Illuminate\Http\Response
     */
    public function mySupportTickets(Request $request) {
        return SupportTicket::filter($request->all())->where('creator_id', $this->user()->id)->get();
    }
    
    /**
     * Create new support ticket
     * 
     * @param SupportTicketCreate $request
     * 
     * @return SupportTicket
     */
    public function createTicket(SupportTicketCreate $request) {
        $data = $request->only(['subject', 'description']);
        $ticket = new SupportTicket();
        $ticket->fill($data);
        $ticket->creator_id = $this->user()->id;
        $ticket->is_solved = false;
        $ticket->saveOrFail();
        return $ticket;
    }
    
    /**
     * Return the ticket
     * 
     * @param SupportTicket
     *
     * @return SupportTicket | null
     */
    public function getTicket(SupportTicket $ticket) {
        $ticket->posts = $ticket->posts()->orderBy('created_at', 'asc')->get();
        return $ticket;
    }  

    /**
     * Reply on the ticket
     * 
     * @param SupportTicket $ticket
     * @param SupportTicketReply $request
     * 
     * @return SupportTicketPost
     */
    public function replyOnTicket(SupportTicket $ticket, SupportTicketReply $request) {
        $data = $request->only(['text']);
        $post = new SupportTicketPost();
        $post->fill($data);
        $post->user_id = $this->user()->id;
        $post->ticket_id = $ticket->id;
        $post->saveOrFail();
        return $post;
    }
}
