<?php

namespace App\Filters;

use App\Filters\Filter;

class SupportTicketFilter extends Filter {
    
    public function q($search) {
        return $this->where(function($q) use ($search) {
                    return $q->where('subject', 'ilike', '%' . $search . '%')
                             ->orWhere('description', 'ilike', '%' . $search . '%');
                });
    }
    
}
