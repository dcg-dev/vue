<?php

namespace App\Filters;

use App\Filters\Filter;

class OrderFilter extends Filter {
    
    public function q($search) {
        return $this->where(function($q) use ($search) {
                    return $q->where('payment_type', 'ilike', '%' . $search . '%')
                             ->orWhere('order_status', 'ilike', '%' . $search . '%')
                             ->orWhere('id', (int) $search);
                             
                });
    }
    
}
