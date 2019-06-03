<?php

namespace App\Filters;

use App\Filters\Filter;

class SubscriptionFilter extends Filter {
    
    public function q($search) {
        return $this->where(function($q) use ($search) {
                    return $q->where('plan', 'ilike', '%' . $search . '%')
                             ->orWhere('id', (int) $search);
                });
    }
    
}
